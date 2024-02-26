<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Récupère l'utilisateur authentifié
        return view('auth/setting', compact('user')); // Envoie l'utilisateur à la vue
    }
    public function update(Request $request)
    {
        $user = Auth::user(); // Récupère l'utilisateur authentifié

        // Valide les données de la requête
        $validatedData = $request->validate([
            'pseudo' => 'required|max:255',
            'email' => 'required|email|max:255|unique:utilisateurs,email,' . $user->id,
        ]);

        // Validation conditionnelle du mot de passe
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'confirmed|min:8',
            ]);
            if (!(Hash::check($request->get('current_password'), $user->password))) {
                return back()->with("error", "Votre mot de passe actuel ne correspond pas au mot de passe que vous avez fourni.");
            }
            $validatedData['password'] = Hash::make($request->get('password'));
        }

        // Met à jour l'utilisateur avec les données validées
        $user->update($validatedData);

        // Redirige vers la page des paramètres avec un message de succès
        return redirect()->route('setting')->with('success', 'Informations mises à jour avec succès');
    }


}
