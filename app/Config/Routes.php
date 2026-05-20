<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
$routes->get('/', 'AuthController::login');
$routes->post('attemptLogin', 'AuthController::attemptLogin'); // Nom d'action cohérent
$routes->get('logout', 'AuthController::logout');

$routes->group('employer', ['filter' => 'auth'], function($routes){
    $routes->get('dashboard', 'CongeController::index'); 
    $routes->post('demande', 'CongeController::creer'); 
});

$routes->group('rh', ['filter' => 'auth'], function($routes) {
    $routes->get('demandes', 'RHController::dashboardRH'); 
    $routes->get('valider/(:num)', 'RHController::validerConge/$1'); // GET pour le bouton simple
    $routes->get('refuser/(:num)', 'RHController::refuserConge/$1'); // GET pour refuser
});

$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    $routes->get('utilisateurs', 'AdminController::users');
    $routes->get('create', 'AdminController::create'); // <-- Change ici
    $routes->post('save', 'AdminController::save');
    $routes->get('delete/(:num)', 'AdminController::delete/$1');
});