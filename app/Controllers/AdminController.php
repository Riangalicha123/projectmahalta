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
            ->select('reservations.ReservationID, rooms.RoomID, rooms.RoomType, rooms.RoomNumber, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.TotalAmount, reservations.ReferenceNumber, reservations.Status, users.UserID,  users.FirstName,  users.LastName, reservations.UserID ')
            ->join ('rooms', 'reservations.RoomID = rooms.RoomID')
            ->join ('users', 'reservations.UserID = users.UserID')
            ->findAll()
        ]; 
        return view('Admin\Hotel\reservation', $data);
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
            ->select('reservations.ReservationID, restaurant_dining_tables.TableID, restaurant_dining_tables.TableNumber, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.Note, reservations.Status, users.UserID,  users.FirstName,  users.LastName, users.ContactNumber, users.Address, reservations.UserID ')
            ->join ('restaurant_dining_tables', 'reservations.TableID = restaurant_dining_tables.TableID')
            ->join ('users', 'reservations.UserID = users.UserID')
            ->findAll()
        ]; 
        return view('Admin\Restaurant\reservation',$data);
    }
    public function updateresStatus($status, $reservationID)
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
            'conrevs' => $this->reservation
            ->select('reservations.ReservationID, events.EventID, events.EventType, reservations.CheckInDate, reservations.NumberOfGuests, reservations.Note, reservations.Status, users.UserID,  users.FirstName,  users.LastName, users.Email, users.ContactNumber, reservations.UserID ')
            ->join ('events', 'reservations.EventID = events.EventID')
            ->join ('users', 'reservations.UserID = users.UserID')
            ->findAll()
        ]; 
        return view('Admin\Convention\reservation',$data);
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

}
