# BulveyzRouter
Very basic but functional router. It will be useful for simple projects, will help to implement the routing system quickly, as it is very easy and fast, you can use it both separately and in conjunction with other classes or patterns.

#### Install via composer 
```
composer require bulveyz/router-php
```

## Example of use
```php
use BulveyzRouter\Route;
use BulveyzRouter\Router;


Route::get('/home', function() {
  echo "Home";
});


Route::any('/user/{id}', function($param) {
  echo "User" . $param->id;
});


Route::post('/create/post', 'PostController@store');


Router::routeVoid();
```

## Don't forget to enable redirecting all requests to index.php in .htaccess. Here is one example:

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-l
RewriteRule .* index.php [L,QSA]
```

## Usage
Connect the necessary classes for the router BulveyzRouter\Route and BulveyzRouter\Router can be connected separately (if you use singleton), but BulveyzRouter\Route must be called and routes must be defined before BulveyzRouter\Router::routeVoid();
And don't forget to call BulveyzRouter\Router::routeVoid(); before defined routes.

### Example
#### index.php
```php
use BulveyzRouter\Router;


// Defained routes
require_once '../routes.php';


// Run router
Router::routeVoid();
```

#### routes.php
```php
use BulveyzRouter\Route;


Route::get('/home', function() {
    echo "Home";
});
```

## Patterns for route
The parameters for the route are specified as {pattern}. The route should not have the same parameters, they should have different names.

### Examples
```php
Route::get('/user/{id}/{second_id}', function($params) {
    echo $params->id . $params->second_id;  
});
```

#### With controller
```php
Route::get('/user/{id}/{second_id}', 'HomeController@index');


public function index($params) 
{
    echo $params->id . $params->second_id;
}
```

## Methods
This version supports only 3 methods:

* GET
* POST
* ANY 

## Set name for route
You can specify the name of the router and return it anywhere.

### Example
```php
Route::get('/home', 'HomeController@index')->name('home.index');


echo \route('home.index'); // return '/home'
```

## Change nampespace for controllers
Of course, you can change the namespace for controllers, by default it is App\ .

### Example
```php
Route::setNamespace('Your namespace');


"Route::setNamespace('Classes');"
```

## Output all defained routes and other data
```php
var_dump(Route::routeList());


// Return namespace
echo Route::getNamespace()


// Return path for route
echo \route('routeName');


Route::get('/user', function (){
    // Return method this route
    echo Router::$method;


    // Return path this route
    echo Router::$route;


    // Return params this route (Array)
    var_dump(Router::$params);


    // Return handler this route
    var_dump(Router::$callback);
});
```

