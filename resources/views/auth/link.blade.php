@include('layout.header')
@auth()
    <div class="d-flex justify-content-center align-items-center " style="min-height: 100vh">
        <div class="text-center">
            <div class="alert mt-4 bg-dark text-white border border-light" role="alert" style="font-size: 1.3em;">
                <p>Vous êtes déjà connecté</p>
                <p>Vous pouvez <a href="{{ route('Home') }}" class="text-white">revenir à la page d'accueil</a></p>
            </div>
        </div>
    </div>
@elseif($userStatus==1)
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh">
        <div class="text-center">
            <div class="alert mt-4 bg-dark text-white border border-light" role="alert" style="font-size: 1.3em;">
                <p>Vous avez déjà un compte</p>
                <p>Vous pouvez <a href="{{ route('Home') }}" class="text-white">revenir à la page d'accueil</a></p>
            </div>
        </div>
    </div>
@elseif($userStatus==2)
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh">
        <div class="text-center">
            <div class="alert mt-4 bg-danger text-white border border-light" role="alert" style="font-size: 1.3em;">
                <p>Vous avez été banni de nos services</p>
            </div>
        </div>
    </div>
@elseif($token15 = false)
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh">
        <div class="text-center">
            <div class="alert mt-4 bg-dark text-white border border-light" role="alert" style="font-size: 1.3em;">
                <p>Votre invitation a expiré</p>
                <p>Vous pouvez <a href="{{ route('Home') }}" class="text-white">revenir à la page d'accueil</a></p>
            </div>
        </div>
    </div>
@else
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-6 border border-light rounded p-4 bg-dark shadow">
            <form method="POST" action="{{ route('account.link', ['token' => $token]) }}" class="px-4 py-3 bg-dark text-white">
                @csrf
                <div class="form-group">
                    <label for="email" class="text-white">Email</label>
                    <input type="email" name="email" required autofocus class="form-control bg-secondary text-white" placeholder="Votre email" autocomplete="email">
                </div>
                <div class="form-group">
                    <label for="password" class="text-white">Mot de passe</label>
                    <input type="password" name="password" required class="form-control bg-secondary text-white" placeholder="Choisissez un mot de passe" autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="text-white">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" required class="form-control bg-secondary text-white" placeholder="Confirmez le mot de passe" autocomplete="new-password">
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-secondary btn-block">Lier le compte</button>
                </div>
            </form>
        </div>
    </div>
@endauth
@include('layout.footer')