<?php

use App\Http\Controllers\AuthController;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/', ['middleware' => ['auth'], function () use ($router) {
    return $router->app->version();
}]);

$router->post('/auth', 'AuthController@auth');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');

$router->get('/product', 'ProductController@index');
$router->get('/product/{id}', 'ProductController@show');
$router->post('/product/store', 'ProductController@store');
$router->put('/product/{id}', 'ProductController@update');
$router->delete('/product/{id}', 'ProductController@destroy');


$router->get('/filter', function () {
    $db = file_get_contents(app()->basePath('public/filter-data.json'));
    $json = json_decode($db, true);

    $collection = collect($json);
    $billdetails = collect($collection['data']['response']['billdetails']);
    $price = $billdetails->map(function ($item, $key) {
        return preg_replace("/[^0-9]/", "", $item['body'][0]);
    });

    $demon = $price->filter(function ($i, $k) {
        return $i >= 100000;
    });
    $reset_demon = array_values(array_filter($demon->toArray()));
    dd($reset_demon);
});