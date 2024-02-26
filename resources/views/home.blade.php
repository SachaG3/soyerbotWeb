@include('layout.header')
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
@auth
    <p>Connecté</p>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Déconnexion</button>
    </form>
@else
    <a href="{{ route('login') }}">Connexion</a>
@endauth
</div>
@include('layout.footer')