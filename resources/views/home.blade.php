@include('layout.header')

@auth
    <p>Connecté</p>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Déconnexion</button>
    </form>
@else
    <a href="{{ route('login') }}">Connexion</a>
@endauth

@include('layout.footer')