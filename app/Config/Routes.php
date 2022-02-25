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
$routes->set404Override(function () {
    return view('error/404');

});
$routes->get('/', 'Home::index', ['filter' => 'authGuard']);
$routes->get('employees', 'Employees::employees', ['filter' => 'authGuard']);
$routes->get('employees/list', 'Employees::employeesList');
$routes->get('employees/level', 'Employees::employeesLevel');
$routes->post('employees/add', 'Employees::employeeAdd');
$routes->post('employees/delete', 'Employees::employeeDelete');
$routes->post('employees/edit', 'Employees::employeeEdit');
$routes->get('goods', 'Goods::goods', ['filter' => 'authGuard']);
$routes->get('goods/list', 'Goods::goodsList');
$routes->post('goods/add', 'Goods::goodsAdd');
$routes->post('goods/delete', 'Goods::goodsDelete');
$routes->post('goods/edit', 'Goods::goodsEdit');
$routes->get('levels', 'Levels::levels', ['filter' => 'authGuard']);
$routes->get('levels/list', 'Levels::levelsList');
$routes->post('levels/add', 'Levels::levelsAdd');
$routes->post('levels/delete', 'Levels::levelsDelete');
$routes->post('levels/edit', 'Levels::levelsEdit');
$routes->post('levels/security', 'Levels::levelSecurity');
$routes->get('transaction', 'Transaction::transaction', ['filter' => 'authGuard']);
$routes->post('transaction/add', 'Transaction::transactionAdd');
$routes->get('report', 'Transaction::report', ['filter' => 'authGuard']);
$routes->post('report/receipt', 'Transaction::transactionReceipt');
$routes->get('signup', 'Auth::signUp');
$routes->get('login', 'Auth::login');
$routes->post('createbooth', 'Auth::createBooth');
$routes->post('loginauth', 'Auth::loginAuth');
$routes->get('logout', 'Auth::logout');

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
