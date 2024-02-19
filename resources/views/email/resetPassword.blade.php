<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser votre mot de passe</title>
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
        Réinitialiser votre mot de passe
    </div>
    <div class="email-body">
        <p>Bonjour,</p>
        <p>Nous avons reçu une demande de réinitialisation de mot de passe pour votre compte. Si vous ne l'avez pas demandé, vous pouvez ignorer cet e-mail.</p>
        <p>Cliquez sur le bouton ci-dessous pour définir un nouveau mot de passe :</p>
        <a href="{{ $resetPasswordUrl }}" target="_blank">Réinitialiser mon mot de passe</a>
    </div>
    <div class="email-footer">
        Pour toute question, contactez notre support client.
        <br>©2024 SoyerBot. Tous droits réservés.
    </div>
</div>
</body>
</html>
