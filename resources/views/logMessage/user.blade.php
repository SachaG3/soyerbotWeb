@include('layout.header')

<div class="container pt-5">
    <h2 class="text-white mb-4">Messages de l'utilisateur</h2>

    <div class="d-flex flex-wrap align-items-end gap-3 mb-3">
        <div class="flex-grow-1">
            <label for="guild_filter" class="form-label text-white">Guilde</label>
            <select class="form-select" id="guild_filter">
                <option value="">Tous les messages</option>
                @foreach($guilds as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-grow-1">
            <label for="search_messages" class="form-label text-white">Rechercher</label>
            <input type="text" id="search_messages" class="form-control" placeholder="Rechercher dans les messages">
        </div>

        <div>
            <label for="sort_messages" class="form-label text-white">Trier par</label>
            <select class="form-select" id="sort_messages">
                <option value="recent">Plus récent</option>
                <option value="oldest">Plus vieux</option>
            </select>
        </div>

        <div>
            <label for="pagination_size" class="form-label text-white">Messages par page</label>
            <select class="form-select" id="pagination_size">
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="500">500</option>
                <option value="1000">1000</option>
            </select>
        </div>
    </div>

    <div id="loading" class="text-center" style="display: none;">
        <div aria-label="Orange and tan hamster running in a metal wheel" role="img" class="wheel-and-hamster" style="margin: auto">
            <div class="wheel"></div>
            <div class="hamster">
                <div class="hamster__body">
                    <div class="hamster__head">
                        <div class="hamster__ear"></div>
                        <div class="hamster__eye"></div>
                        <div class="hamster__nose"></div>
                    </div>
                    <div class="hamster__limb hamster__limb--fr"></div>
                    <div class="hamster__limb hamster__limb--fl"></div>
                    <div class="hamster__limb hamster__limb--br"></div>
                    <div class="hamster__limb hamster__limb--bl"></div>
                    <div class="hamster__tail"></div>
                </div>
            </div>
            <div class="spoke"></div>
        </div>
    </div>

    <div id="messages_content" class="mt-4">
    </div>
</div>

@include('layout.footer')


<script>
    $(document).ready(function() {
        // Extraire l'ID de l'utilisateur de l'URL, si présent
        var userId = window.location.pathname.split('/').pop();
        // Vérifier si l'userId est numérique, sinon le réinitialiser à null
        userId = $.isNumeric(userId) ? userId : null;

        // Fonction pour charger les messages, accepte maintenant userId comme argument
        function loadMessages(page = 1) {
            $('#loading').show();
            $('#messages_content').hide();

            // Préparer les données de la requête, y compris l'userId si disponible
            var requestData = {
                page: page,
                guild_id: $('#guild_filter').val(),
                search: $('#search_messages').val(),
                sort: $('#sort_messages').val(),
                paginate: $('#pagination_size').val(),
            };
            if (userId) {
                requestData.userId = userId; // Ajouter l'userId à la requête si spécifié
            }

            $.ajax({
                url: "{{ route('user.messages.ajax') }}",
                type: 'GET',
                data: requestData,
                success: function(response) {
                    $('#messages_content').html(response).show();
                },
                error: function() {
                    $('#messages_content').html('<p>Une erreur est survenue lors du chargement des messages.</p>').show();
                },
                complete: function() {
                    $('#loading').hide();
                }
            });
        }

        // Gestion des événements pour les filtres et la pagination
        $('#guild_filter, #pagination_size, #sort_messages, #search_messages').on('change', function() {
            loadMessages();
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            loadMessages(page);
        });

        // Charger initialement les messages
        loadMessages();
    });

</script>