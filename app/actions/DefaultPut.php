<?php


namespace CandleLight\Route;


use CandleLight\Error;
use CandleLight\Model;
use CandleLight\Route;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Default action for the PUT Routes
 * @package CandleLight\Route
 */
class DefaultPut extends Route{

    private static $defaults = [
        'operator' => '='
    ];

    /**
     * Function to execute, if this route is called
     * @param Request $request HTTP Request object
     * @param Response $response HTTP Response object
     * @param array $args arguments array
     * @return mixed
     */
    public function dispatch(Request $request, Response $response, array $args){
        $app = $this->getApp();
        $type = $this->getType();
        $atts = $this->parseAttributes(self::$defaults);

        /* @var $query Model */
        $query = $type->new();
        foreach ($args as $key => $value) {
            $query = $query->where($key, $atts['operator'], $value);
        }
        $query = $query->firstOrFail();
        foreach ($request->getParams() as $key => $value) {
            $query->{$key} = $value;
        }
        $query->applyCalculators($app);
        $query->applyFilters($app);
        if ($query->doValidation($app)) {
            return new Error($query->getValidationMessage());
        }
        $query->update();
        return $query;
    }
}

/* @var \CandleLight\App $app */
$app->addRoute(Route::PUT, 'default', DefaultPut::class);