<?php

namespace CandleLight\Middleware;

use CandleLight\Error;
use CandleLight\Middleware;
use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Authenticates the request using the Authentication Header: Bearer %token%
 * @package CandleLight\Middleware
 */
class Authenticate extends Middleware{


    /**
     * Rejects the current Request with the access denied error message
     * @param Response $response
     * @return Response
     */
    private function deny(Response $response): Response{
        return $response->withJson(new Error('Access denied!'));
    }

    /**
     * Validates the Request and adds the userId to the request as an attributes
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    function apply(Request $request, Response $response, callable $next): Response{
        $token = $request->getHeader('Authorization');
        if (count($token) === 0) {
            return $this->deny($response);
        }
        return $this->authenticate($token[0], $request, $response, $next);
    }

    /**
     * Validates the token and injects the attribute into the request object
     * @param string $token
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    private function authenticate(string $token, Request $request, Response $response, callable $next): Response{
        $token = str_replace('Bearer ', '', $token);
        try {
            $token = (array)JWT::decode($token, $_ENV['JWT_KEY'], [$_ENV['JWT_ALGO']]);
            if (!isset($token['user'])) {
                return $this->deny($response);
            }
        } catch (\Exception $e) {
            return $this->deny($response);
        }

        $request = $request->withAttribute('userId', $token['user']);
        $response = $next($request, $response);
        return $response;
    }
}

/* @var \CandleLight\App $app */
$app->addMiddleware('authenticate', Authenticate::class);