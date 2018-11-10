<?php

namespace App;

use App\Exceptions\NoRouteFoundException;

class App
{

    protected $container;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->container = new Container([
            'router' => function () {
                return new Router;
            }
        ]);
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param $uri
     * @param $handler
     */
    public function get($uri, $handler)
    {
        $this->container->router->addRoute($uri, $handler, ['GET']);
    }

    /**
     * @param $uri
     * @param $handler
     */
    public function post($uri, $handler)
    {
        $this->container->router->addRoute($uri, $handler, ['POST']);
    }

    /**
     * @param $uri
     * @param $handler
     * @param array $methods
     */
    public function map($uri, $handler, array $methods = ['GET'])
    {
        $this->container->router->addRoute($uri, $handler, $methods);
    }

    /**
     * @return mixed
     */
    public function run()
    {
        $router = $this->container->router;
        $router->setPath($_SERVER['REQUEST_URI'] ?? '/');

        try {
            $response = $router->getResponse();
        } catch (NoRouteFoundException $e) {
            if ($this->container->has('errorHandler')) {
                $response = $this->container->errorHandler;
            } else {
                return;
            }
        }

        return $this->process($response);
    }

    /**
     * @param $callable
     * @return mixed
     */
    protected function process($callable)
    {
        return $callable();
    }
}
