@include('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    <p>Votre email a été vérifié avec succès ! Vous pouvez maintenant bénéficier de la pleine utilisation de notre site.</p>
                    <a href="{{ route('Home') }}" class="btn btn-primary">
Retourner à la page d'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection