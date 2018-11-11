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
            },
            'response' => function () {
                return new Response;
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

        return $this->respond($this->process($response));
    }

    /**
     * @param $callable
     * @return mixed
     */
    protected function process($callable)
    {
        $response = $this->container->response;


        if (is_array($callable)) {
            $callable[0] = (!is_object($callable[0])) ? new $callable[0] : $callable[0] = new $callable[0];

            return call_user_func($callable, $response);
        }

        return $callable($response);
    }

    /**
     * @param $response
     */
    protected function respond($response)
    {
        if (!$response instanceof Response) {
            echo $response;
            return;
        }

        header(sprintf(
            'HTTP/%s %s %s',
            '1.1',
            $response->getStatusCode(),
            ''
        ));

        foreach ($response->getHeaders() as $header) {
            header($header[0] . ': ' . $header[1]);
        }

        echo $response->getBody();
    }

}
