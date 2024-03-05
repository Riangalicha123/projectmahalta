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
use App\Models\MenubarbeerModel;
use App\Models\MenubarbucketModel;
use App\Models\MenubarcocktailModel;
use App\Models\MenubarjuiceModel;
use App\Models\MenubarmocktailModel;
use App\Models\MenubarModel;
use App\Models\MenubarredwineModel;
use App\Models\MenubarshakeModel;
use App\Models\MenubarshooterModel;
use App\Models\MenubartowerModel;
use App\Models\MenubarliquorModel;
use App\Models\MenucafeModel;
use App\Models\MenucafecoldModel;
use App\Models\MenucafehotModel;
use App\Models\MenucafeicedModel;

use App\Models\MenumainbreakfastModel;
use App\Models\MenumainveggiesModel;
use App\Models\MenumainsoupModel;
use App\Models\MenumainsolomealModel;
use App\Models\MenumainchickenModel;
use App\Models\MenumainsnackModel;
use App\Models\MenumainsizzlingModel;
use App\Models\MenumainseafoodModel;
use App\Models\MenumainporkModel;
use App\Models\MenumainpastaModel;
use App\Models\MenumainModel;
use App\Models\MenumainmealdealsModel;

use App\Traits\EmailTrait;
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
    private $beers;
    private $buckets;
    private $cocktails;
    private $mocktails;
    private $juices;
    private $liquors;
    private $redwines;
    private $shakes;
    private $shooters;
    private $towers;
    private $bars;
    private $cafes;
    private $colds;
    private $hots;
    private $iced;

    private $mains;
    private $breakfasts;
    private $chickens;
    private $mealdeals;
    private $pastas;
    private $porks;
    private $seafoods;
    private $sizzlings;
    private $snacks;
    private $solomeals;
    private $soups;
    private $veggies;

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
        $this->bar = new MenubarModel();
        $this->beers = new MenubarbeerModel();
        $this->buckets = new MenubarbucketModel();
        $this->cocktails = new MenubarcocktailModel();
        $this->juices = new MenubarjuiceModel();
        $this->liquors = new MenubarliquorModel();
        $this->mocktails = new MenubarmocktailModel();
        $this->redwines = new MenubarredwineModel();
        $this->shakes = new MenubarshakeModel();
        $this->shooters = new MenubarshooterModel();
        $this->towers = new MenubartowerModel();
        $this->cafes = new MenucafeModel();
        $this->colds = new MenucafecoldModel();
        $this->hots = new MenucafehotModel();
        $this->iced = new MenucafeicedModel();

        $this->mains = new MenumainModel();
        $this->breakfasts = new MenumainbreakfastModel();
        $this->chickens = new MenumainchickenModel();
        $this->mealdeals = new MenumainmealdealsModel();
        $this->pastas = new MenumainpastaModel();
        $this->porks = new MenumainporkModel();
        $this->seafoods = new MenumainseafoodModel();
        $this->sizzlings = new MenumainsizzlingModel();
        $this->snacks = new MenumainsnackModel();
        $this->solomeals = new MenumainsolomealModel();
        $this->soups = new MenumainsoupModel();
        $this->veggies = new MenumainveggiesModel();
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
    
        // Retrieve data from GET parameters
        $CheckInDate = $this->request->getGet('CheckInDate');
        $CheckOutDate = $this->request->getGet('CheckOutDate');
        $numberOfAdults = $this->request->getGet('Adult');
        $numberOfChildren = $this->request->getGet('Child');
    
        // Sample code to store data in session
        $reservationData = [
            'CheckInDate' => $CheckInDate,
            'CheckOutDate' => $CheckOutDate,
            'Adult' => $numberOfAdults,
            'Child' => $numberOfChildren,
        ];
    
        // Store data in session
        $session->set('reservationData', $reservationData);
    
        $availableRooms = $this->findAvailableRooms($numberOfAdults, $numberOfChildren);
    
        // Pass available rooms data to view
        // Pass reservation data and available rooms data to the view
return view('Hotell/bookroom', ['reservationData' => $reservationData, 'availableRooms' => $availableRooms]);

    }
    
    private function findAvailableRooms($numberOfAdults, $numberOfChildren)
    {
        // Ensure $numberOfAdults and $numberOfChildren are integers
        $numberOfAdults = (int) $numberOfAdults;
        $numberOfChildren = (int) $numberOfChildren;
            
        // Sample query to retrieve available rooms based on minimum and maximum person capacity
        $availableRooms = $this->rooms->where('minPerson <=', $numberOfAdults + $numberOfChildren)
                                        ->where('maxPerson >=', $numberOfAdults + $numberOfChildren)
                                        ->where('AvailabilityStatus', 'Available')
                                        ->findAll();
        
        return $availableRooms;
    }
    public function getdataRoom()
    {
        $session = \Config\Services::session();
    
        // Retrieve reservation data from session
        $reservationData = $session->get('reservationData');
    
        // Retrieve available rooms data
        $availableRooms = $this->findAvailableRooms($reservationData['Adult'], $reservationData['Child']);
    
        // Initialize total amount
        $TotalAmount = 0;
    
        // Check if a room is selected
        $roomSelected = null;
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
        return view('Hotell/bookroom', ['reservationData' => $reservationData, 'availableRooms' => $availableRooms, 'roomSelected' => $roomSelected, 'TotalAmount' => $TotalAmount]);
    }
    
    
    
    
    

    public function getdataRoomReservation()
    {
        // Load the session library
        $session = \Config\Services::session();
    
        // Retrieve reservation data from session
        $reservationData = $session->get('reservationData');
    
        // Retrieve selected room data from session
        $roomSelected = $session->get('roomSelected');
    
        // Check if both reservation and room data exist
        if (!empty($reservationData) && !empty($roomSelected)) {
            // Calculate the total amount based on the number of nights
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
            $session->set('roomReservationData', [
                'reservationData' => $reservationData,
                'roomSelected' => $roomSelected,
                'TotalAmount' => $TotalAmount,
            ]);
    
            // Redirect to the /bookroom/formdetails page
            return redirect()->to(base_url('/bookroom/formdetails'));
        } else {
            // Handle the case where either reservation or room data is missing
            return redirect()->to(base_url('/error')); // Adjust the URL accordingly
        }
    }
    
    
    
    public function gallery()
    {
        return view('Hotel\gallery');
    }
    
    public function blog()
    {
        $data = [
            'activePage' => 'Blog',
            'chats' => $this->chat->findAll()
        ];
        return view('Hotell\blog',$data);
    }
    public function restaurantt()
    {
        $data = [
            'activePage' => 'Restaurant',
            'chats' => $this->chat->findAll(),
            'cocktails' => $this->cocktails->findAll(),
            'mocktails' => $this->mocktails->findAll(),
            'shooters' => $this->shooters->findAll(),
            'towers' => $this->towers->findAll(),
            'juices' => $this->juices->findAll(),
            'shakes' => $this->shakes->findAll(),
            'liquors' => $this->liquors->findAll(),
            'redwines' => $this->redwines->findAll(),
            'beers' => $this->beers->findAll(),
            'buckets' => $this->buckets->findAll(),
            'cafes' => $this->cafes->findAll(),
            'colds' => $this->colds->findAll(),
            'hots' => $this->hots->findAll(),
            'iced' => $this->iced->findAll(),
            
        ];
        return view('Hotell\restaurant',$data);
    }
    public function mainmenu()
    {
        $data = [
            'activePage' => 'Main Menu',
            'chats' => $this->chat->findAll(),
            'mains' => $this->mains->findAll(),
            'breakfasts' => $this->breakfasts->findAll(),
            'chickens' => $this->chickens->findAll(),
            'mealdeals' => $this->mealdeals->findAll(),
            'pastas' => $this->pastas->findAll(),
            'porks' => $this->porks->findAll(),
            'seafoods' => $this->seafoods->findAll(),
            'sizzlings' => $this->sizzlings->findAll(),
            'snacks' => $this->snacks->findAll(),
            'solomeals' => $this->solomeals->findAll(),
            'soups' => $this->soups->findAll(),
            'veggies' => $this->veggies->findAll(),
            
        ];
        return view('Hotell\mainmenu',$data);
    }
    public function barmenu()
    {
        $data = [
            'activePage' => 'Bar Menu',
            'chats' => $this->chat->findAll(),
            'cocktails' => $this->cocktails->findAll(),
            'mocktails' => $this->mocktails->findAll(),
            'shooters' => $this->shooters->findAll(),
            'towers' => $this->towers->findAll(),
            'juices' => $this->juices->findAll(),
            'shakes' => $this->shakes->findAll(),
            'liquors' => $this->liquors->findAll(),
            'redwines' => $this->redwines->findAll(),
            'beers' => $this->beers->findAll(),
            'buckets' => $this->buckets->findAll(),
            
        ];
        return view('Hotell\barmenu',$data);
    }
    public function cafemenu()
    {
        $data = [
            'activePage' => 'Cafe Menu',
            'chats' => $this->chat->findAll(),
            'cafes' => $this->cafes->findAll(),
            'colds' => $this->colds->findAll(),
            'hots' => $this->hots->findAll(),
            'iced' => $this->iced->findAll(),
        ];
        return view('Hotell\cafemenu',$data);
    }
    public function convention()
    {
        $data = [
            'activePage' => 'Convention',
            'events' => $this->events->findAll(),
            'chats' => $this->chat->findAll()
        ];
        return view('Hotell\convention',$data);
    }
    public function bookroom()
    {
        // Load the session library
        $session = \Config\Services::session();
    
        // Retrieve reservation data from session
        $reservationData = $session->get('reservationData');
    
        // Retrieve available rooms data based on reservation data
        $availableRooms = $this->findAvailableRooms($reservationData['Adult'], $reservationData['Child']);
    
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
            'availableRooms' => $availableRooms,
            'roomSelected' => $roomSelected,
            'TotalAmount' => $TotalAmount,
        ];
    
        return view('Hotell\bookroom', $data);
    }
    
    public function formdetails()
    {
        // Load the session library
        $session = \Config\Services::session();
    
        // Retrieve room reservation data from session
        $roomReservationData = $session->get('roomReservationData');
    
        // Calculate down payment and full payment amounts (assuming down payment is 50% of total amount)
        $downPaymentAmount = $roomReservationData['TotalAmount'] * 0.2;
        $fullPaymentAmount = $roomReservationData['TotalAmount'];
    
        // Add down payment and full payment amounts to room reservation data
        $roomReservationData['DownpaymentAmount'] = $downPaymentAmount;
        $roomReservationData['FullpaymentAmount'] = $fullPaymentAmount;
    
        // You can now use $roomReservationData in your view or any other processing
        // For example, passing it to the view data array
        $data = [
            'activePage' => 'Reservation',
            'rooms' => $this->rooms
                ->select('rooms.RoomID, rooms.RoomNumber, rooms.RoomType,rooms.Description,rooms.PricePerNight,rooms.AvailabilityStatus,rooms.Image')
                ->findAll(),
            'qrcodes' => $this->qr->findAll(),
            'roomReservationData' => $roomReservationData,
        ];
    
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
            $TotalAmount = session()->get('roomReservationData')['TotalAmount'];
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
                            'TotalAmount' => $TotalAmount,
                            'Image' => $newFileName
                        ];
                        $inserted = $this->reservation->insert($newReservationData);
        
                        if ($inserted && $roomSelected['AvailabilityStatus'] === 'Available') {
                            $this->rooms->update($roomSelected['RoomID'], ['AvailabilityStatus' => 'Not Available']);
                        }
                        if ($inserted) {
                            $emailMessage = $this->prepareEmailMessage($newReservationData);
                            $this->sendEmail($email, 'Your Reservation Confirmation', $emailMessage);
                            $fcmToken = $user['fcm_token'];
                            if (!empty($fcmToken)) {
                                $notifTitle = 'Reservation Confirmation';
                                $notifBody = 'Your reservation has been successfully added.';
                                $this->sendPushNotification($fcmToken, $notifTitle, $notifBody);
                            }
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
    public function tableReservation(){
        helper(['form']);
        $validationRules = [
            'FirstName' => 'required',
            'LastName' => 'required',
            'ContactNumber' => 'required',
            'Address' => 'required',
            'CheckInDate' => 'required',
            'Venue' => 'required',
            'Note' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            // Validation failed, return with validation errors
            $validationErrors = $this->validator->getErrors();
            return view('/room', ['validationErrors' => $validationErrors]);
        }
        $FirstName = $this->request->getPost('FirstName');
        $LastName = $this->request->getPost('LastName');
        $ContactNumber = $this->request->getPost('ContactNumber');
        $Address = $this->request->getPost('Address');

        // Use a single query to get the user based on both first name and last name
        $user = $this->users->where('FirstName', $FirstName)
                            ->where('LastName', $LastName)
                            ->where('ContactNumber', $ContactNumber)
                            ->where('Address', $Address)
                            ->first();

        // Retrieve Room Data
        $inputTable = $this->request->getPost('Venue');

        $restaurantTable = $this->tables->where('Venue', $inputTable)->first();

        // Check both conditions for roomData
        if ($restaurantTable && $user) {
            // Prepare Reservation Data
            $newReservationData = [
                'CheckInDate' => $this->request->getPost('CheckInDate'),
                'Note' => $this->request->getPost('Note'),
                'Status' => 'Pending',
                'TableID' => $restaurantTable['TableID'], // Use the RoomID from RoomType
                'UserID' => $user['UserID'],
            ];

            // Insert Reservation
            $inserted = $this->reservation->insert($newReservationData);

            // Redirect with appropriate message
            if ($inserted) {
                return redirect()->to(base_url('/restaurant'))->with('success', 'Reservation added successfully.');
            } else {
                return redirect()->to(base_url('/restaurant'))->with('error', 'Failed to add reservation. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/'))->with('error', 'Invalid Username, RoomType, or RoomNumber. Please check your input.');
        }
    }
    public function eventReservation()
    {
        helper(['form']);

        // Validation Rules
        $validationRules = [
            'FirstName' => 'required',
            'LastName' => 'required',
            'ContactNumber' => 'required',
            'CheckInDate' => 'required',
            'EventType' => 'required',
            'NumberOfGuests' => 'required',
            'Note' => 'required',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return view('/bookroom', ['validationErrors' => $validationErrors]);
        }

        // Retrieve Post Data
        $FirstName = $this->request->getPost('FirstName');
        $LastName = $this->request->getPost('LastName');
        $Email = $this->request->getPost('Email');
        $ContactNumber = $this->request->getPost('ContactNumber');

        // Use a single query to get the user based on both first name and last name
        $user = $this->users->where('FirstName', $FirstName)
                            ->where('LastName', $LastName)
                            ->where('Email', $Email)
                            ->where('ContactNumber', $ContactNumber)
                            ->first();

        // Retrieve Room Data
        $inputEventType = $this->request->getPost('EventType');

        $eventDataByType = $this->events->where('EventType', $inputEventType)->first();

        // Check both conditions for eventData
        if ($eventDataByType && $user) {
            // Prepare Reservation Data
            $newReservationData = [
                'CheckInDate' => $this->request->getPost('CheckInDate'),
                'NumberOfGuests' => $this->request->getPost('NumberOfGuests'),
                'Note' => $this->request->getPost('Note'),
                'Status' => 'Pending',
                'EventID' => $eventDataByType['EventID'], // Use the RoomID from RoomType
                'UserID' => $user['UserID'],
            ];

            // Insert Reservation
            $inserted = $this->reservation->insert($newReservationData);

            // Redirect with appropriate message
            if ($inserted) {
                return redirect()->to(base_url('/convention'))->with('success', 'Reservation added successfully.');
            } else {
                return redirect()->to(base_url('/convention'))->with('error', 'Failed to add reservation. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/'))->with('error', 'Invalid Username, RoomType, or RoomNumber. Please check your input.');
        }
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
