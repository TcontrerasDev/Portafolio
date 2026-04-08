<?php

ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Carga de variables de entorno desde .env
$_dotenv = __DIR__ . '/../.env';
if (file_exists($_dotenv)) {
    foreach (parse_ini_file($_dotenv) as $_k => $_v) {
        $_ENV[$_k] = $_v;
    }
}
unset($_dotenv, $_k, $_v);

session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => '',
    'secure'   => true,
    'httponly' => true,
    'samesite' => 'Strict',
]);
session_start();

header("Content-Security-Policy: default-src 'self'; script-src 'self' cdn.jsdelivr.net; style-src 'self' cdn.jsdelivr.net fonts.googleapis.com; font-src 'self' cdn.jsdelivr.net fonts.gstatic.com; img-src 'self' data:; connect-src 'self' cdn.jsdelivr.net; form-action 'self'; object-src 'none'; frame-ancestors 'none'");

// 1. CARGA DE ARCHIVOS
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/middleware/AuthMiddleware.php';

// Autoloader simple: busca en controllers, models, helpers y middleware
spl_autoload_register(function ($clase) {
    $rutas = [
        __DIR__ . '/../app/controllers/' . $clase . '.php',
        __DIR__ . '/../app/models/'      . $clase . '.php',
        __DIR__ . '/../app/helpers/'     . $clase . '.php',
        __DIR__ . '/../app/middleware/'  . $clase . '.php',
    ];
    foreach ($rutas as $ruta) {
        if (file_exists($ruta)) { require_once $ruta; return; }
    }
});

// Carga explícita de modelos públicos (no siguen convención de nombre de clase)
require_once __DIR__ . '/../app/models/TechnicalSkill.php';
require_once __DIR__ . '/../app/models/Experience.php';
require_once __DIR__ . '/../app/models/Project.php';

// 2. LÓGICA DE RUTAS
$uri     = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$metodo  = $_SERVER['REQUEST_METHOD'];
$ruta    = str_replace(BASE_URL, '', $uri);

// 3. PREPARACIÓN DE LA BASE DE DATOS
$database = new Database();
$pdo      = $database->getConnection();

// ── Rutas públicas ────────────────────────────────────────────────────────

if (($ruta === '/' || $ruta === '' || $ruta === '/index.php') && $metodo === 'GET') {
    require_once __DIR__ . '/../app/controllers/HomeController.php';
    (new HomeController($pdo))->index();
    exit;
}

if ($ruta === '/api/proyectos' && $metodo === 'GET') {
    require_once __DIR__ . '/../app/controllers/ProjectApiController.php';
    (new ProjectApiController($pdo))->index($_GET['categoria'] ?? null);
    exit;
}

// ── Rutas admin: login (públicas) ─────────────────────────────────────────

if ($ruta === '/admin/login' && $metodo === 'GET') {
    (new AuthController($pdo))->mostrarLogin(); exit;
}
if ($ruta === '/admin/login' && $metodo === 'POST') {
    (new AuthController($pdo))->procesarLogin(); exit;
}
if ($ruta === '/admin/logout') {
    (new AuthController($pdo))->cerrarSesion(); exit;
}

// ── A partir de aquí se requiere sesión ───────────────────────────────────
AuthMiddleware::verificar();

// Dashboard
if ($ruta === '/admin' && $metodo === 'GET') {
    (new AdminController($pdo))->dashboard(); exit;
}

// ── Proyectos ─────────────────────────────────────────────────────────────
if ($ruta === '/admin/proyectos' && $metodo === 'GET') {
    (new ProyectoAdminController($pdo))->index(); exit;
}
if ($ruta === '/admin/proyectos/crear' && $metodo === 'GET') {
    (new ProyectoAdminController($pdo))->crear(); exit;
}
if ($ruta === '/admin/proyectos/guardar' && $metodo === 'POST') {
    (new ProyectoAdminController($pdo))->guardar(); exit;
}
if (preg_match('#^/admin/proyectos/editar/(\d+)$#', $ruta, $m) && $metodo === 'GET') {
    (new ProyectoAdminController($pdo))->editar((int)$m[1]); exit;
}
if (preg_match('#^/admin/proyectos/actualizar/(\d+)$#', $ruta, $m) && $metodo === 'POST') {
    (new ProyectoAdminController($pdo))->actualizar((int)$m[1]); exit;
}
if (preg_match('#^/admin/proyectos/eliminar/(\d+)$#', $ruta, $m) && $metodo === 'POST') {
    (new ProyectoAdminController($pdo))->eliminar((int)$m[1]); exit;
}

// ── Habilidades ───────────────────────────────────────────────────────────
if ($ruta === '/admin/habilidades' && $metodo === 'GET') {
    (new HabilidadAdminController($pdo))->index(); exit;
}
if ($ruta === '/admin/habilidades/crear' && $metodo === 'GET') {
    (new HabilidadAdminController($pdo))->crear(); exit;
}
if ($ruta === '/admin/habilidades/guardar' && $metodo === 'POST') {
    (new HabilidadAdminController($pdo))->guardar(); exit;
}
if (preg_match('#^/admin/habilidades/editar/(\d+)$#', $ruta, $m) && $metodo === 'GET') {
    (new HabilidadAdminController($pdo))->editar((int)$m[1]); exit;
}
if (preg_match('#^/admin/habilidades/actualizar/(\d+)$#', $ruta, $m) && $metodo === 'POST') {
    (new HabilidadAdminController($pdo))->actualizar((int)$m[1]); exit;
}
if (preg_match('#^/admin/habilidades/eliminar/(\d+)$#', $ruta, $m) && $metodo === 'POST') {
    (new HabilidadAdminController($pdo))->eliminar((int)$m[1]); exit;
}

// ── Experiencia ───────────────────────────────────────────────────────────
if ($ruta === '/admin/experiencia' && $metodo === 'GET') {
    (new ExperienciaAdminController($pdo))->index(); exit;
}
if ($ruta === '/admin/experiencia/crear' && $metodo === 'GET') {
    (new ExperienciaAdminController($pdo))->crear(); exit;
}
if ($ruta === '/admin/experiencia/guardar' && $metodo === 'POST') {
    (new ExperienciaAdminController($pdo))->guardar(); exit;
}
if (preg_match('#^/admin/experiencia/editar/(\d+)$#', $ruta, $m) && $metodo === 'GET') {
    (new ExperienciaAdminController($pdo))->editar((int)$m[1]); exit;
}
if (preg_match('#^/admin/experiencia/actualizar/(\d+)$#', $ruta, $m) && $metodo === 'POST') {
    (new ExperienciaAdminController($pdo))->actualizar((int)$m[1]); exit;
}
if (preg_match('#^/admin/experiencia/eliminar/(\d+)$#', $ruta, $m) && $metodo === 'POST') {
    (new ExperienciaAdminController($pdo))->eliminar((int)$m[1]); exit;
}

// ── Categorías (habilidades) ──────────────────────────────────────────────
if ($ruta === '/admin/categorias' && $metodo === 'GET') {
    (new CategoriaAdminController($pdo))->index(); exit;
}
if ($ruta === '/admin/categorias/crear' && $metodo === 'GET') {
    (new CategoriaAdminController($pdo))->crear(); exit;
}
if ($ruta === '/admin/categorias/guardar' && $metodo === 'POST') {
    (new CategoriaAdminController($pdo))->guardar(); exit;
}
if (preg_match('#^/admin/categorias/editar/(\d+)$#', $ruta, $m) && $metodo === 'GET') {
    (new CategoriaAdminController($pdo))->editar((int)$m[1]); exit;
}
if (preg_match('#^/admin/categorias/actualizar/(\d+)$#', $ruta, $m) && $metodo === 'POST') {
    (new CategoriaAdminController($pdo))->actualizar((int)$m[1]); exit;
}
if (preg_match('#^/admin/categorias/eliminar/(\d+)$#', $ruta, $m) && $metodo === 'POST') {
    (new CategoriaAdminController($pdo))->eliminar((int)$m[1]); exit;
}

// ── Categorías de proyectos ───────────────────────────────────────────────
if ($ruta === '/admin/categorias-proyectos' && $metodo === 'GET') {
    (new CategoriaProyectoAdminController($pdo))->index(); exit;
}
if ($ruta === '/admin/categorias-proyectos/crear' && $metodo === 'GET') {
    (new CategoriaProyectoAdminController($pdo))->crear(); exit;
}
if ($ruta === '/admin/categorias-proyectos/guardar' && $metodo === 'POST') {
    (new CategoriaProyectoAdminController($pdo))->guardar(); exit;
}
if (preg_match('#^/admin/categorias-proyectos/editar/(\d+)$#', $ruta, $m) && $metodo === 'GET') {
    (new CategoriaProyectoAdminController($pdo))->editar((int)$m[1]); exit;
}
if (preg_match('#^/admin/categorias-proyectos/actualizar/(\d+)$#', $ruta, $m) && $metodo === 'POST') {
    (new CategoriaProyectoAdminController($pdo))->actualizar((int)$m[1]); exit;
}
if (preg_match('#^/admin/categorias-proyectos/eliminar/(\d+)$#', $ruta, $m) && $metodo === 'POST') {
    (new CategoriaProyectoAdminController($pdo))->eliminar((int)$m[1]); exit;
}

// ── 404 ───────────────────────────────────────────────────────────────────
http_response_code(404);
echo "<h1>Error 404 - Página no encontrada</h1>";
echo "<p>La ruta <strong>" . htmlspecialchars($ruta, ENT_QUOTES, 'UTF-8') . "</strong> no existe.</p>";
