<?php

namespace Blog\Lib;

use Blog\Lib\Route;
use Blog\Lib\Exception\RouterException

/**
 * This class will add all of the routes defined for the application.
 */
class Router
{
    /**
     * @var static array
     *      Collection of all the Route objects defining a route.
     */
    private $routes = [];

    /**
     * @param array $routes
     *      An array of Route objects
     */
    public function __construct(array $routes)
    {
        foreach ($routes as $route) {
            if ($route instanceof Route) {
                $this->routes[$route->getName()] = $route;
            }
        }
    }

    /**
     * @param \Blog\Lib\Route $route
     *      A Route object to append to the internal collection
     * @param bool $override
     *      If true, overrides identical routes. Defaults false
     * @throws \Blog\Lib\Exception\RouterException
     *      When trying to append an existing route
     */
    public function appendRoute(Route $route, bool $override = false)
    {
        if (!$override) {
            if ($this->routeExists($route->getRoute())) {
                throw new RouterException('Route already exists.');
            }
        }

        $this->routes[$route->getName()] = $route;
        return $this;
    }

    /**
     * @param string $route
     *      The route pattern to match against registered routes.
     * @return bool
     *      True if route pattern already exists
     */
    public function routeExists(string $route): bool
    {
        foreach ($this->yieldRoutes() as $route) {
            if ($route->getRoute() === $route) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     *      True if the route queue is empty
     */
    public function isEmpty(): bool
    {
        return empty($this->routes);
    }

    /**
     * @return array
     *      Yields all of the registered routes
     */
    public function yeildRoutes(): array
    {
        yield $this->routes;
    }

    /**
     * Builds all of the routes for the application.
     * 
     * @param \Slim\App &$app
     *      Reference to the Slim application
     */
    public function hydrate(&$app)
    {
        foreach ($this->yeildRoutes() as $route) {
            if (is_array($route->getMethod()) {
                $app->match($route->getMethod(),
                            $route->getRoute(),
                            $route->getCallback())->setName($route->getName());

                continue;
            }

            $method = $route->getMethod();
            $app->{$method}($route->getRoute(),
                            $route->getCallback())->setName($route->getName());
        }
    }
}
