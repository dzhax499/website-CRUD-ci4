<?php

use CodeIgniter\Router\RouteCollection;

// $routes->get('/', 'Home::index');
$routes->get('/', 'Home::index');
$routes->get('/mahasiswa', 'Mahasiswa::index');
$routes->get('/home_v2' , 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get('/berita', 'Home::index');
$routes->get('/auth/login', 'Auth::login');
$routes->get('/auth/register', 'Auth::register'); 
$routes->post('auth/authenticate', 'Auth::authenticate'); // proses login
$routes->get('/mahasiswa/detail/(:num)', 'Mahasiswa::detail/$1');