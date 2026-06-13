<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ─── PUBLIC ROUTES ────────────────────────────────────────────────
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get('/home/get-mobil-ajax', 'Home::getMobilAjax');
$routes->get('/login', 'Auth::index');
$routes->post('/auth/set-session', 'Auth::setSession');
$routes->get('/logout', 'Auth::logout');

// ─── PROTECTED ROUTES (harus login) ────────────────────────────────
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // Dashboard
    $routes->get('/dashboard', 'Dashboard::index');

    // Manajemen Armada Mobil (admin only)
    $routes->group('mobil', ['filter' => 'auth:admin'], function ($routes) {
        $routes->get('/', 'Mobil::index');
        $routes->get('create', 'Mobil::create');
        $routes->post('store', 'Mobil::store');
        $routes->get('edit/(:num)', 'Mobil::edit/$1');
        $routes->post('update/(:num)', 'Mobil::update/$1');
        $routes->get('delete/(:num)', 'Mobil::delete/$1');
    });

    // Penyewaan (admin only)
    $routes->group('penyewaan', ['filter' => 'auth:admin'], function ($routes) {
        $routes->get('/', 'Penyewaan::index');
        $routes->get('create', 'Penyewaan::create');
        $routes->post('store', 'Penyewaan::store');
        $routes->get('edit/(:num)', 'Penyewaan::edit/$1');
        $routes->post('update/(:num)', 'Penyewaan::update/$1');
        $routes->get('delete/(:num)', 'Penyewaan::delete/$1');
    });

    // Biaya Operasional (admin only)
    $routes->group('biaya', ['filter' => 'auth:admin'], function ($routes) {
        $routes->get('/', 'BiayaOperasional::index');
        $routes->get('create', 'BiayaOperasional::create');
        $routes->post('store', 'BiayaOperasional::store');
        $routes->get('delete/(:num)', 'BiayaOperasional::delete/$1');
    });

    // Cetak PDF (admin only)
    $routes->group('cetak', ['filter' => 'auth:admin'], function ($routes) {
        $routes->get('nota/(:num)', 'Cetak::nota/$1');
        $routes->get('harian', 'Cetak::harian');
        $routes->get('bulanan', 'Cetak::bulanan');
        $routes->get('tahunan', 'Cetak::tahunan');
    });
});
