<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoyerBot - Votre Bot Discord</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body style="background-color: #333838">
<nav class="navbar navbar-expand-lg nav1 bg-dark " style="width: 100%;">
    <div class="container">
        <a class="navbar-brand" href="#">SoyerBot</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Fonctionnalités</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Jeux</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Points & Boutique</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid" >
    <!-- Contenu Principal -->
    <div class="container mt-4">
        <section id="fonctionnalités" class="py-5 ">
            <div class="container">
                <h2 class="mb-4 text-center text-white">Fonctionnalités Principales</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-dark text-white">
                            <div class="card-body border border-light">
                                <h5 class="card-title text-white">Logging des Messages</h5>
                                <p class="card-text text-white">Gardez une trace de tous les messages supprimés ou modifiés sur votre serveur pour une meilleure modération.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-dark text-white border border-light">
                            <div class="card-body">
                                <h5 class="card-title">Alertes de Sécurité</h5>
                                <p class="card-text">Recevez des alertes instantanées pour les tentatives de spam ou les activités suspectes sur le serveur.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-dark text-white border border-light">
                            <div class="card-body">
                                <h5 class="card-title">Alerte ban</h5>
                                <p class="card-text">Une fonctionnalité de liste de bannissements permet d'alerter les admins qu'une personne a déjà été bannie de nombreux serveurs.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Jeux avec cartes -->
        <section id="jeux" class="my-5">
            <h2 class="mb-4">Jeux Disponibles</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <!-- Exemple de carte pour un jeu -->
                <div class="col">
                    <div class="card bg-dark text-white border border-light">
                        <img src="lien_vers_image_jeu.jpg" class="card-img-top" alt="Nom du Jeu">
                        <div class="card-body">
                            <h5 class="card-title">Nom du Jeu</h5>
                            <p class="card-text">Description courte du jeu.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-dark text-white border border-light">
                        <img src="lien_vers_image_jeu.jpg" class="card-img-top" alt="Nom du Jeu">
                        <div class="card-body">
                            <h5 class="card-title">Nom du Jeu</h5>
                            <p class="card-text">Description courte du jeu.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-dark text-white border border-light">
                        <img src="lien_vers_image_jeu.jpg" class="card-img-top" alt="Nom du Jeu">
                        <div class="card-body">
                            <h5 class="card-title">Nom du Jeu</h5>
                            <p class="card-text">Description courte du jeu.</p>
                        </div>
                    </div>
                </div>
                <!-- Ajoutez plus de cartes pour les autres jeux ici -->
            </div>
        </section>
        <section id="points" class="py-5">
            <div class="container ">
                <h2 class="mb-4 text-center">Système de Points & Boutique</h2>
                <p class="text-center">Gagnez des points en participant à des jeux et échangez-les contre des items exclusifs dans la boutique du bot.</p>
                <div class="d-flex justify-content-center mt-4">
                    <div class="card bg-dark text-white" style="width: 18rem;">
                        <div class="card-body border border-light">
                            <h5 class="card-title">Boutique d'Items</h5>
                            <p class="card-text">Parcourez notre sélection d'items exclusifs et utilisez vos points pour les obtenir.</p>
                            <a href="#" class="btn btn-primary">Visiter la Boutique</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
