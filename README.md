# routerPHP
Very simple but functional router. It will be useful for simple projects, will help to quickly implement the routing system, as it is very easy and fast, you can use it both separately and in conjunction with other classes or patterns

####Install via composer 
```
composer require bulveyz/router-php "1.0"
```

## Example of use
```php
use BulveyzRouter\Route;
use BulveyzRouter\Router;


Route::get('/home', function() {
	echo "Home";
});


Route::get('/user/{id}', function($param) {
	echo "User" . $param->id;
});


Route::post('/create/post', 'PostController@store');

Router::routeVoid();
```


