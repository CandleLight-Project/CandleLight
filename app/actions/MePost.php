<?php


namespace CandleLight\Route;


use CandleLight\Error;
use CandleLight\Route;
use Firebase\JWT\JWT;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Default action for the PUT Routes
 * @package CandleLight\Route
 */
class MePost extends Route{

    /**
     * Function to execute, if this route is called
     * @param Request $request HTTP Request object
     * @param Response $response HTTP Response object
     * @param array $args arguments array
     * @return mixed
     */
    public function dispatch(Request $request, Response $response, array $args){
        $params = $request->getParams();
        if (!isset($params['email']) || empty($params['email'])) {
            return new Error('E-Mail not set.');
        }

        // Find User
        $type = $this->getType();
        $user = $type->new();
        $user = $user->where('email', $params['email']);
        $user = $user->firstOrFail();
        $user = $user->toArray();


        // Validate Password
        if (!password_verify($params['password'], $user['password'])) {
            return new Error('Credentials invalid');
        }

        // Generate Token and returns the full response
        return [
            'token' => $this->jwtEncode($user['id']),
            'success' => true
        ];
    }

    /**
     * Generates the JWT base on the given options and the
     * @param int $user
     * @return array
     */
    private function jwtEncode(int $user): string{
        $token = [
            'iat' => time(),
            'exp' => time() + (int)$_ENV['JWT_DURATION'],
            'user' => $user
        ];
        return JWT::encode($token, $_ENV['JWT_KEY'], $_ENV['JWT_ALGO']);
    }
}

/* @var \CandleLight\App $app */
$app->addRoute(Route::POST, 'me', MePost::class);