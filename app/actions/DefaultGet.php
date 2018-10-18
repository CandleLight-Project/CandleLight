<?php


namespace CandleLight\Route;


use CandleLight\Model;
use CandleLight\Route;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Default action for the GET Routes
 * @package CandleLight\Route
 */
class DefaultGet extends Route{

    private static $defaults = [
        'operator' => '=',
        'firstOrFail' => false
    ];

    /**
     * Function to execute, if this route is called
     * @param Request $request HTTP Request object
     * @param Response $response HTTP Response object
     * @param array $args arguments array
     * @return mixed
     */
    public function dispatch(Request $request, Response $response, array $args){
        $type = $this->getType();
        $atts = $this->parseAttributes(self::$defaults);

        /* @var $query Model */
        $query = $type->new();
        foreach ($args as $key => $value) {
            $query = $query->where($key, $atts['operator'], $value);
        }
        if ($atts['firstOrFail']) {
            return $query->firstOrFail()->toArray();
        } else {
            return $query->get()->toArray();
        }
    }
}

/* @var \CandleLight\App $app */
$app->addRoute(Route::GET, 'default', DefaultGet::class);