<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Set default route to booking
$routes->get('/', 'BookingController::index'); 

// Public booking routes
$routes->group('booking', function($routes) {
    $routes->get('new', 'BookingController::newRegistration');
    $routes->get('search', 'BookingController::searchBooking');
    $routes->post('process-search', 'BookingController::processSearch');
    $routes->post('process', 'BookingController::processRegistration');
    $routes->get('success/(:num)', 'BookingController::registrationSuccess/$1');
    
    // Tambahkan route untuk pasien terdaftar
    $routes->get('existing', 'BookingController::existingPatientRegistration');
    $routes->post('process-existing', 'BookingController::processExistingRegistration');
});

$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout');

$routes->get('admin/dashboard', 'AdminController::dashboard', ['filter' => 'auth']);

// Admin Routes
$routes->group('admin/pengguna', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'AdminController::index');
    $routes->get('create', 'AdminController::create');
    $routes->post('store', 'AdminController::store');
    $routes->get('edit/(:num)', 'AdminController::edit/$1');
    $routes->post('update/(:num)', 'AdminController::update/$1');
    $routes->delete('delete/(:num)', 'AdminController::delete/$1');
});

// Manajemen Pasien Routes
$routes->group('admin/pasien', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'PasienController::index');
    $routes->get('create', 'PasienController::create');
    $routes->post('store', 'PasienController::store');
    $routes->get('edit/(:num)', 'PasienController::edit/$1');
    $routes->post('update/(:num)', 'PasienController::update/$1');
    $routes->delete('delete/(:num)', 'PasienController::delete/$1');
});

$routes->group('admin/dokter', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'DokterController::index');
    $routes->get('create', 'DokterController::create');
    $routes->post('store', 'DokterController::store');
    $routes->get('edit/(:num)', 'DokterController::edit/$1');
    $routes->post('update/(:num)', 'DokterController::update/$1');
    $routes->delete('delete/(:num)', 'DokterController::delete/$1');
});

$routes->group('admin/pendaftaran', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'PendaftaranController::index');
    $routes->get('create', 'PendaftaranController::create');
    $routes->post('store', 'PendaftaranController::store');
    $routes->get('edit/(:num)', 'PendaftaranController::edit/$1');
    $routes->post('update/(:num)', 'PendaftaranController::update/$1');
    $routes->delete('delete/(:num)', 'PendaftaranController::delete/$1');
    $routes->post('update-status/(:num)', 'PendaftaranController::updateStatus/$1');
    $routes->get('riwayat/(:num)', 'PendaftaranController::riwayat/$1');
});

$routes->group('admin/laporan', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'LaporanController::index');
    $routes->get('generate', 'LaporanController::generate');
    $routes->post('processGenerate', 'LaporanController::processGenerate');
    $routes->get('view/(:num)', 'LaporanController::view/$1');
    $routes->get('exportPDF/(:num)', 'LaporanController::exportPDF/$1');
});