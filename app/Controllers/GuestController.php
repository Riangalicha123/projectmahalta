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
    public function restaurant()
    {
        $data = [
            'activePage' => 'Restaurant',
            'chats' => $this->chat->findAll()
        ];
        return view('Hotell\restaurant',$data);
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
            'roomReservationData' => $roomReservationData,
        ];
    
        return view('Hotell\checkOutReservation', $data);
    }
    
    

    public function addReservation()
    {
        helper(['form']);
        $session = session();
        // Validation Rules
    // Validation Rules
    $validationRules = [
        'ReferenceNumber' => 'required|exact_length[13]|numeric', 
    ];

    // Set Custom Error Messages
    $validationMessages = [
        'ReferenceNumber' => [
            'exact_length' => 'The {field} field must be exactly 13 digits long.',
            'numeric' => 'The {field} field must contain only numeric characters.'
        ]
    ];

    // Applying Validation Rules and Messages
    if ($this->validate($validationRules, $validationMessages)){
        // Retrieve Post Data
        $FirstName = $this->request->getPost('FirstName');
        $LastName = $this->request->getPost('LastName');
        $ContactNumber = $this->request->getPost('ContactNumber');
        $Address = $this->request->getPost('Address');
        $email = $session->get('username'); // Assuming 'username' is the email in the session
        // Use a single query to get the user based on both first name and last name
        $user = $this->users->where('FirstName', $FirstName)
                            ->where('LastName', $LastName)
                            ->where('ContactNumber', $ContactNumber)
                            ->first();
    
        // Retrieve Room Data from Session
        $roomSelected = session()->get('roomSelected');
    
        // Retrieve Reservation Data from Session
        $reservationData = session()->get('reservationData');

    
        // Retrieve TotalAmount from Session
        $TotalAmount = session()->get('roomReservationData')['TotalAmount'];
    
        // Check if the retrieved sessions are not empty
        if ($roomSelected && $reservationData && $user && $TotalAmount) {
            // Prepare Reservation Data
            $newReservationData = [
                'CheckInDate' => $reservationData['CheckInDate'],
                'CheckOutDate' => $reservationData['CheckOutDate'],
                'Adult' => $reservationData['Adult'],
                'Child' => $reservationData['Child'],
                'downorfullPayment' => $this->request->getPost('downorfullPayment'),
                'ReferenceNumber' => $this->request->getPost('ReferenceNumber'),
                'Status' => 'Pending',
                'RoomID' => $roomSelected['RoomID'], // Use the RoomID from roomSelected
                'UserID' => $user['UserID'],
                'TotalAmount' => $TotalAmount, 
            ];
    
            // Insert Reservation
            $inserted = $this->reservation->insert($newReservationData);
    
            // Update Room AvailabilityStatus if the RoomType is available
            if ($inserted && $roomSelected['AvailabilityStatus'] === 'Available') {
                $this->rooms->update($roomSelected['RoomID'], ['AvailabilityStatus' => 'Not Available']);
            }
    
            // Redirect with appropriate message
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
            return redirect()->to(base_url('/u'))->with('error', 'Invalid data in sessions. Please check your input.');
        }
    }else{
            $newReservationData['validation'] = $this->validator;
    
            return view('Hotell/checkOutReservation', $newReservationData);
        }
        
    }
    private function prepareEmailMessage(array $reservationData): string
{
    // Customize this message with the actual reservation details
    $message = "Dear customer,<br><br>";
    $message .= "Your reservation has been successfully made with the following details:<br>";
    $message .= "Check-in Date: {$reservationData['CheckInDate']}<br>";
    $message .= "Check-out Date: {$reservationData['CheckOutDate']}<br>";
    $message .= "Number of Adults: {$reservationData['Adult']}<br>";
    $message .= "Number of Childs: {$reservationData['Child']}<br>";
    $message .= "Total Amount: {$reservationData['TotalAmount']}<br>";
    $message .= "Reference Number: {$reservationData['ReferenceNumber']}<br>";
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

    // Log or handle the response as needed
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
