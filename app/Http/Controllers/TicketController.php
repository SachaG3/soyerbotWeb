<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\TicketResponse;
use App\Models\MessageImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class TicketController extends Controller
{

    public function createTicket(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image',
        ]);

        $ticket = SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
        ]);

        $response = TicketResponse::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'content' => $request->message,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/images');
                MessageImage::create([
                    'message_id' => $response->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('tickets.show', $ticket->id);
    }



    public function addResponseToTicket(Request $request, $ticketId)
    {
        $request->validate([
            'response' => 'required|string',
        ]);

        $response = TicketResponse::create([
            'ticket_id' => $ticketId,
            'user_id' => Auth::id(),
            'content' => $request->response,
        ]);

        return response()->json(['message' => 'Nouveau message ajouté avec succès au ticket', 'response' => $response]);
    }

    // Ajouter une image à un message
    public function addImageToResponse(Request $request, $responseId)
    {
        $request->validate([
            'image' => 'required|image',
        ]);

        $path = $request->file('image')->store('public/images');

        $image = MessageImage::create([
            'message_id' => $responseId,
            'image_path' => $path,
        ]);

        return response()->json(['message' => 'Image ajoutée avec succès', 'image' => $image]);
    }
    public function showCreateTicketForm()
    {
        return view('ticket.create');
    }

    public function showAddResponseForm($ticketId)
    {
        return view('ticket.add_response', compact('ticketId'));
    }

    public function showAddImageForm($responseId)
    {
        return view('ticket.add_image', compact('responseId'));
    }
    public function index()
    {

        if (auth()->user()->role >= 4) {
            $tickets = SupportTicket::orderBy('status', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate(8);
        } else {
            $tickets = SupportTicket::where('user_id', auth()->id())
                ->orderBy('status', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate(8);
        }

        return view('ticket.index', compact('tickets'));
    }


    public function show($ticketId)
    {
        // Récupère le ticket et ses relations en utilisant `with` pour un chargement eager
        $ticket = SupportTicket::with(['responses.user', 'responses.images'])->findOrFail($ticketId);


        return view('ticket.show', compact('ticket'));
    }
    public function storeResponse(Request $request, $ticketId)
    {
        $request->validate([
            'response_content' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image',
        ]);

        $response = TicketResponse::create([
            'ticket_id' => $ticketId,
            'user_id' => Auth::id(),
            'content' => $request->response_content,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/images');
                MessageImage::create([
                    'message_id' => $response->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('tickets.show', $ticketId)->with('success', 'Réponse ajoutée avec succès.');
    }
}
