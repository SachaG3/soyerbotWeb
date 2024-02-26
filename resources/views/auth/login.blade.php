<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>SoyerBot</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-dark sidebar position-fixed nav1 " style="height: 100vh; width: 15%">
            <div class="sidebar-sticky d-flex flex-column">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('Home')}}"><i class="fas fa-home"></i> Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-cogs"></i> Fonctionnalités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-tags"></i> Prix</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-info-circle"></i> À propos</a>
                    </li>
                </ul>
                <ul class="nav flex-column position-absolute bottom-0 w-100">
                    @auth
                        <li class="nav-item">
                            <a href="{{route('tickets.index')}}" class="nav-link"><i class="fas fa-ticket-alt"></i> Tickets</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('setting')}}" class="nav-link"><i class="fas fa-user"></i> {{Auth::user()->pseudo}}</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link" style="color: white"><i class="fas fa-sign-out-alt"></i> Déconnexion</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Connexion</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 navbarFixed" style="min-height: 100vh" >
            <div id="floating-alerts-container">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show alert-fixed alert-centered" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show alert-fixed alert-centered" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show alert-fixed alert-centered" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <script>
                window.addEventListener('DOMContentLoaded', (event) => {
                    setTimeout(() => {
                        const alerts = document.querySelectorAll('.alert-fixed');
                        alerts.forEach(alert => {
                            new bootstrap.Alert(alert).close();
                        });
                    }, 15000);
                });
            </script>


<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-6 border border-light rounded p-4 bg-dark shadow" >

        <div id="loginFormContainer">
            <form method="POST" action="{{ route('login') }}" class="px-4 py-3 bg-dark text-white" id="loginForm">
                <h2 class="text-white mb-4">Connexion</h2>
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
