<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::processLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::processRegister');
$routes->get('/logout', 'Auth::logout');
$routes->get('/motors', 'MotorController::index');
$routes->get('/motors/(:num)', 'MotorController::view/$1');
$routes->get('/bookings', 'BookingController::index', ['filter' => 'auth']);
$routes->get('/bookings/(:num)', 'BookingController::view/$1', ['filter' => 'auth']);
$routes->get('/bookings/create/(:num)', 'BookingController::create/$1', ['filter' => 'auth']);
$routes->post('/bookings/create/(:num)', 'BookingController::store/$1', ['filter' => 'auth']);
$routes->get('/admin', 'AdminController::index', ['filter' => 'auth']);
$routes->get('/admin/motors', 'AdminController::motors', ['filter' => 'auth']);
$routes->get('/admin/motors/create', 'AdminController::createMotor', ['filter' => 'auth']);
$routes->post('/admin/motors/create', 'AdminController::storeMotor', ['filter' => 'auth']);
$routes->get('/admin/motors/edit/(:num)', 'AdminController::editMotor/$1', ['filter' => 'auth']);
$routes->post('/admin/motors/edit/(:num)', 'AdminController::updateMotor/$1', ['filter' => 'auth']);
$routes->get('/admin/motors/delete/(:num)', 'AdminController::deleteMotor/$1', ['filter' => 'auth']);
$routes->get('/admin/bookings', 'AdminController::bookings', ['filter' => 'auth']);
$routes->get('/admin/bookings/(:num)', 'AdminController::viewBooking/$1', ['filter' => 'auth']);
$routes->post('/admin/bookings/(:num)/update-status', 'AdminController::updateBookingStatus/$1', ['filter' => 'auth']);
$routes->get('/admin/users', 'AdminController::users', ['filter' => 'auth']);
$routes->get('/admin/users/(:num)', 'AdminController::viewUser/$1', ['filter' => 'auth']);
$routes->get('/admin/payment-methods', 'AdminController::paymentMethods', ['filter' => 'auth']);
$routes->get('/admin/payment-methods/create', 'AdminController::createPaymentMethod', ['filter' => 'auth']);
$routes->post('/admin/payment-methods/create', 'AdminController::storePaymentMethod', ['filter' => 'auth']);
$routes->get('/admin/payment-methods/edit/(:num)', 'AdminController::editPaymentMethod/$1', ['filter' => 'auth']);
$routes->post('/admin/payment-methods/edit/(:num)', 'AdminController::updatePaymentMethod/$1', ['filter' => 'auth']);
$routes->get('/admin/payment-methods/delete/(:num)', 'AdminController::deletePaymentMethod/$1', ['filter' => 'auth']);
