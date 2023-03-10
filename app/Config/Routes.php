<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
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
$routes->get('/', 'Home::index');
$routes->post('/auth/login','Auth::login');

//nuevo grupo de rutas
//http://localhost:8080/api
$routes->group('api',['namespace' => 'App\Controllers\API','filter' => 'authFilter'],function($routes){
	//Clientes
	$routes->get('clientes', 'Clientes::index');
	$routes->post('clientes/create', 'Clientes::create');
	$routes->get('clientes/edit/(:num)', 'Clientes::edit/$1');
	$routes->put('clientes/update/(:num)', 'Clientes::update/$1');
	$routes->delete('clientes/delete/(:num)','Clientes::delete/$1');

	//Cuentas
	$routes->get('cuentas', 'Cuentas::index');
	$routes->post('cuentas/create', 'Cuentas::create');
	$routes->get('cuentas/edit/(:num)', 'Cuentas::edit/$1');
	$routes->put('cuentas/update/(:num)', 'Cuentas::update/$1');
	$routes->delete('cuentas/delete/(:num)','Cuentas::delete/$1');

	//Tipos de transaccion
	$routes->get('tipoTransaccion', 'TipoTransaccion::index');
	$routes->post('tipoTransaccion/create', 'TipoTransaccion::create');
	$routes->get('tipoTransaccion/edit/(:num)', 'TipoTransaccion::edit/$1');
	$routes->put('tipoTransaccion/update/(:num)', 'TipoTransaccion::update/$1');
	$routes->delete('tipoTransaccion/delete/(:num)','TipoTransaccion::delete/$1');

	//Transacciones
	$routes->get('transaccion', 'Transacciones::index');
	$routes->post('transaccion/create', 'Transacciones::create');
	$routes->get('transaccion/edit/(:num)', 'Transacciones::edit/$1');
	$routes->put('transaccion/update/(:num)', 'Transacciones::update/$1');
	$routes->delete('transaccion/delete/(:num)','Transacciones::delete/$1');
	$routes->get('transaccion/cliente/(:num)', 'Transacciones::getTransaccionByCliente/$1');
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
