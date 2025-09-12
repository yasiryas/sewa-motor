<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('motors', 'MotorController::index');
$routes->get('motors/(:num)', 'MotorController::show/$1');
$routes->get('booking', 'BookingController::view');
$routes->post('booking', 'BookingController::store');
$routes->get('booking/success', 'BookingController::success');
$routes->get('login', 'AuthController::login');
$routes->post('login/process', 'AuthController::loginProcess');
$routes->get('register', 'AuthController::register');
$routes->post('register/process', 'AuthController::registerProcess');
$routes->get('logout', 'AuthController::logout');

$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('index', 'DashboardController::index');
    $routes->get('booking', 'BookingController::dashboard');
    $routes->get('users', 'UserController::dashboard');
    $routes->get('inventaris/merk', 'BrandController::index');
    $routes->get('inventaris/type', 'TypeController::index');
    $routes->get('inventaris/motor', 'MotorController::index');
    $routes->get('report/booking', 'BookingController::reportBooking');
    $routes->get('report/motor', 'MotorController::reportMotors');
    $routes->get('report/users', 'UserController::reportUsers');
});

// Manajemen brand
$routes->group('dashboard/inventaris/brand', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'BrandController::index');
    $routes->get('create', 'BrandController::create');
    $routes->post('store', 'BrandController::store');
    $routes->post('update', 'BrandController::update');
    $routes->post('delete', 'BrandController::delete');
});



// $routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
//     $routes->get('dashboard/index', 'DashboardController::index');
//     $routes->get('dashboard/booking', 'BookingController::dashboard');
//     $routes->get('dashboard/users', 'UserController::dashboard');
//     $routes->get('dashboard/inventaris/merk', 'BrandController::index');
//     $routes->get('dashboard/inventaris/type', 'TypeController::index');
//     $routes->get('dashboard/inventaris/motor', 'MotorController::index');
//     $routes->get('dashboard/report/booking', 'BookingController::reportBooking');
//     $routes->get('dashboard/report/motor', 'MotorController::reportMotors');
//     $routes->get('dashboard/report/users', 'UserController::reportUsers');
// });

$routes->get('home', 'FrontendController::index');
$routes->get('about', 'FrontendController::about');
$routes->get('contact', 'FrontendController::contact');
$routes->get('services', 'FrontendController::services');
