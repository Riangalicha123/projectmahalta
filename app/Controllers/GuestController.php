<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Jobs\SendReminderEmail;
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
use App\Models\JobModel;
use App\Models\RoomImageModel;
use App\Models\NewsModel;

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
    private $roomimages;
    private $news;
    function __construct()
    {
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
        $this->roomimages = new RoomImageModel();
        $this->news = new NewsModel();
    }
    public function processJobs()
    {
        var_dump($this->processPendingJobs());
    }
    public function home()
    {
        $data = [
            'activePage' => 'Home',
            'chats' => $this->chat->findAll(),
            'rooms' => $this->rooms->findAll(),
            'feedbacks' => $this->feedbacks
                ->select('feedback.FeedbackID,feedback.UserRating,feedback.FeedbackMessage,feedback.datetime, users.UserID, users.Email')
                ->join('users', 'feedback.UserID = users.UserID')
                ->findAll(),
            'news' => $this->news->findAll(),
        ];
        return view('Hotell/index', $data);
    }
    public function about()
    {
        return view('Hotel/about');
    }
    public function room()
    {
        $data = [
            'activePage' => 'Room',
            'rooms' => $this->rooms->findAll(),
            'roomimages' => $this->roomimages
                ->select('rooms.RoomID, rooms.RoomNumber, rooms.RoomType, rooms.Description, rooms.PricePerNight, rooms.minPerson, rooms.maxPerson,  rooms.Image, GROUP_CONCAT(room_images.Image) AS Images')
                ->join('rooms', 'room_images.RoomID = rooms.RoomID')
                ->groupBy('rooms.RoomID')
                ->findAll(),
            'chats' => $this->chat->findAll(),
        ];
        return view('Hotell/room', $data);
    }
    public function roomPolicy()
    {
        $data = [
            'activePage' => 'roomPolicy',
            'chats' => $this->chat->findAll()
        ];
        return view('Hotell/roompolicy', $data);
    }
    public function restaurantPolicy()
    {
        $data = [
            'activePage' => 'resPolicy',
            'chats' => $this->chat->findAll()
        ];
        return view('Hotell/restaurantpolicy', $data);
    }
    public function restaurantt()
    {
        $data = [
            'activePage' => 'Restaurant',
            'chats' => $this->chat->findAll(),

        ];
        return view('Hotell/restaurant', $data);
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
        return view('Hotell/mainmenu', $data);
    }
    public function barmenu()
    {
        $data = [
            'activePage' => 'Bar Menu',
            'chats' => $this->chat->findAll(),
            'venues' => $this->venues->select('restaurant_venue.VenueID,restaurant_venue.VenueName,restaurant_venue.VenueCapacity,restaurant_venue.AvailableCapacity,restaurant_venue.Image ')->findAll(),
            'menubars' => $this->products
                ->select('menu_product.ProductID, menu_product.ProductName, menu_product.ProductPrice, menu_product.Image, menu_product.MenuID, menu_product.CategoryID, menu_category.CategoryID, menu_category.CategoryName, menu.MenuID, menu.MenuType')
                ->join('menu_category', 'menu_product.CategoryID = menu_category.CategoryID')
                ->join('menu', 'menu_product.MenuID = menu.MenuID')
                ->whereIn('menu_category.CategoryID', range(12, 21))
                ->where('menu.MenuType', 'Bar Menu')
                ->findAll(),

        ];
        return view('Hotell/barmenu', $data);
    }
    public function cafemenu()
    {
        $data = [
            'activePage' => 'Cafe Menu',
            'chats' => $this->chat->findAll(),
            'venues' => $this->venues->select('restaurant_venue.VenueID,restaurant_venue.VenueName,restaurant_venue.VenueCapacity,restaurant_venue.AvailableCapacity,restaurant_venue.Image ')->findAll(),
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
        return view('Hotell/cafemenu', $data);
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
        $roomModel = new RoomModel();
        $availableRooms = $roomModel->findAvailableRooms($checkInDate, $checkOutDate, $numberOfAdults, $numberOfChildren);
        return view('Hotell/bookroom', [
            'reservationData' => $reservationData,
            'availableRooms' => $availableRooms,
            'roomimages' => $this->roomimages
                ->select('rooms.RoomID, rooms.RoomNumber, rooms.RoomType, rooms.Description, rooms.PricePerNight, rooms.minPerson, rooms.maxPerson,  rooms.Image, GROUP_CONCAT(room_images.Image) AS Images')
                ->join('rooms', 'room_images.RoomID = rooms.RoomID')
                ->groupBy('rooms.RoomID')
                ->findAll(),
            'rooms' => $this->rooms->findAll(),
        ]);
    }
    public function getdataRoom()
    {
        $session = \Config\Services::session();
        $selectedRoomID = $this->request->getGet('selectedRoomID');
        $checkInFieldName = 'CheckInDate' . $selectedRoomID;
        $checkOutFieldName = 'CheckOutDate' . $selectedRoomID;
        $checkInDate = $this->request->getGet($checkInFieldName);
        $checkOutDate = $this->request->getGet($checkOutFieldName);
        $reservationData = $session->get('reservationData');
        $numberOfAdults = $reservationData['Adult'] ?? 0;
        $numberOfChildren = $reservationData['Child'] ?? 0;
        $addAdult = $this->request->getGet('addAdult');
        $addChild = $this->request->getGet('addChild');
        $addAdult = max(0, (int) $addAdult);
        $addChild = max(0, (int) $addChild);
        $numberOfAdults += $addAdult;
        $numberOfChildren += $addChild;
        $roomModel = new RoomModel;
        $availableRooms = $roomModel->findAvailableRooms($checkInDate, $checkOutDate, $numberOfAdults, $numberOfChildren);
        $roomSelected = null;
        $TotalAmount = 0;
        if (!empty($selectedRoomID)) {
            $roomSelected = $roomModel->find($selectedRoomID);
            if (!empty($roomSelected) && $roomSelected['AvailabilityStatus'] === 'Available') {
                if (!empty($checkInDate) && !empty($checkOutDate)) {
                    $checkInDateTime = new \DateTime($checkInDate);
                    $checkOutDateTime = new \DateTime($checkOutDate);
                    $numberOfNights = $checkInDateTime->diff($checkOutDateTime)->days;
                    if ($roomSelected['PerNightHead'] === 'Head') {
                        $totalGuests = $numberOfAdults + $numberOfChildren;
                        $TotalAmount = $totalGuests * $roomSelected['PricePerNight'] * $numberOfNights;
                    } else {
                        $TotalAmount = $numberOfNights * $roomSelected['PricePerNight'];
                    }
                    $additionalAmount = ($addAdult + $addChild) * 500;
                    $TotalAmount += $additionalAmount;
                    $totalGuests = (int) $numberOfAdults + (int) $numberOfChildren;
                }
                $addAdult = $this->request->getGet('addAdult' . $selectedRoomID);
                $addChild = $this->request->getGet('addChild' . $selectedRoomID);
                $numberOfAdults += (int)$addAdult;
                $numberOfChildren += (int)$addChild;
                $extraGuestAmount = ($addAdult + $addChild) * 500;
                $TotalAmount += $extraGuestAmount;
                $session->set('roomSelected', $roomSelected);
                $session->set('reservationData', [
                    'CheckInDate' => $checkInDate,
                    'CheckOutDate' => $checkOutDate,
                    'Adult' => $numberOfAdults,
                    'Child' => $numberOfChildren,
                    'TotalAmount' => $TotalAmount
                ]);
            }
        }
        return view('Hotell/bookroom', [
            'reservationData' => $session->get('reservationData'),
            'availableRooms' => $availableRooms,
            'roomSelected' => $roomSelected,
            'TotalAmount' => $TotalAmount,
            'roomimages' => $this->roomimages
                ->select('rooms.RoomID, rooms.RoomNumber, rooms.RoomType, rooms.Description, rooms.PricePerNight, rooms.minPerson, rooms.maxPerson,  rooms.Image, GROUP_CONCAT(room_images.Image) AS Images')
                ->join('rooms', 'room_images.RoomID = rooms.RoomID')
                ->groupBy('rooms.RoomID')
                ->findAll(),
            'rooms' => $this->rooms->findAll(),
        ]);
    }
    public function getdataRoomReservation()
    {
        $session = \Config\Services::session();
        $reservationData = $session->get('reservationData');
        $roomSelected = $session->get('roomSelected');
        if (!empty($reservationData) && !empty($roomSelected)) {
            $checkInDate = new \DateTime($reservationData['CheckInDate']);
            $checkOutDate = new \DateTime($reservationData['CheckOutDate']);
            $numberOfNights = $checkInDate->diff($checkOutDate)->days;
            $TotalAmount = 0;
            if ($roomSelected['PerNightHead'] === 'Head') {
                $numberOfAdults = (int) $reservationData['Adult'];
                $numberOfChildren = (int) $reservationData['Child'];
                $totalGuests = $numberOfAdults + $numberOfChildren;
                $TotalAmount = $totalGuests * $roomSelected['PricePerNight'] * $numberOfNights;
            } else {
                $TotalAmount = $numberOfNights * $roomSelected['PricePerNight'];
            }
            $addAdult = $this->request->getGet('addAdult');
            $addChild = $this->request->getGet('addChild');
            $addAdult = max(0, (int) $addAdult);
            $addChild = max(0, (int) $addChild);
            $extraGuestAmount = ($addAdult + $addChild) * 500;
            $TotalAmount += $extraGuestAmount;
            $numberOfAdults = (int) $reservationData['Adult'];
            $numberOfChildren = (int) $reservationData['Child'];
            $totalGuests = $numberOfAdults + $numberOfChildren;
            if ($totalGuests > $roomSelected['maxPerson']) {
                $additionalGuests = $totalGuests - $roomSelected['maxPerson'];
                $TotalAmount += $additionalGuests * 500;
            }
            $session->set('roomReservationData', [
                'reservationData' => $reservationData,
                'roomSelected' => $roomSelected,
                'TotalAmount' => $TotalAmount,
            ]);
            return redirect()->to(base_url('/bookroom/amenities'));
        } else {
            return redirect()->to(base_url('/error'));
        }
    }

    public function bookroom()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        $session = \Config\Services::session();
        $reservationData = $session->get('reservationData');
        $roomSelected = $session->get('roomSelected');
        $TotalAmount = 0;
        $selectedRoomID = $this->request->getGet('selectedRoomID');
        if (!empty($selectedRoomID)) {
            $roomSelected = $this->rooms->find($selectedRoomID);
            if (!empty($roomSelected) && isset($roomSelected['AvailabilityStatus']) && $roomSelected['AvailabilityStatus'] === 'Available') {
                $checkInDate = new \DateTime($reservationData['CheckInDate']);
                $checkOutDate = new \DateTime($reservationData['CheckOutDate']);
                $numberOfNights = $checkInDate->diff($checkOutDate)->days;
                $TotalAmount = $numberOfNights * $roomSelected['PricePerNight'];
                $numberOfAdults = (int) $reservationData['Adult'];
                $numberOfChildren = (int) $reservationData['Child'];
                $totalGuests = $numberOfAdults + $numberOfChildren;
                $session->set('roomSelected', $roomSelected);
            }
        }
        $data = [
            'activePage' => 'Reservation',
            'rooms' => $this->rooms->findAll(),
            'roomimages' => $this->roomimages
                ->select('rooms.RoomID, rooms.RoomNumber, rooms.RoomType, rooms.Description, rooms.PricePerNight, rooms.minPerson, rooms.maxPerson,  rooms.Image, GROUP_CONCAT(room_images.Image) AS Images')
                ->join('rooms', 'room_images.RoomID = rooms.RoomID')
                ->groupBy('rooms.RoomID')
                ->findAll(),
            'reservationData' => $reservationData,
            'roomSelected' => $roomSelected,
            'TotalAmount' => $TotalAmount,
        ];
        return view('Hotell/bookroom', $data);
    }
    public function amenities()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        $session = \Config\Services::session();
        $roomReservationData = $session->get('roomReservationData');
        $downPaymentAmount = $roomReservationData['TotalAmount'] * 0.5;
        $fullPaymentAmount = $roomReservationData['TotalAmount'];
        $roomReservationData['DownpaymentAmount'] = $downPaymentAmount;
        $roomReservationData['FullpaymentAmount'] = $fullPaymentAmount;
        $data = [
            'activePage' => 'Reservation',
            'roinvents' => $this->roominventory->findAll(),
            'qrcodes' => $this->qr->findAll(),
            'roomReservationData' => $roomReservationData,
        ];
        return view('Hotell/amenities', $data);
    }
    public function addAmenities()
    {
        $session = \Config\Services::session();
        $roomInventoryIDs = (array) $this->request->getPost('roomInventoryID');
        $insertQuantities = $this->request->getPost('insertQuantity');
        $roinvents = $this->request->getPost('roinvents');
        $skipAmenities = $this->request->getPost('skip'); // Handle Skip via button click
    
        // Handle "Skip" functionality
        if ($skipAmenities) {
            // Clear any existing amenities data
            $session->remove('amenitiesData');
            
            // Redirect to form details without adding amenities
            return redirect()->to(base_url('/bookroom/formdetails'));
        }
    
        // Proceed if not skipping amenities
        $amenitiesData = [];
    
        if (!empty($roomInventoryIDs)) {
            foreach ($roomInventoryIDs as $index => $roomInventoryID) {
                if (isset($roinvents[$roomInventoryID]) && is_array($roinvents[$roomInventoryID])) {
                    $productName = isset($roinvents[$roomInventoryID]['ProductName']) ? $roinvents[$roomInventoryID]['ProductName'] : 'Unknown Product';
                    $price = isset($roinvents[$roomInventoryID]['Price']) ? $roinvents[$roomInventoryID]['Price'] : 'Unknown Price';
                    $insertQuantity = isset($insertQuantities[$roomInventoryID]) ? $insertQuantities[$roomInventoryID] : 0;
                    $amenitiesData[] = [
                        'roomInventoryID' => $roomInventoryID,
                        'ProductName' => $productName,
                        'Price' => $price,
                        'insertQuantity' => $insertQuantity,
                    ];
                }
            }
    
            // Store amenities in session
            $session->set('amenitiesData', $amenitiesData);
    
            // Calculate total extra price
            $totalExtraPrice = 0;
            if (!empty($amenitiesData)) {
                foreach ($amenitiesData as $amenity) {
                    $totalExtraPrice += $amenity['Price'] * $amenity['insertQuantity'];
                }
            }
    
            // Update total amount in reservation data
            $roomReservationData = $session->get('roomReservationData');
            $roomReservationData['TotalAmount'] += $totalExtraPrice;
            $session->set('roomReservationData', $roomReservationData);
            return redirect()->to(base_url('/bookroom/formdetails'));
        } else {
            return redirect()->to(base_url('/bookroom/amenities'))->with('error', 'Please select at least one amenity.');
        }
    }
    public function formdetails()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        $session = \Config\Services::session();
        $userID = $session->get('userID');
        $amenitiesData = $session->get('amenitiesData');
        $roomReservationData = $session->get('roomReservationData');
        $totalExtraPrice = 0;
    
        // No need to add extra price to TotalAmount here again, it's already done in addAmenities.
        if (isset($amenitiesData) && !empty($amenitiesData)) {
            foreach ($amenitiesData as &$amenity) {
                $amenity['UserID'] = $userID;
                $totalExtraPrice += $amenity['Price'] * $amenity['insertQuantity'];
            }
        }
    
        // The TotalAmount was already updated in the addAmenities function.
        // Here, we just prepare the down payment and full payment amounts based on TotalAmount.
        $downPaymentAmount = $roomReservationData['TotalAmount'] * 0.5;
        $fullPaymentAmount = $roomReservationData['TotalAmount'];
        $roomReservationData['DownpaymentAmount'] = $downPaymentAmount;
        $roomReservationData['FullpaymentAmount'] = $fullPaymentAmount;
    
        // Update the session with the new reservation data
        $session->set('roomReservationData', $roomReservationData);
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
        return view('Hotell/checkOutReservation', $data);
    }
    public function addReservation()
    {
        helper(['form']);
        $session = session();
        $FirstName = $this->request->getPost('FirstName');
        $LastName = $this->request->getPost('LastName');
        $ContactNumber = $this->request->getPost('ContactNumber');
        $Address = $this->request->getPost('Address');
        $email = $session->get('username');
        $user = $this->users->where('FirstName', $FirstName)
            ->where('LastName', $LastName)
            ->where('ContactNumber', $ContactNumber)
            ->first();
        $roomSelected = $session->get('roomSelected');
        $reservationData = $session->get('reservationData');
        $amenitiesData = $session->get('amenitiesData');
        $totalExtraPrice = $session->get('totalExtraPrice');
        $roomReservationData = $session->get('roomReservationData');
        $TotalAmount = $roomReservationData['TotalAmount'] + $totalExtraPrice;
        $skipAmenities = $this->request->getGet('skip') === 'true';
        if ($roomSelected && $reservationData && $user && $TotalAmount) {
            $paymentOption = $this->request->getPost('PaymentOption');
            $referenceNumber = ($paymentOption == 'gcash') ? $this->request->getPost('ReferenceNumberGcash') : $this->request->getPost('ReferenceNumberPaymaya');
            if ($image = $this->request->getFile('Image')) {
                $newFileName = $image->getRandomName();
                if ($image->isValid() && !$image->hasMoved()) {
                    $image->move(FCPATH . 'proof/', $newFileName);
                    $checkInTime = '14:00:00'; // 2:00 PM
                    $checkOutTime = '12:00:00'; // 12:00 PM
                    $checkInDateTime = $reservationData['CheckInDate'] . ' ' . $checkInTime;
                    $checkOutDateTime = $reservationData['CheckOutDate'] . ' ' . $checkOutTime;
                    $emailSendDate = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($checkInDateTime)));
                    $newReservationData = [
                        'CheckInDate' => $checkInDateTime,
                        'CheckOutDate' => $checkOutDateTime,
                        'Adult' => $reservationData['Adult'],
                        'Child' => $reservationData['Child'],
                        'downorfullPayment' => $this->request->getPost('downorfullPayment'),
                        'ReferenceNumber' => $referenceNumber,
                        'PaymentOption' => $paymentOption,
                        'Status' => 'Confirm',
                        'RoomID' => $roomSelected['RoomID'],
                        'UserID' => $user['UserID'],
                        'TotalAmount' => $TotalAmount,
                        'Image' => $newFileName,
                        'email_send_date' => $emailSendDate, // Add email send date
                        'email_sent' => 0 // Initial email sent status
                    ];
                    $inserted = $this->reservation->insert($newReservationData);
                    $reservationID = $this->reservation->getInsertID();
                    if ($inserted) {
                        if (!$skipAmenities && $amenitiesData) {
                            $amenitiesWithUserID = [];
                            foreach ($amenitiesData as $amenity) {
                                $amenity['UserID'] = $user['UserID'];
                                $amenitiesWithUserID[] = $amenity;
                            }
                            foreach ($amenitiesWithUserID as $amenity) {
                                $amenityData = [
                                    'ReservationID' => $reservationID,
                                    'roomInventoryID' => $amenity['roomInventoryID'],
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
                        }else {
                            // Skip amenities, set roomInventoryID and insertQuantity to NULL
                            $amenityData = [
                                'ReservationID' => $reservationID,
                                'roomInventoryID' => null,
                                'insertQuantity' => null,
                                'UserID' => $user['UserID'],
                            ];
                            $this->reservationamenities->insert($amenityData);
                        }
                        $qrCodeInfo = $this->generateQrCode($reservationID, $amenitiesData);
                        $qrCodePath = $qrCodeInfo['file_path'];
                        $qrCodePath2 = $qrCodeInfo['url'];
                        $session->set('qrCodePath', $qrCodePath2);
                        $this->reservation->update($reservationID, ['QRCodePath' => $qrCodePath]);
                        $emailMessage = $this->prepareEmailMessage($newReservationData, $roomSelected, $user, $amenitiesData);
                        $this->sendEmail($email, 'Your Reservation Confirmation', $emailMessage, $qrCodePath);
                        $jobModel = new JobModel();
                        $jobModel->insert([
                            'type' => SendReminderEmail::class,
                            'payload' => json_encode([
                                'to' => $email,
                                'subject' => 'Reservation Reminder',
                                'message' => $this->prepareReminderMessage($newReservationData, $roomSelected, $user, $amenitiesData),
                                'attachmentPath' => null
                            ]),
                            'run_at' => $emailSendDate
                        ]);
                        $fcmToken = $user['fcm_token'];
                        if (!empty($fcmToken)) {
                            $notifTitle = 'Reservation Confirmation';
                            $notifBody = 'Your reservation has been successfully added.';
                            $this->sendPushNotification($fcmToken, $notifTitle, $notifBody);
                        }
                        $session->setFlashdata('success', 'Reservation added successfully and confirmation email sent.');
                        return redirect()->to('/qrpath');
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
    }

    private function generateQrCode($reservationID, $amenitiesData)
    {
        $amenitiesQueryParam = !is_null($amenitiesData) ? http_build_query(['amenities' => $amenitiesData]) : '';
        $encodedUrl = base_url("reservation/$reservationID") . ($amenitiesQueryParam ? "?$amenitiesQueryParam" : '');
        $qrCode = new \Endroid\QrCode\QrCode($encodedUrl);
        $qrCode->setSize(300);
        $writer = new \Endroid\QrCode\Writer\PngWriter();
        $dirPath = FCPATH . 'qr-codes';
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0777, true); // Adjust permissions as necessary
        }
        $filePath = $dirPath . '/qr-code-' . $reservationID . '.png';
        $result = $writer->write($qrCode);
        $result->saveToFile($filePath);
        $url = base_url('qr-codes/qr-code-' . $reservationID . '.png');
        return [
            'url' => $url,
            'file_path' => $filePath
        ];
    }
    public function qrPath()
    {
        $session = session();
        $qrCodePath = $session->get('qrCodePath');
        if (!$qrCodePath) {
            return redirect()->back()->with('error', 'QR code not found.');
        }
        return view('Hotell/qrpath', ['qrCodePath' => $qrCodePath]);
    }
    private function prepareEmailMessage(array $reservationData, array $roomSelected, array $user, ?array $amenitiesData): string
    {
        $checkInDate = $reservationData['CheckInDate'];
        $checkOutDate = $reservationData['CheckOutDate'];
        $adults = $reservationData['Adult'];
        $children = $reservationData['Child'];
        $image = $reservationData['Image'];
        $downorfullPayment = $reservationData['downorfullPayment'];
        $paymentOption = $reservationData['PaymentOption'];
        $referenceNumber = $reservationData['ReferenceNumber'];
        $totalAmount = $reservationData['TotalAmount'];
        $roomNumber = $roomSelected['RoomNumber'];
        $roomType = $roomSelected['RoomType'];
        $firstName = $user['FirstName'];
        $lastName = $user['LastName'];
        $amenitiesMessage = "";
        if (!empty($amenitiesData)) {
            $amenitiesMessage .= "Selected Amenities:<br>";
            foreach ($amenitiesData as $amenity) {
                $amenitiesMessage .= "- {$amenity['ProductName']} ({$amenity['insertQuantity']})<br>";
            }
        }
        $message = "Dear {$firstName} {$lastName},<br><br>";
        $message .= "Your reservation has been successfully made with the following details:<br>";
        $message .= "Room: {$roomNumber} ({$roomType})<br>";
        $message .= "Check-in Date: {$checkInDate}<br>";
        $message .= "Check-out Date: {$checkOutDate}<br>";
        $message .= "Number of Adults: {$adults}<br>";
        $message .= "Number of Children: {$children}<br>";
        $message .= "Payment Option: {$paymentOption}<br>";
        $message .= "Down or Full Payment: {$downorfullPayment}<br>";
        $message .= "Reference Number: {$referenceNumber}<br>";
        $message .= "Rate Amount: {$totalAmount}<br>";
        $message .= $amenitiesMessage; // Add amenities information
        $message .= "Proof of Payment: <a href='" . base_url('/proof/' . $image) . "'>" . $image . "</a><br>";
        $message .= "<br>We look forward to hosting you.<br>";
        $message .= "<br>Below is your qr code. Please download and show this when entering our business.<br>";

        return $message;
    }
    private function prepareReminderMessage(array $reservationData, array $roomSelected, array $user, ?array $amenitiesData): string
    {
        $checkInDate = $reservationData['CheckInDate'];
        $checkOutDate = $reservationData['CheckOutDate'];
        $adults = $reservationData['Adult'];
        $children = $reservationData['Child'];
        $image = $reservationData['Image'];
        $downorfullPayment = $reservationData['downorfullPayment'];
        $paymentOption = $reservationData['PaymentOption'];
        $referenceNumber = $reservationData['ReferenceNumber'];
        $totalAmount = $reservationData['TotalAmount'];
        $roomNumber = $roomSelected['RoomNumber'];
        $roomType = $roomSelected['RoomType'];
        $firstName = $user['FirstName'];
        $lastName = $user['LastName'];
        $amenitiesMessage = "";
        if (!empty($amenitiesData)) {
            $amenitiesMessage .= "Selected Amenities:<br>";
            foreach ($amenitiesData as $amenity) {
                $amenitiesMessage .= "- {$amenity['ProductName']} ({$amenity['insertQuantity']})<br>";
            }
        }
        $message = "Dear {$firstName} {$lastName},<br><br>";
        $message .= "This is a reminder for your reservation tomorrow made with the following details:<br>";
        $message .= "Room: {$roomNumber} ({$roomType})<br>";
        $message .= "Check-in Date: {$checkInDate}<br>";
        $message .= "Check-out Date: {$checkOutDate}<br>";
        $message .= "Number of Adults: {$adults}<br>";
        $message .= "Number of Children: {$children}<br>";
        $message .= "Payment Option: {$paymentOption}<br>";
        $message .= "Down or Full Payment: {$downorfullPayment}<br>";
        $message .= "Reference Number: {$referenceNumber}<br>";
        $message .= "Rate Amount: {$totalAmount}<br>";
        $message .= $amenitiesMessage; // Add amenities information
        $message .= "Proof of Payment: <a href='" . base_url('/proof/' . $image) . "'>" . $image . "</a><br>";
        $message .= "<br>We look forward to hosting you.<br>";
        $message .= "<br>Below is your qr code. Please download and show this when entering our business.<br>";

        return $message;
    }
    protected function sendPushNotification($fcmToken, $title, $body)
    {
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
            'CheckInDate' => 'required',
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
                $checkInDateTime = $this->request->getPost('CheckInDate');
                $emailSendDate = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($checkInDateTime)));
                $restaurantReservation = [
                    'NumberOfGuests' => $numberOfGuests,
                    'CheckInDate' => $checkInDateTime,
                    'Note' => $this->request->getPost('Note'),
                    'Status' => 'Confirm',
                    'VenueName' => $VenueName,
                    'VenueID' => $restaurantVenue['VenueID'],
                    'UserID' => $user['UserID'],
                    'email_send_date' => $emailSendDate, // Add email send date
                    'email_sent' => 0 // Initial email sent status
                ];
                $inserted = $this->reservation->insert($restaurantReservation);
                if ($inserted) {
                    $reservationID = $this->reservation->getInsertID();
                            $qrCodeInfo  = $this->generateeeQrCode($reservationID);
                            $qrCodePath = $qrCodeInfo['file_path'];
                            $qrCodePath2 = $qrCodeInfo['url'];
                            $session->set('qrCodePath', $qrCodePath2);
                            $this->reservation->update($reservationID, ['QRCodePath' => $qrCodePath]);
                    $emailMessage = $this->prepareEmail($restaurantReservation);
                    $this->sendEmail($email, 'Your Reservation Confirmation', $emailMessage);
                    $jobModel = new JobModel();
                        $jobModel->insert([
                            'type' => SendReminderEmail::class,
                            'payload' => json_encode([
                                'to' => $email,
                                'subject' => 'Reservation Reminder',
                                'message' => $this->prepareEmailReminder($restaurantReservation),
                                'attachmentPath' => null
                            ]),
                            'run_at' => $emailSendDate
                        ]);
                    $fcmToken = $user['fcm_token'];
                    if (!empty($fcmToken)) {
                        $notifTitle = 'Reservation Confirmation';
                        $notifBody = 'Your reservation has been successfully added.';
                        $this->sendPushNotification($fcmToken, $notifTitle, $notifBody);
                    }
                    $session->setFlashdata('success', 'Reservation added successfully and email sent.');
                    return redirect()->to('/qrrestaurantpath');
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
    private function generateeeQrCode($reservationID)
    {
        $encodedUrl = base_url("resreservation/$reservationID");
        $qrCode = new \Endroid\QrCode\QrCode($encodedUrl);
        $qrCode->setSize(300);
        $writer = new \Endroid\QrCode\Writer\PngWriter();
        $dirPath = FCPATH . 'qr-codes';
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0777, true); 
        }
        $filePath = $dirPath . '/qr-code-' . $reservationID . '.png';
        $result = $writer->write($qrCode);
        $result->saveToFile($filePath);
        $url = base_url('qr-codes/qr-code-' . $reservationID . '.png');
        return [
            'url' => $url,
            'file_path' => $filePath
        ];
    }
    public function qrrestaurantPath()
    {
        $session = session();
        $qrCodePath = $session->get('qrCodePath');
        if (!$qrCodePath) {
            return redirect()->back()->with('error', 'QR code not found.');
        }
        return view('Hotell/qrpath_restaurant', ['qrCodePath' => $qrCodePath]);
    }
    private function prepareEmail(array $reservationDataa): string // Corrected method name
    {
        $CheckInDate = $reservationDataa['CheckInDate'];
        $NumberOfGuests = $reservationDataa['NumberOfGuests'];
        $Note = $reservationDataa['Note'];
        $VenueName = $reservationDataa['VenueName'];
        $message = "Dear customer,<br><br>";
        $message .= "Your reservation has been successfully made with the following details:<br>";
        $message .= "Venue Name: {$VenueName}<br>";
        $message .= "Arrival Date and Time: {$CheckInDate}<br>";
        $message .= "Number of Guests: {$NumberOfGuests}<br>";
        $message .= "Note: {$Note}<br>";
        $message .= "<br>We look forward to hosting you.<br>";
        return $message;
    }
    private function prepareEmailReminder(array $reservationDataa): string // Corrected method name
    {
        $CheckInDate = $reservationDataa['CheckInDate'];
        $NumberOfGuests = $reservationDataa['NumberOfGuests'];
        $Note = $reservationDataa['Note'];
        $VenueName = $reservationDataa['VenueName'];
        $message = "Dear customer,<br><br>";
        $message .= "This is a reminder for your reservation tomorrow made with the following details:<br>";
        $message .= "Venue Name: {$VenueName}<br>";
        $message .= "Arrival Date and Time: {$CheckInDate}<br>";
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
        return view('Hotell/convention', $data);
    }
    public function conPackage()
    {
        $data = [
            'activePage' => 'conPackage',
            'chats' => $this->chat->findAll()
        ];
        return view('Hotell/conpackage', $data);
    }
    public function getconvenuedirectInformation()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        $session = \Config\Services::session();
        $selectedconVenueID = $this->request->getPost('selectedconVenueID');
        $convenuesSelected = null;
        $eventTypes = [];
        if (!empty($selectedconVenueID)) {
            $convenuesSelected = $this->convenues->find($selectedconVenueID);
            $session->set('convenuesSelected', $convenuesSelected);
            if (!empty($convenuesSelected['conVenueName'])) {
                switch ($convenuesSelected['conVenueName']) {
                    case 'CBRC Hall':
                        $eventTypes = ['Wedding', 'Seminar', 'Christening', 'Birthday', 'Anniversary'];
                        break;
                    case 'Tamaraw':
                        $eventTypes = ['Birthday', 'Seminar'];
                        break;
                    case 'Octagon':
                        $eventTypes = ['Wedding', 'Seminar', 'Christening', 'Birthday', 'Anniversary'];
                        break;
                    default:
                        $eventTypes = [];
                        break;
                }
            }
        }
        $reservationModel = new ReservationModel();
        $conVenueID = $this->request->getPost('selectedconVenueID'); // Get selected convention venue ID
        $reservationsQuery = $reservationModel->table('reservations')
            ->select('DATE_FORMAT(CheckInDate, "%Y-%m-%d") as StartDate, DATE_FORMAT(CheckOutDate, "%Y-%m-%d") as EndDate, Status, convention.conventionID, convention.conVenueID')
            ->join('convention', 'reservations.conventionID = convention.conventionID')
            ->where('convention.conVenueID', $conVenueID)
            ->get();
        $reservations = $reservationsQuery->getResultArray();
        $unavailableDates = [];
        foreach ($reservations as $reservation) {
            $startDate = new \DateTime($reservation['StartDate']);
            $endDate = new \DateTime($reservation['EndDate']);
            $endDate->modify('+1 day');
            $interval = new \DateInterval('P1D');
            $period = new \DatePeriod($startDate, $interval, $endDate);
            if ($reservation['Status'] === 'Cancel') {
                continue;
            }
            foreach ($period as $date) {
                $unavailableDates[] = $date->format('Y-m-d');
            }
        }
        return view('Hotell/coninformation', [
            'convenuesSelected' => $convenuesSelected,
            'eventTypes' => $eventTypes,
            'unavailableDates' => $unavailableDates,
        ]);
    }
    public function conReservation()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
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
        return view('Hotell/conreservation', $data);
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
        $TotalAmount = $NumberOfGuests * 999;
        $session->set('TotalAmount', $TotalAmount); 
        return redirect()->to(base_url('/convention-center/reservation/formdetails'));
    }
    public function conventioninformation()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        $session = \Config\Services::session();
        $convenuesSelected = $session->get('convenuesSelected');
        $ReservationData = $session->get('ReservationData');
        $EventData = $session->get('EventData');
        $UserData = $session->get('UserData');
        $TotalAmount = $session->get('TotalAmount');
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
        return view('Hotell/coninformation', $data);
    }
    public function conventionformdetails()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        $session = \Config\Services::session();
        $ReservationData = $session->get('ReservationData');
        $convenuesSelected = $session->get('convenuesSelected');
        $EventData = $session->get('EventData');
        $UserData = $session->get('UserData');
        $TotalAmount = $session->get('TotalAmount');
        $DownPaymentAmount = $TotalAmount * 0.5;
        $FullPaymentAmount = $TotalAmount;
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
        return view('Hotell/conformdetail', $data);
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
            $email = $session->get('username');
            if ($EventData && $ReservationData && $UserData && $TotalAmount && $convenuesSelected) {
                if ($image = $this->request->getFile('Image')) {
                    $newFileName = $image->getRandomName();
                    if ($image->isValid() && !$image->hasMoved()) {
                        $image->move(FCPATH . 'proof/', $newFileName);
                        $eventID = $EventData['EventID'] ?? null;
                        $conVenueID = $convenuesSelected['conVenueID'] ?? null;
                        $conventionData = [
                            'EventID' => $eventID,
                            'conVenueID' => $conVenueID,
                        ];
                        $conventionID = $this->conventions->insert($conventionData);
                        $checkInDateTime = $ReservationData['CheckInDate'];
                        $emailSendDate = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($checkInDateTime)));
                        $newReservationData = [
                            'UserID' => $UserData['UserID'],
                            'conventionID' => $conventionID,
                            'CheckInDate' => $ReservationData['CheckInDate'],
                            'CheckOutDate' => $ReservationData['CheckOutDate'],
                            'NumberOfGuests' => $ReservationData['NumberOfGuests'],
                            'downorfullPayment' => $this->request->getPost('downorfullPayment'),
                            'ReferenceNumber' => $referenceNumber,
                            'PaymentOption' => $paymentOption,
                            'Status' => 'Confirm',
                            'TotalAmount' => $TotalAmount,
                            'Image' => $newFileName,
                            'email_send_date' => $emailSendDate, // Add email send date
                            'email_sent' => 0 // Initial email sent status
                        ];
                        $inserted = $this->reservation->insert($newReservationData);
                        if ($inserted) {
                            $reservationID = $this->reservation->getInsertID();
                            $qrCodeInfo  = $this->generateeQrCode($reservationID);
                            $qrCodePath = $qrCodeInfo['file_path'];
                            $qrCodePath2 = $qrCodeInfo['url'];
                            $session->set('qrCodePath', $qrCodePath2);
                            $this->reservation->update($reservationID, ['QRCodePath' => $qrCodePath]);
                            $emailMessage = $this->prepareEmailConventionMessage($UserData, $newReservationData, $EventData, $convenuesSelected);
                            $emailMessage2 = $this->sendEmail($email, 'Your Reservation Confirmation', $emailMessage);
                            $jobModel = new JobModel();
                        $jobModel->insert([
                            'type' => SendReminderEmail::class,
                            'payload' => json_encode([
                                'to' => $email,
                                'subject' => 'Reservation Reminder',
                                'message' => $this->prepareReminderConventionMessage($UserData, $newReservationData, $EventData, $convenuesSelected),
                                'attachmentPath' => null
                            ]),
                            'run_at' => $emailSendDate
                        ]);
                            $fcmToken = $UserData['fcm_token'];
                            if (!empty($fcmToken)) {
                                $notifTitle = 'Reservation Confirmation';
                                $notifBody = 'Your reservation has been successfully added.';
                                $this->sendPushNotification($fcmToken, $notifTitle, $notifBody);
                            }
                            $session->setFlashdata('success', 'Reservation added successfully and email sent.');
                            return redirect()->to('/qrcoventionpath');
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
            $newReservationData['validation'] = $this->validator;
            $newReservationData = ['qrcodes' => $this->qr->findAll()];
            return view('Hotell/conformdetail', $newReservationData);
        }
    }
    private function generateeQrCode($reservationID)
    {
        $encodedUrl = base_url("conreservation/$reservationID");
        $qrCode = new \Endroid\QrCode\QrCode($encodedUrl);
        $qrCode->setSize(300);
        $writer = new \Endroid\QrCode\Writer\PngWriter();
        $dirPath = FCPATH . 'qr-codes';
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0777, true); 
        }
        $filePath = $dirPath . '/qr-code-' . $reservationID . '.png';
        $result = $writer->write($qrCode);
        $result->saveToFile($filePath);
        $url = base_url('qr-codes/qr-code-' . $reservationID . '.png');
        return [
            'url' => $url,
            'file_path' => $filePath
        ];
    }
    public function qrconventionPath()
    {
        $session = session();
        $qrCodePath = $session->get('qrCodePath');
        if (!$qrCodePath) {
            return redirect()->back()->with('error', 'QR code not found.');
        }
        return view('Hotell/qrpath_convention', ['qrCodePath' => $qrCodePath]);
    }
    private function prepareEmailConventionMessage(array $userData, array $reservationData, array $eventData, array $convenuesSelected): string
    {
        $numberofGuests = $reservationData['NumberOfGuests'] ?? '';
        $checkInDate = $reservationData['CheckInDate'] ?? '';
        $checkOutDate = $reservationData['CheckOutDate'] ?? '';
        $downorfullPayment = $reservationData['downorfullPayment'] ?? '';
        $referenceNumber = $reservationData['ReferenceNumber'] ?? '';
        $paymentOption = $reservationData['PaymentOption'] ?? '';
        $totalAmount = $reservationData['TotalAmount'] ?? '';
        $image = $reservationData['Image'] ?? '';
        $firstName = $userData['FirstName'] ?? '';
        $lastName = $userData['LastName'] ?? '';
        $contactNumber = $userData['ContactNumber'] ?? '';
        $eventType = $eventData['EventType'] ?? '';
        $conVenueName = $convenuesSelected['conVenueName'] ?? '';
        $message = "Dear {$firstName} {$lastName},<br><br>";
        $message .= "Your reservation has been successfully made with the following details:<br>";
        $message .= "Number of Guests: {$numberofGuests}<br>";
        $message .= "Check-In Date: {$checkInDate}<br>";
        $message .= "Check-Out Date: {$checkOutDate}<br>";
        $message .= "Payment Option: {$paymentOption}<br>";
        $message .= "Reference Number: {$referenceNumber}<br>";
        $message .= "Total Amount: {$totalAmount}<br>";
        $message .= "Down/Full Payment: {$downorfullPayment}<br>";
        $message .= "Event Type: {$eventType}<br>";
        $message .= "Contact Number: {$contactNumber}<br>";
        $message .= "Convention Venue: {$conVenueName}<br>";
        $message .= "Proof of Payment: <a href='" . base_url('/proof/' . $image) . "'>" . $image . "</a><br>";
        return $message;
    }
    private function prepareReminderConventionMessage(array $userData, array $reservationData, array $eventData, array $convenuesSelected): string
    {
        $numberofGuests = $reservationData['NumberOfGuests'] ?? '';
        $checkInDate = $reservationData['CheckInDate'] ?? '';
        $checkOutDate = $reservationData['CheckOutDate'] ?? '';
        $downorfullPayment = $reservationData['downorfullPayment'] ?? '';
        $referenceNumber = $reservationData['ReferenceNumber'] ?? '';
        $paymentOption = $reservationData['PaymentOption'] ?? '';
        $totalAmount = $reservationData['TotalAmount'] ?? '';
        $image = $reservationData['Image'] ?? '';
        $firstName = $userData['FirstName'] ?? '';
        $lastName = $userData['LastName'] ?? '';
        $contactNumber = $userData['ContactNumber'] ?? '';
        $eventType = $eventData['EventType'] ?? '';
        $conVenueName = $convenuesSelected['conVenueName'] ?? '';
        $message = "Dear {$firstName} {$lastName},<br><br>";
        $message .= "Your reservation has been successfully made with the following details:<br>";
        $message .= "Number of Guests: {$numberofGuests}<br>";
        $message .= "Check-In Date: {$checkInDate}<br>";
        $message .= "Check-Out Date: {$checkOutDate}<br>";
        $message .= "Payment Option: {$paymentOption}<br>";
        $message .= "Reference Number: {$referenceNumber}<br>";
        $message .= "Total Amount: {$totalAmount}<br>";
        $message .= "Down/Full Payment: {$downorfullPayment}<br>";
        $message .= "Event Type: {$eventType}<br>";
        $message .= "Contact Number: {$contactNumber}<br>";
        $message .= "Convention Venue: {$conVenueName}<br>";
        $message .= "Proof of Payment: <a href='" . base_url('/proof/' . $image) . "'>" . $image . "</a><br>";
        return $message;
    }
    public function contact()
    {
        return view('Hotel/contact');
    }
    public function getFeedback()
    {
        return view('Hotell/index');
    }
    public function submitReview()
    {
        $feedbackModel = new FeedbackModel();
        $Email = $this->request->getPost('Email');
        $userModel = new UserModel(); 
        $user = $userModel->where('Email', $Email)->first();
        $data = [
            'UserID'           => $user['UserID'], 
            'UserRating'       => $this->request->getPost('UserRating'),
            'FeedbackMessage'  => $this->request->getPost('FeedbackMessage'),
            'datetime'         => date('Y-m-d H:i:s') 
        ];
        try {
            $result = $feedbackModel->insert($data);
            if ($result === false) {
                return "Failed to submit review.";
            } else {
                return "Your Review & Rating Have Been Successfully Submitted";
            }
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return "An error occurred while submitting the review.";
        }
    }
    public function Review()
    {
        if ($this->request->getPost('action')) {
            $feedbackModel = new FeedbackModel();
            $reviews = $feedbackModel->orderBy('FeedbackID', 'DESC')->findAll();
            $averageRating = 0;
            $totalReview = 0;
            $fiveStarReview = 0;
            $fourStarReview = 0;
            $threeStarReview = 0;
            $twoStarReview = 0;
            $oneStarReview = 0;
            $totalUserRating = 0;
            $reviewContent = [];
            $userModel = new UserModel();
    
            // Updated bad keywords list
            $badKeywords = ['bad', 'terrible', 'awful', 'poor', 'disappointing', 'horrible', 'dreadful', 'abysmal', 'disgusting'];
    
            foreach ($reviews as $row) {
                $containsBadKeyword = false;
                foreach ($badKeywords as $keyword) {
                    if (stripos($row['FeedbackMessage'], $keyword) !== false) {
                        $containsBadKeyword = true;
                        break;
                    }
                }
                if ($containsBadKeyword) {
                    continue;
                }
                $user = $userModel->find($row['UserID']);
                if ($user && isset($user['FirstName']) && isset($user['LastName'])) {
                    $fullName = $user['FirstName'] . ' ' . $user['LastName'];  // Concatenate first and last names
                } else {
                    $fullName = "Unknown";
                }
                $reviewContent[] = [
                    'FullName' => $fullName,  // Updated to display full name
                    'FeedbackMessage' => $row['FeedbackMessage'],
                    'rating' => $row['UserRating'],
                    'datetime' => date('l jS, F Y H:i:s A', strtotime($row['datetime']))
                ];
                switch ($row['UserRating']) {
                    case 5:
                        $fiveStarReview++;
                        break;
                    case 4:
                        $fourStarReview++;
                        break;
                    case 3:
                        $threeStarReview++;
                        break;
                    case 2:
                        $twoStarReview++;
                        break;
                    case 1:
                        $oneStarReview++;
                        break;
                }
                $totalUserRating += $row['UserRating'];
                $totalReview++;
            }
            $averageRating = $totalReview > 0 ? $totalUserRating / $totalReview : 0;
            $output = [
                'average_rating' => number_format($averageRating, 1),
                'total_review' => $totalReview,
                'five_star_review' => $fiveStarReview,
                'four_star_review' => $fourStarReview,
                'three_star_review' => $threeStarReview,
                'two_star_review' => $twoStarReview,
                'one_star_review' => $oneStarReview,
                'review_data' => $reviewContent
            ];
    
            return json_encode($output);
        }
    }
    
    
    public function postFeedback()
    {
        helper(['form']);
        $validationRules = [
            'Email' => 'required',
            'FeedbackMessage' => 'required',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return view('/', ['validationErrors' => $validationErrors]);
        }
        $Email = $this->request->getPost('Email');
        $feedbackMessage = $this->request->getPost('FeedbackMessage');
        $user = $this->users->where('Email', $Email)->first();
        if ($user) {
            $existingFeedback = $this->feedbacks->where('UserID', $user['UserID'])->first();
            if ($existingFeedback) {
                $this->feedbacks->update($existingFeedback['FeedbackID'], ['FeedbackMessage' => $feedbackMessage]);
                return redirect()->to(base_url('/'))->with('success', 'Feedback updated successfully.');
            } else {
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
    public function profile()
    {
        return view('Hotell/profile');
    }
    public function updateProfile($userID)
    {
        helper(['form']);
        $validationRules = [
            'FirstName' => 'required|min_length[2]|max_length[100]',
            'LastName' => 'required|min_length[2]|max_length[100]', 
            'Email' => 'required|min_length[4]|max_length[100]|valid_email',
            'ContactNumber' => 'required|max_length[11]',
            'Address' => 'required|min_length[2]|max_length[255]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->back()->withInput()->with('validationErrors', $validationErrors);
        }
        $updatedUserData = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'Email' => $this->request->getVar('Email'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
            'Address' => $this->request->getVar('Address'),
        ];
        $this->users->update($userID, $updatedUserData);
        return redirect()->to(base_url('/profile'))->with('success', 'Guest details updated successfully.');
    }
    public function changePassword()
    {
        return view('Hotell/changepassword');
    }
    public function updatePassword()
    {
        $session = session();
        $userModel = new UserModel();
        $userID = $session->get('id');
        $rules = [
            'oldpassword' => 'required',
            'newpassword' => 'required|min_length[8]',
            'confirmpassword' => 'required|matches[newpassword]'
        ];
        if ($this->validate($rules)) {
            $oldPassword = $this->request->getPost('oldpassword');
            $newPassword = $this->request->getPost('newpassword');
            $user = $userModel->find($userID);
            if (password_verify($oldPassword, $user['Password'])) {
                $userModel->updatePassword($userID, $newPassword);
                $session->setFlashdata('msg', 'Password successfully updated');
                return redirect()->to('/change-password');
            } else {
                $session->setFlashdata('msg', 'Old password is incorrect');
                return redirect()->to('/change-password');
            }
        } else {
            $data['validation'] = $this->validator;
            return view('Hotell/changepassword', $data);
        }
    }
    public function get_chat_data()
    {
        $msg = strtolower(trim($this->request->getPost('msg')));
        $arrInput = explode(" ", $msg);
        $arr = $this->chat->getAllChatbot();
        $arrCount = [];
        foreach ($arr as $key => $row) {
            $question = strtolower($row['Question']);
            $arrQuestion = explode(" ", $question);
            $count = 0;
            foreach ($arrInput as $inputWord) {
                if (in_array($inputWord, $arrQuestion)) {
                    $count++;
                }
            }
            $arrCount[$key] = $count;
        }
        if (array_sum($arrCount) == 0) {
            echo "Sorry, I can't recognize. Please choose one above";
            exit;
        } else {
            $maxIndex = array_search(max($arrCount), $arrCount);
            echo $arr[$maxIndex]['Answer'];
            exit;
        }
    }
    public function booking()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); 
        }
        $userID = session()->get('id');
        $data = [
            'hotelrevs' => $this->reservation
                ->select('reservations.ReservationID, rooms.RoomID, rooms.RoomNumber, rooms.RoomType, rooms.Image as room_image, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.PaymentOption, reservations.ReferenceNumber, reservations.Adult, reservations.Child, reservations.downorfullPayment, reservations.Image as reservation_image, reservations.QRCodePath, reservations.TotalAmount, reservations.Status, users.UserID, users.FirstName, users.LastName, users.ContactNumber')
                ->join('rooms', 'reservations.RoomID = rooms.RoomID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->where('reservations.Status', 'Confirm')
                ->where('reservations.UserID', $userID)
                ->findAll(),
            'reevents' => $this->reservation
                ->select('reservations.ReservationID, convention.conventionID, convention.conVenueID, convention_venue.conVenueID, convention_venue.conVenueName, convention_venue.minGuest, convention_venue.maxGuest, convention_venue.Image as venue_image, convention.EventID, events.EventType, events.Description as event_description, events.Image as event_image, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.PaymentOption, reservations.ReferenceNumber, reservations.downorfullPayment, reservations.TotalAmount, reservations.Image as reservation_image, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, users.Email, reservations.UserID')
                ->join('convention', 'reservations.conventionID = convention.conventionID')
                ->join('convention_venue', 'convention.conVenueID = convention_venue.conVenueID')
                ->join('events', 'convention.EventID = events.EventID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->where('reservations.Status', 'Confirm')
                ->where('reservations.UserID', $userID)
                ->findAll(),
            'restrevs' => $this->reservation
                ->select('reservations.ReservationID, restaurant_venue.VenueID, restaurant_venue.VenueName,restaurant_venue.Image as venue_image, reservations.ArivalDate,reservations.ArivalTime, reservations.CheckInDate, reservations.NumberOfGuests, reservations.Note, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address, reservations.UserID ')
                ->join('restaurant_venue', 'reservations.VenueID = restaurant_venue.VenueID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->where('reservations.Status', 'Confirm')
                ->where('reservations.UserID', $userID)
                ->findAll(),
        ];
        return view('Hotell/booking', $data);
    }
    public function bookinghotelupdatestatus($status, $reservationID)
    {
        $session = session();
        $allowedStatuses = ['Cancel'];
        if (!in_array($status, $allowedStatuses)) {
            return redirect()->back()->with('error', 'Invalid status');
        }
        $reservation = $this->reservation
            ->where('ReservationID', $reservationID)
            ->first();
        if (!$reservation) {
            return redirect()->back()->with('error', 'Reservation not found');
        }
        $user = $this->users
            ->where('UserID', $reservation['UserID'])
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found for the reservation');
        }
        $checkInDate = new \DateTime($reservation['CheckInDate']);
        $cancellationDate = new \DateTime();
        $difference = $cancellationDate->diff($checkInDate);
        $daysDifference = $difference->days;
        if ($daysDifference <= 3) {
            $refundAmount = $reservation['downorfullPayment'] * 0.5;
            $updateData = ['Status' => $status, 'RefundAmount' => $refundAmount];
            $updated = $this->reservation->update($reservationID, $updateData);
            if ($updated) {
                $emailMessage = "Dear customer,<br><br>";
                $emailMessage .= "Your reservation has been canceled, and a refund of {$refundAmount} has been initiated on 3 days.<br>";
                $emailMessage .= "If you have any questions, please contact us in our contact below.<br>";
                $emailMessage .= "09812480320<br>";
                $emailMessage .= "or<br>";
                $emailMessage .= "mahaltaresorts@gmail.com<br>";
                $this->sendEmail($user['Email'], 'Reservation Canceled and Refund Initiated on 3 Days', $emailMessage);
                $fcmToken = $user['fcm_token'];
                if (!empty($fcmToken)) {
                    $notifTitle = 'Reservation Canceled and Refund Initiated';
                    $notifBody = "Your reservation has been canceled, and a refund of {$refundAmount} has been initiated.";
                    $this->sendPushNotification($fcmToken, $notifTitle, $notifBody);
                }
                $session->setFlashdata('success', 'Reservation canceled successfully, and refund initiated.');
                return redirect()->to('/booking');
            } else {
                return redirect()->back()->with('error', 'Failed to update reservation status');
            }
        } else {
            $updateData = ['Status' => $status];
            $updated = $this->reservation->update($reservationID, $updateData);
            if ($updated) {
                $emailMessage = "Dear customer,<br><br>";
                $emailMessage .= "Your reservation has been canceled. Refund is not applicable as the cancellation period has passed.<br>";
                $emailMessage .= "If you have any questions, please contact us in our contact below.<br>";
                $emailMessage .= "099123123123<br>";
                $emailMessage .= "or<br>";
                $emailMessage .= "email@gmail.com<br>";
                $this->sendEmail($user['Email'], 'Reservation Canceled', $emailMessage);
                $fcmToken = $user['fcm_token'];
                if (!empty($fcmToken)) {
                    $notifTitle = 'Reservation Canceled';
                    $notifBody = "Your reservation has been canceled. Refund is not applicable as the cancellation period has passed.";
                    $this->sendPushNotification($fcmToken, $notifTitle, $notifBody);
                }
                $session->setFlashdata('success', 'Reservation canceled successfully.');
                return redirect()->to('/booking');
            } else {
                return redirect()->back()->with('error', 'Failed to update reservation status');
            }
        }
    }
    public function bookingrestauupdatestatus($status, $reservationID)
    {
        $session = session();
        $allowedStatuses = ['Cancel'];
        if (!in_array($status, $allowedStatuses)) {
            return redirect()->back()->with('error', 'Invalid status');
        }
        $reservation = $this->reservation
            ->where('ReservationID', $reservationID)
            ->first();
        if (!$reservation) {
            return redirect()->back()->with('error', 'Reservation not found');
        }
        $user = $this->users
            ->where('UserID', $reservation['UserID'])
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found for the reservation');
        }
        $updateData = ['Status' => $status];
        $updated = $this->reservation->update($reservationID, $updateData);
        if ($updated) {
            $emailMessage = "Dear customer,<br><br>";
            $emailMessage .= "Your reservation status has been updated to: <strong style='color:" . ($status == 'Confirm' ? 'green' : 'red') . ";'>{$status}</strong>.<br>";
            $emailMessage .= "Reservation ID: {$reservation['ReservationID']}<br>";
            $emailMessage .= "Arrival Date: {$reservation['ArivalDate']}<br>";
            $emailMessage .= "Arrival Date: {$reservation['ArivalTime']}<br>";
            $emailMessage .= "Number of Guests: {$reservation['NumberOfGuests']}<br>";
            $emailMessage .= "Note : {$reservation['Note']}<br>";
            $emailMessage .= "If you have any questions, please contact us.<br>";
            $this->sendEmail($user['Email'], 'Reservation Status Updated', $emailMessage);
            $fcmToken = $user['fcm_token'];
            if (!empty($fcmToken)) {
                $notifTitle = 'Reservation Status Updated';
                $notifBody = "Your reservation status has been updated to {$status}.";
                $this->sendPushNotification($fcmToken, $notifTitle, $notifBody);
            }
            $session->setFlashdata('success', 'Reservation status updated successfully and email sent.');
            return redirect()->to('/booking');
        } else {
            return redirect()->back()->with('error', 'Failed to update reservation status');
        }
    }
    public function bookingconvenupdatestatus($status, $reservationID)
    {
        $session = session();
        $allowedStatuses = ['Cancel'];
        if (!in_array($status, $allowedStatuses)) {
            return redirect()->back()->with('error', 'Invalid status');
        }
        $reservation = $this->reservation
            ->where('ReservationID', $reservationID)
            ->first();
        if (!$reservation) {
            return redirect()->back()->with('error', 'Reservation not found');
        }
        $user = $this->users
            ->where('UserID', $reservation['UserID'])
            ->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User not found for the reservation');
        }
        $updateData = ['Status' => $status];
        $updated = $this->reservation->update($reservationID, $updateData);
        if ($updated) {
            $emailMessage = "Dear customer,<br><br>";
            $emailMessage .= "Your reservation status has been updated to: <strong style='color:" . ($status == 'Confirm' ? 'green' : 'red') . ";'>{$status}</strong>.<br>";
            $emailMessage .= "Reservation ID: {$reservation['ReservationID']}<br>";
            $emailMessage .= "Check-In Date: {$reservation['CheckInDate']}<br>";
            $emailMessage .= "Check-Out Date: {$reservation['CheckOutDate']}<br>";
            $emailMessage .= "Number of Guests: {$reservation['NumberOfGuests']}<br>";
            $emailMessage .= "Total Amount: {$reservation['TotalAmount']}<br>";
            $emailMessage .= "If you have any questions, please contact us.<br>";
            $this->sendEmail($user['Email'], 'Reservation Status Updated', $emailMessage);
            $fcmToken = $user['fcm_token'];
            if (!empty($fcmToken)) {
                $notifTitle = 'Reservation Status Updated';
                $notifBody = "Your reservation status has been updated to {$status}.";
                $this->sendPushNotification($fcmToken, $notifTitle, $notifBody);
            }
            $session->setFlashdata('success', 'Reservation status updated successfully and email sent.');
            return redirect()->to('/booking');
        } else {
            return redirect()->back()->with('error', 'Failed to update reservation status');
        }
    }
    public function daytour()
    {
        return view('Hotell/daytour');
    }
}
