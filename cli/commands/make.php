<?php

use CandleLight\App;
use CandleLight\Artisan\Client;
use CandleLight\Artisan\Command;
use CandleLight\Artisan\Operation;
use CandleLight\Artisan\Template;
use CandleLight\Route;

/** @var $app App */
/** @var $client Client */

/**
 * Build Blocks from a Template
 */
$client->addCommand(new Command('make', 'Generate a CDL-Block of the given type', function (Command $c) use ($app): void{

    /**
     * Action-Block
     */
    $c->addOperation(new Operation('action', 'Builds a new route Action-Block', function (): void{

        // Methods array
        $methods = [
            Route::GET,
            Route::POST,
            Route::PUT,
            Route::DELETE
        ];

        // Request all Fields in one big chunk
        $fields = [
            'name' => Client::prompt('Action name:', 'isUpperCamelCase'),
            'handle' => Client::prompt('Action handle:', 'isSnakeCase'),
            'method' => 'ROUTE::' . strtoupper(Client::prompt(sprintf('Method (%s)', implode(', ', $methods)), function (string $s) use ($methods): bool{
                    return in_array($s, $methods);
                }))
        ];

        // Build file from template
        $tmpl = new Template(CDL_CLI . '/templates/tmpl.action.txt', CDL_ACTIONS . checkDirString($fields['name']) . '.php', $fields);
        $tmpl->process();

    }));

    /**
     * Calculator-Block
     */
    $c->addOperation(new Operation('calculator', 'Builds a new Calculator-Block', function (): void{

        // Request all Fields in one big chunk
        $fields = [
            'name' => Client::prompt('Calculator name:', 'isUpperCamelCase'),
            'handle' => Client::prompt('Calculator handle:', 'isSnakeCase')
        ];

        // Build file from template
        $tmpl = new Template(__DIR__ . '/templates/tmpl.calculator.txt', CDL_CALCULATORS . checkDirString($fields['name']) . '.php', $fields);
        $tmpl->process();

    }));

    /**
     * Filter-Block
     */
    $c->addOperation(new Operation('filter', 'Builds a new Filter-Block', function (): void{

        // Request all Fields in one big chunk
        $fields = [
            'name' => Client::prompt('Filter name:', 'isUpperCamelCase'),
            'handle' => Client::prompt('Filter handle:', 'isSnakeCase')
        ];

        // Build file from template
        $tmpl = new Template(CDL_CLI . '/templates/tmpl.filter.txt', CDL_FILTERS . checkDirString($fields['name']) . '.php', $fields);
        $tmpl->process();

    }));

    /**
     * Middleware-Block
     */
    $c->addOperation(new Operation('middleware', 'Builds a new Middleware-Block', function (): void{

        // Request all Fields in one big chunk
        $fields = [
            'name' => Client::prompt('Middleware name:', 'isUpperCamelCase'),
            'handle' => Client::prompt('Middleware handle:', 'isSnakeCase')
        ];

        // Build file from template
        $tmpl = new Template(CDL_CLI . '/templates/tmpl.middleware.txt', CDL_MIDDLEWARE . checkDirString($fields['name']) . '.php', $fields);
        $tmpl->process();

    }));

    /**
     * Content-Type
     */
    $c->addOperation(new Operation('type', 'Builds a new Content-Type', function (): void{

        // Request all Fields in one big chunk
        $fields = [
            'type' => Client::prompt('Type slug:'),
            'title' => Client::prompt('Type Title text:'),
            'description' => Client::prompt('Type Description text:')
        ];

        // Build file from template
        $tmpl = new Template(CDL_CLI . '/templates/tmpl.type.txt', CDL_TYPES . checkDirString($fields['type']) . '.php', $fields);
        $tmpl->process();

    }));

    /**
     * Validation-Block
     */
    $c->addOperation(new Operation('validation', 'Builds a new Validation-Block', function (): void{

        // Request all Fields in one big chunk
        $fields = [
            'name' => Client::prompt('Validation name:', 'isUpperCamelCase'),
            'handle' => Client::prompt('Validation handle:', 'isSnakeCase')
        ];

        // Build file from template
        $tmpl = new Template(CDL_CLI . '/templates/tmpl.validation.txt', CDL_VALIDATIONS . checkDirString($fields['name']) . '.php', $fields);
        $tmpl->process();

    }));

    /**
     * Database Migration
     */
    $c->addOperation(new Operation('migration', 'Creates a new Migration file for the given Type', function () use ($app): void{
        $type = Client::prompt('Type slug:');
        if (!$app->hasType($type)) {
            throw new Exception(sprintf('Type %s does not exist in the Application.', $type));
        }
        $fields = [
            'type' => $type,
            'table' => ($app->getType($type)->getSettings())['table']
        ];
        $tmpl = new Template(CDL_CLI . '/templates/tmpl.migration.txt', CDL_MIGRATIONS . date('Y-m-d-U') . '-' . $type . '.php', $fields);
        $tmpl->process();
    }));

}));