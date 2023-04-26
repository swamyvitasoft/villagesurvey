<?php

namespace Config;

use App\Libraries\Hash;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Login::index');

$routes->group('/', ['filter' => 'AlreadyLoggedIn'], function ($routes) {
    $routes->get('', 'Login::login');
    $routes->get('login', 'Login::login');
    $routes->get('create', 'Login::create');
    $routes->post('check', 'Login::check');
    $routes->post('recover', 'Login::recover');
});
$routes->group('/', ['filter' => 'AuthCheck'], function ($routes) {
    $routes->group('dashboard/', static function ($routes) {
        $routes->get(Hash::path('index'), 'Dashboard::index');
        $routes->post(Hash::path('regAction'), 'Dashboard::regAction');
        $routes->post(Hash::path('logAction'), 'Dashboard::logAction');
        $routes->get(Hash::path('add'), 'Dashboard::add');
        $routes->post(Hash::path('addAction'), 'Dashboard::addAction');
        $routes->get(Hash::path('view'), 'Dashboard::view');
        $routes->post(Hash::path('auth1'), 'Dashboard::auth1');
        $routes->get(Hash::path('auth') . '/(:any)', 'Dashboard::auth/$1');
        $routes->get(Hash::path('show') . '/(:any)', 'Dashboard::show/$1');
        $routes->get(Hash::path('edit') . '/(:any)', 'Dashboard::edit/$1');
        $routes->get(Hash::path('delete') . '/(:any)', 'Dashboard::delete/$1');
        $routes->get(Hash::path('changepwd'), 'Dashboard::changepwd');
        $routes->post(Hash::path('updatepwd'), 'Dashboard::updatepwd');
    });
    $routes->group('agents/', static function ($routes) {
        $routes->get(Hash::path('index'), 'Agents::index');
        $routes->get(Hash::path('add'), 'Agents::add');
        $routes->post(Hash::path('addAction'), 'Agents::addAction');
    });
    $routes->group('topics/', static function ($routes) {
        $routes->get(Hash::path('index'), 'Topics::index');
        $routes->get(Hash::path('add'), 'Topics::add');
        $routes->post(Hash::path('addAction'), 'Topics::addAction');
    });
    $routes->group('survey/', static function ($routes) {
        $routes->get(Hash::path('index'), 'Survey::index');
        $routes->post(Hash::path('addAction'), 'Survey::addAction');
    });
    $routes->group('members/', static function ($routes) {
        $routes->get(Hash::path('index'), 'Members::index');
    });
});
$routes->get('logout', 'Login::logout');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
