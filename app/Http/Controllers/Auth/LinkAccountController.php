<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmailMailable;
use App\Models\TokenDiscord;
use App\Models\Utilisateur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\resetPassword;

// Définition du contrôleur pour la liaison des comptes et la vérification d'email
class LinkAccountController extends Controller
{
    // Affiche le formulaire de liaison de compte
    public function showLinkForm($token)
    {
        // Cherche le token dans la base de données
        $tokenRecord = TokenDiscord::where('token', $token)->first();

        // Si le token n'existe pas, redirige vers la page d'accueil avec un message d'erreur
        if (!$tokenRecord) {
            return redirect('/')->with('error', 'Token invalide.');
        }

        // Vérifie si le token a plus de 15 minutes
        $dateCreation = $tokenRecord->date_creation;
        $token15 = true;
        if (now()->diffInMinutes($dateCreation) > 15) {
            $token15 = false;
        }

        // Récupère le statut d'activation de l'utilisateur lié au token
        $userStatus = $tokenRecord->utilisateur->active;

        // Renvoie à la vue de liaison avec les données nécessaires
        return view('auth.link', compact('token', 'userStatus', 'token15'));
    }

    // Lie le compte utilisateur avec les données fournies dans la requête
    public function linkAccount(Request $request, $token)
    {
        // Valide les données de la requête
        $request->validate([
            'email' => 'required|email|unique:utilisateurs,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Cherche le token et échoue si non trouvé
        $tokenRecord = TokenDiscord::where('token', $token)->firstOrFail();
        $emailVerificationToken = Str::random(60);

        // Crée ou met à jour l'utilisateur avec les données fournies
        $user = Utilisateur::updateOrCreate(
            ['id' => $tokenRecord->id_utilisateur],
            [
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 1,
                'active' => true,
                'email_verified_at' => now(),
                'email_verification_token' => $emailVerificationToken
            ]
        );

        // Connecte l'utilisateur automatiquement
        auth()->login($user, true);

        // Supprime le token utilisé pour la liaison
        $tokenRecord->delete();

        // Envoie un e-mail de vérification à l'utilisateur
        Mail::to($request->email)->send(new VerifyEmailMailable($emailVerificationToken));

        // Redirige vers la route 'Home' avec un message de succès
        return redirect()->route('Home')->with('success', 'Compte lié avec succès.');
    }

    // Vérifie l'email de l'utilisateur à partir du token fourni
    public function verifyEmail($token)
    {
        // Cherche l'utilisateur par le token de vérification d'email
        $user = Utilisateur::where('email_verification_token', $token)->first();

        // Si aucun utilisateur n'est trouvé, renvoie un message d'erreur
        if (!$user) {
            return redirect('/')->with('error', 'Token de vérification d\'e-mail invalide.');
        }

        // Vérifie si le token de vérification d'email a plus de 15 minutes
        $emailVerificationCreatedAt = Carbon::parse($user->email_verification_at);
        if (Carbon::now()->diffInMinutes($emailVerificationCreatedAt) > 15) {
            // Génère un nouveau token et envoie un nouvel e-mail si le token a expiré
            $emailVerificationToken = Str::random(60);
            $user->email_verification_token = $emailVerificationToken;
            $user->email_verified_at = now();
            $user->save();

            Mail::to($user->email)->send(new resetPassword($emailVerificationToken));
            return redirect('errors.mailtoken')->with('error', 'Le délai de vérification de l\'e-mail est dépassé. Un nouvel e-mail de vérification a été envoyé.');
        }

        // Marque l'email comme vérifié si le token est valide
        $user->email_validated = 1;
        $user->save();

        // Redirige vers la route 'Home' avec un message de succès
        return redirect()->route('Home')->with('success', 'E-mail vérifié avec succès.');
    }
}
