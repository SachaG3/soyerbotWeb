@include('layout.header')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-6 border border-light rounded p-4 bg-dark shadow">
        @if ($errors->any())
            <div class="text-white">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('settings.update') }}" class="px-4 py-3 bg-dark text-white">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="pseudo" class="text-white">Pseudo:</label>
                <input type="text" id="pseudo" name="pseudo" required class="form-control bg-secondary text-white" value="{{ $user->pseudo }}">
            </div>

            <div class="form-group">
                <label for="email" class="text-white">E-mail:</label>
                <input type="email" id="email" name="email" required class="form-control bg-secondary text-white" value="{{ $user->email }}">
            </div>

            <div class="form-group position-relative">
                <label for="current_password" class="text-white">Mot de passe actuel:</label>
                <input type="password" id="current_password" name="current_password" class="form-control bg-secondary text-white">
                <span toggle="#current_password" class="fa fa-fw fa-eye field-icon toggle-password position-absolute" style="top: 38px; right: 10px; cursor: pointer;"></span>

            </div>

            <div class="form-group position-relative">
                <label for="password" class="text-white">Nouveau mot de passe:</label>
                <input type="password" id="password" name="password" class="form-control bg-secondary text-white">
                <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password position-absolute" style="top: 38px; right: 10px; cursor: pointer;"></span>

            </div>

            <div class="form-group position-relative">
                <label for="password_confirmation" class="text-white">Confirmez le nouveau mot de passe:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control bg-secondary text-white">
                <span toggle="#password_confirmation" class="fa fa-fw fa-eye field-icon toggle-password position-absolute" style="top: 38px; right: 10px; cursor: pointer;"></span>

            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-secondary btn-block">Mettre à jour</button>
            </div>

        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.toggle-password').click(function() {
            $(this).toggleClass('fa-eye fa-eye-slash');
            let input = $($(this).attr('toggle'));
            if (input.attr('type') == 'password') {
                input.attr('type', 'text');
            } else {
                input.attr('type', 'password');
            }
        });
    });
</script>

@include('layout.footer')