<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TokenDiscord;
use App\Models\Utilisateur; // Utilisez le modèle Utilisateur au lieu de User
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LinkAccountController extends Controller
{
    public function showLinkForm($token)
    {
        $tokenRecord = TokenDiscord::where('token', $token)->first();

        if (!$tokenRecord) {
            return redirect('/')->with('error', 'Token invalide.');
        }
        $dateCreation = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $tokenRecord->date_creation, 'UTC')
            ->setTimezone('Europe/Paris');

        $token15=true;
        if (now()->diffInMinutes($dateCreation) > 15) {
            $token15=false;
        }
        $userStatus = $tokenRecord->utilisateur->active;
        return view('auth.link', compact('token','userStatus','token15'));
    }


    public function linkAccount(Request $request, $token)
    {
        $request->validate([
            'email' => 'required|email|unique:utilisateurs,email', // Assurez-vous d'utiliser la table utilisateurs
            'password' => 'required|min:8|confirmed',
        ]);

        $tokenRecord = TokenDiscord::where('token', $token)->firstOrFail();

        // Créez ou mettez à jour l'utilisateur avec l'email, le mot de passe et le rôle
        $user = Utilisateur::updateOrCreate(
            ['id' => $tokenRecord->id_utilisateur], // Utilisez le champ approprié pour l'identification
            [
                'email' => $request->email,
                'password' => Hash::make($request->password), // Hash du mot de passe
                'role' => 1, // Set le rôle à 1
                'active' => true, // Activez le compte, si nécessaire
            ]
        );

        // Connectez l'utilisateur
        auth()->login($user, true); // Le second paramètre `true` force la "remember" functionality

        // Supprimez le token si vous ne souhaitez pas qu'il soit réutilisé
        $tokenRecord->delete();

        return redirect()->route('home')->with('success', 'Compte lié avec succès.');
    }
}
