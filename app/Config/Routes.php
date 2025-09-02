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

$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
