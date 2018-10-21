<?php

use CandleLight\App;
use CandleLight\DirProvider;

// Base
define('CDL_ROOT', __DIR__ . DIRECTORY_SEPARATOR);
define('CDL_APP', CDL_ROOT . 'app' . DIRECTORY_SEPARATOR);
define('CDL_CLI', CDL_ROOT . 'cli' . DIRECTORY_SEPARATOR);

// Vendors
define('CDL_VENDOR', CDL_ROOT . 'vendor' . DIRECTORY_SEPARATOR);

// Application Data
define('CDL_CONFIG', CDL_APP . 'config' . DIRECTORY_SEPARATOR);
define('CDL_TYPES', CDL_APP . 'types' . DIRECTORY_SEPARATOR);
define('CDL_VALIDATIONS', CDL_APP . 'validations' . DIRECTORY_SEPARATOR);
define('CDL_CALCULATORS', CDL_APP . 'calculators' . DIRECTORY_SEPARATOR);
define('CDL_FILTERS', CDL_APP . 'filters' . DIRECTORY_SEPARATOR);
define('CDL_MIDDLEWARE', CDL_APP . 'middleware' . DIRECTORY_SEPARATOR);
define('CDL_MIGRATIONS', CDL_APP . 'migrations' . DIRECTORY_SEPARATOR);
define('CDL_ACTIONS', CDL_APP . 'actions' . DIRECTORY_SEPARATOR);

// Load Vendor Files
require_once CDL_VENDOR . 'autoload.php';

// Prepare environment
$dotenv = new Dotenv\Dotenv(CDL_ROOT);
$dotenv->load();

// Initialize Application
$app = new App();

// Load plugins and extensions
DirProvider::glob(CDL_VALIDATIONS . '*.php', 0, ['app' => $app]);    // Load Validations
DirProvider::glob(CDL_CALCULATORS . '*.php', 0, ['app' => $app]);    // Load Calculators
DirProvider::glob(CDL_FILTERS . '*.php', 0, ['app' => $app]);        // Load Filters
DirProvider::glob(CDL_MIDDLEWARE . '*.php', 0, ['app' => $app]);     // Load Middleware
DirProvider::glob(CDL_MIGRATIONS . '*.php', 0, ['app' => $app]);     // Load Migrations
DirProvider::glob(CDL_ACTIONS . '*.php', 0, ['app' => $app]);        // Load Custom Routes
DirProvider::glob(CDL_TYPES . '*.php', 0, ['app' => $app]);          // Load Types
DirProvider::glob(CDL_CONFIG . '*.php', 0, ['app' => $app]);        // Load Config files

// Prepare Application
$app->load(false);


if (CDL_START) {
    // Start Applications
    $app->run();
}