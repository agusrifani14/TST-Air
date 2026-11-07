<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

// Booking Route Group
$routes->group('booking', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->post('create', 'BookingAPI::create');
    // $routes->post('pay/(:any)/(:any)/(:any)', 'BookingAPI::pay/$1/$2/$3');
    $routes->get('checkin', 'BookingAPI::checkinForm');
    $routes->get('checkin-result', 'BookingAPI::checkinResult');
    // $routes->post('test', 'BookingAPI::testAuth');
});

//  Airport Route Group
$routes->group('airport', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('get-all', 'AirportAPI::getAllAirport');
    $routes->get('add-airport', 'AirportController::addAirportPage');
    $routes->post('add', 'AirportController::add');
    $routes->get('', 'AirportController::viewAirportPage');
    $routes->get('fetch-airport/(:any)', 'AirportController::fetchAirport/$1');
    $routes->post('edit-airport/(:any)', 'AirportController::editAirport/$1');
    $routes->post('delete-airport/(:any)', 'AirportController::deleteAirport/$1');
});

// Flight Route Group
$routes->group('flight', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('get', 'FlightAPI::getFlight');
    $routes->get('get-all', 'FlightAPI::getAllFlights');
    $routes->get('add-flight', 'FlightController::addFlightPage');
    $routes->post('add', 'FlightController::add');
    $routes->get('', 'FlightController::viewFlightPage');
    $routes->get('fetch-flight/(:any)', 'FlightController::fetchFlight/$1');
    $routes->post('edit-flight/(:any)', 'FlightController::editFlight/$1');
    $routes->post('delete-flight/(:any)', 'FlightController::deleteFlight/$1');
    $routes->get('get-per-id', 'FlightAPI::getByID');
});

// Login
$routes->get('login', 'LoginController::index');
$routes->post('login-process', 'LoginController::loginProcess');
$routes->get('logout', 'LoginController::logout');

// Finance
$routes->get('finance-dashboard', 'FinanceController::viewDashboard');