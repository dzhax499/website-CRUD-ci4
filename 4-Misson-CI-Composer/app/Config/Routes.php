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
$routes->get('loadPage/(:any)', 'Admin::loadPage/$1');

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

    // Student management (traditional CRUD)
    $routes->get('students', 'Admin::students');
    $routes->get('students', 'Admin::students');
    $routes->get('addStudent', 'Admin::addStudent');
    $routes->post('storeStudent', 'Admin::storeStudent');
    $routes->get('viewStudent/(:any)', 'Admin::viewStudent/$1');
    $routes->get('editStudent/(:any)', 'Admin::editStudent/$1');
    $routes->post('updateStudent/(:any)', 'Admin::updateStudent/$1');
    $routes->post('deleteStudent/(:any)', 'Admin::deleteStudent/$1');

    // student management (AJAX NO REFRESH  CRUD)
    $routes->get('getStudentsAjax', 'Admin::getStudentsAjax');
    $routes->post('storeStudentAjax', 'Admin::storeStudentAjax');
    $routes->get('getStudentAjax/(:any)', 'Admin::getStudentAjax/$1');
    $routes->post('updateStudentAjax/(:any)', 'Admin::updateStudentAjax/$1');
    $routes->post('deleteStudentAjax/(:any)', 'Admin::deleteStudentAjax/$1');


    // Enrollment management
    $routes->get('manageEnrollment/(:any)', 'Admin::manageEnrollment/$1');
    $routes->get('enroll/(:any)/(:any)', 'Admin::enroll/$1/$2');
    $routes->get('unenroll/(:any)/(:any)', 'Admin::unenroll/$1/$2');
});

// Student routes (protected)
$routes->group('student', ['filter' => 'auth'], function ($routes) {
    $routes->get('courses', 'Student::courses');
    $routes->get('enrollments', 'Student::enrollments');

    // enrollMultiple sekarang menangani baik enroll maupun drop
    // Fungsi processTransactions DIHAPUS dan diganti dengan enrollMultiple yang lebih powerful
    $routes->post('enrollMultiple', 'Student::enrollMultiple'); // Handles both enroll and drop via action parameter

    // TETAP DIPERTAHANKAN: Individual enroll/unenroll untuk keperluan khusus
    $routes->get('enroll/(:any)', 'Student::enroll/$1');
    $routes->get('unenroll/(:any)', 'Student::unenroll/$1');
});
