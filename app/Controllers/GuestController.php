<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoomModel;
use App\Models\TableModel;
use App\Models\EventModel;
use App\Models\ReservationModel;
use App\Models\FeedbackModel;
class GuestController extends BaseController
{
    private $users;
    private $rooms;
    private $tables;
    private $events;
    private $reservation;

    private $feedbacks;

    function __construct(){
        helper(['form']);
        $this->users = new UserModel();
        $this->rooms = new RoomModel();
        $this->tables = new TableModel();
        $this->events = new EventModel();
        $this->reservation = new ReservationModel();
        $this->feedbacks = new FeedbackModel();
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
            // You can perform any additional processing or data manipulation here

            // Redirect to the /bookroom/formdetails page
            return redirect()->to(base_url('/bookroom/formdetails'));
        } else {
            // Handle the case where either reservation or room data is missing
            return redirect()->to(base_url('/error')); // Adjust the URL accordingly
        }
    }
    public function calculateTotalAmount()
    {
        // Load the session library
        $session = \Config\Services::session();

        // Retrieve reservation data from session
        $reservationData = $session->get('reservationData');

        // Retrieve selected room data from session
        $roomSelected = $session->get('roomSelected');

        // Check if both reservation and room data exist
        if (!empty($reservationData) && !empty($roomSelected)) {
            // Extract necessary details from reservation and room data
            $checkInDate = strtotime($reservationData['CheckInDate']);
            $checkOutDate = strtotime($reservationData['CheckOutDate']);
            $numberOfGuests = $reservationData['NumberOfGuests'];
            $roomPrice = $roomSelected['Price'];

            // Calculate the number of days booked
            $numberOfDays = ceil(($checkOutDate - $checkInDate) / (60 * 60 * 24));

            // Calculate the base room cost
            $roomCost = $numberOfDays * $roomPrice;

            // Calculate the guest cost
            $guestCost = 4999 + (($numberOfGuests - 2) * 500); // 2 guests are already included

            // Calculate the total amount
            $totalAmount = $roomCost + $guestCost;

            // You can store the totalAmount in the session or use it as needed

            // Redirect to the next page or perform any other actions
            return redirect()->to(base_url('/bookroom/formdetails'))->with('totalAmount', $totalAmount);
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
        ];
        return view('Hotell\blog',$data);
    }
    public function restaurant()
    {
        $data = [
            'activePage' => 'Restaurant',
        ];
        return view('Hotell\restaurant',$data);
    }
    public function convention()
    {
        $data = [
            'activePage' => 'Convention',
            'events' => $this->events->findAll(),
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
    
        return view('Hotell\checkOutReservation', $data);
    }

    public function addReservation()
    {
        helper(['form']);

        // Validation Rules (Adjust as needed)
        $validationRules = [
            'FirstName' => 'required',
            'LastName' => 'required',
            'ContactNumber' => 'required',
            'Address' => 'required',
            'CheckInDate' => 'required',
            'CheckOutDate' => 'required',
            'RoomNumber' => 'required',
            'RoomType' => 'required',
            'NumberOfGuests' => 'required',
            'ReferenceNumber' => 'required',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return view('/bookroom', ['validationErrors' => $validationErrors]);
        }

        // Retrieve Post Data
        $FirstName = $this->request->getPost('FirstName');
        $LastName = $this->request->getPost('LastName');
        $ContactNumber = $this->request->getPost('ContactNumber');
        $Address = $this->request->getPost('Address');
        $NumberOfGuests = $this->request->getPost('NumberOfGuests');

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

        // Check if the retrieved sessions are not empty
        if ($roomSelected && $reservationData && $user) {
            // Calculate TotalAmount based on PricePerNight and add charge for additional guests
            $pricePerNight = $roomSelected['PricePerNight'];
            $additionalGuestCharge = 500;
            $totalGuests = $reservationData['NumberOfGuests'];

            // Calculate TotalAmount
            $totalAmount = $pricePerNight + ($additionalGuestCharge * max(0, $totalGuests - 2));

            // Prepare Reservation Data
            $newReservationData = [
                'CheckInDate' => $reservationData['CheckInDate'],
                'CheckOutDate' => $reservationData['CheckOutDate'],
                'NumberOfGuests' => $totalGuests,
                'TotalAmount' => $totalAmount,
                'ReferenceNumber' => $this->request->getPost('ReferenceNumber'),
                'Status' => 'Pending',
                'RoomID' => $roomSelected['RoomID'], // Use the RoomID from roomSelected
                'UserID' => $user['UserID'],
            ];

            // Insert Reservation
            $inserted = $this->reservation->insert($newReservationData);

            // Redirect with appropriate message
            if ($inserted) {
                return redirect()->to(base_url('/bookroom'))->with('success', 'Reservation added successfully.');
            } else {
                return redirect()->to(base_url('/bookroom'))->with('error', 'Failed to add reservation. Please try again.');
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
            'CheckOutDate' => 'required',
            'TableNumber' => 'required',
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
        $inputTable = $this->request->getPost('TableNumber');

        $restaurantTable = $this->tables->where('TableNumber', $inputTable)->first();

        // Check both conditions for roomData
        if ($restaurantTable && $user) {
            // Prepare Reservation Data
            $newReservationData = [
                'CheckInDate' => $this->request->getPost('CheckInDate'),
                'CheckOutDate' => $this->request->getPost('CheckOutDate'),
                'Note' => $this->request->getPost('Note'),
                'Status' => 'Pending',
                'TableID' => $restaurantTable['TableID'], // Use the RoomID from RoomType
                'UserID' => $user['UserID'],
            ];

            // Insert Reservation
            $inserted = $this->reservation->insert($newReservationData);

            // Redirect with appropriate message
            if ($inserted) {
                return redirect()->to(base_url('/bookroom'))->with('success', 'Reservation added successfully.');
            } else {
                return redirect()->to(base_url('/bookroom'))->with('error', 'Failed to add reservation. Please try again.');
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
                return redirect()->to(base_url('/bookroom'))->with('success', 'Reservation added successfully.');
            } else {
                return redirect()->to(base_url('/bookroom'))->with('error', 'Failed to add reservation. Please try again.');
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

}
