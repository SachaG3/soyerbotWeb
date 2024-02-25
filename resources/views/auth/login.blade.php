@include('layout.header')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-6 border border-light rounded p-4 bg-dark shadow" >

        <div id="loginFormContainer">
            <form method="POST" action="{{ route('login') }}" class="px-4 py-3 bg-dark text-white" id="loginForm">
                @csrf

                <div class="form-group">
                    <label for="email" class="text-white">Email</label>
                    <input type="email" name="email" required autofocus class="form-control bg-secondary text-white" autocomplete="email"
                           pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$" title="Veuillez fournir une adresse e-mail valide">
                </div>

                <div class="form-group position-relative">
                    <label for="password" class="text-white">Mot de passe</label>
                    <input type="password" name="password" required id="password" class="form-control bg-secondary text-white" autocomplete="current-password">
                    <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password position-absolute" style="top: 38px; right: 10px; cursor: pointer;"></span>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label for="remember" class="form-check-label text-white">Se souvenir de moi</label>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-secondary btn-block">Connexion</button>
                </div>
                <div class="form-group mt-3">
                    <a href="#" id="resetPasswordLink">Réinitialiser sont mot de passe </a>
                </div>
            </form>
        </div>
            <div id="resetPasswordFormContainer" style="display: none;">
                <form method="POST" action="{{ route('reset.password') }}" class="px-4 py-3 bg-dark text-white">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="text-white">Adresse Email</label>
                        <input type="email" name="email" required autofocus class="form-control bg-secondary text-white" autocomplete="email"
                               pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$" title="Veuillez fournir une adresse e-mail valide">
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-secondary btn-block">Envoyer le lien de réinitialisation</button>
                    </div>
                </form>
            </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.toggle-password').click(function() {
            let input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
                $(this).removeClass('fa-eye').addClass('fa-eye-slash'); // Change l'icône
            } else {
                input.attr("type", "password");
                $(this).removeClass('fa-eye-slash').addClass('fa-eye'); // Rechange l'icône
            }
        });
        $('#resetPasswordLink').click(function(e) {
            e.preventDefault();
            $('#loginFormContainer').hide();
            $('#resetPasswordFormContainer').show();
        });
    });
</script>

@include('layout.footer')
