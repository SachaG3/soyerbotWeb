<!DOCTYPE html>
<html>
<head>
    <title>Vérification d'Email</title>
</head>
<body>
<h2>Bienvenue sur notre site {{ $user->pseudo }}</h2>
<br/>
Votre email enregistré est {{ $user->email }} , Veuillez cliquer sur le lien ci-dessous pour vérifier votre compte d'email
<br/>
<a href="{{ $url }}">Cliquez ici pour vérifier</a>
</body>
</html>