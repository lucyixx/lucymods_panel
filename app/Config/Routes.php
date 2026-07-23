<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'Home::index');
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'User::index');
$routes->match(['get', 'post'], 'login', 'Auth::login');
$routes->match(['get', 'post'], 'register', 'Auth::register');
$routes->match(['get', 'post'], 'settings', 'User::settings');
$routes->match(['get', 'post'], 'Server', 'User::Server');
$routes->match(['get', 'post'], 'Server/lib-online', 'User::Server');

$routes->group('games', function ($routes) {
    $routes->get('/', 'Home::games');
    $routes->get('/details', 'Home::details');
});

$routes->group('keys', function ($routes) {
	$routes->match(['get', 'post'], '/', 'Keys::index');
	$routes->match(['get', 'post'], 'generate', 'Keys::generate');
	$routes->get('(:num)', 'Keys::edit_key/$1');
	$routes->get('reset', 'Keys::api_key_reset');
	$routes->get('delete', 'Keys::api_key_delete');
	$routes->post('edit', 'Keys::edit_key');
	$routes->match(['get', 'post'], 'api', 'Keys::api_get_keys');
	$routes->get('delExp', 'Keys::delExpkeys');
	$routes->get('download/all', 'Keys::download_all_Keys');
	$routes->get('download/new', 'Keys::download_new_Keys');
	$routes->get('start', 'Keys::startDate');

	// KEY FREE //
	$routes->group('free', function ($routes) {
		$routes->match(['get', 'post'], '/', 'Keys::free');
		$routes->get('recreate', 'Keys::free_action');
	});
});

$routes->group('admin', ['filter' => 'admin'], function ($routes) {
	$routes->match(['get', 'post'], 'create-referral', 'User::ref_index');
	$routes->match(['get', 'post'], 'manage-users', 'User::manage_users');
	$routes->match(['get', 'post'], 'user/(:num)', 'User::user_edit/$1');
	$routes->match(['get', 'post'], 'user/singledelete/(:num)', 'User::singleDelete/$1');
	$routes->match(['get', 'post'], 'lib-online', 'User::lib');
	/* --------------------------- Admin API Grouping -------------------------- */
	$routes->group('api', function ($routes) {
		$routes->match(['get', 'post'], 'users', 'User::api_get_users');
	});
});

$routes->post('connect', 'Connect::index');
// $routes->match(['get', 'post'], 'connect', 'Connect::index');

// FILE MANAGER //
$routes->group('libOnline', function ($routes) {
	$routes->get('/', 'LibOnline::index');
	$routes->get('delete/(:segment)', 'LibOnline::delete/$1');
	$routes->get('download/(:segment)', 'LibOnline::download/$1');
	$routes->post('upload', 'LibOnline::upload');
});