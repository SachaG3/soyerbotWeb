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
        $userId = $userId ?? Auth::id();

        // Conditionnellement charger les guildes uniquement pour la vue principale
        if (!$request->ajax()) {
            $guilds = Message::where('userId', $userId)
                ->with('listGuild')
                ->get()
                ->pluck('listGuild.name_guild', 'listGuild.id_guild')
                ->sort();
        }

        $query = Message::where('userId', $userId);

        // Appliquer le filtrage conditionnel
        if ($request->filled('guild_id')) {
            if ($request->guild_id == 'private') {
                $query->where(function ($q) {
                    $q->whereNull('id_guild')->orWhere('id_guild', 0);
                });
            } else {
                $query->where('id_guild', $request->guild_id);
            }
        }

        // Recherche et tri
        if ($request->filled('search')) {
            $query->where('message', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('sort')) {
            $sortDirection = $request->sort == 'recent' ? 'desc' : 'asc';
            $query->orderBy('creationDate', $sortDirection);
        }

        // Pagination des résultats sans eager loading par défaut
        $perPage = $request->input('paginate', 50);
        $messages = $query->paginate($perPage);

        // Charger la relation listGuild après la pagination si nécessaire
        $messages->load('listGuild');

        if ($request->ajax()) {
            return view('logMessage.partial.messages_list', compact('messages'))->render();
        }

        return view('logMessage.user', compact('messages', isset($guilds) ? 'guilds' : null));
    }



}