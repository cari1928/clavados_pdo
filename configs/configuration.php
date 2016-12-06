<?php //2016-10-14

define('PATH', '/var/www/html/clavados_pdo/');

// Archivo de configuración de Clavados
// define('DB_IP', '192.168.1.69'); //se debe modificar cada que se acceda a internet
// define('DB_IP', '192.168.1.79');
// define('DB_IP', '192.168.43.166');
define('DB_IP', 'localhost');
define('DB_NAME', 'clavados_pdo');
define('DB_USER', 'admincl');
define('DB_PASS', '1234');
define('DB_ENGINE', 'mysql');

/*
2016-10-14 - TEMPLATE ENGINE CONSTANTS
LAST DIAGONAL IS VERY IMPORTANT, IS RELATIONATED WITH AN ADDRESS
se ocupa en cp_web.class.php->templateEngine()
 */
define('TEMPLATE', PATH . 'templates/');
define('TEMPLATE_C', PATH . 'templates_c/');
define('CACHE', PATH . 'cache/');
define('CONFIGS', PATH . 'configs/');
