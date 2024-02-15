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
class GuestController extends BaseController
{
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
        $NumberOfGuests = $this->request->getGet('NumberOfGuests');
    
        // Sample code to store data in session
        $reservationData = [
            'CheckInDate' => $CheckInDate,
            'CheckOutDate' => $CheckOutDate,
            'NumberOfGuests' => $NumberOfGuests,
        ];
    
        // Store data in session
        $session->set('reservationData', $reservationData);
    
        // Redirect to another page or perform any other actions
        return redirect()->to(base_url('/bookroom'))->with('success', 'Reservation data retrieved successfully.');
    }
    public function getdataRoom()
    {
        $session = \Config\Services::session();
    
        // Assuming GET method is used
        $selectedRoomID = $this->request->getGet('selectedRoomID');
    
        // Check if a room is selected
        if (!empty($selectedRoomID)) {
            // Fetch the selected room data from the database using the ID
            $roomSelected = $this->rooms->find($selectedRoomID);
    
            // Check if the room is available before storing it in the session
            if (!empty($roomSelected) && isset($roomSelected['AvailabilityStatus']) && $roomSelected['AvailabilityStatus'] === 'Available') {
                // Store the data in the session
                $session->set('roomSelected', $roomSelected);
    
                // Redirect to the /bookroom page
                return redirect()->to(base_url('/bookroom'));
            }
        }
    
        // Handle the case where no room is selected or the selected room is not available
        return redirect()->to(base_url('/error')); // Adjust the URL accordingly
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
    
        // Retrieve selected room data from session
        $roomSelected = $session->get('roomSelected');
    
        
        // You can now use $reservationData and $roomSelected in your view or any other processing
        // For example, passing them to the view data array
        $data = [
            'activePage' => 'Reservation',
            'rooms' => $this->rooms
                ->select('rooms.RoomID, rooms.RoomNumber, rooms.RoomType,rooms.Description,rooms.PricePerNight,rooms.AvailabilityStatus,rooms.Image')
                ->findAll(),
            'reservationData' => $reservationData,
            'roomSelected' => $roomSelected,
        ];
    
        return view('Hotell\bookroom', $data);
    }
    public function formdetails()
    {
        // Load the session library
        $session = \Config\Services::session();
    
        // Retrieve room reservation data from session
        $roomReservationData = $session->get('roomReservationData');
    
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
    
        // Retrieve Post Data
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
    
        // Retrieve Room Data from Session
        $roomSelected = session()->get('roomSelected');
    
        // Retrieve Reservation Data from Session
        $reservationData = session()->get('reservationData');
    
        // Retrieve TotalAmount from Session
        $totalAmount = session()->get('roomReservationData')['TotalAmount'];
    
        // Check if the retrieved sessions are not empty
        if ($roomSelected && $reservationData && $user && $totalAmount) {
            // Prepare Reservation Data
            $newReservationData = [
                'CheckInDate' => $reservationData['CheckInDate'],
                'CheckOutDate' => $reservationData['CheckOutDate'],
                'NumberOfGuests' => $reservationData['NumberOfGuests'],
                'downorfullPayment' => $this->request->getPost('downorfullPayment'),
                'ReferenceNumber' => $this->request->getPost('ReferenceNumber'),
                'Status' => 'Pending',
                'RoomID' => $roomSelected['RoomID'], // Use the RoomID from roomSelected
                'UserID' => $user['UserID'],
                'TotalAmount' => $totalAmount, // Include TotalAmount
            ];
    
            // Insert Reservation
            $inserted = $this->reservation->insert($newReservationData);
    
            // Redirect with appropriate message
            if ($inserted) {
                return redirect()->to(base_url('/bookroom/formdetails'))->with('success', 'Reservation added successfully.');
            } else {
                return redirect()->to(base_url('/bookroom/formdetails'))->with('error', 'Failed to add reservation. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/'))->with('error', 'Invalid data in sessions. Please check your input.');
        }
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
