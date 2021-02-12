<?php

namespace Davidwyly\Lunchnlearn\Http;

use Davidwyly\Lunchnlearn\Http\Controller\Controller;

/**
 * @property array $post
 * @property array $get
 * @property array $put
 * @property array $patch
 * @property array $delete
 * @method post(string $string, \Closure $param)
 * @method get(string $string, \Closure $param)
 */
class Router
{
    const SUPPORTED_METHODS = [
        'post',
        'get',
        'put',
        'patch',
        'delete',
    ];

    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function __call($method, $arguments)
    {
        if (in_array($method, self::SUPPORTED_METHODS)
            && count($arguments) === 2
        ) {
            list($route, $callback) = $arguments;
            $this->{$method}[$this->cleanRoute($route)] = $callback;
        }
    }

    /**
     * On destruct, find the proper route and call it
     */
    public function __destruct()
    {
        $request_method     = mb_strtolower($this->request->request_method);
        $request_method_map = (array)$this->{$request_method};

        // success if the route exists with the correct http method
        if (array_key_exists($this->request->request_uri, $request_method_map)) {
            call_user_func_array($request_method_map[$this->request->request_uri], [$this->request]);
        }
        $this->renderUnsupportedMethod($request_method);
        $this->renderUnsupportedEndpointMethod($request_method);
        $this->renderMissingEndpoint();
    }

    /**
     * @param string $request_method
     */
    private function renderUnsupportedMethod(string $request_method): void
    {
        if (!in_array($request_method, self::SUPPORTED_METHODS)) {
            http_response_code(Controller::HTTP_METHOD_NOT_ALLOWED);
            die(json_encode(['error' => "HTTP Method '$request_method' not allowed"], JSON_PRETTY_PRINT));
        }
    }

    /**
     * @param string $request_method
     */
    private function renderUnsupportedEndpointMethod(string $request_method): void
    {
        $supported_methods = self::SUPPORTED_METHODS;
        unset($supported_methods[$request_method]);
        foreach ($supported_methods as $supported_method) {
            if (array_key_exists($this->request->request_uri, (array)$this->{$supported_method})) {
                http_response_code(Controller::HTTP_METHOD_NOT_ALLOWED);
                die(json_encode(['error' => "HTTP Method '$request_method' not allowed"], JSON_PRETTY_PRINT));
            }
        }
    }

    private function renderMissingEndpoint(): void
    {
        http_response_code(Controller::HTTP_NOT_FOUND);
        die(json_encode(['error' => 'Resource not found'], JSON_PRETTY_PRINT));
    }

    /**
     * @param string $route
     *
     * @return string
     */
    private function cleanRoute(string $route): string
    {
        if (empty($route)) {
            return '/';
        }
        return rtrim($route, '/');
    }
}