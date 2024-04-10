<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoomModel;
use App\Models\TableModel;
use App\Models\EventModel;
use App\Models\ReservationModel;
use App\Models\FeedbackModel;
use App\Models\GuestModel;
use App\Models\ChatModel;
use App\Models\QrcodeModel;
use App\Models\MenuModel;
use App\Models\MenuProductModel;
use App\Models\MenuCategoryModel;
use App\Models\RestaurantVenueModel;
use App\Models\MenuProductIcedModel;
use App\Traits\EmailTrait;
use App\Models\RoomInventoryModel;
use App\Models\ReservationAmenities;
use App\Models\ConventionVenueModel;
use App\Models\ConventionModel;
class GuestController extends BaseController
{
    use EmailTrait;
    private $users;
    private $rooms;
    private $tables;
    private $events;
    private $reservation;
    private $guest;
    private $feedbacks;
    private $chat;
    private $qr;
    private $menus;
    private $products;
    private $categories;
    private $venues;
    private $iced;
    private $roominventory;
    private $reservationamenities;
    private $convenues;
    private $conventions;

    function __construct(){
        helper(['form']);
        $this->users = new UserModel();
        $this->rooms = new RoomModel();
        $this->tables = new TableModel();
        $this->events = new EventModel();
        $this->reservation = new ReservationModel();
        $this->feedbacks = new FeedbackModel();
        $this->guest = new GuestModel();
        $this->chat = new ChatModel();
        $this->qr = new QrcodeModel();
        $this->menus = new MenuModel();
        $this->products = new MenuProductModel();
        $this->categories = new MenuCategoryModel();
        $this->venues = new RestaurantVenueModel();
        $this->iced = new MenuProductIcedModel();
        $this->roominventory = new RoomInventoryModel();
        $this->reservationamenities = new ReservationAmenities();
        $this->convenues = new ConventionVenueModel();
        $this->conventions = new ConventionModel();
    }
    public function index()
    {
        //
    }
    
    /* public function home()
    {
        $data = [
            'rooms' => $this->rooms->findAll(),
        ]; 
        return view('Hotel\home', $data);
    } */
    public function home()
    {
        $data = [
            'activePage' => 'Home',
            'chats' => $this->chat->findAll(),
            'feedbacks' => $this->feedbacks
            ->select('feedback.FeedbackID,feedback.FeedbackMessage, users.UserID, users.Email')
            ->join ('users', 'feedback.UserID = users.UserID')
            ->findAll()
        ];
        return view('Hotell\index', $data);
    }
    public function about()
    {
        return view('Hotel\about');
    }
    /* public function room()
    {
        $data = [
            'rooms' => $this->rooms->findAll(),
        ]; 
        return view('Hotel\room', $data);
    } */
    public function room()
    {
        $data = [
            'activePage' => 'Room',
            'rooms' => $this->rooms->findAll(),
            'chats' => $this->chat->findAll(),
        ];
        return view('Hotell\room', $data);
    }
    public function getData()
    {
        $session = \Config\Services::session();
        $checkInDate = $this->request->getGet('CheckInDate');
        $checkOutDate = $this->request->getGet('CheckOutDate');
        $numberOfAdults = $this->request->getGet('Adult');
        $numberOfChildren = $this->request->getGet('Child');
        $reservationData = [
            'CheckInDate' => $checkInDate,
            'CheckOutDate' => $checkOutDate,
            'Adult' => $numberOfAdults,
            'Child' => $numberOfChildren,
        ];
        $session->set('reservationData', $reservationData);
        // Pass all required parameters to findAvailableRooms method
        $availableRooms = $this->findAvailableRooms($checkInDate, $checkOutDate, $numberOfAdults, $numberOfChildren);
        return view('Hotell/bookroom', ['reservationData' => $reservationData, 'availableRooms' => $availableRooms]);
    }
    private function findAvailableRooms($checkInDate, $checkOutDate, $numberOfAdults, $numberOfChildren)
    {
        // Ensure $numberOfAdults and $numberOfChildren are integers
        $numberOfAdults = (int) $numberOfAdults;
        $numberOfChildren = (int) $numberOfChildren;
    
        // Convert check-in and check-out dates to proper formats (assuming they are in 'Y-m-d' format)
        $checkInDateFormatted = date('Y-m-d', strtotime($checkInDate));
        $checkOutDateFormatted = date('Y-m-d', strtotime($checkOutDate));
        $availableRooms = $this->rooms->where('minPerson <=', $numberOfAdults + $numberOfChildren)
                                        ->where('maxPerson >=', $numberOfAdults + $numberOfChildren)
                                     
                                        ->whereNotIn('RoomID', function ($builder) use ($checkInDateFormatted, $checkOutDateFormatted) {
                                            $builder->select('RoomID')
                                                    ->from('reservations')
                                                    ->where('CheckInDate <=', date('Y-m-d', strtotime($checkOutDateFormatted . ' +1 day')))
                                                    ->where('CheckOutDate >=', date('Y-m-d', strtotime($checkInDateFormatted . ' -1 day')));
                                                    
                                        })
                                        ->findAll();
    
        return $availableRooms;
    }
    
    public function getdataRoom()
    {
        $session = \Config\Services::session();
        $reservationData = $session->get('reservationData');
        $selectedRoomID = $this->request->getGet('selectedRoomID');
        $roomSelected = null;
        $TotalAmount = 0;
        $availableRooms = $this->findAvailableRooms($reservationData['CheckInDate'], $reservationData['CheckOutDate'], $reservationData['Adult'], $reservationData['Child']);
    
        // If a room is selected
        if (!empty($selectedRoomID)) {
            // Find the selected room
            $roomSelected = $this->rooms->find($selectedRoomID);
    
            // Calculate total amount if room is available
            if (!empty($roomSelected) && $roomSelected['AvailabilityStatus'] === 'Available') {
                $checkInDate = new \DateTime($reservationData['CheckInDate']);
                $checkOutDate = new \DateTime($reservationData['CheckOutDate']);
                $numberOfNights = $checkInDate->diff($checkOutDate)->days;
    
                $TotalAmount = $numberOfNights * $roomSelected['PricePerNight'];
                $numberOfAdults = (int) $reservationData['Adult'];
                $numberOfChildren = (int) $reservationData['Child'];
                $totalGuests = $numberOfAdults + $numberOfChildren;
    
                // Calculate additional charge for extra guests
                if ($totalGuests > $roomSelected['minPerson']) {
                    $additionalGuests = $totalGuests - $roomSelected['minPerson'];
                    $TotalAmount += $additionalGuests * 500;
                }
                $session->set('roomSelected', $roomSelected);
            }
        }
    
        // Pass data to the view
        return view('Hotell/bookroom', [
            'reservationData' => $reservationData,
            'availableRooms' => $availableRooms,
            'roomSelected' => $roomSelected,
            'TotalAmount' => $TotalAmount
        ]);
    }
    
    public function getdataRoomReservation()
    {
        $session = \Config\Services::session();
        $reservationData = $session->get('reservationData');
        $roomSelected = $session->get('roomSelected');
        $amenitiesData = $session->get('amenitiesData'); // Retrieve amenities data from session
        $totalExtraPrice = 0; // Initialize total extra price
    
        // Calculate total extra price for amenities
        if (!empty($amenitiesData)) {
            foreach ($amenitiesData as $amenity) {
                $totalExtraPrice += $amenity['Price'] * $amenity['insertQuantity'];
            }
        }
    
        if (!empty($reservationData) && !empty($roomSelected)) {
            $checkInDate = new \DateTime($reservationData['CheckInDate']);
            $checkOutDate = new \DateTime($reservationData['CheckOutDate']);
            $numberOfNights = $checkInDate->diff($checkOutDate)->days;
            $TotalAmount = $numberOfNights * $roomSelected['PricePerNight'];
    
            // Add total extra price to the TotalAmount
            $TotalAmount += $totalExtraPrice;
    
            $numberOfAdults = (int) $reservationData['Adult'];
            $numberOfChildren = (int) $reservationData['Child'];
            $totalGuests = $numberOfAdults + $numberOfChildren;
    
            if ($totalGuests > $roomSelected['minPerson']) {
                $additionalGuests = $totalGuests - $roomSelected['minPerson'];
                $TotalAmount += $additionalGuests * 500;    
            }
    
            // Set roomReservationData including totalExtraPrice
            $session->set('roomReservationData', [
                'reservationData' => $reservationData,
                'roomSelected' => $roomSelected,
                'TotalAmount' => $TotalAmount,
                'totalExtraPrice' => $totalExtraPrice, // Include totalExtraPrice
            ]);
            return redirect()->to(base_url('/bookroom/amenities'));
        } else {
            return redirect()->to(base_url('/error'));
        }
    }
    
    public function addAmenities()
    {
        $session = \Config\Services::session();
        $roomInventoryIDs = (array) $this->request->getPost('roomInventoryID'); 
        $insertQuantities = $this->request->getPost('insertQuantity');
        $roinvents = $this->request->getPost('roinvents');
        $amenitiesData = [];
        if (!empty($roomInventoryIDs)) {
            foreach ($roomInventoryIDs as $index => $roomInventoryID) {
                if (isset($roinvents[$roomInventoryID]) && is_array($roinvents[$roomInventoryID])) {
                    $productName = isset($roinvents[$roomInventoryID]['ProductName']) ? $roinvents[$roomInventoryID]['ProductName'] : 'Unknown Product';
                    $price = isset($roinvents[$roomInventoryID]['Price']) ? $roinvents[$roomInventoryID]['Price'] : 'Unknown Price';
                    $insertQuantity = isset($insertQuantities[$roomInventoryID]) ? $insertQuantities[$roomInventoryID] : 0;
                    
                    // Build amenities data array
                    $amenitiesData[] = [
                        'roomInventoryID' => $roomInventoryID,
                        'ProductName' => $productName,
                        'Price' => $price,
                        'insertQuantity' => $insertQuantity,
                    ];
                }
            }
            
            $session->set('amenitiesData', $amenitiesData);
            
            return redirect()->to(base_url('/bookroom/formdetails'));
        } else {
            return redirect()->to(base_url('/bookroom/amenities'))->with('error', 'Please select at least one amenity.');
        }
    }
    public function roomPolicy()
    {
        $data = [
            'activePage' => 'roomPolicy',
            'chats' => $this->chat->findAll()
        ];
        return view('Hotell\roompolicy',$data);
    }
    public function restaurantPolicy()
    {
        $data = [
            'activePage' => 'resPolicy',
            'chats' => $this->chat->findAll()
        ];
        return view('Hotell\restaurantpolicy',$data);
    }
    

    public function restaurantt()
    {
        $data = [
            'activePage' => 'Restaurant',
            'chats' => $this->chat->findAll(),
            
        ];
        return view('Hotell\restaurant',$data);
    }
    public function mainmenu()
    {
        $data = [
            'activePage' => 'Main Menu',
            'chats' => $this->chat->findAll(),
            'venues' => $this->venues->select('restaurant_venue.VenueID,restaurant_venue.VenueName,restaurant_venue.VenueCapacity,restaurant_venue.AvailableCapacity,restaurant_venue.Image ')->findAll(),
            'menumains' => $this->products
            ->select('menu_product.ProductID, menu_product.ProductName, menu_product.ProductPrice, menu_product.Image, menu_product.MenuID, menu_product.CategoryID, menu_category.CategoryID, menu_category.CategoryName, menu.MenuID, menu.MenuType')
            ->join('menu_category', 'menu_product.CategoryID = menu_category.CategoryID')
            ->join('menu', 'menu_product.MenuID = menu.MenuID')
            ->whereIn('menu_category.CategoryID', range(1, 11))
            ->where('menu.MenuType', 'Main Menu')
            ->findAll(),
        ];
        return view('Hotell\mainmenu',$data);
    }
    public function barmenu()
    {
        $data = [
            'activePage' => 'Bar Menu',
            'chats' => $this->chat->findAll(),
            'menubars' => $this->products
            ->select('menu_product.ProductID, menu_product.ProductName, menu_product.ProductPrice, menu_product.Image, menu_product.MenuID, menu_product.CategoryID, menu_category.CategoryID, menu_category.CategoryName, menu.MenuID, menu.MenuType')
            ->join('menu_category', 'menu_product.CategoryID = menu_category.CategoryID')
            ->join('menu', 'menu_product.MenuID = menu.MenuID')
            ->whereIn('menu_category.CategoryID', range(12, 21))
            ->where('menu.MenuType', 'Bar Menu')
            ->findAll(),
            
        ];
        return view('Hotell\barmenu',$data);
    }
    public function cafemenu()
    {
        $data = [
            'activePage' => 'Cafe Menu',
            'chats' => $this->chat->findAll(),
            'menucafes' => $this->products
            ->select('menu_product.ProductID, menu_product.ProductName, menu_product.ProductPrice,menu_product.ProductPrices, menu_product.Image, menu_product.MenuID, menu_product.CategoryID, menu_category.CategoryID, menu_category.CategoryName, menu.MenuID, menu.MenuType')
            ->join('menu_category', 'menu_product.CategoryID = menu_category.CategoryID')
            ->join('menu', 'menu_product.MenuID = menu.MenuID')
            ->whereIn('menu_category.CategoryID', range(21, 24))
            ->where('menu.MenuType', 'Cafe Menu')
            ->findAll(),
            'menuices' => $this->iced
            ->select('menu_producticed.IcedID, menu_producticed.IcedName, menu_producticed.PriceTall, menu_producticed.PriceGrande, menu_producticed.Image, menu_producticed.MenuID, menu_producticed.CategoryID, menu_category.CategoryID, menu_category.CategoryName, menu.MenuID, menu.MenuType')
            ->join('menu_category', 'menu_producticed.CategoryID = menu_category.CategoryID')
            ->join('menu', 'menu_producticed.MenuID = menu.MenuID')
            ->where('menu_category.CategoryID', 22)
            ->where('menu.MenuType', 'Cafe Menu')
            ->findAll(),
        ];
        return view('Hotell\cafemenu',$data);
    }

    public function bookroom()
    {
        // Load the session library
        $session = \Config\Services::session();
    
        // Retrieve reservation data from session
        $reservationData = $session->get('reservationData');
    
        // Retrieve available rooms data based on reservation data
        /* $availableRooms = $this->findAvailableRooms($reservationData['Adult'], $reservationData['Child']); */
    
        // Retrieve selected room data from session
        $roomSelected = $session->get('roomSelected');
    
        // Initialize total amount
        $TotalAmount = 0;
    
        // Check if a room is selected
        $selectedRoomID = $this->request->getGet('selectedRoomID');
        if (!empty($selectedRoomID)) {
            // Fetch the selected room data from the database using the ID
            $roomSelected = $this->rooms->find($selectedRoomID);
    
            // Check if the room is available before storing it in the session
            if (!empty($roomSelected) && isset($roomSelected['AvailabilityStatus']) && $roomSelected['AvailabilityStatus'] === 'Available') {
                // Calculate total amount
                $checkInDate = new \DateTime($reservationData['CheckInDate']);
                $checkOutDate = new \DateTime($reservationData['CheckOutDate']);
                $numberOfNights = $checkInDate->diff($checkOutDate)->days;
    
                // Calculate the total amount based on the number of nights and room price
                $TotalAmount = $numberOfNights * $roomSelected['PricePerNight'];
    
                // Convert Adult and Child values to integers
                $numberOfAdults = (int) $reservationData['Adult'];
                $numberOfChildren = (int) $reservationData['Child'];
    
                // Check if the number of guests exceeds the minimum capacity of the room
                $totalGuests = $numberOfAdults + $numberOfChildren;
                if ($totalGuests > $roomSelected['minPerson']) {
                    // If the number of guests exceeds the minimum capacity, increase the total amount
                    $additionalGuests = $totalGuests - $roomSelected['minPerson'];
                    $TotalAmount += $additionalGuests * 500; // PHP 500 per additional guest
                }
    
                // Store the data in the session
                $session->set('roomSelected', $roomSelected);
            }
        }
    
        // Pass reservation data, available rooms data, and total amount to the view
        $data = [
            'activePage' => 'Reservation',
            'rooms' => $this->rooms->findAll(),
            'reservationData' => $reservationData,
            /* 'availableRooms' => $availableRooms, */
            'roomSelected' => $roomSelected,
            'TotalAmount' => $TotalAmount,
        ];
    
        return view('Hotell\bookroom', $data);
    }
    public function amenities()
    {
         // Load the session library
         $session = \Config\Services::session();
    
         // Retrieve room reservation data from session
         $roomReservationData = $session->get('roomReservationData');
     
         // Calculate down payment and full payment amounts (assuming down payment is 50% of total amount)
         $downPaymentAmount = $roomReservationData['TotalAmount'] * 0.5;
         $fullPaymentAmount = $roomReservationData['TotalAmount'];
     
         // Add down payment and full payment amounts to room reservation data
         $roomReservationData['DownpaymentAmount'] = $downPaymentAmount;
         $roomReservationData['FullpaymentAmount'] = $fullPaymentAmount;
        $data = [
            'activePage' => 'Reservation',
            'roinvents' => $this->roominventory->findAll(),
            'qrcodes' => $this->qr->findAll(),
            'roomReservationData' => $roomReservationData,
        ];
    
        return view('Hotell\amenities', $data);
    }
    
    public function formdetails()
    {
        // Load the session library
        $session = \Config\Services::session();
        
        // Get user ID from session
        $userID = $session->get('userID');
    
        // Retrieve amenities and room reservation data from session
        $amenitiesData = $session->get('amenitiesData');
        $roomReservationData = $session->get('roomReservationData');
    
        // Calculate total extra price for amenities
        $totalExtraPrice = 0;
        if (isset($amenitiesData) && !empty($amenitiesData)) {
            foreach ($amenitiesData as &$amenity) {
                // Add UserID to each amenity data
                $amenity['UserID'] = $userID;
                $totalExtraPrice += $amenity['Price'] * $amenity['insertQuantity'];
            }
        }
    
        // Update total amount in roomReservationData
        if (isset($roomReservationData) && is_array($roomReservationData)) {
            if (array_key_exists('TotalAmount', $roomReservationData)) {
                $roomReservationData['TotalAmount'] += $totalExtraPrice;
            } else {
                $roomReservationData['TotalAmount'] = $totalExtraPrice;
            }
        }
    
        // Calculate down payment and full payment amounts
        $downPaymentAmount = $roomReservationData['TotalAmount'] * 0.5;
        $fullPaymentAmount = $roomReservationData['TotalAmount'];
    
        // Add calculated amounts to roomReservationData
        $roomReservationData['DownpaymentAmount'] = $downPaymentAmount;
        $roomReservationData['FullpaymentAmount'] = $fullPaymentAmount;
    
        // Prepare data to pass to the view
        $data = [
            'activePage' => 'Reservation',
            'rooms' => $this->rooms
                ->select('rooms.RoomID, rooms.RoomNumber, rooms.RoomType,rooms.Description,rooms.PricePerNight,rooms.AvailabilityStatus,rooms.Image')
                ->findAll(),
            'qrcodes' => $this->qr->findAll(),
            'roomReservationData' => $roomReservationData,
            'amenitiesData' => $amenitiesData,
            'totalExtraPrice' => $totalExtraPrice,
        ];
    
        // Pass data to the view
        return view('Hotell\checkOutReservation', $data);
    }
    public function addReservation()
    {
        helper(['form']);
        $session = session();
        $validationRules = [
            'PaymentOption' => 'required|in_list[gcash,paymaya]',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        $validationMessages = [
            'PaymentOption' => [
                'required' => 'Please select a payment option.',
                'in_list' => 'Invalid payment option selected.'
            ],
            'Image' => [
                'uploaded' => 'Please upload an image for proof.',
                'max_size' => 'The image size exceeds the maximum allowed size of 10MB.',
                'ext_in' => 'Only PNG, JPG, and GIF files are allowed for proof.'
            ],
            'ReferenceNumberPaymaya' => [
                'required' => 'The Paymaya reference number is required.',
                'regex_match' => 'The Paymaya must start with "CA" followed by 12 alphanumeric characters.'
            ],
            'ReferenceNumberGcash' => [
                'required' => 'The Gcash reference number is required.',
                'numeric' => 'The Gcash reference number must be numeric.',
                'exact_length[13]' => 'The Gcash reference number must be exactly 13 characters long.'
            ],
        ];
        if ($this->validate($validationRules, $validationMessages)) {
            // Retrieve reservation data and user details
            $FirstName = $this->request->getPost('FirstName');
            $LastName = $this->request->getPost('LastName');
            $ContactNumber = $this->request->getPost('ContactNumber');
            $Address = $this->request->getPost('Address');
            $email = $session->get('username');
            $user = $this->users->where('FirstName', $FirstName)
                                ->where('LastName', $LastName)
                                ->where('ContactNumber', $ContactNumber)
                                ->first();
            $roomSelected = session()->get('roomSelected');
            $reservationData = session()->get('reservationData');
            $amenitiesData = session()->get('amenitiesData');
            $totalExtraPrice = session()->get('totalExtraPrice');
            $TotalAmount = session()->get('roomReservationData')['TotalAmount'] + $totalExtraPrice;
    
            // Get the selected payment option and reference number
            $paymentOption = $this->request->getPost('PaymentOption');
            $referenceNumber = ($paymentOption == 'gcash') ? $this->request->getPost('ReferenceNumberGcash') : $this->request->getPost('ReferenceNumberPaymaya');
    
            if ($roomSelected && $reservationData && $user && $TotalAmount) {
                if ($image = $this->request->getFile('Image')) {
                    $newFileName = $image->getRandomName();
                    if ($image->isValid() && !$image->hasMoved()) {
                        $image->move(FCPATH .'proof/', $newFileName);
    
                        // Define the desired times for CheckInDate and CheckOutDate
                        $checkInTime = '14:00:00'; // 2:00 PM
                        $checkOutTime = '12:00:00'; // 12:00 PM
                        
                        // Concatenate the times with the date strings
                        $checkInDateTime = $reservationData['CheckInDate'] . ' ' . $checkInTime;
                        $checkOutDateTime = $reservationData['CheckOutDate'] . ' ' . $checkOutTime;
                       // Prepare amenity data with UserID
                    $amenitiesWithUserID = [];
                    foreach ($amenitiesData as $amenity) {
                        $amenity['UserID'] = $user['UserID'];
                        $amenitiesWithUserID[] = $amenity;
                    }
                    
                    // Insert amenities data
                    foreach ($amenitiesWithUserID as $amenity) {
                        $amenityData = [
                            'roomInventoryID' => $amenity['roomInventoryID'], // Assuming roomInventoryID is linked to room ID
                            'insertQuantity' => $amenity['insertQuantity'],
                            'UserID' => $amenity['UserID'],
                        ];
                        $this->reservationamenities->insert($amenityData);
                        $roomInventoryID = $amenity['roomInventoryID'];
                        $insertQuantity = $amenity['insertQuantity'];
                        $roomInventory = $this->roominventory->find($roomInventoryID);
                        if ($roomInventory) {
                            $currentQuantity = $roomInventory['Quantity'];
                            $newQuantity = $currentQuantity - $insertQuantity;
                            $this->roominventory->update($roomInventoryID, ['Quantity' => $newQuantity]);
                        }
                    }
                        $newReservationData = [
                            'CheckInDate' => $checkInDateTime,
                            'CheckOutDate' => $checkOutDateTime,
                            'Adult' => $reservationData['Adult'],
                            'Child' => $reservationData['Child'],
                            'downorfullPayment' => $this->request->getPost('downorfullPayment'),
                            'ReferenceNumber' => $referenceNumber,
                            'PaymentOption' => $paymentOption,
                            'Status' => 'Pending',
                            'RoomID' => $roomSelected['RoomID'],
                            'UserID' => $user['UserID'],
                            'TotalAmount' => $TotalAmount + $totalExtraPrice,
                            'AmenitiesID' => $amenitiesData,
                            'Image' => $newFileName
                        ];
                        $inserted = $this->reservation->insert($newReservationData);
                        if ($inserted) {
                            $emailMessage = $this->prepareEmailMessage($newReservationData);
                            $this->sendEmail($email, 'Your Reservation Confirmation', $emailMessage);
                            $fcmToken = $user['fcm_token'];
                            if (!empty($fcmToken)) {
                                $notifTitle = 'Reservation Confirmation';
                                $notifBody = 'Your reservation has been successfully added.';
                                $this->sendPushNotification($fcmToken, $notifTitle, $notifBody);
                            }
    
                            // Redirect with success message
                            $session->setFlashdata('success', 'Reservation added successfully and email sent.');
                            return redirect()->to('/room');
                        } else {
                            return redirect()->to(base_url('/s'))->with('error', 'Failed to add reservation. Please try again.');
                        }
                    } else {
                        return redirect()->to(base_url('/u'))->with('error', 'Failed to upload image. Please try again.');
                    }
                } else {
                    return redirect()->to(base_url('/u'))->with('error', 'Please upload an image.');
                }
            } else {
                return redirect()->to(base_url('/u'))->with('error', 'Invalid data in sessions. Please check your input.');
            }
        } else {
            // Validation failed, return to the reservation form with validation errors
            $newReservationData['validation'] = $this->validator;
            return view('Hotell/checkOutReservation', $newReservationData);
        }
    }
    private function prepareEmailMessage(array $reservationData): string
    {
        $checkInDate = $reservationData['CheckInDate'];
        $checkOutDate = $reservationData['CheckOutDate'];
        $adults = $reservationData['Adult'];
        $children = $reservationData['Child'];
        $newFileName = $reservationData['Image'];
        $downorfullPayment = $reservationData['downorfullPayment'];
        $paymentOption = $reservationData['PaymentOption'];
        $referenceNumber = $reservationData['ReferenceNumber'];
        $totalAmount = $reservationData['TotalAmount'];
    
        $message = "Dear customer,<br><br>";
        $message .= "Your reservation has been successfully made with the following details:<br>";
        $message .= "Check-in Date: {$checkInDate}<br>";
        $message .= "Check-out Date: {$checkOutDate}<br>";
        $message .= "Number of Adults: {$adults}<br>";
        $message .= "Number of Children: {$children}<br>";
        $message .= "Payment Option: {$paymentOption}<br>";
        $message .= "Down or Full Payment: {$downorfullPayment}<br>";
        $message .= "Reference Number: {$referenceNumber}<br>";
        $message .= "Rate Amount: {$totalAmount}<br>";
        $message .= "Proof of Payment: <img src='" . base_url('/proof/' . $newFileName) . "' alt='Proof of Payment'><br>"; 
        $message .= "<br>We look forward to hosting you.<br>";
    
        return $message;
    }
    protected function sendPushNotification($fcmToken, $title, $body) {
        $firebaseServerKey = 'AAAAKoechE8:APA91bEJSQ3bMHlFCb8pFAQ_kJ_xaA5yi4Zy9hR0t1Wqugqy7JUPYgpeNzvl9CJTN67sx4M_f8_9hrKKsnFQaxPCV4bYhtrgrOXdPntM2GpQnPuc07YEa3dkLJhlpzxmv6gXOnRQeNCA';
        $postData = [
            'to' => $fcmToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
        ];
        $headers = [
            'Authorization: key=' . $firebaseServerKey,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        $result = curl_exec($ch);
        curl_close($ch);
    }
    public function updateVenueOptions()
    {
        $NumberOfGuests = $this->request->getVar('NumberOfGuests');

        $venues = $this->venues->where('AvailableCapacity >=', $NumberOfGuests)->findAll();

        return $this->response->setJSON($venues); // Return venues as JSON
    }
    public function tableReservation()
    {
        $session = session();
        helper(['form']);

        $validationRules = [
            'FirstName' => 'required',
            'LastName' => 'required',
            'ContactNumber' => 'required',
            'ArivalDate' => 'required',
            'ArivalTime' => 'required',
            'NumberOfGuests' => 'required',
            'VenueName' => 'required', 
        ];

        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to('/')->with('validationErrors', $validationErrors);
        }

        $FirstName = $this->request->getPost('FirstName');
        $LastName = $this->request->getPost('LastName');
        $ContactNumber = $this->request->getPost('ContactNumber');
        $email = $session->get('username');

        $user = $this->users->where('FirstName', $FirstName)
                            ->where('LastName', $LastName)
                            ->where('ContactNumber', $ContactNumber)
                            ->first();

        $VenueName = $this->request->getPost('VenueName');
        $restaurantVenue = $this->venues->where('VenueName', $VenueName)->first();

        if ($restaurantVenue && $user) {
            $availableCapacity = $restaurantVenue['AvailableCapacity'];
            $numberOfGuests = $this->request->getPost('NumberOfGuests');

            if ($availableCapacity >= $numberOfGuests) {
                $newAvailableCapacity = $availableCapacity - $numberOfGuests;
                $this->venues->update($restaurantVenue['VenueID'], ['AvailableCapacity' => $newAvailableCapacity]);

                $restaurantReservation = [
                    'NumberOfGuests' => $numberOfGuests,
                    'ArivalDate' => $this->request->getPost('ArivalDate'),
                    'ArivalTime' => $this->request->getPost('ArivalTime'),
                    'Note' => $this->request->getPost('Note'),
                    'Status' => 'Pending',
                    'VenueName' => $VenueName,
                    'VenueID' => $restaurantVenue['VenueID'],
                    'UserID' => $user['UserID'],
                ];

                $inserted = $this->reservation->insert($restaurantReservation);

                if ($inserted) {
                    $emailMessage = $this->prepareEmail($restaurantReservation);
                    $this->sendEmail($email, 'Your Reservation Confirmation', $emailMessage);
                    $fcmToken = $user['fcm_token'];

                    if (!empty($fcmToken)) {
                        $notifTitle = 'Reservation Confirmation';
                        $notifBody = 'Your reservation has been successfully added.';
                        $this->sendPushNotification($fcmToken, $notifTitle, $notifBody);
                    }
                    $session->setFlashdata('success', 'Reservation added successfully and email sent.');
                    return redirect()->to('/mainmenu');
                } else {
                    return redirect()->to(base_url('/'))->with('error', 'Failed to add reservation. Please try again.');
                }
            } else {
                return redirect()->to(base_url('/'))->with('error', 'Not enough available capacity. Please select a different venue or reduce the number of guests.');
            }
        } else {
            return redirect()->to(base_url('/'))->with('error', 'Invalid user or venue information. Please check your input.');
        }
    }

    private function prepareEmail(array $reservationDataa): string // Corrected method name
    {
        $ArivalDate = $reservationDataa['ArivalDate'];
        $ArivalTime = $reservationDataa['ArivalTime'];
        $NumberOfGuests = $reservationDataa['NumberOfGuests'];
        $Note = $reservationDataa['Note'];
        $VenueName = $reservationDataa['VenueName'];

        $message = "Dear customer,<br><br>";
        $message .= "Your reservation has been successfully made with the following details:<br>";
        $message .= "Venue Name: {$VenueName}<br>";
        $message .= "Arrival Date: {$ArivalDate}<br>";
        $message .= "Arrival Time: {$ArivalTime}<br>";
        $message .= "Number of Guests: {$NumberOfGuests}<br>";
        $message .= "Note: {$Note}<br>";
        $message .= "<br>We look forward to hosting you.<br>";

        return $message;
    }

    public function convention()
    {
        
        $data = [
            'activePage' => 'Convention',
            'events' => $this->events->findAll(),
            'convenues' => $this->convenues->findAll(),
            'chats' => $this->chat->findAll()
        ];
        return view('Hotell\convention',$data);
    }
    
/*     public function getdataconVenue()
    {
        $session = \Config\Services::session();
        $selectedconVenueID = $this->request->getGet('selectedconVenueID');
        $convenuesSelected = null;
        if (!empty($selectedconVenueID)) {
            $convenuesSelected = $this->convenues->find($selectedconVenueID);
                $session->set('convenuesSelected', $convenuesSelected);
        }
        $convenues = $this->convenues->findAll();
        return view('Hotell/conreservation', [
            'convenuesSelected' => $convenuesSelected,
            'convenues' => $convenues,
        ]);
    } */
    public function getconvenuedirectInformation()
    {
        $session = \Config\Services::session();
        $selectedconVenueID = $this->request->getPost('selectedconVenueID');
        $convenuesSelected = null;
        if (!empty($selectedconVenueID)) {
            // Retrieve the selected venue from the database based on the ID
            $convenuesSelected = $this->convenues->find($selectedconVenueID);
            $session->set('convenuesSelected', $convenuesSelected);
        }
        
        return view('Hotell/coninformation', [
            'convenuesSelected' => $convenuesSelected,
        ]);
    }
    
    
    
    public function conReservation()
    {
        // Load the session library
        $session = \Config\Services::session();
        $convenuesSelected = $session->get('convenuesSelected');
        $selectedconVenueID = $this->request->getGet('selectedconVenueID');
        if (!empty($selectedconVenueID)) {
            $convenuesSelected = $this->convenues->find($selectedconVenueID);
                $session->set('convenuesSelected', $convenuesSelected);
        }

        $data = [
            'activePage' => 'Convention Reservation',
            'events' => $this->events->findAll(),
            'convenues' => $this->convenues->findAll(), // Pass $convenues to the view
            'convenuesSelected' => $convenuesSelected,
            'chats' => $this->chat->findAll()
        ];
        
        return view('Hotell\conreservation', $data);
    }
    public function getVenueDateandGuests()
    {
        $session = \Config\Services::session();
        $CheckInDate = $this->request->getPost('CheckInDate');
        $CheckOutDate = $this->request->getPost('CheckOutDate');
        $NumberOfGuests = $this->request->getPost('NumberOfGuests');

        $FirstName = $this->request->getPost('FirstName');
        $LastName = $this->request->getPost('LastName');
        $ContactNumber = $this->request->getPost('ContactNumber');
        $Region = $this->request->getPost('Region');
        $Province = $this->request->getPost('Province');
        $City = $this->request->getPost('City');
        $Barangay = $this->request->getPost('Barangay');
        $EventType = $this->request->getPost('EventType');
        // Store user data in session
        $UserData = [
            'FirstName' => $FirstName,
            'LastName' => $LastName,
            'ContactNumber' => $ContactNumber,
            'Region' => $Region,
            'Province' => $Province,
            'City' => $City,
            'Barangay' => $Barangay,
        ];
        $ReservationData = [
            'CheckInDate' => $CheckInDate,
            'CheckOutDate' => $CheckOutDate,
            'NumberOfGuests' => $NumberOfGuests,
        ];
        $EventData = [
            'EventType' => $EventType
        ];
        $session->set('UserData', $UserData);
        $session->set('ReservationData', $ReservationData);
        $session->set('EventData', $EventData);
        
        $TotalAmount = $NumberOfGuests * 999; // Calculate total amount
        $session->set('TotalAmount', $TotalAmount); // Store total amount in session
        
        return redirect()->to(base_url('/convention-center/reservation/formdetails'));
    }

    public function conventioninformation()
    {
        $session = \Config\Services::session();
        $convenuesSelected = $session->get('convenuesSelected');
        $ReservationData = $session->get('ReservationData');
        $EventData = $session->get('EventData');
        $UserData = $session->get('UserData');
        $TotalAmount = $session->get('TotalAmount'); // Retrieve total amount from session
        $qr = $this->qr->findAll();
        $data = [
            'activePage' => 'Convention',
            'events' => $this->events->findAll(),
            'convenues' => $this->convenues->findAll(),
            'convenuesSelected' => $convenuesSelected,
            'UserData' => $UserData,
            'TotalAmount' => $TotalAmount,
            'ReservationData' => $ReservationData,
            'EventData' => $EventData,
            'chats' => $this->chat->findAll(),
            'qrcodes' => $qr,
        ];
        return view('Hotell\coninformation', $data);
    }
    public function conventionformdetails()
    {
        $session = \Config\Services::session();
        $ReservationData = $session->get('ReservationData');
        $convenuesSelected = $session->get('convenuesSelected');
        $EventData = $session->get('EventData');
        $UserData = $session->get('UserData');
        $TotalAmount = $session->get('TotalAmount'); // Retrieve total amount from session
    
        // Calculate down payment and full payment amounts
        $DownPaymentAmount = $TotalAmount * 0.5;
        $FullPaymentAmount = $TotalAmount;
    
        // Store down payment and full payment amounts in the data array
        $data = [
            'activePage' => 'Convention',
            'events' => $this->events->findAll(),
            'convenues' => $this->convenues->findAll(),
            'UserData' => $UserData,
            'TotalAmount' => $TotalAmount,
            'convenuesSelected' => $convenuesSelected,
            'ReservationData' => $ReservationData,
            'EventData' => $EventData,
            'DownpaymentAmount' => $DownPaymentAmount,
            'FullpaymentAmount' => $FullPaymentAmount,
            'chats' => $this->chat->findAll(),
            'qrcodes' => $this->qr->findAll(),
        ];
        return view('Hotell\conformdetail', $data);
    }
    public function conPackage()
    {
        $data = [
            'activePage' => 'conPackage',
            'chats' => $this->chat->findAll()
        ];
        return view('Hotell\conpackage',$data);
    }
    public function conventionReservation()
    {
       helper(['form']);
        $session = session();
        $validationRules = [
            'PaymentOption' => 'required|in_list[gcash,paymaya]',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        $validationMessages = [
            'PaymentOption' => [
                'required' => 'Please select a payment option.',
                'in_list' => 'Invalid payment option selected.'
            ],
            'Image' => [
                'uploaded' => 'Please upload an image for proof.',
                'max_size' => 'The image size exceeds the maximum allowed size of 10MB.',
                'ext_in' => 'Only PNG, JPG, and GIF files are allowed for proof.'
            ],
            'ReferenceNumberPaymaya' => [
                'required' => 'The Paymaya reference number is required.',
                'regex_match' => 'The Paymaya must start with "CA" followed by 12 alphanumeric characters.'
            ],
            'ReferenceNumberGcash' => [
                'required' => 'The Gcash reference number is required.',
                'numeric' => 'The Gcash reference number must be numeric.',
                'exact_length[13]' => 'The Gcash reference number must be exactly 13 characters long.'
            ],
        ];
        if ($this->validate($validationRules, $validationMessages)) {
            $UserData = session()->get('UserData');
            $FirstName = $UserData['FirstName'] ?? '';
            $LastName = $UserData['LastName'] ?? '';
            $ContactNumber = $UserData['ContactNumber'] ?? '';
            $Region = $UserData['Region'] ?? '';
            $Province = $UserData['Province'] ?? '';
            $City = $UserData['City'] ?? '';
            $Barangay = $UserData['Barangay'] ?? '';
            $UserData = $this->users->where('FirstName', $FirstName)
                                ->where('LastName', $LastName)
                                ->where('ContactNumber', $ContactNumber)
                                ->where('Region', $Region)
                                ->where('Province', $Province)
                                ->where('City', $City)
                                ->where('Barangay', $Barangay)
                                ->first();
            $ReservationData = session()->get('ReservationData');
            $EventData = session()->get('EventData');
            $EventType = $EventData['EventType'] ?? '';
            $EventData = $this->events->where('EventType', $EventType)
                                ->first();
            $TotalAmount = session()->get('TotalAmount');
            $convenuesSelected = session()->get('convenuesSelected');
            $paymentOption = $this->request->getPost('PaymentOption');
            $referenceNumber = ($paymentOption == 'gcash') ? $this->request->getPost('ReferenceNumberGcash') : $this->request->getPost('ReferenceNumberPaymaya');
    
            
            if ($EventData && $ReservationData && $UserData && $TotalAmount && $convenuesSelected) {
                if ($image = $this->request->getFile('Image')) {
                    $newFileName = $image->getRandomName();
                    if ($image->isValid() && !$image->hasMoved()) {
                        $image->move(FCPATH .'proof/', $newFileName);
                        $checkInTime = '14:00:00'; // 2:00 PM
                        $checkOutTime = '12:00:00'; // 12:00 PM
                        $checkInDateTime = $ReservationData['CheckInDate'] . ' ' . $checkInTime;
                        $checkOutDateTime = $ReservationData['CheckOutDate'] . ' ' . $checkOutTime;
 
                        $eventID = $EventData['EventID'] ?? null;
                        $conVenueID = $convenuesSelected['conVenueID'] ?? null;
                        $conventionData = [
                            'EventID' => $eventID,
                            'conVenueID' => $conVenueID,
                        ];
                        $conventionID = $this->conventions->insert($conventionData);
                        $newReservationData = [
                            'UserID' => $UserData['UserID'],
                            'conventionID' => $conventionID,
                            'CheckInDate' => $checkInDateTime,
                            'CheckOutDate' => $checkOutDateTime,
                            'NumberOfGuests' => $ReservationData['NumberOfGuests'],
                            'downorfullPayment' => $this->request->getPost('downorfullPayment'),
                            'ReferenceNumber' => $referenceNumber,
                            'PaymentOption' => $paymentOption,
                            'Status' => 'Pending',
                            'TotalAmount' => $TotalAmount,
                            'Image' => $newFileName
                        ];
                        $inserted = $this->reservation->insert($newReservationData);
                        if ($inserted) {
    
                            // Redirect with success message
                            $session->setFlashdata('success', 'Reservation added successfully and email sent.');
                            return redirect()->to('/convention-center');
                        } else {
                            return redirect()->to(base_url('/s'))->with('error', 'Failed to add reservation. Please try again.');
                        }
                    } else {
                        return redirect()->to(base_url('/u'))->with('error', 'Failed to upload image. Please try again.');
                    }
                } else {
                    return redirect()->to(base_url('/u'))->with('error', 'Please upload an image.');
                }
            } else {
                return redirect()->to(base_url('/u'))->with('error', 'Invalid data in sessions. Please check your input.');
            }
        } else {
            // Validation failed, return to the reservation form with validation errors
            $newReservationData['validation'] = $this->validator;
            $newReservationData = ['qrcodes' => $this->qr->findAll()];
            return view('Hotell/conformdetail', $newReservationData);
        }
        
    }    
    private function prepareEmailllMessage(array $reservationData): string
    {
        $numberofGuests = $reservationData['NumberOfGuests'] ?? '';
        $arrivalDate = $reservationData['ArivalDate'] ?? '';
        $note = $reservationData['Note'] ?? '';
        $eventType = $reservationData['EventType'] ?? ''; // Check if EventType key exists

        $message = "Dear customer,<br><br>";
        $message .= "Your reservation has been successfully made with the following details:<br>";
        $message .= "Event Type: {$eventType}<br>";
        $message .= "Number of Guests: {$numberofGuests}<br>";
        $message .= "Arrival Date: {$arrivalDate}<br>";
        $message .= "Note: {$note}<br>";

        return $message;
    }


    
    public function contact()
    {
        return view('Hotel\contact');
    }
    public function getFeedback()
    {
        return view('Hotell\index');
    }
    public function postFeedback()
    {
        helper(['form']);

        // Validation Rules
        $validationRules = [
            'Email' => 'required',
            'FeedbackMessage' => 'required',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return view('/', ['validationErrors' => $validationErrors]);
        }

        // Retrieve Post Data
        $Email = $this->request->getPost('Email');
        $feedbackMessage = $this->request->getPost('FeedbackMessage');

        // Use a single query to get the user based on Email
        $user = $this->users->where('Email', $Email)->first();

        // Check if the user exists
        if ($user) {
            // Check if a feedback from the same user already exists
            $existingFeedback = $this->feedbacks->where('UserID', $user['UserID'])->first();

            if ($existingFeedback) {
                // If a feedback exists, you can choose to update it
                $this->feedbacks->update($existingFeedback['FeedbackID'], ['FeedbackMessage' => $feedbackMessage]);

                return redirect()->to(base_url('/'))->with('success', 'Feedback updated successfully.');
            } else {
                // If no feedback exists, insert a new one
                $newFeedbackData = [
                    'FeedbackMessage' => $feedbackMessage,
                    'UserID' => $user['UserID'],
                ];

                $inserted = $this->feedbacks->insert($newFeedbackData);

                return $inserted
                    ? redirect()->to(base_url('/'))->with('success', 'Feedback added successfully.')
                    : redirect()->to(base_url('/'))->with('error', 'Failed to add Feedback. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/forbidden'))->with('error', 'Invalid Email. Please check your input.');
        }
    }
    public function faq()
    {
        return view('Hotell\index');
    }
    public function profile()
    {
        return view('Hotell\profile');
    }
    public function updateProfile($userID)
    {
        helper(['form']);
    
        // Validation Rules
        $validationRules = [
            'FirstName' => 'required|min_length[2]|max_length[100]', // Adjusted min_length from 4 to 2
            'LastName' => 'required|min_length[2]|max_length[100]', // Adjusted min_length from 4 to 2
            'Email' => 'required|min_length[4]|max_length[100]|valid_email',
            'ContactNumber' => 'required|max_length[11]', // Adjusted max_length from 11 to match typical phone numbers
            'Address' => 'required|min_length[2]|max_length[255]', // Adjusted max_length from 100 to 255
        ];
    
        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->back()->withInput()->with('validationErrors', $validationErrors); // Redirect back with input and validation errors
        }
    
        // Prepare Updated User Data
        $updatedUserData = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'Email' => $this->request->getVar('Email'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
            'Address' => $this->request->getVar('Address'),
        ];
    
        // Update User Details
        $this->users->update($userID, $updatedUserData);
    
        // Redirect with appropriate message
        return redirect()->to(base_url('/profile'))->with('success', 'Guest details updated successfully.');
    }
    public function get_chat_data()
    {
        $msg = strtolower(trim($this->request->getPost('msg')));

        // Explode the message into an array of words
        $arrInput = explode(" ", $msg);

        $arr = $this->chat->getAllChatbot(); // Call the method from ChatModel

        // Initialize an array to store the count of matching words for each question
        $arrCount = [];

        // Loop through each record in the chatbot table
        foreach ($arr as $key => $row) {
            // Convert question to lowercase and explode it into an array of words
            $question = strtolower($row['Question']);
            $arrQuestion = explode(" ", $question);

            // Initialize counter for matching words
            $count = 0;

            // Loop through each word in the input message
            foreach ($arrInput as $inputWord) {
                // Check if the input word exists in the question
                if (in_array($inputWord, $arrQuestion)) {
                    $count++;
                }
            }

            // Store the count for this question
            $arrCount[$key] = $count;
        }

        // Check if no matching words were found
        if (array_sum($arrCount) == 0) {
            echo "Sorry, I can't recognize. Please choose one below";
            exit;
        } else {
            // Find the index of the question with the highest count of matching words
            $maxIndex = array_search(max($arrCount), $arrCount);
            // Return the corresponding answer
            echo $arr[$maxIndex]['Answer'];
            exit;
        }
    }


}
