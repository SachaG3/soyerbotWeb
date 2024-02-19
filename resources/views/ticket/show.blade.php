@include('layout.header')

<div class="container mt-5" style="">
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h1>{{ $ticket->subject }}</h1>
            <p>Créé par: {{ $ticket->user->pseudo }}</p>
        </div>
        <div class="card-body">
            <h2>Messages</h2>
            @foreach ($ticket->responses as $response)
                <div class="mb-3" style="@if($response->user_id == $ticket->user->id) margin-right:10%; text-align: left; @else text-align: right; margin-left: 10%; @endif">
                    <div class="p-2 bg-secondary text-white rounded">
                        <p>{{ $response->user->pseudo }}: {{ $response->content }}</p>
                        @if ($response->images->isNotEmpty())
                            <div class="row">
                                @foreach ($response->images as $image)
                                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                                        <div class="image-container">
                                            <img src="{{ asset(Storage::url($image->image_path)) }}" alt="Image associée à la réponse" class="img-fluid rounded" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-url="{{ asset(Storage::url($image->image_path)) }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="card-footer">
            <h3 class="text-black">Répondre</h3>
            <form action="{{ route('ticket.responses.store', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <textarea class="form-control" name="response_content" id="response_content" rows="3" placeholder="Votre réponse..."></textarea>
                </div>
                <div class="mb-3">
                    <label for="images" class="form-label">Ajouter des images :</label>
                    <input type="file" class="form-control" name="images[]" id="images" multiple>
                    <small class="text-muted">Vous pouvez sélectionner plusieurs images.</small>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Envoyer Réponse</button>
                </div>
            </form>
        </div>
    </div>
</div>


@include('layout.footer')
