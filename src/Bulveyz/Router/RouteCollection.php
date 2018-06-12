<?php

namespace BulveyzRouter;

/**
 * Class RouteCollection
 * @package App
 *
 * Содержит методы и свойства для работы в создании, редактировании, дополнении маршрутов
 */
abstract class RouteCollection
{

    /**
     * @var array
     *
     * Массив всех маршрутов и методов
     */
    protected static $routes  = [
        "GET" => [],
        "POST" => [],
        "ANY" => [],
        "All" => []
    ];

    /**
     * @var string
     * Пространство имен (по этому пространтсву будут подргружаться контроллеры)
     */
    private static $namespace = 'App';

    /**
     * @param $route
     * @function $callback
     * @param $method
     *
     * Добавляет новыймаршрут в $routes с названием, функциео обработчикм и методом
     */
    protected static function addRoute($route, $callback, $method) {
        self::$routes[$method][$route] = [
            'route' => $route,
            'method' => $method,
            'callback' => $callback
        ];

        self::$routes['All'][$route] = [
            'route' => $route,
            'method' => $method,
            'callback' => $callback,
            'name' => [$route => $route]
        ];
    }

    /**
     * @param $newName
     * @param $oldName
     *
     * Устанавливет имя для маршрута если указана ->name(routeName);
     */
    protected static function setName($newName, $oldName, $method)
    {
        self::$routes['All'][$oldName]['name'][$newName] = self::$routes['All'][$oldName]['name'][$oldName];
        unset(self::$routes['All'][$oldName]['name'][$oldName]);
    }

    /**
     * @return array
     *
     * Возвращает массив маршрутов
     */
    public static function getRoutes()
    {
        return self::$routes;
    }

    /**
     * @param string $namespace
     *
     * Устанавливет новое пространтсво имен
     */
    protected static function setNamespace($namespace)
    {
        self::$namespace = $namespace;
    }

    /**
     * @return string
     */
    public static function getNamespace()
    {
        return self::$namespace;
    }
}