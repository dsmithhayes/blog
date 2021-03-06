<?php

namespace Blog\Lib;

use Interop\Container\ContainerInterface as Container;

/**
 * Ideally you will right the callback function to mimic exactly what you
 * would normally pass into the `Slim\App`. When the callback is passed into the
 * `Slim\App` it assumes to be a method of that object. The use of `$this` will
 * work as you would expect it within the callback functions.
 */
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
     * @var \Interop\Container\ContainerInterface
     *      An instance of the application container
     */
    protected $container;

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
     * @param callable|string $callback
     *      A callback method for the response, or the name of a class and
     *      method to pass into the application
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @param \Interop\Container\ContainerInterface $container
     *      The application container
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
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
     *      The un-called callback function.
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @return \Interop\Container\ContainerInteface
     *      The instance of the application container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }
}
