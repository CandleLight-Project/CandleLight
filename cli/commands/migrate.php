<?php

/** @var $app App */
/** @var $client Client */

use CandleLight\App;
use CandleLight\Artisan\Client;
use CandleLight\Artisan\Command;
use CandleLight\Artisan\Operation;
use CandleLight\Artisan\Template;
use CandleLight\Migration;

$client->addCommand(new Command('migrate', 'Manage Database Migrations', function (Command $c) use ($app){

    /**
     * Executes all open migrations (up)
     */
    $c->addOperation(new Operation('up', 'Executes all undone DB-Migrations', function () use ($app){
        Migration::prepareMigrationTable($app);
        foreach ($app->getMigrations() as $name => $migration) {
            if (!Migration::hasMigrated($name)) {
                $migration->execUp($name);
                echo sprintf('UP: %s' . PHP_EOL, $name);
            }
        }
    }));

    /**
     * Rollback one migration
     */
    $c->addOperation(new Operation('down', 'Rollbacks the last DB-Migrations', function () use ($app){
        Migration::prepareMigrationTable($app);
        $name = Migration::getLastMigration($app);
        if ($name){
            $migration = $app->getMigration($name);
            $migration->execDown($name);
            echo sprintf('Down: %s' . PHP_EOL, $name);
        }
    }));
}));