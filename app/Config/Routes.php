<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::index');

$routes->group('/ruangadmin/login', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'Login::index');
    $routes->post('action', 'Login::action');
    $routes->post('destroy', 'Login::destroy');
});

$routes->group('ruangadmin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');

    $routes->group('users', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
        $routes->get('/', 'Users::index');
        $routes->post('store', 'Users::store');
        $routes->post('delete', 'Users::delete');
        $routes->post('update', 'Users::update');
        $routes->post('reset/(:any)', 'Users::reset_/$1');
        $routes->post('set/(:any)', 'Users::set_/$1');
        $routes->post('delete-multiple', 'Users::deleteMultiple');
        $routes->post('reset-multiple', 'Users::resetMultiple');
        $routes->post('set-multiple', 'Users::setMultiple');
    });

    $routes->group('nasabah', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
        $routes->get('/', 'Nasabah::index');
        $routes->get('baru', 'Nasabah::Baru');
        $routes->post('store', 'Nasabah::store');
        $routes->post('delete', 'Nasabah::delete');
        $routes->post('update', 'Nasabah::update');
        $routes->post('delete-multiple', 'Nasabah::deleteMultiple');
    });

    $routes->group('inputan', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
        $routes->get('/', 'InputField::index');
        $routes->post('store', 'InputField::store');
        $routes->post('delete', 'InputField::delete');
        $routes->post('update', 'InputField::update');
        $routes->post('delete-multiple', 'InputField::deleteMultiple');
        $routes->post('set/(:any)', 'InputField::set_/$1');
        $routes->post('set-multiple', 'InputField::setMultiple');
    });
});

// API Routes

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    $routes->post('setuser/status', 'Admin::setUserStatus');
    $routes->get('getInput', 'Admin::getNasabahInput');

    $routes->group('data', ['namespace' => 'App\Controllers\Api'], function ($routes) {
        $routes->post('options/years', 'Admin::getYears/$1');
        $routes->post('options/(:any)', 'Admin::getDataOption/$1');
        $routes->post('users', 'Admin::dataUsers');
        $routes->post('nasabah', 'Admin::dataNasabah');
        $routes->post('inputan', 'Admin::dataInputan');
    });

    $routes->group('row', ['namespace' => 'App\Controllers\Api'], function ($routes) {
        $routes->post('users/(:any)', 'Admin::getRowUsers/$1');
        $routes->post('inputan/(:any)', 'Admin::getRowInputan/$1');
    });

    $routes->group('public', ['namespace' => 'App\Controllers\Api'], function ($routes) {
        $routes->group('get', ['namespace' => 'App\Controllers\Api'], function ($routes) {
            $routes->get('article', 'PublicApi::getArticle');
            $routes->get('category', 'PublicApi::getCategory');
            $routes->get('category-products', 'PublicApi::getCategoryProducts');
            $routes->get('category-faq', 'PublicApi::getCategoryFaq');
            $routes->get('tags', 'PublicApi::getTags');
            $routes->get('teams', 'PublicApi::getTeams');
            $routes->get('teams-page', 'PublicApi::teamsPage');
            $routes->get('clients', 'PublicApi::getClients');
            $routes->get('clients/order/(:any)', 'PublicApi::getClientsOrders/$1');
            $routes->get('clients/select/(:any)', 'PublicApi::getClientsSelect/$1');
            $routes->get('products', 'PublicApi::getProducts');
            $routes->get('products-brosur/(:any)', 'PublicApi::getProductsBrosur/$1');
            $routes->get('products-file/(:any)', 'PublicApi::getProductsFile/$1');
            $routes->get('products-demo', 'PublicApi::getProductsDemo');
            $routes->get('products/demo/(:any)', 'PublicApi::getProductsDemo/$1');
            $routes->get('products/(:any)', 'PublicApi::getProducts/$1');
            $routes->get('faq', 'PublicApi::getFaq');
            $routes->get('faq/(:any)', 'PublicApi::getFaq/$1');
            $routes->get('career', 'PublicApi::getCareer');
        });
    });
});


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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
