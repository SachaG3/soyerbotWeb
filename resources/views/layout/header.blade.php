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
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-dark sidebar position-fixed nav1 " style="height: 100vh; width: 15%">
            <div class="sidebar-sticky d-flex flex-column">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('Home')}}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Fonctionnalités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Prix</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">À propos</a>
                    </li>
                </ul>
                <ul class="nav flex-column position-absolute bottom-0 w-100">
                    @auth
                        <li class="nav-item">
                            <a href="{{route('tickets.index')}}" class="nav-link">Tickets</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('setting')}}" class="nav-link">{{Auth::user()->pseudo}}</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link" style="color: white">Déconnexion</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Connexion</a>
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





