@include('layout.header')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh">
    <div class="text-center">
        <div class="alert mt-4 border border-light" role="alert" style="font-size: 1.3em; background-color: orange; color: white;">
            <p>Votre compte a été désactivé. Cliquez sur le bouton pour le réactiver.</p>
            <form method="POST" action="{{ route('reset.password') }}">
                @csrf
                <div class="form-group">
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Entrer l'email ici">
                </div>
                <button type="submit" class="btn btn-light" style="font-size: 1.3em; margin-top: 15px;"><span style="color: #1a202c">Réinitialiser le mot de passe</span></button>
            </form>
        </div>
    </div>
</div>
@include('layout.footer')