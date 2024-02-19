
<form action="{{ route('responses.store', ['ticketId' => $ticketId]) }}" method="POST">
    @csrf
    <label for="response">Réponse :</label>
    <textarea name="response" id="response" required></textarea>

    <button type="submit">Ajouter Réponse</button>
</form>
