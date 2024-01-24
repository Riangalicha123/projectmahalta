<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoomModel;
use App\Models\TableModel;
use App\Models\EventModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;
use App\Models\StaffDetailModel;
use App\Models\DepartmentModel;
use App\Models\AdminModel;
use App\Models\GuestModel;
use App\Models\ReservationModel;
use App\Models\FeedbackModel;

class AdminController extends BaseController
{
    private $rooms;
    private $tables;
    private $events;
    private $users;
    private $usersrole;
    private $staffDetail;
    private $department;
    private $admin;
    private $guest;
    private $reservation;
    private $feedbacks;

    function __construct(){
        helper(['form']);
        $this->rooms = new RoomModel();
        $this->tables = new TableModel();
        $this->events = new EventModel();
        $this->users = new UserModel();
        $this->usersrole = new UserRoleModel();
        $this->staffDetail = new StaffDetailModel();
        $this->department = new DepartmentModel();
        $this->admin = new AdminModel();
        $this->guest = new GuestModel();
        $this->reservation = new ReservationModel();
        $this->feedbacks = new FeedbackModel();
    }
    public function index()
    {
        //
    }
    public function dashboard()
    {
        $data = [
            'adminRoutes' => 'dashboard',
        ];
        return view('Admin\index', $data);
    }
    public function customer()
    {
        $data = [
            'adminRoutes' => 'customer',
            'guests' => $this->guest
            ->select('guest.GuestID,guest.Status, users.UserID,  users.FirstName,  users.LastName, users.Email, users.ContactNumber, users.Address')
            ->join ('users', 'guest.UserID = users.UserID')
            ->findAll()
        ];
        return view('Admin\customer', $data);
    }
    public function addCustomer()
    {
        helper(['form']);

        // Validation Rules
        $validationRules = [
            'FirstName' => 'required|min_length[4]|max_length[100]',
            'LastName' => 'required|min_length[4]|max_length[100]',
            'Email' => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.Email]',
            'Password' => 'required|min_length[4]|max_length[50]',
            'ContactNumber' => 'required|max_length[11]',
            'Address' => 'required|min_length[4]|max_length[100]',
            'confirmPassword' => 'matches[Password]',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return view('/admin-dashboard', ['validationErrors' => $validationErrors]);
        }

        // Use a single query to get the user based on both first name and last name
        $user = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'Email' => $this->request->getVar('Email'),
            'Password' => password_hash($this->request->getVar('Password'), PASSWORD_DEFAULT),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
            'Address' => $this->request->getVar('Address'),
            'UserRoleID' => 1,
        ];

        // Additional checks and modifications
        if (empty($user['FirstName']) || empty($user['LastName']) || empty($user['Email'])) {
            // Handle the case where essential user details are missing
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Incomplete user details. Please provide all required information.');
        }

        // Check if the email is unique
        if (!$this->isEmailUnique($user['Email'])) {
            // Handle the case where the email is not unique
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Email address is already in use. Please choose a different one.');
        }

        // Insert the user into the database
        $insertedUserID = $this->users->insert($user);


        // Check both conditions for staffData
        if ($insertedUserID) {
            // Prepare Staff Data
            $newGuestData = [
                'UserID' => $insertedUserID,
            ];

            // Insert Staff Details
            $insertedGuestID = $this->guest->insert($newGuestData);

            // Retrieve the inserted staff details
            $insertedGuestDetails = $this->guest->find($insertedGuestID);

            // Redirect with appropriate message and staff details
            if ($insertedGuestID) {
                return redirect()->to(base_url('/admin-customer'))->with('success', 'Reservation added successfully.')->with('staffDetails', $insertedGuestDetails);
            } else {
                return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Failed to add reservation. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Invalid Username, RoomType, or RoomNumber. Please check your input.');
        }
    }
    
    public function updateCustomer($userID)
    {
        helper(['form']);

        // Validation Rules
        $validationRules = [
            'FirstName' => 'required|min_length[4]|max_length[100]',
            'LastName' => 'required|min_length[4]|max_length[100]',
            'Email' => 'required|min_length[4]|max_length[100]|valid_email',
            'ContactNumber' => 'required|max_length[11]',
            'Address' => 'required|min_length[4]|max_length[100]',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return view('/admin-dashboard', ['validationErrors' => $validationErrors]);
        }

        // Prepare Updated Staff Data
        $updatedGuestData = [
            'UserID' => $userID,
        ];

        // Update Staff Details
        $this->guest->update($userID, $updatedGuestData);

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
        return redirect()->to(base_url('/admin-customer'))->with('success', 'Guest details updated successfully.');
    }

    
    public function holReservation()
    {
        $data = [
            'adminRoutes' => 'holReservation',
            'hotelrevs' => $this->reservation
            ->select('reservations.ReservationID, rooms.RoomID, rooms.RoomNumber, rooms.RoomType, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.ReferenceNumber, reservations.TotalAmount, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, users.Address, reservations.UserID ')
            ->join ('rooms', 'reservations.RoomID = rooms.RoomID')
            ->join ('users', 'reservations.UserID = users.UserID')
            ->findAll()
        ]; 
        return view('Admin\Hotel\reservation', $data);
    }
    public function addHotelReservation()
    {
        helper(['form']);

        // Validation Rules
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
            'TotalAmount' => 'required',
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

        // Use a single query to get the user based on both first name and last name
        $user = $this->users->where('FirstName', $FirstName)
                            ->where('LastName', $LastName)
                            ->where('ContactNumber', $ContactNumber)
                            ->where('Address', $Address)
                            ->first();

        // Retrieve Room Data
        $inputRoomType = $this->request->getPost('RoomType');
        $inputRoomNumber = $this->request->getPost('RoomNumber');

        $roomDataByType = $this->rooms->where('RoomType', $inputRoomType)->first();
        $roomDataByNumber = $this->rooms->where('RoomNumber', $inputRoomNumber)->first();

        // Check both conditions for roomData
        if ($roomDataByType && $roomDataByNumber && $user) {
            // Prepare Reservation Data
            $newReservationData = [
                'CheckInDate' => $this->request->getPost('CheckInDate'),
                'CheckOutDate' => $this->request->getPost('CheckOutDate'),
                'NumberOfGuests' => $this->request->getPost('NumberOfGuests'),
                'TotalAmount' => $this->request->getPost('TotalAmount'),
                'ReferenceNumber' => $this->request->getPost('ReferenceNumber'),
                'Status' => 'Pending',
                'RoomID' => $roomDataByType['RoomID'], // Use the RoomID from RoomType
                'UserID' => $user['UserID'],
            ];

            // Insert Reservation
            $inserted = $this->reservation->insert($newReservationData);

            // Redirect with appropriate message
            if ($inserted) {
                return redirect()->to(base_url('/admin-hotel/reservation'))->with('success', 'Reservation added successfully.');
            } else {
                return redirect()->to(base_url('/admin-hotel/reservation'))->with('error', 'Failed to add reservation. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-hotel'))->with('error', 'Invalid Username, RoomType, or RoomNumber. Please check your input.');
        }
    }
    public function updateHotelReservation($reservationID)
    {
        helper(['form']);

        // Validation Rules (you can customize these based on your requirements)
        $validationRules = [
            
            'CheckInDate' => 'required',
            'CheckOutDate' => 'required',
            'RoomNumber' => 'required',
            'RoomType' => 'required',
            'NumberOfGuests' => 'required|numeric',
            'TotalAmount' => 'required|numeric',
            'ReferenceNumber' => 'required|numeric',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            // You might want to handle validation errors here
            return redirect()->to(base_url("/editReservation/{$reservationID}"))->with('validationErrors', $validationErrors);
        }


        $inputRoomType = $this->request->getPost('RoomType');
        $inputRoomNumber = $this->request->getPost('RoomNumber');

        $roomData = $this->rooms->where('RoomType', $inputRoomType)
                                ->where('RoomNumber', $inputRoomNumber)
                                ->first();

        // Update Reservation Data
        if ($roomData) {
                // Prepare Reservation Data
                $updateReservationData = [
                    'CheckInDate' => $this->request->getPost('CheckInDate'),
                    'CheckOutDate' => $this->request->getPost('CheckOutDate'),
                    'NumberOfGuests' => $this->request->getPost('NumberOfGuests'),
                    'TotalAmount' => $this->request->getPost('TotalAmount'),
                    'ReferenceNumber' => $this->request->getPost('ReferenceNumber'),
                    'RoomID' => $roomData['RoomID'], // Use the RoomID from RoomType
                ];

        // Update Reservation
        $this->reservation->update($reservationID, $updateReservationData);

        // Redirect with appropriate message
        return redirect()->to(base_url('/admin-hotel/reservation'))->with('success', 'Reservation updated successfully.');
        } else {
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Invalid RoomType or RoomNumber. Please check your input.');
        }
    }
    public function updateStatus($status, $reservationID)
    {
        // Get the ReservationID from the request, assuming it's sent via POST
        $allowedStatuses = ['Confirm', 'Pending', 'Cancel'];
        if (!in_array($status, $allowedStatuses)) {
            // Handle invalid status (you may redirect or show an error message)
            return redirect()->back('/admin-dashboard')->with('error', 'Invalid status');
        }

        // Update the reservation status in the database
        $updateData = ['Status' => $status];
        $this->reservation->update($reservationID, $updateData);

        // Redirect to the reservation page or wherever appropriate
        return redirect()->to('/admin-hotel/reservation')->with('success', 'Reservation status updated successfully');
    }
    public function resReservation()
    {
        $data = [
            'adminRoutes' => 'restReservation',
            'restrevs' => $this->reservation
            ->select('reservations.ReservationID, restaurant_dining_tables.TableID, restaurant_dining_tables.TableNumber, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.Note, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, users.Address, reservations.UserID ')
            ->join ('restaurant_dining_tables', 'reservations.TableID = restaurant_dining_tables.TableID')
            ->join ('users', 'reservations.UserID = users.UserID')
            ->findAll()
        ]; 
        return view('Admin\Restaurant\reservation',$data);
    }
    public function addRestauReservation(){
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
                return redirect()->to(base_url('/admin-restaurant/reservation'))->with('success', 'Reservation added successfully.');
            } else {
                return redirect()->to(base_url('/admin-restaurant/reservation'))->with('error', 'Failed to add reservation. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Invalid Username, RoomType, or RoomNumber. Please check your input.');
        }
    }
    public function updateRestauReservation($reservationID)
    {
        helper(['form']);

        // Validation Rules (you can customize these based on your requirements)
        $validationRules = [
            
            'CheckInDate' => 'required',
            'TableNumber' => 'required',
            'Note' => 'required',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            // You might want to handle validation errors here
            return redirect()->to(base_url("/editReservation/{$reservationID}"))->with('validationErrors', $validationErrors);
        }


        
        $inputTableNumber = $this->request->getPost('TableNumber');

        $tableData = $this->tables->where('TableNumber', $inputTableNumber)
                                ->first();

        // Update Reservation Data
        if ($tableData) {
                // Prepare Reservation Data
                $updateReservationData = [
                    'CheckInDate' => $this->request->getPost('CheckInDate'),
                    'Note' => $this->request->getPost('Note'),
                    'TableID' => $tableData['TableID'], // Use the RoomID from RoomType
                ];

        // Update Reservation
        $this->reservation->update($reservationID, $updateReservationData);

        // Redirect with appropriate message
        return redirect()->to(base_url('/admin-restaurant/reservation'))->with('success', 'Reservation updated successfully.');
        } else {
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Invalid RoomType or RoomNumber. Please check your input.');
        }
    }
    public function updateResStatus($status, $reservationID)
    {
        // Get the ReservationID from the request, assuming it's sent via POST
        $allowedStatuses = ['Confirm', 'Pending', 'Cancel'];
        if (!in_array($status, $allowedStatuses)) {
            // Handle invalid status (you may redirect or show an error message)
            return redirect()->back('/admin-dashboard')->with('error', 'Invalid status');
        }

        // Update the reservation status in the database
        $updateData = ['Status' => $status];
        $this->reservation->update($reservationID, $updateData);

        // Redirect to the reservation page or wherever appropriate
        return redirect()->to('/admin-restaurant/reservation')->with('success', 'Reservation status updated successfully');
    }
    public function conReservation()
    {
        $data = [
            'adminRoutes' => 'conReservation',
            'reevents' => $this->reservation
            ->select('reservations.ReservationID, events.EventID, events.EventName, events.EventType, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.Note, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, users.Email, users.Address, reservations.UserID ')
            ->join ('events', 'reservations.EventID = events.EventID')
            ->join ('users', 'reservations.UserID = users.UserID')
            ->findAll()
        ]; 
        return view('Admin\Convention\reservation',$data);
    }
    public function addConReservation()
    {
        helper(['form']);

        // Validation Rules
        $validationRules = [
            'FirstName' => 'required',
            'LastName' => 'required',
            'Email' => 'required',
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
                return redirect()->to(base_url('/admin-convention/reservation'))->with('success', 'Reservation added successfully.');
            } else {
                return redirect()->to(base_url('/admin-convention/reservation'))->with('error', 'Failed to add reservation. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Invalid Username, RoomType, or RoomNumber. Please check your input.');
        }
    }
    public function updateConReservation($reservationID)
    {
        helper(['form']);

        // Validation Rules (you can customize these based on your requirements)
        $validationRules = [
            'EventType' => 'required',
            'CheckInDate' => 'required',
            'NumberOfGuests' => 'required',
            'Note' => 'required',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            // You might want to handle validation errors here
            return redirect()->to(base_url("/editReservation/{$reservationID}"))->with('validationErrors', $validationErrors);
        }


        
        $inputEventType = $this->request->getPost('EventType');

        $eventData = $this->events->where('EventType', $inputEventType)
                                ->first();

        // Update Reservation Data
        if ($eventData) {
                // Prepare Reservation Data
                $updateReservationData = [
                    'CheckInDate' => $this->request->getPost('CheckInDate'),
                    'NumberOfGuests' => $this->request->getPost('NumberOfGuests'),
                    'Note' => $this->request->getPost('Note'),
                    'EventID' => $eventData['EventID'], // Use the RoomID from RoomType
                ];

        // Update Reservation
        $this->reservation->update($reservationID, $updateReservationData);

        // Redirect with appropriate message
        return redirect()->to(base_url('/admin-convention/reservation'))->with('success', 'Reservation updated successfully.');
        } else {
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Invalid RoomType or RoomNumber. Please check your input.');
        }
    }
    public function updateconStatus($status, $reservationID)
    {
        // Get the ReservationID from the request, assuming it's sent via POST
        $allowedStatuses = ['Confirm', 'Pending', 'Cancel'];
        if (!in_array($status, $allowedStatuses)) {
            // Handle invalid status (you may redirect or show an error message)
            return redirect()->back('/admin-dashboard')->with('error', 'Invalid status');
        }

        // Update the reservation status in the database
        $updateData = ['Status' => $status];
        $this->reservation->update($reservationID, $updateData);

        // Redirect to the reservation page or wherever appropriate
        return redirect()->to('/admin-convention/reservation')->with('success', 'Reservation status updated successfully');
    }
    public function staffAccounts()
    {
        $data = [
            'adminRoutes' => 'staffAccount',
            'staffs' => $this->staffDetail
            ->select('staff_details.StaffDetailsID, departments.DepartmentID, departments.DepartmentName, users.UserID,  users.FirstName,  users.LastName, users.Email, users.ContactNumber, users.Address')
            ->join ('departments', 'staff_details.DepartmentID = departments.DepartmentID')
            ->join ('users', 'staff_details.UserID = users.UserID')
            ->findAll()
        ]; 
        return view('Admin\staffAccount',$data);
    }
    public function addStaffDetails()
    {
        helper(['form']);

        // Validation Rules
        $validationRules = [
            'FirstName' => 'required|min_length[4]|max_length[100]',
            'LastName' => 'required|min_length[4]|max_length[100]',
            'Email' => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.Email]',
            'Password' => 'required|min_length[4]|max_length[50]',
            'ContactNumber' => 'required|max_length[11]',
            'Address' => 'required|min_length[4]|max_length[100]',
            'confirmPassword' => 'matches[Password]',
            'DepartmentName'=> 'required',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return view('/admin-dashboard', ['validationErrors' => $validationErrors]);
        }

        // Use a single query to get the user based on both first name and last name
        $user = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'Email' => $this->request->getVar('Email'),
            'Password' => password_hash($this->request->getVar('Password'), PASSWORD_DEFAULT),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
            'Address' => $this->request->getVar('Address'),
            'UserRoleID' => 2,
        ];

        // Additional checks and modifications
        if (empty($user['FirstName']) || empty($user['LastName']) || empty($user['Email'])) {
            // Handle the case where essential user details are missing
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Incomplete user details. Please provide all required information.');
        }

        // Check if the email is unique
        if (!$this->isEmailUnique($user['Email'])) {
            // Handle the case where the email is not unique
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Email address is already in use. Please choose a different one.');
        }

        // Insert the user into the database
        $insertedUserID = $this->users->insert($user);

        // Retrieve Room Data
        $inputDepartmentName = $this->request->getPost('DepartmentName');

        $staffDataByType = $this->department->where('DepartmentName', $inputDepartmentName)->first();

        // Check both conditions for staffData
        if ($staffDataByType && $insertedUserID) {
            // Prepare Staff Data
            $newStaffData = [
                'DepartmentID' => $staffDataByType['DepartmentID'],
                'UserID' => $insertedUserID,
            ];

            // Insert Staff Details
            $insertedStaffID = $this->staffDetail->insert($newStaffData);

            // Retrieve the inserted staff details
            $insertedStaffDetails = $this->staffDetail->find($insertedStaffID);

            // Redirect with appropriate message and staff details
            if ($insertedStaffID) {
                return redirect()->to(base_url('/admin-staffaccounts'))->with('success', 'Reservation added successfully.')->with('staffDetails', $insertedStaffDetails);
            } else {
                return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Failed to add reservation. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Invalid Username, RoomType, or RoomNumber. Please check your input.');
        }
    }

    // Function to check if the email is unique
    private function isEmailUnique($email)
    {
        $existingUser = $this->users->where('Email', $email)->first();
        return empty($existingUser);
    }
    public function updateStaffDetails($userID)
    {
        helper(['form']);

        // Validation Rules
        $validationRules = [
            'FirstName' => 'required|min_length[4]|max_length[100]',
            'LastName' => 'required|min_length[4]|max_length[100]',
            'Email' => 'required|min_length[4]|max_length[100]|valid_email',
            'ContactNumber' => 'required|max_length[11]',
            'Address' => 'required|min_length[4]|max_length[100]',
            'DepartmentName' => 'required',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return view('/admin-dashboard', ['validationErrors' => $validationErrors]);
        }

        // Retrieve Room Data
        $inputDepartmentName = $this->request->getPost('DepartmentName');
        $staffDataByType = $this->department->where('DepartmentName', $inputDepartmentName)->first();

        // Check if the department exists
        if (!$staffDataByType) {
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Invalid DepartmentName. Please check your input.');
        }

        // Prepare Updated Staff Data
        $updatedStaffData = [
            'DepartmentID' => $staffDataByType['DepartmentID'],
            'UserID' => $userID,
        ];

        // Update Staff Details
        $this->staffDetail->update($userID, $updatedStaffData);

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
        return redirect()->to(base_url('/admin-staffaccounts'))->with('success', 'Staff details updated successfully.')->with('staffData', $staffDataByType);
    }
    public function feedback()
    {
        $data = [
            'adminRoutes' => 'feedback',
            'feedbacks' => $this->feedbacks
            ->select('feedback.FeedbackID,feedback.FeedbackMessage, users.UserID, users.Email')
            ->join ('users', 'feedback.UserID = users.UserID')
            ->findAll()
        ];
        return view('Admin\feedback', $data);
    }

}
