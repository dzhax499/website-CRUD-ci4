<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/auth/doLogin', 'Auth::doLogin');
$routes->get('/logout', 'Auth::logout');

$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
});

$routes->group('student', ['filter' => 'auth:student'], function ($routes) {
    $routes->get('dashboard', 'Student::dashboard');
});


$routes->get('/admin/dashboard', 'Admin::dashboard');
$routes->get('/student/dashboard', 'Student::dashboard');
