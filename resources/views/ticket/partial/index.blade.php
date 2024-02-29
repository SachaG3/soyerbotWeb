<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    $(document).ready(function() {
        $(document).on('click', '.delete-ticket-btn', function() {
            var ticketId = $(this).data('ticket-id');

            Swal.fire({
                title: 'Êtes-vous sûr(e) ?',
                text: "Cela sera supprimé définitivement !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimez-le !'
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/tickets/' + ticketId,
                        type: 'POST',
                        data: {_method: 'DELETE'},
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Supprimé !',
                                    response.message,
                                    'success'
                                );

                                // Recharger les tickets
                                $.ajax({
                                    url: '/tickets',
                                    type: 'GET',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    },
                                    success: function(response) {
                                        $('#tickets-container').html(response);
                                    }
                                });
                            } else {
                                Swal.fire(
                                    'Erreur !',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Erreur !',
                                'Une erreur est survenue lors de la suppression du ticket.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        $(document).on('change', '.ticket-status-toggle', function() {
            var ticketId = $(this).data('ticket-id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/tickets/status/' + ticketId,
                type: 'POST',
                data: {
                    status: status,
                },
                success: function(response) {
                    Swal.fire(
                        'Mis à jour !',
                        'Le statut du ticket a été mis à jour.',
                        'success'
                    );

                    $.ajax({
                        url: '/tickets',
                        type: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(response) {
                            $('#tickets-container').html(response);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Erreur !',
                        "Une erreur est survenue lors de la mise à jour du statut du ticket.",
                        'error'
                    );
                    $('.ticket-status-toggle[data-ticket-id="' + ticketId + '"]').prop('checked', !status);
                }
            });
        });
    });
</script>

<div id="content" class="mt-5 mt-md-0">
    <div class="container pt-5" >
        <h1 class="mb-4 text-white">Tickets</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4 ">
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
                <div class="ticket col" data-ticket-id="{{ $ticket->id }}">
                    <div class="card bg-dark text-white h-100 position-relative"> <!-- Ajoutez la classe position-relative -->
                        <div class="form-check form-switch position-absolute top-0 end-0 m-3"> <!-- Commutateur de position absolument dans le coin supérieur droit -->
                            <input class="form-check-input ticket-status-toggle" type="checkbox" id="{{ 'ticketToggle' . $ticket->id }}" data-ticket-id="{{ $ticket->id }}" {{ $ticket->status == 1 ? 'checked' : '' }} >
                            <label class="form-check-label" for="{{ 'ticketToggle' . $ticket->id }}">
                            </label>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">{{ $ticket->subject }}</h5>
                            <p>Créé par: {{ $ticket->user->pseudo }}</p>
                            @if ($ticket->status == 0)
                                <p class="badge bg-warning text-dark">En cours</p>
                            @else
                                <p class="badge bg-success">Terminé</p>
                            @endif
                        </div>


                        <div class="card-footer bg-secondary d-flex justify-content-between">
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-primary ajax-link"><i class="fas fa-eye"></i> Voir le ticket</a>
                            <div class="text-center" >
                                <button type="button" class="btn btn-danger delete-ticket-btn" data-ticket-id="{{ $ticket->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>
    @if(is_object($tickets))
        <div class=" container d-flex text-dark "  style="margin-top: 3%; color: black !important;">
            <div id="tickets-container pagination-container">
                {{ $tickets->links() }}
            </div>
        </div>
    @endif
</div>

