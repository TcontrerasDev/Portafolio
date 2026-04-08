<?php

class AuthMiddleware
{
    public static function verificar(): void
    {
        if (empty($_SESSION['id_usuario'])) {
            header('Location: ' . BASE_URL . '/admin/login');
            exit;
        }
    }
}
