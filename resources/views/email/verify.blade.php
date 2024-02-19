<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de votre e-mail</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            font-family: Arial, sans-serif;
            font-size: 16px;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .email-header {
            background-color: #f3f3f3;
            color: #333;
            padding: 20px;
            font-size: 20px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .email-body {
            padding: 20px;
            line-height: 1.5;
            text-align: center;
        }
        .email-footer {
            background-color: #f3f3f3;
            color: #333;
            padding: 20px;
            font-size: 14px;
            text-align: center;
            border-top: 1px solid #ddd;
        }
        a {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            margin-top: 20px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        Confirmation de votre e-mail
    </div>
    <div class="email-body">
        <p>Bonjour,</p>
        <p>Veuillez cliquer sur le bouton ci-dessous pour confirmer votre adresse e-mail.</p>
        <a href="{{ $verificationUrl }}" target="_blank">Confirmer mon e-mail</a>
        <p>Si vous n'avez pas demandé cette confirmation, veuillez ignorer cet e-mail.</p>
    </div>
    <div class="email-footer">
        Pour toute question, contactez notre support client.
        <br>©2024 SoyerBot. Tous droits réservés.
    </div>
</div>
</body>
</html>
