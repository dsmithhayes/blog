<?php

namespace Blog\Lib;

abstract class Route
{
    /**
     * @var string
     *      The name of the route
     */
    protected $name;

    /**
     * @var string|array
     *      The HTTP method, or methods
     */
    protected $method;

    /**
     * @var string
     *      The route pattern to match
     */
    protected $route;

    /**
     * @var callable
     *      The callback method for when the route is matched
     */
    protected $callback;

    /**
     * @param string $name
     *      Sets the name of the route
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string|array $method
     *      Sets the method or methods for the route
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param string $route
     *      The actual route to match
     */
    public function setRoute(string $route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @param callable $callback
     *      The callback method for when the route is matched
     */
    public function setCallback(callable $callback)
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @return string
     *      The name of the route
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|array
     *      The HTTP method, or methods
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     *      The route pattern
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @return callable
     *      The un-called callback function
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $req
     *      Instance of the appklication's HTTP Request
     * @param \Psr\Http\Message\ResponseInterface $res
     *      Instance of the application's HTTP Response
     * @return \Psr\Http\Message\ResponseInterface
     *      The response from the callback
     */
    public function call(Request $req, Response $res): Response
    {
        return $this->callback($req, $res);
    }
}
