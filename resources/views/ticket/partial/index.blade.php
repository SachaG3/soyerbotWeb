

<div id="content">
<div class="container mt-5" >
    <h1 class="mb-4 text-white">Tickets</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <div class="card bg-info h-100">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h5 class="card-title text-white">Nouveau Ticket</h5>
                    <p class="card-text text-white">Une question, un problème ? Créez un ticket pour obtenir de l'aide.</p>
                    <a href="{{ route('tickets.create') }}" class="btn btn-light mt-3 text-black ajax-link">Créer un Ticket</a>
                </div>
            </div>
        </div>

        @foreach ($tickets as $ticket)
            <div class="col">
                <div class="card bg-dark text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $ticket->subject }}</h5>
                        <p>Créé par: {{ $ticket->user->pseudo }}</p>
                        <!-- Bouton indiquant le statut du ticket -->
                        @if ($ticket->status == 0)
                            <p class="badge bg-warning text-dark">En cours</p>
                        @else
                            <p class="badge bg-success">Terminé</p>
                        @endif
                    </div>
                    <div class="card-footer bg-secondary d-flex justify-content-between">
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-primary ajax-link">Voir le ticket</a>
                        <button class="btn btn-danger">Corbeille</button>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

</div>
@if(is_object($tickets))
    <div class=" container d-flex text-dark "  style="margin-top: 3%; color: black !important;">
        <div id="tickets-container">
            {{ $tickets->links() }}
        </div>
    </div>
@endif
</div>
