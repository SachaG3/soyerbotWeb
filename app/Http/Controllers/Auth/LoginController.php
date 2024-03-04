<?php

// Namespace et imports
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\resetPassword;
use App\Models\User;
use App\Models\Utilisateur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    // Affichage du formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Traitement de la tentative de connexion
    public function login(Request $request)
    {
        // Validation des champs requis
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Recherche de l'utilisateur par email
        $user = Utilisateur::where('email', $request->email)->first();

        // Si l'utilisateur n'existe pas, retourne une erreur
        if (! $user) {
            return back()->withErrors(['email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.'])->onlyInput('email');
        }

        // Si l'utilisateur a tenté de se connecter plus de 10 fois, désactive le compte
        if($user->numberLogin > 10) {
            $user->active = 3; // Statut désactivé
            $user->save();
        }

        // Gestion des statuts de l'utilisateur (banni ou désactivé)
        if($user->active == 2){
            return view('auth.ban');
        }
        if($user->active == 3){
            return view('auth.disable');
        }

        // Tentative de connexion avec les identifiants fournis
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Réinitialise le compteur de tentatives de connexion
            $user->numberLogin = 0;
            $user->save();

            // Régénération de la session pour éviter les attaques de fixation de session
            $request->session()->regenerate();

            // Redirection vers la page d'accueil
            return redirect()->intended(route('Home'))->with('success', 'Connexion réussie.');;
        } else {
            // Incrémente le compteur de tentatives de connexion en cas d'échec
            $user->numberLogin++;
            $user->save();

            // Retourne une erreur
            return back()->withErrors([
                'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
            ])->onlyInput('email');
        }
    }

    // Affichage du formulaire de réinitialisation du mot de passe
    public function showResetPassword(Request $request)
    {
        $user = Utilisateur::where('email', $request->input('email'))->first();

        // Si l'utilisateur n'existe pas, retourne une erreur
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Génère un token pour la réinitialisation du mot de passe
        $passwordVerificationToken=Str::random(60);
        $user->passwordVerificationToken = $passwordVerificationToken;

        // Enregistre la date de création du token
        $user->tokenCreationDate = now();
        $user->save();

        // Envoie un email avec le token de réinitialisation
        Mail::to($user->email)->send(new resetPassword($passwordVerificationToken));
        return redirect(route('login'));
    }

    // Réinitialisation du mot de passe avec le token
    public function resetPassword($token)
    {
        $user = Utilisateur::where('passwordVerificationToken', $token)->first();

        // Si le token est invalide, retourne une erreur
        if (!$user) {
            return redirect('/')->with('error', 'Token de vérification d\'e-mail invalide.');
        }

        // Vérifie si le token a expiré
        $emailVerificationCreatedAt = Carbon::parse($user->email_verification_at);

        if (Carbon::now()->diffInMinutes($emailVerificationCreatedAt) > 15) {
            // Génère un nouveau token si l'ancien a expiré
            $emailVerificationToken = Str::random(60);
            $user->email_verification_token = $emailVerificationToken;
            $user->email_verified_at = now();
            $user->save();

            // Renvoie un email de vérification
            Mail::to($user->email)->send(new resetPassword($emailVerificationToken));
            return redirect('errors.mailtoken')->with('error', 'Le délai de vérification de l\'e-mail est dépassé. Un nouvel e-mail de vérification a été envoyé.');
        }

        // Préparation de la vue de réinitialisation du mot de passe
        $user=1;

        return view('auth.password',compact('user','token'));
    }

    // Traitement du formulaire de réinitialisation du mot de passe
    public function passwordReset(Request $request)
    {
        // Validation des champs requis
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = Utilisateur::where('passwordVerificationToken', $request->input('token'))->first();

        // Vérifie l'existence de l'utilisateur et la validité du token
        if (!$user) {
            return redirect()->back()->withErrors(['token' => 'Ce token de réinitialisation de mot de passe est invalide.']);
        }

        // Vérifie si le token a expiré
        if (Carbon::now()->diffInMinutes($user->tokenCreationDate) > 15) {
            // Génère un nouveau token en cas d'expiration
            $passwordVerificationToken=Str::random(60);
            $user->passwordVerificationToken = $passwordVerificationToken;

            // Met à jour la date de création du token
            $user->tokenCreationDate = now();
            $user->save();

            // Envoie un nouvel email de réinitialisation
            Mail::to($user->email)->send(new resetPassword($passwordVerificationToken));
        }

        // Réinitialise le mot de passe de l'utilisateur
        $user->password = Hash::make($request->input('password'));
        $user->passwordVerificationToken = null;
        $user->numberLogin = 0;
        $user->active = 1;
        $user->save();

        // Redirection vers la page d'accueil avec un message de succès
        return redirect(route('Home'))->with('status', 'Votre mot de passe a été réinitialisé avec succès !');
    }
    public function ResetPasswordApi(Request $request)
    {
        $user = Utilisateur::where('email', $request->input('email'))->first();

        // Si l'utilisateur n'existe pas, retourne une erreur
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Génère un token pour la réinitialisation du mot de passe
        $passwordVerificationToken=Str::random(60);
        $user->passwordVerificationToken = $passwordVerificationToken;

        // Enregistre la date de création du token
        $user->tokenCreationDate = now();
        $user->save();

        // Envoie un email avec le token de réinitialisation
        Mail::to($user->email)->send(new resetPassword($passwordVerificationToken));
        return response()->json([
            'message' => 'email envoyé.',
        ]);
    }

    public function loginApi(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = Utilisateur::where('email', $request->email)->first();

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Les informations de connexion fournies sont incorrectes.'], 401);
        }

        // Vérifier l'état de l'utilisateur (actif, banni, désactivé)
        if($user->active != 1) {
            $status = $user->active == 2 ? 'banni' : 'désactivé';
            return response()->json(['message' => "Votre compte est $status."], 403);
        }

        // Création d'un token pour l'utilisateur
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie.',
            'user' => $user->only(['id', 'email', 'pseudo', 'role']), // Retourner les informations nécessaires
            'token' => $token,
        ]);
    }
}
