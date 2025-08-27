<?php
// Configuración de la base de datos
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "desafios_fitness");

// URL base para uso en enlaces o redirecciones
define("BASE_URL", "http://localhost/DesafiosFitness/");

// Iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Rutas absolutas base
define("ROOT_PATH", realpath(__DIR__ . '/..'));
define("CONFIG_PATH", ROOT_PATH . "/config");
define("DB_PATH", ROOT_PATH . "/db");
define("INCLUDES_PATH", ROOT_PATH . "/includes");
define("LIB_PATH", ROOT_PATH . "/lib");
define("TEMPLATES_PATH", ROOT_PATH . "/templates");
define("PUBLIC_PATH", ROOT_PATH . "/public");
define("ASSETS_PATH", BASE_URL . "assets");
