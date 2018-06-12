<?php
namespace BulveyzRouter;



/**
 * Class Router
 * @package App
 *
 * Класс служит для обработки шаршрута и вычислений
 */
class Router
{
    /**
     * @var array
     * Возвращает все маршруты
     */
    public static $routes = [];

    /**
     * @var string
     * Пространтво имен для подключения контроллера
     */
    public static $namespace;

    /**
     * @var string
     * Текущий URL адрес
     */
    public static $url = '';

    /**
     * @var string
     * Если маршрут найден, примет его URL
     */
    public static $route;

    /**
     * @var string
     * Если маршрут найден, примет его метод
     */
    public static $method;

    /**
     * @var object
     * Если маршрут найден, примет его callback
     */
    public static $callback;

    /**
     * @var array
     * Если маршрут найден, примет параметры ({id}...)
     */
    public static $params;

    /**
     * Вычислияет и сравнивает маршруты с текущим, если маршрут найден
     * то вызовет свойства выше и поместит данные из массива в них
     */
    private static function routeMath()
    {
        foreach (self::$routes['All'] as $route)
        {
            $pattern = preg_replace("/\{(.*?)\}/", "(?P<$1>[\w-]+)", $route['route']);
            $pattern = "#^". trim($pattern, '/') ."$#";
            preg_match($pattern, trim(self::$url, '/'), $matches);
            if ($matches) {
                self::$route = $route['route'];
                self::$callback = $route['callback'];
                self::$method = $route['method'];
                self::$params = $matches;
            }
        }
    }

    /**
     * Служит главным методом для обработки маршрута и вывода результата, содержит
     * в себе другие методы для реализаций и подключений данных маршрута
     * Определяет массив всех доступных маршрутов,
     * пространоство имен указанное в RouteCollection,
     * текущий URL адрес
     */
    public static function routeVoid()
    {
        self::$routes = RouteCollection::getRoutes();
        self::$namespace = RouteCollection::getNamespace();
        self::$url = rtrim(parse_url($_SERVER['REQUEST_URI'])['path'], '/');

        self::routeMath();

        self::checkMethod();

        if (is_callable(self::$callback)) {
            call_user_func(self::$callback, (object) self::$params);
        } else {
            self::controllerConnect(self::$callback);
        }
   }

    /**
     * @param $callback
     *
     * Служит для подключения контроллера указанного в маршруте, выполняет проверки на
     * существование класса и метода вызываемого класса
     */
    private static function controllerConnect($callback)
   {
       $controller_data = explode('@', $callback);

       $controller = self::$namespace . '\\' . ucwords($controller_data[0]);
       $action =  $controller_data[1];

       if (class_exists($controller)) {
           $controllerInstance = new $controller;
       } else {
           exit('Controller ' . $controller . ' not found');
       }

       if (method_exists($controllerInstance, $action)) {
           call_user_func_array([$controllerInstance, $action], [(object) self::$params]);
       } else {
           exit($controller . ' action ' . $action . ' not found');
       }
   }

    /**
     * Вернет ошибку ксли метод не совпадает с текущим, но если метод ANY то
     * ничего не вернет, а породлжит выполнение кода
     */
    private static function checkMethod()
   {
         if (self::$route) {
             if (self::$method  === 'ANY') {
                 return false;
             } elseif (self::$method != $_SERVER['REQUEST_METHOD']) {
                 return exit('Method not allowed');
             }
         } else {
             return exit('Route not found');
         }
   }
}