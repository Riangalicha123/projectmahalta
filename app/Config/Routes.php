<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'GuestController::home');
$routes->get('/room', 'GuestController::room');
$routes->get('/bookroom/submit', 'GuestController::getData');
$routes->get('/getdataRoom', 'GuestController::getdataRoom');
$routes->get('/bookroom', 'GuestController::bookroom');
$routes->get('/bookroom/getdataRoom', 'GuestController::getdataRoomReservation');
$routes->get('/bookroom/formdetails', 'GuestController::formdetails');
$routes->post('/bookroom/addReservation', 'GuestController::addReservation');
$routes->get('/blog', 'GuestController::blog');
$routes->get('/faq', 'GuestController::faq');
//$routes->get('/contact', 'GuestController::contact');
$routes->get('/restaurant', 'GuestController::restaurant');
$routes->get('/convention', 'GuestController::convention');
$routes->get('/profile', 'GuestController::profile');
$routes->get('/chat', 'GuestController::chat');
$routes->post('/updateProfile/(:num)', 'GuestController::updateProfile/$1');

$routes->post('/tableReservation', 'GuestController::tableReservation');
$routes->post('/eventReservation', 'GuestController::eventReservation');
$routes->get('/getFeedback', 'GuestController::getFeedback');
$routes->post('/postFeedback', 'GuestController::postFeedback');


$routes->get('/register', 'UserController::register');
$routes->match(['get', 'post'],'/registerAuth', 'UserController::registerAuth',);
$routes->get('/login', 'UserController::login');
$routes->post('/loginAuth', 'UserController::loginAuth');
$routes->get('/logout', 'UserController::logout');


$routes->get('/staff-hotel', 'StaffController::home');
$routes->get('/staff-hotelreservation', 'StaffController::reservation');
$routes->post('/addhotelReservation', 'StaffController::addhotelReservation');
$routes->post('/updatehotelReservation/(:num)', 'StaffController::updatehotelReservation/$1');
$routes->get('/staff/updatestatus/(:segment)/(:num)', 'StaffController::updateStatus/$1/$2',/* ['filter' => 'authGuard'] */);
$routes->get('/staff-hotelroom', 'StaffController::room');
$routes->post('/addRoom', 'StaffController::addRoom');
$routes->get('/deleteRoom/(:any)', 'StaffController::deleteRoom/$1');
$routes->post('/updateRoom', 'StaffController::updateRoom');

$routes->get('/staff-restaurant', 'StaffController::reshome');
$routes->get('/staff-restaurant-reservation', 'StaffController::resReservation',/* ['filter' => 'authGuard'] */);
$routes->post('/addrestauReservation', 'StaffController::addrestauReservation');
$routes->post('/updaterestauReservation/(:num)', 'StaffController::updaterestauReservation/$1');
$routes->get('/staff/updaterestauStatus/(:segment)/(:num)', 'StaffController::updaterestauStatus/$1/$2',/* ['filter' => 'authGuard'] */);
$routes->get('/staff-restaurant-table', 'StaffController::resTable',/* ['filter' => 'authGuard'] */);
$routes->post('/addTable', 'StaffController::addTable');
$routes->post('/updateTable', 'StaffController::updateTable');

$routes->get('/staff-convention', 'StaffController::conhome');
$routes->get('/staff-convention-reservation', 'StaffController::conReservation',/* ['filter' => 'authGuard'] */);
$routes->post('/addconReservation', 'StaffController::addconReservation');
$routes->post('/updateconReservation/(:num)', 'StaffController::updateconReservation/$1');
$routes->get('/staff/updateconStatus/(:segment)/(:num)', 'StaffController::updateconStatus/$1/$2',/* ['filter' => 'authGuard'] */);
$routes->get('/staff-convention-event', 'StaffController::conEvent',/* ['filter' => 'authGuard'] */);
$routes->post('/addEvent', 'StaffController::addEvent');
$routes->post('/updateEvent', 'StaffController::updateEvent');

$routes->get('/staff-inventory', 'InventoryController::inhome');
$routes->get('/staff-inventory/hotel', 'InventoryController::inhotel');
$routes->post('/addinHotel', 'InventoryController::addinHotel');
$routes->post('/updateinHotel/(:num)', 'InventoryController::updateinHotel/$1');
$routes->get('/staff-inventory/restaurant', 'InventoryController::inrestaurant');
$routes->post('/addinRestaurant', 'InventoryController::addinRestaurant');
$routes->post('/updateinRestaurant/(:num)', 'InventoryController::updateinRestaurant/$1');

//Admin
$routes->get('/admin-dashboard', 'AdminController::dashboard',/* ['filter' => 'authGuard'] */);

$routes->get('/admin-customer', 'AdminController::customer',/* ['filter' => 'authGuard'] */);
$routes->post('/admin-addCustomer', 'AdminController::addCustomer',/* ['filter' => 'authGuard'] */);
$routes->post('/updateCustomer/(:num)', 'AdminController::updateCustomer/$1');
//Admin-Hotel
$routes->get('/admin-hotel/reservation', 'AdminController::holReservation',/* ['filter' => 'authGuard'] */);
$routes->post('/addHotelReservation', 'AdminController::addHotelReservation');
$routes->post('/updateHotelReservation/(:num)', 'AdminController::updateHotelReservation/$1');
$routes->get('/admin/updatestatus/(:segment)/(:num)', 'AdminController::updateStatus/$1/$2',/* ['filter' => 'authGuard'] */);
//Admin-Restaurant
$routes->get('/admin-restaurant/reservation', 'AdminController::resReservation',/* ['filter' => 'authGuard'] */);
$routes->post('/addRestauReservation', 'AdminController::addRestauReservation');
$routes->post('/updateRestauReservation/(:num)', 'AdminController::updateRestauReservation/$1');
$routes->get('/admin/updateRestauStatus/(:segment)/(:num)', 'AdminController::updateResStatus/$1/$2',/* ['filter' => 'authGuard'] */);
//Admin-Convention
$routes->get('/admin-convention/reservation', 'AdminController::conReservation',/* ['filter' => 'authGuard'] */);
$routes->post('/addConReservation', 'AdminController::addConReservation');
$routes->post('/updateConReservation/(:num)', 'AdminController::updateConReservation/$1');
$routes->get('/admin/updateconstatus/(:segment)/(:num)', 'AdminController::updateconStatus/$1/$2',/* ['filter' => 'authGuard'] */);

//Admin-RateManagement
$routes->get('/admin-rate', 'AdminController::rate',/* ['filter' => 'authGuard'] */);
$routes->post('/submit-rate-form', 'AdminController::submitRateForm',/* ['filter' => 'authGuard'] */);

//Admin-Feedback
$routes->get('/admin-staffaccounts', 'AdminController::staffAccounts',/* ['filter' => 'authGuard'] */);
$routes->post('/admin-addstaffdetails', 'AdminController::addStaffDetails',/* ['filter' => 'authGuard'] */);
$routes->post('/updateStaffDetails/(:num)', 'AdminController::updateStaffDetails/$1');
$routes->get('/admin-feedback', 'AdminController::feedback',/* ['filter' => 'authGuard'] */);

//Admin-ChatBot
$routes->get('/admin-chat', 'AdminController::chat',/* ['filter' => 'authGuard'] */);
$routes->post('/addChat', 'AdminController::addChat');
$routes->post('/updateChat/(:num)', 'AdminController::updateChat/$1');
$routes->post('/get_chat_data', 'AdminController::get_chat_data');
