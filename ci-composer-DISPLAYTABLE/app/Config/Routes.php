<?php

use CodeIgniter\Router\RouteCollection;

// $routes->get('/', 'Home::index');
$routes->get('/', 'Mahasiswa::index');
$routes->get('/mahasiswa/detail/(:num)', 'Mahasiswa::detail/$1');