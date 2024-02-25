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
use App\Models\ChatModel;
use App\Traits\EmailTrait;

class AdminController extends BaseController
{
    use EmailTrait;
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
    private $chat;
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
        $this->chat = new ChatModel();
    }
    public function index()
    {
        //
    }
    public function login(){
        helper(['form']);
        $data = [
            'activePage' => 'AdminLogin',
        ];
        return view('AdminLogin',$data);
    }
    public function LoginAuth()
    {
        $session = session();
        $email = $this->request->getVar('Email');
        $password = $this->request->getVar('Password');

        // Retrieve user data from the database based on the provided email
        $data = $this->users->where('Email', $email)->first();

        if ($data) {
            // Verify the provided password against the hashed password in the database
            $pass = $data['Password'];
            $authenticatedPassword = password_verify($password, $pass);
    
            if ($authenticatedPassword) {
                // Check if user is verified
                if ($data['is_verified'] == 0) {
                    // User is not verified, set flash data and redirect to login with error message
                    $session->setFlashdata('msg', 'Account is not verified. Please check your email.');
                    return redirect()->to('/login');
                }
    
                // User is verified, proceed with setting session data
                $ses_data = [
                    'id' => $data['UserID'],
                    'username' => $data['Email'],
                    'firstname' => $data['FirstName'],
                    'lastname' => $data['LastName'],
                    'contact' => $data['ContactNumber'],
                    'isLoggedIn' => true,
                    'userRole' => $data['UserRoleID'],
                    'address' => $data['Region'] . ', ' . $data['Province'] . ', ' . $data['City'] . ', ' . $data['Barangay'],
                ];
    
                $session->set($ses_data);

                // Redirect based on user role, staff details, and admin
                if ($data['UserRoleID'] == 1) {
                    // Guest role, redirect to home
                    return redirect()->to('/');
                } elseif ($data['UserRoleID'] == 2) {
                    // Staff role, redirect to the appropriate portal
                    $staffDetails = $this->staffDetail->where('UserID', $data['UserID'])->first();

                    if ($staffDetails) {
                        // Redirect to the corresponding staff portal based on DepartmentID
                        switch ($staffDetails['DepartmentID']) {
                            case 1:
                                return redirect()->to('/staff-convention');
                            case 2:
                                return redirect()->to('/staff-hotel');
                            case 3:
                                return redirect()->to('/staff-restaurant');
                            case 4:
                                return redirect()->to('/staff-inventory');
                            default:
                                // Handle unexpected DepartmentID
                                return redirect()->to('/');
                        }
                    } else {
                        // Handle missing staff details
                        return redirect()->to('/');
                    }
                } elseif ($data['UserRoleID'] == 3) {
                    // Admin role, redirect to admin dashboard
                    $adminDetails = $this->admin->where('UserID', $data['UserID'])->first();

                    if ($adminDetails) {
                        // Redirect to the corresponding admin portal based on AdminID
                        switch ($adminDetails['AdminID']) {
                            case 1:
                                return redirect()->to('/admin-dashboard');
                            default:
                                // Handle unexpected AdminID
                                return redirect()->to('/');
                        }
                    } else {
                        // Handle missing admin details
                        return redirect()->to('/adminlogin');
                    }
                }
            } else {
                // Incorrect password
                $session->setFlashdata('msg', 'Password is incorrect');
                return redirect()->to('/adminlogin');
            }
        } else {
            // Email not found
            $session->setFlashdata('msg', 'Email does not exist');
            return redirect()->to('/admin-login');
        }
    }
    public function logout()
    {
        $session = session();
        $session->destroy(); // Destroy the user's session
        return redirect()->to('/admin-login'); // Redirect the user to the login page or any other page after logout
    }
    public function dashboard()
    {
        $data = [
            'adminRoutes' => 'dashboard',
            'customers' => $this->guest
            ->select('guest.GuestID, guest.Status, users.UserID, users.FirstName, users.LastName, users.Email, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address', false)
            ->join ('users', 'guest.UserID = users.UserID')
            ->findAll(),
            'hotelrevs' => $this->reservation
    ->select('reservations.ReservationID, rooms.RoomID, rooms.RoomNumber, rooms.RoomType, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.ReferenceNumber, reservations.TotalAmount, reservations.Status, users.UserID, users.FirstName, users.LastName, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address, reservations.UserID', false)
    ->join('rooms', 'reservations.RoomID = rooms.RoomID')
    ->join('users', 'reservations.UserID = users.UserID')
    ->findAll(),



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
            ->select('reservations.ReservationID, rooms.RoomID, rooms.RoomNumber, rooms.RoomType, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.ReferenceNumber, reservations.downorfullPayment, reservations.TotalAmount, reservations.Status, users.UserID, users.FirstName, users.LastName, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address, reservations.UserID', false)
            ->join('rooms', 'reservations.RoomID = rooms.RoomID')
            ->join('users', 'reservations.UserID = users.UserID')
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
            'downorfullPayment' => 'required',
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
                'downorfullPayment' => $this->request->getPost('downorfullPayment'),
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
            'downorfullPayment' => 'required|numeric',
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
                    'downorfullPayment' => $this->request->getPost('downorfullPayment'),
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
        $session = session();
        $allowedStatuses = ['Confirm', 'Pending', 'Cancel'];
    
        if (!in_array($status, $allowedStatuses)) {
            // Handle invalid status
            return redirect()->back()->with('error', 'Invalid status');
        }
    
        // Retrieve the reservation and associated user's email address
        $reservation = $this->reservation
                             ->where('ReservationID', $reservationID)
                             ->first();
    
        if (!$reservation) {
            // Handle case where reservation doesn't exist
            return redirect()->back()->with('error', 'Reservation not found');
        }
    
        // Retrieve user data based on UserID from the reservation
        $user = $this->users
                     ->where('UserID', $reservation['UserID'])
                     ->first();
    
        if (!$user) {
            // Handle case where user doesn't exist
            return redirect()->back()->with('error', 'User not found for the reservation');
        }
    
        // Update the reservation status in the database
        $updateData = ['Status' => $status];
        $updated = $this->reservation->update($reservationID, $updateData);
    
        if ($updated) {
         // Prepare the email message with reservation details
        $emailMessage = "Dear customer,<br><br>";
        $emailMessage .= "Your reservation status has been updated to: <strong style='color:" . ($status == 'Confirm' ? 'green' : 'red') . ";'>{$status}</strong>.<br>";
        $emailMessage .= "Reservation ID: {$reservation['ReservationID']}<br>";
        $emailMessage .= "Check-In Date: {$reservation['CheckInDate']}<br>";
        $emailMessage .= "Check-Out Date: {$reservation['CheckOutDate']}<br>";
        $emailMessage .= "Number of Guests: {$reservation['NumberOfGuests']}<br>";
        $emailMessage .= "Total Amount: {$reservation['TotalAmount']}<br>";
        $emailMessage .= "If you have any questions, please contact us.<br>";

    
            // Send the email to the user
            $this->sendEmail($user['Email'], 'Reservation Status Updated', $emailMessage);
            $fcmToken = $user['fcm_token'];
            if (!empty($fcmToken)) {
                $notifTitle = 'Reservation Status Updated';
                $notifBody = "Your reservation status has been updated to {$status}.";
                $this->sendPushNotification($fcmToken, $notifTitle, $notifBody);
            }
            // Redirect to the reservation page with a success message
            $session->setFlashdata('success', 'Reservation status updated successfully and email sent.');
            return redirect()->to('/admin-hotel/reservation');
        } else {
            // Handle case where update fails
            return redirect()->back()->with('error', 'Failed to update reservation status');
        }
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
    
    public function resReservation()
    {
        $data = [
            'adminRoutes' => 'restReservation',
            'restrevs' => $this->reservation
            ->select('reservations.ReservationID, restaurant_dining_tables.TableID, restaurant_dining_tables.Venue, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.Note, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, users.Address, reservations.UserID ')
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
            'Venue' => 'required',
            'Note' => 'required',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            // You might want to handle validation errors here
            return redirect()->to(base_url("/editReservation/{$reservationID}"))->with('validationErrors', $validationErrors);
        }


        
        $inputTableNumber = $this->request->getPost('Venue');

        $tableData = $this->tables->where('Venue', $inputTableNumber)
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
    public function rate()
    {
        
        $data = [
            'adminRoutes' => 'rate',
            
        ];
    
        return view('Admin/rate', $data);
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

    public function chat()
    {
        
        $data = [
            'adminRoutes' => 'chat',
            'chats' => $this->chat->findAll()
        ];
    
        // Load the view with the data
        return view('Admin/chat', $data);
    }
    public function addChat(){
        helper(['form']);

        // Validation Rules
        $validationRules = [
            'Question' => 'required',
            'Answer' => 'required',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return view('/bookroom', ['validationErrors' => $validationErrors]);
        }


       
            $newReservationData = [
                'Question' => $this->request->getPost('Question'),
                'Answer' => $this->request->getPost('Answer'),
            ];

            // Insert Reservation
            $inserted = $this->chat->insert($newReservationData);

            // Redirect with appropriate message
            if ($inserted) {
                return redirect()->to(base_url('/admin-chat'))->with('success', 'Reservation added successfully.');
            } else {
                return redirect()->to(base_url('/admin-chat'))->with('error', 'Failed to add reservation. Please try again.');
            }
    }
    public function updateChat($ChatID)
    {
        helper(['form']);

        // Validation Rules (you can customize these based on your requirements)
        $validationRules = [
            'Question' => 'required',
            'Answer' => 'required',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            // You might want to handle validation errors here
            return redirect()->to(base_url("/editReservation/{$ChatID}"))->with('validationErrors', $validationErrors);
        }


                // Prepare Reservation Data
                $updateReservationData = [
                    'Question' => $this->request->getPost('Question'),
                    'Answer' => $this->request->getPost('Answer'),
                ];

        // Update Reservation
        $this->chat->update($ChatID, $updateReservationData);

        // Redirect with appropriate message
        return redirect()->to(base_url('/admin-chat'))->with('success', 'Reservation updated successfully.');
    }

    
    public function holService()
    {
        $data = [
            'adminRoutes' => 'holService',
            'rooms' => $this->rooms->findAll(),
        ];
    
        // Load the view with the data
        return view('Admin/Hotel/service', $data);
    }
    public function addserviceRoom(){
        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'RoomNumber' => $this->request->getVar('RoomNumber'),
                'RoomType' => $this->request->getVar('RoomType'),
                'Description' => $this->request->getVar('Description'),
                'PricePerNight' => $this->request->getVar('PricePerNight'),
                'AvailabilityStatus' => $this->request->getVar('AvailabilityStatus'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'uploads/', $newFileName)) {
                        // Save product data to the database
                        $this->rooms->save($data);
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
    
        return redirect()->to('/admin-hotel/service');
    }
    public function updateserviceRoom(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'RoomID' => $this->request->getVar('RoomID'),
                'RoomNumber' => $this->request->getVar('RoomNumber'),
                'RoomType' => $this->request->getVar('RoomType'),
                'Description' => $this->request->getVar('Description'),
                'PricePerNight' => $this->request->getVar('PricePerNight'),
                'AvailabilityStatus' => $this->request->getVar('AvailabilityStatus'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'uploads/', $newFileName)) {
                        // Save product data to the database
                        $this->rooms->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-hotel/service');
    }
    public function restService()
    {
        $data = [
            'adminRoutes' => 'restService',
            'tables' => $this->tables->findAll(),
        ];
    
        // Load the view with the data
        return view('Admin/Restaurant/service', $data);
    }
    public function addserviceTable(){
        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'TableID' => $this->request->getVar('TableID'),
                'Venue' => $this->request->getVar('Venue'),
                'AvailabilityStatus' => $this->request->getVar('AvailabilityStatus'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'uploads/', $newFileName)) {
                        // Save product data to the database
                        $this->tables->save($data);
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
    
        return redirect()->to('/admin-restaurant/service');
    }
    


    public function updateserviceTable(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'TableID' => $this->request->getVar('TableID'),
                'Venue' => $this->request->getVar('Venue'),
                'AvailabilityStatus' => $this->request->getVar('AvailabilityStatus'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'uploads/', $newFileName)) {
                        // Save product data to the database
                        $this->tables->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function conService()
    {
        $data = [
            'adminRoutes' => 'conService',
            'events' => $this->events->findAll(),
        ];
    
        // Load the view with the data
        return view('Admin/Convention/service', $data);
    }
    public function addserviceEvent(){
        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'RoomNumber' => $this->request->getVar('RoomNumber'),
                'EventType' => $this->request->getVar('EventType'),
                'Description' => $this->request->getVar('Description'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'uploads/', $newFileName)) {
                        // Save product data to the database
                        $this->events->save($data);
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
    
        return redirect()->to('/admin-convention/service');
    }
    public function updateserviceEvent(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'EventID' => $this->request->getVar('EventID'),
                'EventType' => $this->request->getVar('EventType'),
                'Description' => $this->request->getVar('Description'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'uploads/', $newFileName)) {
                        // Save product data to the database
                        $this->events->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-convention/service');
    }
     
    
    
}
