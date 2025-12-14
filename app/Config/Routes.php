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
$routes->get('produk/(:num)', 'FrontController::detailP`roduk/$1');
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
$routes->get('product/search', 'FrontController::searchAjaxProduk');
$routes->get('product/filterByBrand/(:num)', 'FrontController::filterByBrand/$1');
$routes->get('check-time', 'FrontController::checkTime');
$routes->get('profile', 'UserController::profile', ['filter' => 'auth']);
$routes->post('profile/update', 'UserController::updateProfile', ['filter' => 'auth']);
$routes->post('profile/change-password', 'UserController::changePassword', ['filter' => 'auth']);

$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('index', 'DashboardController::index');
    $routes->get('booking', 'BookingController::dashboard');
    $routes->get('users', 'UserController::dashboard');
    $routes->get('inventaris/merk', 'BrandController::index');
    $routes->get('inventaris/type', 'TypeController::index');
    $routes->get('inventaris/motor', 'MotorController::index');
    $routes->get('report/booking', 'ReportController::reportBooking');
    $routes->post('report/booking/get-data', 'ReportController::getBookingData');
    $routes->post('get-bookings', 'ReportController::ajaxBookings');
    $routes->post('report/booking/export', 'ReportController::exportBookingExcel');
    $routes->get('report/motor', 'ReportController::reportMotor');
    $routes->post('report/motor/get-data', 'ReportController::getMotorData');
    $routes->post('report/motor/export', 'ReportController::exportMotorExcel');
    $routes->get('report/users', 'UserController::reportUsers');
    $routes->post('report/user/get-data', 'ReportController::getUserData');
    $routes->post('report/user/export', 'ReportController::exportUserExcel');
    $routes->get('settings/faq', 'SettingController::indexFAQ');
    $routes->post('settings/faq/store', 'SettingController::faqStore');
    $routes->post('settings/faq/update', 'SettingController::faqUpdate');
    $routes->post('settings/faq/delete', 'SettingController::faqDelete');
    $routes->get('invoice/(:num)', 'BookingController::invoice/$1');
    $routes->get('monthly-bookings', 'DashboardController::getMonthlyBookings');
    $routes->get('top-motors', 'DashboardController::topMotors');
    $routes->get('booking-status', 'DashboardController::bookingStatus');
    $routes->get('settings/profile', 'SettingController::profile');
    $routes->post('settings/profile/update', 'SettingController::updateProfile');
    $routes->post('settings/profile/update-password', 'SettingController::updatePassword');
    $routes->get('settings/profile/bussiness', 'SettingController::profileBussiness');
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
// $routes->get('send-test-email', 'EmailController::sendEmail');

//booking from user
$routes->group('booking', ['filter' => 'auth'], function ($routes) {
    $routes->post('user-store', 'BookingController::userStore');
    $routes->get('pesanan', 'FrontController::listBookingUser');
    $routes->get('detail/(:num)', 'BookingController::bookingDetail/$1');
    $routes->post('cancel/(:num)', 'BookingController::cancelBooking/$1');
    $routes->get('detail-booking/(:num)', 'FrontController::detailBookingUser/$1');
    $routes->get('detail-booking-page/(:num)', 'FrontController::detailBookingUserPage/$1');
    $routes->get('getBookingDetails', 'BookingController::getBookingDetails');
    $routes->post('update-from-detail-user', 'FrontController::updateBookingFromDetailUser');
    $routes->get('invoice/(:num)', 'FrontController::invoice/$1');
    $routes->get('cancel-user/(:num)', 'BookingController::cancelBookingUser/$1');
});


$routes->get('home', 'FrontendController::index');
$routes->get('about', 'FrontendController::about');
$routes->get('contact', 'FrontendController::contact');
$routes->get('services', 'FrontendController::services');
