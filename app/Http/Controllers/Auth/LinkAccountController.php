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

class LinkAccountController extends Controller
{
    public function showLinkForm($token)
    {
        $tokenRecord = TokenDiscord::where('token', $token)->first();

        if (!$tokenRecord) {
            return redirect('/')->with('error', 'Token invalide.');
        }
        $dateCreation = $tokenRecord->date_creation;

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
            'email' => 'required|email|unique:utilisateurs,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $tokenRecord = TokenDiscord::where('token', $token)->firstOrFail();
        $emailVerificationToken = Str::random(60);

        $user = Utilisateur::updateOrCreate(
            ['id' => $tokenRecord->id_utilisateur],
            [
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 1,
                'active' => true,
                'email_verified_at'=>now(),
                'email_verification_token' => $emailVerificationToken
            ]
        );
        auth()->login($user, true);

        $tokenRecord->delete();


        Mail::to($request->email)->send(new VerifyEmailMailable($emailVerificationToken));


        return redirect()->route('Home')->with('success', 'Compte lié avec succès.');
    }
    public function verifyEmail($token)
    {
        $user = Utilisateur::where('email_verification_token', $token)->first();

        if (!$user) {
            return redirect('/')->with('error', 'Token de vérification d\'e-mail invalide.');
        }

        $emailVerificationCreatedAt = Carbon::parse($user->email_verification_at);

        if (Carbon::now()->diffInMinutes($emailVerificationCreatedAt) > 15) {
            $emailVerificationToken = Str::random(60);
            $user->email_verification_token = $emailVerificationToken;
            $user->email_verified_at = now();
            $user->save();

            Mail::to($user->email)->send(new resetPassword($emailVerificationToken));
            return redirect('errors.mailtoken')->with('error', 'Le délai de vérification de l\'e-mail est dépassé. Un nouvel e-mail de vérification a été envoyé.');
        }

        $user->email_validated = 1;
        $user->save();

        return redirect()->route('Home')->with('success', 'E-mail vérifié avec succès.');
    }
}
