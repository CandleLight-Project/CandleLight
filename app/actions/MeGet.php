<?php


namespace CandleLight\Route;

use CandleLight\Route;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Default action for the PUT Routes
 * @package CandleLight\Route
 */
class MeGet extends Route{

    /**
     * Function to execute, if this route is called
     * @param Request $request HTTP Request object
     * @param Response $response HTTP Response object
     * @param array $args arguments array
     * @return mixed
     */
    public function dispatch(Request $request, Response $response, array $args){
        $user = $request->getAttribute('userId');
        $type = $this->getType();
        $mode = $type->new();
        $user = $mode->findOrFail($user);
        return $user->toArray();
    }
}

/* @var \CandleLight\App $app */
$app->addRoute(Route::GET, 'me', MeGet::class);