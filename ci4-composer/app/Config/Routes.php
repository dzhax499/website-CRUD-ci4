<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/hai', 'haii::index');
$routes->get('/hai-notview', 'dosen::display');
