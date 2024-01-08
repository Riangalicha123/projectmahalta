<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'GuestController::home');
$routes->get('/room', 'GuestController::room');
$routes->get('/bookroom', 'GuestController::bookroom');
$routes->get('/blog', 'GuestController::blog');
//$routes->get('/contact', 'GuestController::contact');
$routes->get('/restaurant', 'GuestController::restaurant');
$routes->get('/convention', 'GuestController::convention');
$routes->post('/addReservation', 'GuestController::addReservation');

$routes->get('/register', 'UserController::register');
$routes->match(['get', 'post'],'/registerAuth', 'UserController::registerAuth',);
$routes->get('/login', 'UserController::login');
$routes->post('/loginAuth', 'UserController::loginAuth');
$routes->get('/logout', 'UserController::logout');


$routes->get('/staff-hotel', 'StaffController::home');
$routes->get('/staff-hotelreservation', 'StaffController::reservation');

$routes->get('/staff-hotelroom', 'StaffController::room');
$routes->post('/addRoom', 'StaffController::addRoom');
$routes->get('/deleteRoom/(:any)', 'StaffController::deleteRoom/$1');
$routes->get('/editRoom/(:any)', 'StaffController::editRoom/$1');
$routes->post('/updateRoom', 'StaffController::updateRoom');
$routes->get('/staff-restaurant-reservation', 'StaffController::resReservation',/* ['filter' => 'authGuard'] */);
$routes->post('/tableReservation', 'StaffController::tableReservation');
$routes->get('/staff-restaurant-table', 'StaffController::resTable',/* ['filter' => 'authGuard'] */);
$routes->get('/staff-convention-reservation', 'StaffController::conReservation',/* ['filter' => 'authGuard'] */);

$routes->get('/admin-dashboard', 'AdminController::dashboard',/* ['filter' => 'authGuard'] */);
$routes->get('/admin/hotel/reservation', 'AdminController::reservation',/* ['filter' => 'authGuard'] */);
$routes->get('/admin/updatestatus/(:segment)/(:num)', 'AdminController::updateStatus/$1/$2',/* ['filter' => 'authGuard'] */);
$routes->get('/admin/restaurant/reservation', 'AdminController::resReservation',/* ['filter' => 'authGuard'] */);
$routes->get('/admin/updateresstatus/(:segment)/(:num)', 'AdminController::updateresStatus/$1/$2',/* ['filter' => 'authGuard'] */);



