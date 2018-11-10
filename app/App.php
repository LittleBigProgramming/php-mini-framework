<?php

namespace App;

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
        $response = $router->getResponse();

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
