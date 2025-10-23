<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'FrontController::index');
$routes->get('produk', 'FrontController::produk');
$routes->get('tentang-kami', 'FrontController::tentang_kami');
$routes->get('faq', 'FrontController::faq');
$routes->get('kontak', 'FrontController::kontak');
$routes->get('produk/(:num)', 'FrontController::detailProduk/$1');
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
    $routes->get('settings/faq', 'SettingController::index');
    $routes->post('settings/faq/store', 'SettingController::faqStore');
    $routes->post('settings/faq/update', 'SettingController::faqUpdate');
    $routes->post('settings/faq/delete', 'SettingController::faqDelete');
});

// Manajemen brand
$routes->group('dashboard/inventaris/brand', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'BrandController::index');
    $routes->post('store', 'BrandController::store');
    $routes->post('update', 'BrandController::update');
    $routes->post('delete', 'BrandController::delete');
});

// Manajemen type
$routes->group('dashboard/inventaris/type', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'TypeController::index');
    $routes->post('store', 'TypeController::store');
    $routes->post('update', 'TypeController::update');
    $routes->post('delete', 'TypeController::delete');
});

// Manajemen motor
$routes->group('dashboard/inventaris/motor', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'MotorController::index');
    $routes->post('store', 'MotorController::store');
    $routes->post('update', 'MotorController::update');
    $routes->post('delete', 'MotorController::delete');
});

// Manajemen user
$routes->group('dashboard/user', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'UserController::index');
    $routes->post('store', 'UserController::store');
    $routes->post('update', 'UserController::update');
    $routes->post('delete', 'UserController::delete');
    $routes->post('reset', 'UserController::resetPassword');
    $routes->get('search', 'UserController::search');
});

// Manajemen booking for admin
$routes->group('dashboard/booking/', ['filter' => 'auth'], function ($routes) {
    $routes->post('storeUser', 'UserController::storeUserInBooking');
    $routes->post('adminStore', 'BookingController::adminStore');
    $routes->post('update', 'MotorController::update');
    $routes->post('deleteAdmin', 'BookingController::deleteAdmin');
    $routes->get('detail/(:num)', 'BookingController::detail/$1');
    $routes->post('updateStatus/(:num)', 'BookingController::updateStatus/$1');
    $routes->get('getAvailableMotorsBooking', 'BookingController::getAvialableMotorsBooking');
});

//Email Test Route
$routes->post('send-email', 'EmailController::sendEmail');


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
