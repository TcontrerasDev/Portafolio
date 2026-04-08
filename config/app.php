<?php

// BASE_URL: prefijo de URL del proyecto
// Local  → /tomas-contreras
// Prod   → '' (vacío, app en la raíz del dominio)
//
// $_SERVER['SCRIPT_NAME'] tras el rewrite de Apache:
//   local: /tomas-contreras/public/index.php  → strippear '/public'
//   prod:  /index.php                          → dirname = '/'  → ''

$_scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');

// Si index.php vive en …/public/, subir un nivel
if (substr($_scriptDir, -7) === '/public') {
    $_scriptDir = substr($_scriptDir, 0, -7);
}

define('BASE_URL',  $_scriptDir);          // ''  en prod | '/tomas-contreras' en local
define('BASE_PATH', dirname(__DIR__));     // Ruta absoluta a la raíz del proyecto

unset($_scriptDir);
