<?php

use CandleLight\App;
use CandleLight\DirProvider;

define('CDL_ROOT', __DIR__ . DIRECTORY_SEPARATOR);
define('CDL_CONFIG', CDL_ROOT . 'config' . DIRECTORY_SEPARATOR);
define('CDL_TYPES', CDL_ROOT . 'types' . DIRECTORY_SEPARATOR);
define('CDL_VENDOR', CDL_ROOT . 'vendor' . DIRECTORY_SEPARATOR);

define('CDL_VALIDATIONS', CDL_ROOT . 'validations' . DIRECTORY_SEPARATOR);
define('CDL_CALCULATORS', CDL_ROOT . 'calculators' . DIRECTORY_SEPARATOR);
define('CDL_FILTERS', CDL_ROOT . 'filters' . DIRECTORY_SEPARATOR);
define('CDL_MIDDLEWARE', CDL_ROOT . 'middleware' . DIRECTORY_SEPARATOR);
define('CDL_ACTIONS', CDL_ROOT . 'actions' . DIRECTORY_SEPARATOR);

require_once CDL_VENDOR . 'autoload.php';

$dotenv = new Dotenv\Dotenv(CDL_ROOT);
$dotenv->load();

// Initialize Application
$app = new App();

// Load plugins and extensions
DirProvider::glob(CDL_VALIDATIONS . '*.php', 0, ['app' => $app]);    // Load Validations
DirProvider::glob(CDL_CALCULATORS . '*.php', 0, ['app' => $app]);    // Load Calculators
DirProvider::glob(CDL_FILTERS . '*.php', 0, ['app' => $app]);        // Load Filters
DirProvider::glob(CDL_MIDDLEWARE . '*.php', 0, ['app' => $app]);     // Load Middleware
DirProvider::glob(CDL_ACTIONS . '*.php', 0, ['app' => $app]);        // Load Custom Routes
DirProvider::glob(CDL_TYPES . '*.php', 0, ['app' => $app]);          // Load Types
DirProvider::glob(CDL_CONFIG . '*.php', 0, ['app' => $app]);        // Load Config files

// Prepare Application
$app->load(false);

// Start Applications
$app->run();