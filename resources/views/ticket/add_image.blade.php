<form action="{{ route('images.store', ['responseId' => $responseId]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="image">Image :</label>
    <input type="file" name="image" id="image" required>

    <button type="submit">Ajouter Image</button>
</form>
