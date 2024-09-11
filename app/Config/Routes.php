<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['filter' => 'cors:api'], static function (RouteCollection $routes): void {
    $routes->resource('listpublic');

    $routes->options('listpublic', static function () {});
    $routes->options('listpublic/(:any)', static function () {});
});