<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\TicketResponse;
use App\Models\MessageImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// Contrôleur pour la gestion des tickets de support
class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Méthode pour créer un nouveau ticket
    public function createTicket(Request $request)
    {
        // Valide les données de la requête
        $request->validate([
            'subject' => 'required|string', // Sujet requis et doit être une chaîne
            'message' => 'required|string', // Message requis et doit être une chaîne
            'images' => 'nullable|array', // Images optionnelles et doivent être un tableau
            'images.*' => 'image', // Chaque image doit être un fichier image valide
        ]);

        // Crée un nouveau ticket dans la base de données
        $ticket = SupportTicket::create([
            'user_id' => Auth::id(), // Associe le ticket à l'utilisateur actuellement authentifié
            'subject' => $request->subject, // Définit le sujet du ticket
        ]);

        // Crée une réponse initiale pour le ticket
        $response = TicketResponse::create([
            'ticket_id' => $ticket->id, // Lie la réponse au ticket créé
            'user_id' => Auth::id(), // Associe la réponse à l'utilisateur actuellement authentifié
            'content' => $request->message, // Définit le contenu de la réponse
        ]);

        // Vérifie si des fichiers images ont été téléversés
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/images'); // Stocke chaque image dans le système de fichiers
                MessageImage::create([
                    'message_id' => $response->id, // Associe l'image à la réponse créée
                    'image_path' => $path, // Sauvegarde le chemin de l'image
                ]);
            }
        }

        // Redirige l'utilisateur vers la page du ticket créé
        return redirect()->route('tickets.show', $ticket->id);
    }

    // Affiche le formulaire de création d'un ticket
    public function showCreateTicketForm()
    {
        // Gère les requêtes AJAX séparément
        if (request()->ajax()) {
            return response()->json(['html' => view('ticket.partial.create')->render()]);
        } else {
            return view('ticket.create'); // Affiche la vue complète pour les requêtes non-AJAX
        }
    }

    // Liste les tickets de support
    public function index(Request $request)
    {
        // Affiche tous les tickets pour les utilisateurs avec un rôle >= 4
        if ($request->user()->role >= 4) {
            $tickets = SupportTicket::orderBy('status', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate(8);
        } else {
            // Affiche seulement les tickets de l'utilisateur connecté pour les autres
            $tickets = SupportTicket::where('user_id', $request->user()->id)
                ->orderBy('status', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate(8);
        }

        // Gère les requêtes AJAX séparément pour un rendu partiel
        if ($request->ajax()) {
            return view('ticket.partial.index', compact('tickets'))->render();
        }

        // Affiche la vue complète avec les tickets
        return view('ticket.index', compact('tickets'));
    }

    // Affiche les détails d'un ticket spécifique
    public function show($ticketId)
    {
        // Récupère le ticket et ses réponses associées, y compris les utilisateurs et images
        $ticket = SupportTicket::with(['responses.user', 'responses.images'])->findOrFail($ticketId);


        // Vérifie si l'utilisateur courant est le propriétaire du ticket ou un administrateur
        $user = Auth::user();
        if ($ticket->user_id !== $user->id && $user->role < 4) {
            // Si l'utilisateur n'est ni le propriétaire ni un admin, redirige ou affiche une erreur
            return back()->with('error', 'Vous n\'avez pas le droit d\'accéder à ce ticket.');
        }

        // Gère les requêtes AJAX séparément pour un rendu partiel
        if (request()->ajax()) {
            return response()->json(['html' => view('ticket.partial.show', compact('ticket'))->render()]);
        } else {
            // Affiche la vue complète pour les détails du ticket
            return view('ticket.show', compact('ticket'));
        }
    }


    // Stocke une réponse à un ticket spécifique, avec possibilité d'ajouter des images
    public function storeResponse(Request $request, $ticketId)
    {
        // Valide les données de la requête
        $request->validate([
            'response_content' => 'required|string', // Contenu de la réponse requis et doit être une chaîne
            'images' => 'nullable|array', // Images optionnelles et doivent être un tableau
            'images.*' => 'image', // Chaque image doit être un fichier image valide
        ]);

        // Crée une nouvelle réponse pour le ticket
        $response = TicketResponse::create([
            'ticket_id' => $ticketId, // Lie la réponse au ticket spécifié
            'user_id' => Auth::id(), // Associe la réponse à l'utilisateur actuellement authentifié
            'content' => $request->response_content, // Définit le contenu de la réponse
        ]);

        // Vérifie si des fichiers images ont été téléversés
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/images'); // Stocke chaque image dans le système de fichiers
                MessageImage::create([
                    'message_id' => $response->id, // Associe l'image à la réponse créée
                    'image_path' => $path, // Sauvegarde le chemin de l'image
                ]);
            }
        }

        // Redirige l'utilisateur vers la page des détails du ticket avec un message de succès
        return redirect()->route('tickets.show', $ticketId)->with('success', 'Réponse ajoutée avec succès.');
    }
}
