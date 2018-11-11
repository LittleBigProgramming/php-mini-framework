<?php

namespace App;

class Response
{
    protected $body;
    protected $statusCode = 200;
    protected $headers = [];

    /**
     * @param $body
     * @return mixed
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param $statusCode
     * @return mixed
     */
    public function withStatus($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $body
     * @return $this
     */
    public function withJson($body)
    {
        $this->withHeader('Content-Type', 'application/json');
        $this->body = json_encode($body);

        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function withHeader($name, $value)
    {
        $this->headers[] = [$name, $value];
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
