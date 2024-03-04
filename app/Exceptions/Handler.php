<?php

namespace App\Exceptions;

use HttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */

    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {
            // Gérer les exceptions spécifiquement pour les réponses API en JSON ici
            if ($exception instanceof AuthenticationException) {
                return response()->json(['error' => 'Non authentifié.'], 401);
            }

            if ($exception instanceof AuthorizationException) {
                return response()->json(['error' => 'Accès non autorisé.'], 403);
            }

            if ($exception instanceof TokenMismatchException) {
                return response()->json(['error' => 'Votre token CSRF est invalide.'], 419);
            }

            if ($exception instanceof HttpException) {
                return response()->json(['error' => 'Erreur HTTP.', 'status' => $exception->getStatusCode()]);
            }

            // Gérer ici d'autres types d'exceptions si nécessaire

            // Réponse par défaut pour les autres exceptions non capturées spécifiquement
            return response()->json(['error' => 'Une erreur inattendue est survenue.'], 500);
        }
        // Gestion du token CSRF manquant ou incorrect
        if ($exception instanceof TokenMismatchException) {
            return redirect()->route('login')->with('error', 'Votre session a expiré. Veuillez vous reconnecter.');
        }
        // Gestion des erreurs d'authentification
        if ($exception instanceof AuthenticationException) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à cette page.');
        }
        // Gestion des erreurs d'autorisation
        if ($exception instanceof AuthorizationException) {
            return redirect()->route('login')->with('error', 'Vous n’avez pas les droits nécessaires pour accéder à cette page.');
        }
        // Gestion des autres erreurs HTTP (par exemple, 403 Forbidden)
        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
            if ($statusCode == 403) {
                return redirect()->route('login')->with('error', 'Accès refusé. Vous devez être connecté pour voir cette page.');
            }
        }
        return redirect()->route('error')->with('error', 'Une erreur est survenue.');
    }
    public function register() {
        $this->reportable(function (Throwable $e) {
            //
            if (app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });
    }
}
