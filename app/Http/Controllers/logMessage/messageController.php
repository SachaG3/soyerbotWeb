<?php
namespace App\Http\Controllers\logMessage;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class messageController extends Controller{

    public function getUserMessages(Request $request, $userId = null)
    {
        // Récupère l'ID de l'utilisateur depuis l'URL ou le corps de la requête, ou utilise l'ID de l'utilisateur actuellement authentifié
        $userId = $userId ?: $request->input('userId', Auth::id());

        // Initialisation de la variable $guilds si la requête n'est pas une requête AJAX
        if (!$request->ajax()) {
            $guilds = Message::where('userId', $userId) // Cherche les messages par ID utilisateur
            ->with('listGuild') // Charge les relations 'listGuild' (guilde associée à chaque message)
            ->get() // Obtient les résultats
            ->pluck('listGuild.name_guild', 'listGuild.id_guild') // Récupère uniquement le nom et l'ID de la guilde
            ->sort(); // Trie les guildes
        }

        // Crée la requête de base pour récupérer les messages de l'utilisateur
        $query = Message::where('userId', $userId);

        // Filtre la requête par ID de guilde si spécifié
        if ($request->filled('guild_id')) {
            if ($request->guild_id == 'private') {
                // Filtre pour les messages privés (sans guilde)
                $query->where(function ($q) {
                    $q->whereNull('id_guild')->orWhere('id_guild', 0);
                });
            } else {
                // Filtre par un ID de guilde spécifique
                $query->where('id_guild', $request->guild_id);
            }
        }

        // Applique un filtre de recherche sur le contenu du message si spécifié
        if ($request->filled('search')) {
            $query->where('message', 'like', '%' . $request->search . '%');
        }

        // Ordonne les messages par date de création, selon le critère spécifié
        if ($request->filled('sort')) {
            $sortDirection = $request->sort == 'recent' ? 'desc' : 'asc';
            $query->orderBy('creationDate', $sortDirection);
        }

        // Définit le nombre de messages par page pour la pagination
        $perPage = $request->input('paginate', 50);
        // Applique la pagination à la requête
        $messages = $query->paginate($perPage);

        // Charge la relation 'listGuild' pour chaque message paginé
        $messages->load('listGuild');

        // Si la requête est une requête AJAX, renvoie seulement le fragment de vue avec les messages
        if ($request->ajax()) {
            return view('logMessage.partial.messages_list', compact('messages'))->render();
        }

        // Pour les requêtes non AJAX, renvoie la vue complète avec les messages et, si disponible, les guildes
        return view('logMessage.user', compact('messages', isset($guilds) ? 'guilds' : null));
    }



}