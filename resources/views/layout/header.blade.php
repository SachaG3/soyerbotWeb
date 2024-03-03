<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>SoyerBot</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>

</head>
<body style="background-color: #333838">

<nav class=" navbarFixed hidden navbar navbar-expand-lg navbar-dark bg-dark fixed-top d-lg-none">
    <div class="container-fluid">
        <a class="navbar-brand" href="/home">SoyerBot</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="sidebarMenu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('Home')}}"><i class="fas fa-home"></i> Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-cogs"></i> Fonctionnalités</a>
                </li>
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
    </div>
</nav>

<div class="d-flex">
    <div class="d-none d-md-block bg-dark sidebar position-fixed" style="height: 100vh; width: 15%">
        <div class="sidebar-sticky d-flex flex-column">
            <div class="sidebar-sticky d-flex flex-column">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('Home')}}"><i class="fas fa-home"></i> Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('user.messages')}}"><i class="fas fa fa-comment" aria-hidden="true"></i> Mes messages</a>
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
                            <a href="{{route('tickets.index')}}" class="nav-link"> <i class="fas fa-ticket-alt"></i> Tickets</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('setting')}}" class="nav-link spin-setting">
                                <i class="fas fa-cog svg-icon"></i>
                                  {{Auth::user()->pseudo}}</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link" style="color: white">
                                    <i class="fas fa-sign-out-alt"></i> Déconnexion</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Connexion</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</div>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 navbarFixed" style="min-height: 100vh;" >
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





