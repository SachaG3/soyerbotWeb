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
        if (request()->ajax()) {
            return response()->json(['html' => view('ticket.partial.create')->render()]);
        } else {
            return view('ticket.create');
        }
    }

    public function index(Request $request)
    {
        if ($request->user()->role >= 4) {
            $tickets = SupportTicket::orderBy('status', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate(8);
        } else {
            $tickets = SupportTicket::where('user_id', $request->user()->id)
                ->orderBy('status', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate(8);
        }

        if ($request->ajax()) {
            return view('ticket.partial.index', compact('tickets'))->render();
        }

        return view('ticket.index', compact('tickets'));
    }



    // Dans TicketController
    public function show($ticketId)
    {
        $ticket = SupportTicket::with(['responses.user', 'responses.images'])->findOrFail($ticketId);

        if (request()->ajax()) {
            return response()->json(['html' => view('ticket.partial.show', compact('ticket'))->render()]);
        } else {
            return view('ticket.show', compact('ticket'));
        }
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
