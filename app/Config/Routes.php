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
$routes->get('/restaurantt', 'GuestController::restaurantt',['filter' => 'noAuth']);
$routes->get('/mainmenu', 'GuestController::mainmenu',['filter' => 'noAuth']);
$routes->get('/barmenu', 'GuestController::barmenu',['filter' => 'noAuth']);
$routes->get('/cafemenu', 'GuestController::cafemenu',['filter' => 'noAuth']);
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
$routes->post('/api/fetch-province', 'UserController::fetchProvince',['filter' => 'noAuth']);
$routes->post('/api/fetch-city', 'UserController::fetchCity',['filter' => 'noAuth']);
$routes->post('/api/fetch-barangay', 'UserController::fetchBarangay',['filter' => 'noAuth']);
$routes->match(['get', 'post'],'/registerAuth', 'UserController::registerAuth',['filter' => 'noAuth']);
$routes->get('/login', 'UserController::login');
$routes->post('/loginAuth', 'UserController::loginAuth');
$routes->get('/logout', 'UserController::logout');
$routes->get('/verify/(:any)', 'UserController::verifyEmail/$1');
$routes->post('/saveToken', 'UserController::saveToken');

$routes->get('/admin-login', 'AdminController::login');
$routes->post('/adminloginAuth', 'AdminController::loginAuth');
$routes->get('/admin-logout', 'AdminController::logout');

$routes->get('/staff-login', 'StaffController::login');
$routes->post('/staffloginAuth', 'StaffController::loginAuth');
$routes->get('/staff-logout', 'StaffController::logout');


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

$routes->get('/admin-qrcode', 'AdminController::Qrcode',['filter' => 'adminGuard']);
$routes->post('/updateQrcode', 'AdminController::updateQrcode',['filter' => 'adminGuard']);



$routes->post('/addCocktails', 'RestaurantController::addCocktails',['filter' => 'adminGuard']);
$routes->post('/updateCocktails', 'RestaurantController::updateCocktails',['filter' => 'adminGuard']);

$routes->post('/addMocktails', 'RestaurantController::addMocktails',['filter' => 'adminGuard']);
$routes->post('/updateMocktails', 'RestaurantController::updateMocktails',['filter' => 'adminGuard']);

$routes->post('/addShooters', 'RestaurantController::addShooters',['filter' => 'adminGuard']);
$routes->post('/updateShooters', 'RestaurantController::updateShooters',['filter' => 'adminGuard']);

$routes->post('/addTower', 'RestaurantController::addTower',['filter' => 'adminGuard']);
$routes->post('/updateTower', 'RestaurantController::updateTower',['filter' => 'adminGuard']);

$routes->post('/addJuices', 'RestaurantController::addJuices',['filter' => 'adminGuard']);
$routes->post('/updateJuices', 'RestaurantController::updateJuices',['filter' => 'adminGuard']);

$routes->post('/addShakes', 'RestaurantController::addShakes',['filter' => 'adminGuard']);
$routes->post('/updateShakes', 'RestaurantController::updateShakes',['filter' => 'adminGuard']);

$routes->post('/addLiquors', 'RestaurantController::addLiquors',['filter' => 'adminGuard']);
$routes->post('/updateLiquors', 'RestaurantController::updateLiquors',['filter' => 'adminGuard']);

$routes->post('/addRedwine', 'RestaurantController::addRedwine',['filter' => 'adminGuard']);
$routes->post('/updateRedwine', 'RestaurantController::updateRedwine',['filter' => 'adminGuard']);

$routes->post('/addBeer', 'RestaurantController::addBeer',['filter' => 'adminGuard']);
$routes->post('/updateBeer', 'RestaurantController::updateBeer',['filter' => 'adminGuard']);

$routes->post('/addBucket', 'RestaurantController::addBucket',['filter' => 'adminGuard']);
$routes->post('/updateBucket', 'RestaurantController::updateBucket',['filter' => 'adminGuard']);

$routes->post('/addIced', 'RestaurantController::addIced',['filter' => 'adminGuard']);
$routes->post('/updateIced', 'RestaurantController::updateIced',['filter' => 'adminGuard']);

$routes->post('/addHot', 'RestaurantController::addHot',['filter' => 'adminGuard']);
$routes->post('/updateHot', 'RestaurantController::updateHot',['filter' => 'adminGuard']);

$routes->post('/addCold', 'RestaurantController::addCold',['filter' => 'adminGuard']);
$routes->post('/updateCold', 'RestaurantController::updateCold',['filter' => 'adminGuard']);

$routes->post('/addBreakfast', 'RestaurantController::addBreakfast',['filter' => 'adminGuard']);
$routes->post('/updateBreakfast', 'RestaurantController::updateBreakfast',['filter' => 'adminGuard']);

$routes->post('/addChicken', 'RestaurantController::addChicken',['filter' => 'adminGuard']);
$routes->post('/updateChicken', 'RestaurantController::updateChicken',['filter' => 'adminGuard']);

$routes->post('/addPasta', 'RestaurantController::addPasta',['filter' => 'adminGuard']);
$routes->post('/updatePasta', 'RestaurantController::updatePasta',['filter' => 'adminGuard']);

$routes->post('/addSizzling', 'RestaurantController::addSizzling',['filter' => 'adminGuard']);
$routes->post('/updateSizzling', 'RestaurantController::updateSizzling',['filter' => 'adminGuard']);

$routes->post('/addPork', 'RestaurantController::addPork',['filter' => 'adminGuard']);
$routes->post('/updatePork', 'RestaurantController::updatePork',['filter' => 'adminGuard']);

$routes->post('/addSoup', 'RestaurantController::addSoup',['filter' => 'adminGuard']);
$routes->post('/updateSoup', 'RestaurantController::updateSoup',['filter' => 'adminGuard']);

$routes->post('/addMealdeal', 'RestaurantController::addMealdeal',['filter' => 'adminGuard']);
$routes->post('/updateMealdeal', 'RestaurantController::updateMealdeal',['filter' => 'adminGuard']);

$routes->post('/addVeggies', 'RestaurantController::addVeggies',['filter' => 'adminGuard']);
$routes->post('/updateVeggies', 'RestaurantController::updateVeggies',['filter' => 'adminGuard']);

$routes->post('/addSolomeal', 'RestaurantController::addSolomeal',['filter' => 'adminGuard']);
$routes->post('/updateSolomeal', 'RestaurantController::updateSolomeal',['filter' => 'adminGuard']);

$routes->post('/addSeafood', 'RestaurantController::addSeafood',['filter' => 'adminGuard']);
$routes->post('/updateSeafood', 'RestaurantController::updateSeafood',['filter' => 'adminGuard']);

$routes->post('/addSnack', 'RestaurantController::addSnack',['filter' => 'adminGuard']);
$routes->post('/updateSnack', 'RestaurantController::updateSnack',['filter' => 'adminGuard']);