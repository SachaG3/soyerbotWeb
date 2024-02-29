@if($messages->count() > 0)
    <div class="table-responsive">
        <table class="table table-dark table-striped border border-light rounded">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Message</th>
                <th scope="col">Guild</th>
                <th scope="col">Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($messages as $index => $message)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td>{{ $message->message }}</td>
                    <td>{{ $message->guild ? $message->guild->name_guild : 'Message privé' }}</td>
                    <td>{{ \Carbon\Carbon::parse($message->creationDate)->diffForHumans() }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {!! $messages->links() !!}
    </div>
@else
    <p class="text-white">Aucun message trouvé.</p>
@endif
