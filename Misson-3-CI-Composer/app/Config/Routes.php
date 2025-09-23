<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/home', 'Auth::login');

// Home routes
$routes->get('/', 'Auth::login');

// Mahasiswa routes (existing)
$routes->get('/mahasiswa', 'Mahasiswa::index');
$routes->get('/mahasiswa/detail/(:num)', 'Mahasiswa::detail/$1');

// Authentication routes
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/authenticate', 'Auth::authenticate');
$routes->get('/auth/logout', 'Auth::logout');
$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/store', 'Auth::store');

// Dashboard routes (role-based)
$routes->get('/dashboard', 'Dashboard::index');

// Admin routes (protected)
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    // Course management
    $routes->get('courses', 'Admin::courses');
    $routes->get('courses/add', 'Admin::addCourse');
    $routes->post('courses/store', 'Admin::storeCourse');
    $routes->get('courses/edit/(:any)', 'Admin::editCourse/$1');
    $routes->post('courses/update/(:any)', 'Admin::updateCourse/$1');
    $routes->get('courses/delete/(:any)', 'Admin::deleteCourse/$1');

    // Student management
    $routes->get('students', 'Admin::students');
    $routes->get('students/view/(:any)', 'Admin::viewStudent/$1');
});

// Student routes (protected)
$routes->group('student', ['filter' => 'auth'], function ($routes) {
    $routes->get('courses', 'Student::courses');
    $routes->get('enrollments', 'Student::enrollments');
    $routes->get('enroll/(:any)', 'Student::enroll/$1');
    $routes->get('unenroll/(:any)', 'Student::unenroll/$1');
});
