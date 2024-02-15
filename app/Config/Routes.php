<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'GuestController::home',['filter' => 'noAuth']);
$routes->get('/room', 'GuestController::room',['filter' => 'noAuth']);
$routes->get('/bookroom/submit', 'GuestController::getData',['filter' => 'noAuth']);
$routes->get('/getdataRoom', 'GuestController::getdataRoom',['filter' => 'noAuth']);
$routes->get('/bookroom', 'GuestController::bookroom',['filter' => 'noAuth']);
$routes->get('/bookroom/getdataRoom', 'GuestController::getdataRoomReservation',['filter' => 'noAuth']);
$routes->get('/bookroom/formdetails', 'GuestController::formdetails',['filter' => 'noAuth']);
$routes->post('/bookroom/addReservation', 'GuestController::addReservation',['filter' => 'noAuth']);
$routes->get('/blog', 'GuestController::blog',['filter' => 'noAuth']);
$routes->get('/faq', 'GuestController::faq',['filter' => 'noAuth']);
//$routes->get('/contact', 'GuestController::contact');
$routes->get('/restaurant', 'GuestController::restaurant',['filter' => 'noAuth']);
$routes->get('/convention', 'GuestController::convention',['filter' => 'noAuth']);
$routes->get('/profile', 'GuestController::profile',['filter' => 'noAuth']);
$routes->get('/chat', 'GuestController::chat',['filter' => 'noAuth']);
$routes->post('/updateProfile/(:num)', 'GuestController::updateProfile/$1',['filter' => 'noAuth']);

$routes->post('/tableReservation', 'GuestController::tableReservation',['filter' => 'noAuth']);
$routes->post('/eventReservation', 'GuestController::eventReservation',['filter' => 'noAuth']);
$routes->get('/getFeedback', 'GuestController::getFeedback',['filter' => 'noAuth']);
$routes->post('/postFeedback', 'GuestController::postFeedback',['filter' => 'noAuth']);

$routes->post('/get_chat_data', 'GuestController::get_chat_data',['filter' => 'noAuth']);


$routes->get('/register', 'UserController::register',['filter' => 'noAuth']);
$routes->match(['get', 'post'],'/registerAuth', 'UserController::registerAuth',['filter' => 'noAuth']);
$routes->get('/login', 'UserController::login');
$routes->post('/loginAuth', 'UserController::loginAuth');
$routes->get('/logout', 'UserController::logout');


$routes->get('/staff-hotel', 'StaffController::home',['filter' => 'staffGuard']);
$routes->get('/staff-hotelreservation', 'StaffController::reservation',['filter' => 'staffGuard']);
$routes->post('/addhotelReservation', 'StaffController::addhotelReservation',['filter' => 'staffGuard']);
$routes->post('/updatehotelReservation/(:num)', 'StaffController::updatehotelReservation/$1',['filter' => 'staffGuard']);
$routes->get('/staff/updatestatus/(:segment)/(:num)', 'StaffController::updateStatus/$1/$2',['filter' => 'staffGuard']);
$routes->get('/staff-hotelroom', 'StaffController::room',['filter' => 'staffGuard']);
$routes->post('/addRoom', 'StaffController::addRoom',['filter' => 'staffGuard']);
$routes->get('/deleteRoom/(:any)', 'StaffController::deleteRoom/$1');
$routes->post('/updateRoom', 'StaffController::updateRoom',['filter' => 'staffGuard']);

$routes->get('/staff-restaurant', 'StaffController::reshome',['filter' => 'staffGuard']);
$routes->get('/staff-restaurant-reservation', 'StaffController::resReservation',['filter' => 'staffGuard']);
$routes->post('/addrestauReservation', 'StaffController::addrestauReservation',['filter' => 'staffGuard']);
$routes->post('/updaterestauReservation/(:num)', 'StaffController::updaterestauReservation/$1',['filter' => 'staffGuard']);
$routes->get('/staff/updaterestauStatus/(:segment)/(:num)', 'StaffController::updaterestauStatus/$1/$2',['filter' => 'staffGuard']);
$routes->get('/staff-restaurant-table', 'StaffController::resTable',['filter' => 'staffGuard']);
$routes->post('/addTable', 'StaffController::addTable',['filter' => 'staffGuard']);
$routes->post('/updateTable', 'StaffController::updateTable',['filter' => 'staffGuard']);

$routes->get('/staff-convention', 'StaffController::conhome',['filter' => 'staffGuard']);
$routes->get('/staff-convention-reservation', 'StaffController::conReservation',['filter' => 'staffGuard']);
$routes->post('/addconReservation', 'StaffController::addconReservation',['filter' => 'staffGuard']);
$routes->post('/updateconReservation/(:num)', 'StaffController::updateconReservation/$1',['filter' => 'staffGuard']);
$routes->get('/staff/updateconStatus/(:segment)/(:num)', 'StaffController::updateconStatus/$1/$2',['filter' => 'staffGuard']);
$routes->get('/staff-convention-event', 'StaffController::conEvent',['filter' => 'staffGuard']);
$routes->post('/addEvent', 'StaffController::addEvent',['filter' => 'staffGuard']);
$routes->post('/updateEvent', 'StaffController::updateEvent',['filter' => 'staffGuard']);

$routes->get('/staff-inventory', 'InventoryController::inhome',['filter' => 'staffGuard']);
$routes->get('/staff-inventory/hotel', 'InventoryController::inhotel',['filter' => 'staffGuard']);
$routes->post('/addinHotel', 'InventoryController::addinHotel',['filter' => 'staffGuard']);
$routes->post('/updateinHotel/(:num)', 'InventoryController::updateinHotel/$1',['filter' => 'staffGuard']);
$routes->get('/staff-inventory/restaurant', 'InventoryController::inrestaurant',['filter' => 'staffGuard']);
$routes->post('/addinRestaurant', 'InventoryController::addinRestaurant',['filter' => 'staffGuard']);
$routes->post('/updateinRestaurant/(:num)', 'InventoryController::updateinRestaurant/$1',['filter' => 'staffGuard']);

//Admin-Dashboard
$routes->get('/admin-dashboard', 'AdminController::dashboard',['filter' => 'adminGuard']);

$routes->get('/admin-customer', 'AdminController::customer',['filter' => 'adminGuard']);
$routes->post('/admin-addCustomer', 'AdminController::addCustomer',['filter' => 'adminGuard']);
$routes->post('/updateCustomer/(:num)', 'AdminController::updateCustomer/$1',['filter' => 'adminGuard']);
//Admin-Hotel-Reservation
$routes->get('/admin-hotel/reservation', 'AdminController::holReservation',['filter' => 'adminGuard']);
$routes->post('/addHotelReservation', 'AdminController::addHotelReservation',['filter' => 'adminGuard']);
$routes->post('/updateHotelReservation/(:num)', 'AdminController::updateHotelReservation/$1',['filter' => 'adminGuard']);
$routes->get('/admin/updatestatus/(:segment)/(:num)', 'AdminController::updateStatus/$1/$2',['filter' => 'adminGuard']);
//Admin-Restaurant-Reservation
$routes->get('/admin-restaurant/reservation', 'AdminController::resReservation',['filter' => 'adminGuard']);
$routes->post('/addRestauReservation', 'AdminController::addRestauReservation',['filter' => 'adminGuard']);
$routes->post('/updateRestauReservation/(:num)', 'AdminController::updateRestauReservation/$1',['filter' => 'adminGuard']);
$routes->get('/admin/updateRestauStatus/(:segment)/(:num)', 'AdminController::updateResStatus/$1/$2',['filter' => 'adminGuard']);
//Admin-Convention-Reservation
$routes->get('/admin-convention/reservation', 'AdminController::conReservation',['filter' => 'adminGuard']);
$routes->post('/addConReservation', 'AdminController::addConReservation',['filter' => 'adminGuard']);
$routes->post('/updateConReservation/(:num)', 'AdminController::updateConReservation/$1',['filter' => 'adminGuard']);
$routes->get('/admin/updateconstatus/(:segment)/(:num)', 'AdminController::updateconStatus/$1/$2',['filter' => 'adminGuard']);

//Admin-RateManagement
$routes->get('/admin-rate', 'AdminController::rate',['filter' => 'adminGuard']);
$routes->post('/submit-rate-form', 'AdminController::submitRateForm',['filter' => 'adminGuard']);

//Admin-Feedback
$routes->get('/admin-staffaccounts', 'AdminController::staffAccounts',['filter' => 'adminGuard']);
$routes->post('/admin-addstaffdetails', 'AdminController::addStaffDetails',['filter' => 'adminGuard']);
$routes->post('/updateStaffDetails/(:num)', 'AdminController::updateStaffDetails/$1');
$routes->get('/admin-feedback', 'AdminController::feedback',['filter' => 'adminGuard']);

//Admin-ChatBot
$routes->get('/admin-chat', 'AdminController::chat',['filter' => 'adminGuard']);
$routes->post('/addChat', 'AdminController::addChat',['filter' => 'adminGuard']);
$routes->post('/updateChat/(:num)', 'AdminController::updateChat/$1',['filter' => 'adminGuard']);


//Admin-Service Catalog Management
//Hotel
$routes->get('/admin-hotel/service', 'AdminController::holService',['filter' => 'adminGuard']);
$routes->post('/addserviceRoom', 'AdminController::addserviceRoom',['filter' => 'adminGuard']);
$routes->post('/updateserviceRoom', 'AdminController::updateserviceRoom',['filter' => 'adminGuard']);
//Restaurant
$routes->get('/admin-restaurant/service', 'AdminController::restService',['filter' => 'adminGuard']);
$routes->post('/addserviceTable', 'AdminController::addserviceTable',['filter' => 'adminGuard']);
$routes->post('/updateserviceTable', 'AdminController::updateserviceTable',['filter' => 'adminGuard']);
//Convention
$routes->get('/admin-convention/service', 'AdminController::conService',['filter' => 'adminGuard']);
$routes->post('/addserviceEvent', 'AdminController::addserviceEvent',['filter' => 'adminGuard']);
$routes->post('/updateserviceEvent', 'AdminController::updateserviceEvent',['filter' => 'adminGuard']);

