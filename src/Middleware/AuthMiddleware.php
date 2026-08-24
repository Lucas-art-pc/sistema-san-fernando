<?php

namespace App\Middleware;

class AuthMiddleware
{
    public function handle(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['id_usuario']);
    }
}