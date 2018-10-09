<?php

/**
 * Adds DB connections to System
 */
$app->initDb([
    "default" => [
        "driver" => "mysql",
        "host" => "localhost",
        "database" => "cdl",
        "username" => "username",
        "password" => "password",
        "charset" => "utf8",
        "collation" => "utf8_unicode_ci",
        "prefix" => "cdl_"
    ]
]);