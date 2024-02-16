<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;

class VerifyEmailController extends Controller
{
    public function verify($token)
    {
        $user = Utilisateur::where('email_verification_token', $token)->firstOrFail();

        $user->email_verification_token = null;
        $user->email_verified_at = now();

        $user->save();

        return redirect()->route('email.verified');
    }
    public function sendVerificationEmail(User $user)
    {
        // Générez un token unique
        $token = Str::random(64);
        $user->email_verification_token = $token;
        $user->save();

        // Générez l'URL de vérification
        $url = route('verify.email', ['token' => $token]);

        // Utilisez la fonction Mail::send de Laravel pour envoyer l'e-mail.
        // Vous pouvez utiliser une vue pour formater l'e-mail.
        Mail::send('emails.verification', ['url' => $url], function ($m) use ($user) {
            $m->to($user->email)->subject('Vérifiez votre adresse e-mail');
        });
    }
}
