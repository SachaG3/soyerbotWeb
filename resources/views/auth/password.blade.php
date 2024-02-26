@include('layout.header')
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

        <form method="POST" action="{{ route('password-reset') }}" class="px-4 py-3 bg-dark text-white">
            <h2 class="text-white mb-4">Nouveau mot de passe</h2>
            @csrf
            @method('PUT')
            <input hidden name="token" value="{{$token}}" >

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