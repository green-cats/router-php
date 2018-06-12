<?php

/**
 * @param $route
 * @return mixed
 * Возвращет путь маршрута по имени
 */
function route($route) {
    $routes =  \BulveyzRouter\Route::routeList()['All'];

    foreach ($routes as $routen) {
        if (isset($routen['name'][$route])) {
            return $routen['name'][$route];
        }
    }
}