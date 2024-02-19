<?php

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
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = Utilisateur::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.'])->onlyInput('email');
        }

        if($user->numberLogin > 10) {
            $user->active = 3;
            $user->save();
        }

        if($user->active == 2){
            return view('auth.ban');
        }
        if($user->active == 3){
            return view('auth.disable');
        }


        if (Auth::attempt($credentials, $request->filled('remember'))) {

            $user->numberLogin = 0;
            $user->save();

            $request->session()->regenerate();

            return redirect()->intended(route('Home'));
        } else {
            $user->numberLogin++;
            $user->save();

            return back()->withErrors([
                'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
            ])->onlyInput('email');
        }
    }
    public function showResetPassword(Request $request)
    {
        $user = Utilisateur::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $passwordVerificationToken=Str::random(60);
        $user->passwordVerificationToken = $passwordVerificationToken;

        $user->tokenCreationDate = now();
        $user->save();

        Mail::to($user->email)->send(new resetPassword($passwordVerificationToken));
        return response()->json(['success' => 'Password reset token generated', 'token' => $user->passwordVerificationToken]);
    }
    public function resetPassword($token)
    {
        $user = Utilisateur::where('passwordVerificationToken', $token)->first();

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
        $user=1;

        return view('auth.password',compact('user','token'));
    }
    public function passwordReset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = Utilisateur::where('passwordVerificationToken', $request->input('token'))->first();

        if (!$user) {
            return redirect()->back()->withErrors(['token' => 'Ce token de réinitialisation de mot de passe est invalide.']);
        }

        if (Carbon::now()->diffInMinutes($user->tokenCreationDate) > 15) {
            $passwordVerificationToken=Str::random(60);
            $user->passwordVerificationToken = $passwordVerificationToken;

            $user->tokenCreationDate = now();
            $user->save();

            Mail::to($user->email)->send(new resetPassword($passwordVerificationToken));
        }

        $user->password = Hash::make($request->input('password'));
        $user->passwordVerificationToken = null;
        $user->numberLogin = 0;
        $user->active = 1;
        $user->save();

        return redirect(route('Home'))->with('status', 'Votre mot de passe a été réinitialisé avec succès !');
    }
}
