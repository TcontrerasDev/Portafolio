<?php

class AuthController
{
    private UsuarioModel $modelo;

    public function __construct(PDO $pdo)
    {
        $this->modelo = new UsuarioModel($pdo);
    }

    public function mostrarLogin(): void
    {
        $error = $_SESSION['error_login'] ?? null;
        unset($_SESSION['error_login']);
        require __DIR__ . '/../../views/admin/auth/login.php';
    }

    public function procesarLogin(): void
    {
        Csrf::validar();

        // Rate limiting: máx 5 intentos, bloqueo 15 min
        $ahora = time();
        $_SESSION['login_intentos']       = $_SESSION['login_intentos'] ?? 0;
        $_SESSION['login_bloqueado_hasta'] = $_SESSION['login_bloqueado_hasta'] ?? 0;

        if ($ahora < $_SESSION['login_bloqueado_hasta']) {
            $minutos = (int) ceil(($_SESSION['login_bloqueado_hasta'] - $ahora) / 60);
            $_SESSION['error_login'] = "Demasiados intentos. Espera {$minutos} minuto(s).";
            header('Location: ' . BASE_URL . '/tom-workspace/login');
            exit;
        }

        $nombre    = trim($_POST['nombre_usuario'] ?? '');
        $contrasena = $_POST['contrasena'] ?? '';

        $usuario = $this->modelo->obtenerPorNombre($nombre);
        if ($usuario && password_verify($contrasena, $usuario['contrasena_hash'])) {
            $_SESSION['login_intentos']        = 0;
            $_SESSION['login_bloqueado_hasta'] = 0;
            session_regenerate_id(true);
            $_SESSION['id_usuario']     = $usuario['id'];
            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
            header('Location: ' . BASE_URL . '/tom-workspace');
            exit;
        }

        $_SESSION['login_intentos']++;
        if ($_SESSION['login_intentos'] >= 5) {
            $_SESSION['login_bloqueado_hasta'] = $ahora + (15 * 60);
            $_SESSION['login_intentos']        = 0;
            $_SESSION['error_login'] = 'Demasiados intentos fallidos. Cuenta bloqueada 15 minutos.';
        } else {
            $_SESSION['error_login'] = 'Credenciales inválidas';
        }
        header('Location: ' . BASE_URL . '/tom-workspace/login');
        exit;
    }

    public function cerrarSesion(): void
    {
        $_SESSION = [];
        session_destroy();
        header('Location: ' . BASE_URL . '/tom-workspace/login');
        exit;
    }
}
