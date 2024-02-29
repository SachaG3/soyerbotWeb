<div class="container mt-5 mt-md-0 pt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header text-white bg-secondary">Créer un nouveau ticket</div>
                <div class="card-body bg-dark text-white">
                    <form class="ajax-link" action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="subject" class="form-label">Sujet :</label>
                            <input type="text" class="form-control" name="subject" id="subject" required>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message :</label>
                            <textarea class="form-control" name="message" id="message" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="images" class="form-label">Ajouter des images :</label>
                            <input type="file" class="form-control" name="images[]" id="images" multiple>
                            <small class="text-muted">Vous pouvez sélectionner plusieurs images.</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-secondary btn-block">Créer Ticket</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
