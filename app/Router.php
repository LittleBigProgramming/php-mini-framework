<?php

namespace App;

use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\NoRouteFoundException;

class Router
{
    protected $routes = [];
    protected $methods = [];
    protected $path;

    /**
     * @param $path
     */
    public function setPath($path = '/')
    {
        $this->path = $path;
    }

    /**
     * @param $uri
     * @param $handler
     */
    public function addRoute($uri, $handler, array $methods = ['GET'])
    {
        $this->routes[$uri] = $handler;
        $this->methods[$uri] = $methods;
    }

    /**
     * @return mixed
     * @throws MethodNotAllowedException
     * @throws NoRouteFoundException
     */
    public function getResponse()
    {

        if (!isset($this->routes[$this->path])) {
            throw new NoRouteFoundException('No route found for this ' . $this->path);
        }

        if (!in_array($_SERVER['REQUEST_METHOD'], $this->methods[$this->path])) {
            throw new MethodNotAllowedException;
        }

        return $this->routes[$this->path];
    }
}
