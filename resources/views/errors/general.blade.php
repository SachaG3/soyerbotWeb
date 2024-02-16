@include('layout.header')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh">
    <div class="text-center">
        <div class="alert mt-4 bg-dark text-white border border-light" role="alert" style="font-size: 1.3em;">
            <p>Une erreur est survenue </p>
            <p>Vous pouvez contacter le support via l'adresse : <a href="mailto:contact@soyerbot.fr">contact@soyerbot.fr</a></p>
            <p>Sinon, vous pouvez <a href="{{ route('Home') }}">retourner sur la page d'accueil</a></p>
        </div>
    </div>
</div>
