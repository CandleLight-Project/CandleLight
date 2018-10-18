<?php

use CandleLight\Artisan\Client;
use CandleLight\Artisan\Command;
use CandleLight\Artisan\Operation;
use CandleLight\Artisan\Template;
use CandleLight\Route;

/**
 * Checks if the given string is a UpperCamelCase-String
 * @param string $s the string to check
 * @return bool returns true if the string matches the pattern
 */
function isUpperCamelCase(string $s): bool{
    return preg_match('/^([A-Z][a-z]+)*$/', $s);
}

/**
 * Checks if the given string is a snake-case-String
 * @param string $s the string to check
 * @return bool returns true if the string matches the pattern
 */
function isSnakeCase(string $s): bool{
    return preg_match('/^([a-z]+-*)*$/', $s);
}



$client = new Client();

/**
 * Build Blocks from a Template
 */
$client->addCommand(new Command('make', 'Generate a CDL-Block of the given type', function (Command $c){

    /**
     * Action-Block
     */
    $c->addOperation(new Operation('action', 'Builds a new route Action-Block', function (){

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
        $tmpl = new Template(__DIR__ . '/templates/tmpl.action.txt', CDL_ACTIONS . $fields['name'] . '.php', $fields);
        $tmpl->process();

    }));

    /**
     * Calculator-Block
     */
    $c->addOperation(new Operation('calculator', 'Builds a new Calculator-Block', function (){

        // Request all Fields in one big chunk
        $fields = [
            'name' => Client::prompt('Calculator name:', 'isUpperCamelCase'),
            'handle' => Client::prompt('Calculator handle:', 'isSnakeCase')
        ];

        // Build file from template
        $tmpl = new Template(__DIR__ . '/templates/tmpl.calculator.txt', CDL_CALCULATORS . $fields['name'] . '.php', $fields);
        $tmpl->process();

    }));

    /**
     * Filter-Block
     */
    $c->addOperation(new Operation('filter', 'Builds a new Filter-Block', function (){

        // Request all Fields in one big chunk
        $fields = [
            'name' => Client::prompt('Filter name:', 'isUpperCamelCase'),
            'handle' => Client::prompt('Filter handle:', 'isSnakeCase')
        ];

        // Build file from template
        $tmpl = new Template(__DIR__ . '/templates/tmpl.filter.txt', CDL_FILTERS . $fields['name'] . '.php', $fields);
        $tmpl->process();

    }));

    /**
     * Middleware-Block
     */
    $c->addOperation(new Operation('middleware', 'Builds a new Middleware-Block', function (){

        // Request all Fields in one big chunk
        $fields = [
            'name' => Client::prompt('Middleware name:', 'isUpperCamelCase'),
            'handle' => Client::prompt('Middleware handle:', 'isSnakeCase')
        ];

        // Build file from template
        $tmpl = new Template(__DIR__ . '/templates/tmpl.middleware.txt', CDL_MIDDLEWARE . $fields['name'] . '.php', $fields);
        $tmpl->process();

    }));

    /**
     * Content-Type
     */
    $c->addOperation(new Operation('type', 'Builds a new Content-Type', function (){

        // Request all Fields in one big chunk
        $fields = [
            'type' => Client::prompt('Type slug:'),
            'title' => Client::prompt('Type Title text:'),
            'description' => Client::prompt('Type Description text:')
        ];

        // Build file from template
        $tmpl = new Template(__DIR__ . '/templates/tmpl.type.txt', CDL_TYPES . $fields['type'] . '.php', $fields);
        $tmpl->process();

    }));

    /**
     * Validation-Block
     */
    $c->addOperation(new Operation('validation', 'Builds a new Validation-Block', function (){

        // Request all Fields in one big chunk
        $fields = [
            'name' => Client::prompt('Validation name:', 'isUpperCamelCase'),
            'handle' => Client::prompt('Validation handle:', 'isSnakeCase')
        ];

        // Build file from template
        $tmpl = new Template(__DIR__ . '/templates/tmpl.validation.txt', CDL_VALIDATIONS . $fields['name'] . '.php', $fields);
        $tmpl->process();

    }));

}));
$client->dispatch($argv);
exit();