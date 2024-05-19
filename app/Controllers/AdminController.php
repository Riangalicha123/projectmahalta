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
use App\Models\QrcodeModel;
use App\Models\MenuModel;
use App\Models\MenuProductModel;
use App\Models\MenuCategoryModel;
use App\Models\RestaurantVenueModel;
use App\Models\MenuProductIcedModel;
use App\Models\RegionModel;
use App\Models\ProvinceModel;
use App\Models\CityModel;
use App\Models\BarangayModel;
use App\Traits\EmailTrait;
use App\Models\ConventionVenueModel;
use App\Models\RoomImageModel;
use App\Models\RoomInventoryModel;
use App\Models\NewsModel;
use App\Models\ReservationAmenities;
use App\Models\ConventionModel;
use CodeIgniter\API\ResponseTrait;
use DateTime;

class AdminController extends BaseController
{
    use EmailTrait;
    use ResponseTrait;
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
    private $qr;
    private $menus;
    private $products;
    private $categories;
    private $venues;
    private $iced;
    private $regions;
    private $province;
    private $cities;
    private $barangay;
    private $convenues;
    private $roomimages;
    private $roominventory;
    private $news;
    private $reseraminities;
    private $conventions;
    function __construct()
    {
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
        $this->qr = new QrcodeModel();
        $this->menus = new MenuModel();
        $this->products = new MenuProductModel();
        $this->categories = new MenuCategoryModel();
        $this->venues = new RestaurantVenueModel();
        $this->iced = new MenuProductIcedModel();
        $this->regions = new RegionModel();
        $this->province = new ProvinceModel();
        $this->cities = new CityModel();
        $this->barangay = new BarangayModel();
        $this->convenues = new ConventionVenueModel();
        $this->roomimages = new RoomImageModel();
        $this->roominventory = new RoomInventoryModel();
        $this->news = new NewsModel();
        $this->reseraminities = new ReservationAmenities();
        $this->conventions = new ConventionModel();
    }
    public function index()
    {
        //
    }
    public function login()
    {
        helper(['form']);
        $data = [
            'activePage' => 'AdminLogin',
        ];
        return view('AdminLogin', $data);
    }
    public function LoginAuth()
    {
        $session = session();
        $email = $this->request->getVar('Email');
        $password = $this->request->getVar('Password');
        $data = $this->users->where('Email', $email)->first();
        if ($data) {
            $pass = $data['Password'];
            $authenticatedPassword = password_verify($password, $pass);
            if ($authenticatedPassword) {
                if ($data['is_verified'] == 0) {
                    $session->setFlashdata('msg', 'Account is not verified. Please check your email.');
                    return redirect()->to('/login');
                }
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
                if ($data['UserRoleID'] == 1) {
                    return redirect()->to('/');
                } elseif ($data['UserRoleID'] == 2) {
                    $staffDetails = $this->staffDetail->where('UserID', $data['UserID'])->first();

                    if ($staffDetails) {
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
                                return redirect()->to('/');
                        }
                    } else {
                        return redirect()->to('/');
                    }
                } elseif ($data['UserRoleID'] == 3) {
                    $adminDetails = $this->admin->where('UserID', $data['UserID'])->first();
                    if ($adminDetails) {
                        switch ($adminDetails['AdminID']) {
                            case 1:
                                return redirect()->to('/admin-dashboard');
                            default:
                                return redirect()->to('/');
                        }
                    } else {
                        return redirect()->to('/adminlogin');
                    }
                }
            } else {
                $session->setFlashdata('msg', 'Password is incorrect');
                return redirect()->to('/adminlogin');
            }
        } else {
            $session->setFlashdata('msg', 'Email does not exist');
            return redirect()->to('/admin-login');
        }
    }
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/admin-login');
    }
    public function dashboard()
    {
        // Initialize counts for positive, neutral, and negative ratings
        $positiveCount = 0;
        $neutralCount = 0;
        $negativeCount = 0;

        $feedbackData = $this->feedbacks->findAll();

        // Iterate through each feedback entry
        foreach ($feedbackData as $feedback) {
            // Categorize ratings
            switch ($feedback['UserRating']) {
                case '1':
                case '2':
                    $negativeCount++;
                    break;
                case '3':
                    $neutralCount++;
                    break;
                case '4':
                case '5':
                    $positiveCount++;
                    break;
            }
        }

        // Compute total number of ratings
        $totalRating = count($feedbackData);

        // Compute percentages
        $positivePercentage = ($positiveCount / $totalRating) * 100;
        $neutralPercentage = ($neutralCount / $totalRating) * 100;
        $negativePercentage = ($negativeCount / $totalRating) * 100;

        $roomreservations = $this->reservation->select('reservations.RoomID, rooms.RoomType, MONTH(reservations.CheckInDate) AS CheckInMonth, YEAR(reservations.CheckInDate) AS CheckInYear, COUNT(*) AS ReservationCount')
                                         ->join('rooms', 'reservations.RoomID = rooms.RoomID')
                                         ->where('reservations.Status', 'Confirm')
                                         ->where('reservations.RoomID IS NOT NULL', null, false)
                                         ->groupBy('reservations.RoomID, rooms.RoomType, CheckInMonth, CheckInYear')
                                         ->findAll();
    

        $regions = $this->regions->findAll();
        $data = [
            'adminRoutes' => 'dashboard',
            'roinvents' => $this->roominventory->findAll(),
            'regions' => $regions,
            'customers' => $this->guest
                ->select('guest.GuestID, users.UserID, users.FirstName, users.LastName, users.Email, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address', false)
                ->join('users', 'guest.UserID = users.UserID')
                ->findAll(),
            'hotelrevs' => $this->reservation
                ->select('reservations.ReservationID, rooms.RoomID, rooms.RoomNumber, rooms.RoomType, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests,reservations.PaymentOption,reservations.ReferenceNumber,reservations.Adult,reservations.Child, reservations.downorfullPayment,reservations.Image, reservations.TotalAmount, reservations.Status, users.UserID, users.FirstName, users.LastName, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address', false)
                ->join('rooms', 'reservations.RoomID = rooms.RoomID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->where('reservations.Status', 'Confirm')
                ->findAll(),
            'reevents' => $this->reservation
                ->select('reservations.ReservationID, convention.conventionID, convention.conVenueID, convention_venue.conVenueID, convention_venue.conVenueName, convention_venue.minGuest, convention_venue.maxGuest, convention_venue.Image as venue_image, convention.EventID, events.EventType, events.Description as event_description, events.Image as event_image, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.PaymentOption, reservations.ReferenceNumber, reservations.downorfullPayment, reservations.TotalAmount, reservations.Image as reservation_image, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, users.Email, reservations.UserID')
                ->join('convention', 'reservations.conventionID = convention.conventionID')
                ->join('convention_venue', 'convention.conVenueID = convention_venue.conVenueID')
                ->join('events', 'convention.EventID = events.EventID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->where('reservations.Status', 'Confirm')
                ->findAll(),
            'restrevs' => $this->reservation
                ->select('reservations.ReservationID, restaurant_venue.VenueID, restaurant_venue.VenueName, reservations.ArivalDate,reservations.ArivalTime, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.Note, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address, reservations.UserID ')
                ->join('restaurant_venue', 'reservations.VenueID = restaurant_venue.VenueID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->where('reservations.Status', 'Confirm')
                ->findAll(),
            'reseraminities' => $this->reseraminities
                ->select('reservations.ReservationID, reservations.CheckOutDate, reservations.UserID, room_inventory.roomInventoryID, room_inventory.ProductName, reservation_amenities.AmenitiesID, reservation_amenities.InsertQuantity')
                ->join('reservations', 'reservation_amenities.ReservationID = reservations.ReservationID')
                ->join('users', 'reservation_amenities.UserID = users.UserID')
                ->join('room_inventory', 'reservation_amenities.roomInventoryID = room_inventory.roomInventoryID')
                ->where('reservations.Status', 'Confirm')
                ->findAll(),
            'feedback' => $this->feedbacks->findAll(),
            'positivePercentage' => $positivePercentage,
            'neutralPercentage' => $neutralPercentage,
            'negativePercentage' => $negativePercentage,
            'roomreservations' => $roomreservations,
            'roomTypes' => $this->rooms->getRoomTypes(),
        ];
        return view('Admin\index', $data);
    }
    public function getReservationData()
    {
        $year = $this->request->getPost('year');
        $reservations = $this->reservation->where('YEAR(CheckInDate)', $year)
                                        ->findAll();
        echo json_encode($reservations);
    }
    public function getReservationByYear()
    {
        // Kunin ang taon mula sa POST request
        $selectedYear = $this->request->getPost('selectedYear');

        // Query para sa mga reservation base sa hiniling na taon
        $roomreservations = $this->reservation->select('reservations.RoomID, rooms.RoomType, MONTH(reservations.CheckInDate) AS CheckInMonth, COUNT(*) AS ReservationCount')
                                            ->join('rooms', 'reservations.RoomID = rooms.RoomID')
                                            ->where('YEAR(reservations.CheckInDate)', $selectedYear)
                                            ->where('reservations.Status', 'Confirm')
                                            ->where('reservations.RoomID IS NOT NULL', null, false)
                                            ->groupBy('reservations.RoomID, rooms.RoomType, CheckInMonth')
                                            ->findAll();

        // Ipasa ang mga reservation data pabalik sa View
        $data['roomreservations'] = $roomreservations;

        // Ibalik ang data sa JSON format
        return $this->response->setJSON($data);
    }
    public function getMonthlyData()
    {
        $year = $this->request->getPost('year');
        $data = $this->reseraminities->getMonthlyInventoryData($year);

        return $this->response->setJSON($data);
    }
    
    public function customer()
    {
        $data = [
            'adminRoutes' => 'customer',
            'guests' => $this->guest
                ->select('guest.GuestID, users.UserID,  users.FirstName,  users.LastName, users.Email, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address')
                ->join('users', 'guest.UserID = users.UserID')
                ->findAll()
        ];
        return view('Admin\customer', $data);
    }
    public function addCustomer()
    {
        helper(['form']);
        $validationRules = [
            'FirstName' => 'required|min_length[4]|max_length[100]',
            'LastName' => 'required|min_length[4]|max_length[100]',
            'Email' => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.Email]',
            'ContactNumber' => 'required|max_length[11]',
            'Address' => 'required|min_length[4]|max_length[100]',
            'confirmPassword' => 'matches[Password]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return view('/admin-dashboard', ['validationErrors' => $validationErrors]);
        }
        $user = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'Email' => $this->request->getVar('Email'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
            'Address' => $this->request->getVar('Address'),
            'UserRoleID' => 1,
            'verification_token' => bin2hex(random_bytes(16)),
            'is_verified' => 1,
        ];
        if (empty($user['FirstName']) || empty($user['LastName']) || empty($user['Email'])) {
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Incomplete user details. Please provide all required information.');
        }
        if (!$this->isEmailUnique($user['Email'])) {
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Email address is already in use. Please choose a different one.');
        }
        $insertedUserID = $this->users->insert($user);
        if ($insertedUserID) {
            $newGuestData = [
                'UserID' => $insertedUserID,
            ];
            $insertedGuestID = $this->guest->insert($newGuestData);
            $insertedGuestDetails = $this->guest->find($insertedGuestID);
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
                ->select('reservations.ReservationID, rooms.RoomID, rooms.RoomNumber, rooms.RoomType, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests,reservations.PaymentOption,reservations.ReferenceNumber,reservations.Adult,reservations.Child, reservations.downorfullPayment,reservations.Image, reservations.TotalAmount, reservations.Status, users.UserID, users.FirstName, users.LastName, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address', false)
                ->join('rooms', 'reservations.RoomID = rooms.RoomID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->findAll(),
                'regions' => $this->regions->findAll(),
        ];
        return view('Admin\Hotel\reservation', $data);
    }
    public function addHotelReservation()
    {
        helper(['form']);
    
        // Retrieve and map region, province, city, and barangay descriptions
        $regionCode = $this->request->getVar('Region');
        $provinceCode = $this->request->getVar('Province');
        $cityCode = $this->request->getVar('City');
        $barangayCode = $this->request->getVar('Barangay');
    
        $regionDesc = $this->regions->where('regCode', $regionCode)->first()['regDesc'] ?? '';
        $provinceDesc = $this->province->where('provCode', $provinceCode)->first()['provDesc'] ?? '';
        $cityDesc = $this->cities->where('citymunCode', $cityCode)->first()['citymunDesc'] ?? '';
        $barangayDesc = $this->barangay->where('brgyCode', $barangayCode)->first()['brgyDesc'] ?? '';
    
        // Construct user data
        $userData = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
            'Region' => $regionDesc,
            'Province' => $provinceDesc,
            'City' => $cityDesc,
            'Barangay' => $barangayDesc,
            'UserRoleID' => 1,
            'verification_token' => bin2hex(random_bytes(16)),
            'is_verified' => 1,
        ];
    
        // Insert user data into the database and retrieve the new UserID
        $UserID = $this->users->insert($userData, true);  // The second parameter 'true' retrieves the insert ID
    
        if ($UserID) {
            $guestData = [
                'UserID' => $UserID,
            ];
            $this->guest->insert($guestData);

            // Retrieve Room Data
            $inputRoomType = $this->request->getPost('RoomType');
            $inputRoomNumber = $this->request->getPost('RoomNumber');
    
            $roomDataByType = $this->rooms->where('RoomType', $inputRoomType)->first();
            $roomDataByNumber = $this->rooms->where('RoomNumber', $inputRoomNumber)->first();
    
            // Check both conditions for roomData
            if ($roomDataByType && $roomDataByNumber) {
                // Prepare Reservation Data
                $newReservationData = [
                    'CheckInDate' => $this->request->getPost('CheckInDate'),
                    'CheckOutDate' => $this->request->getPost('CheckOutDate'),
                    'Adult' => $this->request->getPost('Adult'),
                    'Child' => $this->request->getPost('Child'),
                    'TotalAmount' => $this->request->getPost('TotalAmount'),
                    'downorfullPayment' => $this->request->getPost('downorfullPayment'),
                    'ReferenceNumber' => $this->request->getPost('ReferenceNumber'),
                    'PaymentOption' => $this->request->getPost('PaymentOption'),
                    'Status' => 'Confirm',
                    'RoomID' => $roomDataByType['RoomID'], 
                    'UserID' => $UserID, 
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
                return redirect()->to(base_url('/admin-hotel'))->with('error', 'Invalid RoomType or RoomNumber. Please check your input.');
            }
        } else {
            return redirect()->to(base_url('/admin-hotel'))->with('error', 'Failed to create user. Please try again.');
        }
    }    
    public function updateHotelReservation($reservationID)
    {
        helper(['form']);
        
        // Retrieve user data from the request
        $userData = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
        ];
        
        // Retrieve the existing reservation to get the UserID
        $reservation = $this->reservation->find($reservationID);
        if (!$reservation) {
            return redirect()->to(base_url('/admin-hotel/reservation'))->with('error', 'Reservation not found.');
        }
    
        $userID = $reservation['UserID'];
        
        // Update user data in the database
        $updateUserResult = $this->users->update($userID, $userData);
    
        if ($updateUserResult) {
            // Retrieve room data from the request
            $inputRoomType = $this->request->getPost('RoomType');
            $inputRoomNumber = $this->request->getPost('RoomNumber');
            
            // Find the room data by type and number
            $roomDataByType = $this->rooms->where('RoomType', $inputRoomType)->first();
            $roomDataByNumber = $this->rooms->where('RoomNumber', $inputRoomNumber)->first();
            
            // Check if both room type and number are valid and match
            if ($roomDataByType && $roomDataByNumber && $roomDataByType['RoomID'] === $roomDataByNumber['RoomID']) {
                // Prepare the new reservation data
                $newReservationData = [
                    'CheckInDate' => $this->request->getPost('CheckInDate'),
                    'CheckOutDate' => $this->request->getPost('CheckOutDate'),
                    'Adult' => $this->request->getPost('Adult'),
                    'Child' => $this->request->getPost('Child'),
                    'TotalAmount' => $this->request->getPost('TotalAmount'),
                    'downorfullPayment' => $this->request->getPost('downorfullPayment'),
                    'ReferenceNumber' => $this->request->getPost('ReferenceNumber'),
                    'PaymentOption' => $this->request->getPost('PaymentOption'),
                    'Status' => 'Confirm',
                    'RoomID' => $roomDataByType['RoomID'],
                    'UserID' => $userID,
                ];
                
                // Update the reservation
                $updateReservationResult = $this->reservation->update($reservationID, $newReservationData);
                
                if ($updateReservationResult) {
                    return redirect()->to(base_url('/admin-hotel/reservation'))->with('success', 'Reservation updated successfully.');
                } else {
                    return redirect()->to(base_url('/admin-hotel/reservation'))->with('error', 'Failed to update reservation. Please try again.');
                }
            } else {
                return redirect()->to(base_url('/admin-hotel'))->with('error', 'Invalid RoomType or RoomNumber. Please check your input.');
            }
        } else {
            return redirect()->to(base_url('/admin-hotel'))->with('error', 'Failed to update user information. Please try again.');
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
            $emailMessage .= "Adult: {$reservation['Adult']}<br>";
            $emailMessage .= "Kid: {$reservation['Child']}<br>";
            $emailMessage .= "Payment Option: {$reservation['PaymentOption']}<br>";
            $emailMessage .= "ReferenceNumber: {$reservation['ReferenceNumber']}<br>";
            $emailMessage .= "Down or Full Payment: {$reservation['downorfullPayment']}<br>";
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

        // Log or handle the response as needed
    }
    public function resReservation()
    {
        $data = [
            'adminRoutes' => 'restReservation',
            'restrevs' => $this->reservation
                ->select('reservations.ReservationID, restaurant_venue.VenueID, restaurant_venue.VenueName, reservations.ArivalDate,reservations.ArivalTime, reservations.CheckInDate, reservations.NumberOfGuests, reservations.Note, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address, reservations.UserID ')
                ->join('restaurant_venue', 'reservations.VenueID = restaurant_venue.VenueID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->findAll()
        ];
        return view('Admin\Restaurant\reservation', $data);
    }
    public function addRestauReservation()
    {
        helper(['form']);
        // Construct user data
        $userData = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
            'verification_token' => bin2hex(random_bytes(16)),
            'is_verified' => 1,
        ];
    
        // Insert user data into the database and retrieve the new UserID
        $UserID = $this->users->insert($userData, true);  // The second parameter 'true' retrieves the insert ID
    
        if ($UserID) {
            $guestData = [
                'UserID' => $UserID,
            ];
            $this->guest->insert($guestData);
            $VenueName = $this->request->getPost('VenueName');
            $restaurantVenue = $this->venues->where('VenueName', $VenueName)->first();
    
            if ($restaurantVenue ) {
                $availableCapacity = $restaurantVenue['AvailableCapacity'];
                $numberOfGuests = $this->request->getPost('NumberOfGuests');
    
                if ($availableCapacity >= $numberOfGuests) {
                    $newAvailableCapacity = $availableCapacity - $numberOfGuests;
                    $this->venues->update($restaurantVenue['VenueID'], ['AvailableCapacity' => $newAvailableCapacity]);
    
                    $restaurantReservation = [
                        'NumberOfGuests' => $numberOfGuests,
                        'CheckInDate' => $this->request->getPost('CheckInDate'),
                        'Note' => $this->request->getPost('Note'),
                        'Status' => 'Confirm',
                        'VenueName' => $VenueName,
                        'VenueID' => $restaurantVenue['VenueID'],
                        'UserID' => $UserID,
                    ];
    
                    $inserted = $this->reservation->insert($restaurantReservation);
    
                    if ($inserted) {
                        return redirect()->to(base_url('/admin-restaurant/reservation'))->with('success', 'Reservation updated successfully.');
                    } else {
                        return redirect()->to(base_url('/admin-restaurant/reservation'))->with('error', 'Failed to add reservation. Please try again.');
                    }
                } else {
                    return redirect()->to(base_url('/admin-restaurant/reservation'))->with('error', 'Not enough available capacity. Please select a different venue or reduce the number of guests.');
                }
            } else {
                return redirect()->to(base_url('/admin-restaurant/reservation'))->with('error', 'Invalid user or venue information. Please check your input.');
            }
    
        } else {
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Failed to create user. Please try again.');
        }
    }
    public function updateRestauReservation($reservationID)
    {
        helper(['form']);
    
        // Validation Rules (you can customize these based on your requirements)
        $userData = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
        ];
        
        // Retrieve the existing reservation to get the UserID
        $reservation = $this->reservation->find($reservationID);
        if (!$reservation) {
            return redirect()->to(base_url('/admin-restaurant/reservation'))->with('error', 'Reservation not found.');
        }
    
        $userID = $reservation['UserID'];
        
        // Update user data in the database
        $updateUserResult = $this->users->update($userID, $userData);
    
        if ($updateUserResult) {
            $VenueName = $this->request->getPost('VenueName');
            $restaurantVenue = $this->venues->where('VenueName', $VenueName)->first();
    
            if ($restaurantVenue) {
                $availableCapacity = $restaurantVenue['AvailableCapacity'];
                $numberOfGuests = $this->request->getPost('NumberOfGuests');
    
                if ($availableCapacity >= $numberOfGuests) {
                    // Calculate new available capacity
                    $newAvailableCapacity = $availableCapacity - $numberOfGuests;
    
                    // Update the venue's available capacity
                    $this->venues->update($restaurantVenue['VenueID'], ['AvailableCapacity' => $newAvailableCapacity]);
    
                    // Prepare data to update the reservation
                    $restaurantReservation = [
                        'NumberOfGuests' => $numberOfGuests,
                        'CheckInDate' => $this->request->getPost('CheckInDate'),
                        'Note' => $this->request->getPost('Note'),
                        'Status' => 'Confirm', // Fixed typo here
                        'VenueName' => $VenueName,
                        'VenueID' => $restaurantVenue['VenueID'],
                        'UserID' => $userID,
                    ];
    
                    // Update the reservation in the database
                    $updated = $this->reservation->update($reservationID, $restaurantReservation);
    
                    if ($updated) {
                        return redirect()->to(base_url('/admin-restaurant/reservation'))->with('success', 'Reservation updated successfully.');
                    } else {
                        // Roll back the venue capacity update in case of reservation update failure
                        $this->venues->update($restaurantVenue['VenueID'], ['AvailableCapacity' => $availableCapacity]);
                        return redirect()->to(base_url('/admin-restaurant/reservation'))->with('error', 'Failed to update reservation. Please try again.');
                    }
                } else {
                    return redirect()->to(base_url('/admin-restaurant/reservation'))->with('error', 'Not enough available capacity. Please select a different venue or reduce the number of guests.');
                }
            } else {
                return redirect()->to(base_url('/admin-restaurant/reservation'))->with('error', 'Invalid venue information. Please check your input.');
            }
        } else {
            return redirect()->to(base_url('/admin-restaurant/reservation'))->with('error', 'Failed to update user information. Please try again.');
        }
    }
    
    public function updateResStatus($status, $reservationID)
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
            $emailMessage .= "Arrival Date: {$reservation['ArivalDate']}<br>";
            $emailMessage .= "Arrival Date: {$reservation['ArivalTime']}<br>";
            $emailMessage .= "Number of Guests: {$reservation['NumberOfGuests']}<br>";
            $emailMessage .= "Note : {$reservation['Note']}<br>";
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
            return redirect()->to('/admin-restaurant/reservation');
        } else {
            // Handle case where update fails
            return redirect()->back()->with('error', 'Failed to update reservation status');
        }
    }
    public function conReservation()
    {
        $data = [
            'adminRoutes' => 'conReservation',
            'reevents' => $this->reservation
                ->select('reservations.ReservationID, convention.conventionID, convention.conVenueID, convention_venue.conVenueID, convention_venue.conVenueName, convention_venue.minGuest, convention_venue.maxGuest, convention_venue.Image as venue_image, convention.EventID, events.EventType, events.Description as event_description, events.Image as event_image, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.PaymentOption, reservations.ReferenceNumber, reservations.downorfullPayment, reservations.TotalAmount, reservations.Image as reservation_image, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, users.Email, reservations.UserID')
                ->join('convention', 'reservations.conventionID = convention.conventionID')
                ->join('convention_venue', 'convention.conVenueID = convention_venue.conVenueID')
                ->join('events', 'convention.EventID = events.EventID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->findAll()
        ];
        return view('Admin\Convention\reservation', $data);
    }
    public function addConReservation()
    {
        helper(['form']);
    
        // Construct user data
        $userData = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
            'UserRoleID' => 1,
            'verification_token' => bin2hex(random_bytes(16)),
            'is_verified' => 1,
        ];
    
        // Insert user data into the database and retrieve the new UserID
        $UserID = $this->users->insert($userData, true);  // The second parameter 'true' retrieves the insert ID
    
        if ($UserID) {
            $guestData = [
                'UserID' => $UserID,
            ];
            $this->guest->insert($guestData);
            $inputVenueName = $this->request->getPost('conVenueName');
            $venueDataByName = $this->convenues->where('conVenueName', $inputVenueName)->first();
            $inputEventType = $this->request->getPost('EventType');
            $eventDataByType = $this->events->where('EventType', $inputEventType)->first();
    
            // Ensure only the necessary IDs are passed
            if ($venueDataByName && $eventDataByType) {
                $conventionData = [
                    'EventID' => $eventDataByType['EventID'], // Ensure 'EventID' is fetched correctly
                    'conVenueID' => $venueDataByName['conVenueID'], // Ensure 'conVenueID' is fetched correctly
                ];
    
                $conventionID = $this->conventions->insert($conventionData);
                
                if ($conventionID) {
                    // Prepare Reservation Data
                    $newReservationData = [
                        'CheckInDate' => $this->request->getPost('CheckInDate'),
                        'CheckOutDate' => $this->request->getPost('CheckOutDate'),
                        'NumberOfGuests' => $this->request->getPost('NumberOfGuests'),
                        'TotalAmount' => $this->request->getPost('TotalAmount'),
                        'downorfullPayment' => $this->request->getPost('downorfullPayment'),
                        'ReferenceNumber' => $this->request->getPost('ReferenceNumber'),
                        'PaymentOption' => $this->request->getPost('PaymentOption'),
                        'Status' => 'Confirm',
                        'conventionID' => $conventionID, 
                        'UserID' => $UserID, 
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
                    return redirect()->to(base_url('/admin-convention'))->with('error', 'Failed to add convention. Please check your input.');
                }
            } else {
                return redirect()->to(base_url('/admin-convention'))->with('error', 'Invalid Event Type or Venue Name. Please check your input.');
            }
        } else {
            return redirect()->to(base_url('/admin-convention'))->with('error', 'Failed to create user. Please try again.');
        }
    }
    public function updateConReservation($reservationID)
{
    helper(['form']);

    // Retrieve existing reservation
    $existingReservation = $this->reservation->find($reservationID);

    if (!$existingReservation) {
        return redirect()->to(base_url('/admin-convention/reservation'))->with('error', 'Reservation not found.');
    }

    // Retrieve existing user associated with the reservation
    $userID = $existingReservation['UserID'];
    $existingUser = $this->users->find($userID);

    if (!$existingUser) {
        return redirect()->to(base_url('/admin-convention/reservation'))->with('error', 'User associated with the reservation not found.');
    }

    // Update user data
    $userData = [
        'FirstName' => $this->request->getVar('FirstName'),
        'LastName' => $this->request->getVar('LastName'),
        'ContactNumber' => $this->request->getVar('ContactNumber'),
    ];

    $userUpdated = $this->users->update($userID, $userData);

    if ($userUpdated) {
        $inputVenueName = $this->request->getPost('conVenueName');
        $venueDataByName = $this->convenues->where('conVenueName', $inputVenueName)->first();
        $inputEventType = $this->request->getPost('EventType');
        $eventDataByType = $this->events->where('EventType', $inputEventType)->first();

        if ($venueDataByName && $eventDataByType) {
            $conventionData = [
                'EventID' => $eventDataByType['EventID'], // Ensure 'EventID' is fetched correctly
                'conVenueID' => $venueDataByName['conVenueID'], // Ensure 'conVenueID' is fetched correctly
            ];

            // Update convention data
            $conventionID = $existingReservation['conventionID'];
            $conventionUpdated = $this->conventions->update($conventionID, $conventionData);

            if ($conventionUpdated) {
                // Prepare updated Reservation Data
                $updatedReservationData = [
                    'CheckInDate' => $this->request->getPost('CheckInDate'),
                    'CheckOutDate' => $this->request->getPost('CheckOutDate'),
                    'NumberOfGuests' => $this->request->getPost('NumberOfGuests'),
                    'TotalAmount' => $this->request->getPost('TotalAmount'),
                    'downorfullPayment' => $this->request->getPost('downorfullPayment'),
                    'ReferenceNumber' => $this->request->getPost('ReferenceNumber'),
                    'PaymentOption' => $this->request->getPost('PaymentOption'),
                    'Status' => 'Confirm',
                ];

                // Update Reservation
                $reservationUpdated = $this->reservation->update($reservationID, $updatedReservationData);

                // Redirect with appropriate message
                if ($reservationUpdated) {
                    return redirect()->to(base_url('/admin-convention/reservation'))->with('success', 'Reservation updated successfully.');
                } else {
                    return redirect()->to(base_url('/admin-convention/reservation'))->with('error', 'Failed to update reservation. Please try again.');
                }
            } else {
                return redirect()->to(base_url('/admin-convention'))->with('error', 'Failed to update convention. Please check your input.');
            }
        } else {
            return redirect()->to(base_url('/admin-convention'))->with('error', 'Invalid Event Type or Venue Name. Please check your input.');
        }
    } else {
        return redirect()->to(base_url('/admin-convention/reservation'))->with('error', 'Failed to update user. Please try again.');
    }
}

    public function updateconStatus($status, $reservationID)
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
    public function staffAccounts()
    {
        $data = [
            'adminRoutes' => 'staffAccount',
            'regions' => $this->regions->findAll(),
            'staffs' => $this->staffDetail
                ->select('staff_details.StaffDetailsID, departments.DepartmentID, departments.DepartmentName, users.UserID, users.FirstName, users.LastName, users.Email, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address')
                ->join('departments', 'staff_details.DepartmentID = departments.DepartmentID')
                ->join('users', 'staff_details.UserID = users.UserID')
                ->findAll()
        ];
        return view('Admin\staffAccount', $data);
    }

    public function fetchProvince()
    {
        $request = service('request');

        // Ensure regCode is set in the request
        $regCode = $request->getPost('regCode');

        // Load the model or service responsible for fetching provinces
        $provinces = $this->province->where('regCode', $regCode)->findAll();

        $data['provinces'] = $provinces;

        return $this->response->setJSON($data);
    }

    public function fetchCity()
    {
        $request = service('request');

        // Ensure provCode is set in the request
        $provCode = $request->getPost('provCode');

        // Load the model or service responsible for fetching cities
        $cities = $this->cities->where('provCode', $provCode)->findAll();

        $data['cities'] = $cities;

        return $this->response->setJSON($data);
    }

    public function fetchBarangay()
    {
        $request = service('request');

        // Ensure citymunCode is set in the request
        $citymunCode = $request->getPost('citymunCode');

        // Load the model or service responsible for fetching barangays
        $barangays = $this->barangay->where('citymunCode', $citymunCode)->findAll();

        $data['barangays'] = $barangays;

        return $this->response->setJSON($data);
    }
    public function addStaffDetails()
    {
        helper(['form']);

        // Validation Rules and Messages
        $validationRules = [
            'FirstName' => 'required|min_length[4]|max_length[100]',
            'LastName' => 'required|min_length[4]|max_length[100]',
            'Email' => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.Email]',
            'Password' => 'required|min_length[4]|max_length[50]',
            'confirmPassword' => 'matches[Password]',
            'ContactNumber' => 'required|max_length[11]',
            'Region' => 'required',
            'Province' => 'required',
            'City' => 'required',
            'Barangay' => 'required',
            'DepartmentName' => 'required',
        ];

        $validationMessages = [
            'FirstName' => [
                'required' => 'The first name field is required.',
                'min_length' => 'The first name must be at least 4 characters long.',
                'max_length' => 'The first name must not exceed 100 characters.',
            ],
            'LastName' => [
                'required' => 'The last name field is required.',
                'min_length' => 'The last name must be at least 4 characters long.',
                'max_length' => 'The last name must not exceed 100 characters.',
            ],
            'Email' => [
                'required' => 'The email field is required.',
                'min_length' => 'The email must be at least 4 characters long.',
                'max_length' => 'The email must not exceed 100 characters.',
                'valid_email' => 'Please enter a valid email address.',
                'is_unique' => 'This email address is already registered.',
            ],
            'Password' => [
                'required' => 'The password field is required.',
                'min_length' => 'The password must be at least 4 characters long.',
                'max_length' => 'The password must not exceed 50 characters.',
            ],
            'ContactNumber' => [
                'required' => 'The contact number field is required.',
                'max_length' => 'The contact number must not exceed 11 characters.',
            ],
            'confirmPassword' => [
                'matches' => 'The confirm password field must match the password field.',
            ],
            'DepartmentName' => [
                'required' => 'The department name field is required.',
            ],
            'Region' => [
                'required' => 'The region field is required.',
            ],
            'Province' => [
                'required' => 'The province field is required.',
            ],
            'City' => [
                'required' => 'The city field is required.',
            ],
            'Barangay' => [
                'required' => 'The barangay field is required.',
            ],
        ];

        // Validate Input
        if ($this->validate($validationRules, $validationMessages)) {


            $regionCode = $this->request->getVar('Region');
            $provinceCode = $this->request->getVar('Province');
            $cityCode = $this->request->getVar('City');
            $barangayCode = $this->request->getVar('Barangay');

            $regionDesc = $this->regions->where('regCode', $regionCode)->first()['regDesc'];
            $provinceDesc = $this->province->where('provCode', $provinceCode)->first()['provDesc'];
            $cityDesc = $this->cities->where('citymunCode', $cityCode)->first()['citymunDesc'];
            $barangayDesc = $this->barangay->where('brgyCode', $barangayCode)->first()['brgyDesc'];

            // Construct user data
            $userData = [
                'FirstName' => $this->request->getVar('FirstName'),
                'LastName' => $this->request->getVar('LastName'),
                'Email' => $this->request->getVar('Email'),
                'Password' => password_hash($this->request->getVar('Password'), PASSWORD_DEFAULT),
                'ContactNumber' =>  $this->request->getVar('ContactNumber'),
                'Region' => $regionDesc,
                'Province' => $provinceDesc,
                'City' => $cityDesc,
                'Barangay' => $barangayDesc,
                'UserRoleID' => 2, // Assuming 2 is the role ID for staff
            ];
            $verificationToken = bin2hex(random_bytes(16));
            $userData['verification_token'] = $verificationToken;
            $userData['is_verified'] = 1;

            // Insert user data into the database
            $insertedUserID = $this->users->insert($userData);

            // Handle database insertion errors
            if (!$insertedUserID) {
                return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Failed to add staff. Please try again.');
            }

            // Retrieve department ID based on department name
            $inputDepartmentName = $this->request->getPost('DepartmentName');
            $departmentData = $this->department->where('DepartmentName', $inputDepartmentName)->first();

            if (!$departmentData) {
                return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Invalid department selected.');
            }

            // Construct staff data
            $staffData = [
                'DepartmentID' => $departmentData['DepartmentID'],
                'UserID' => $insertedUserID,
            ];

            // Insert staff data into the database
            $insertedStaffID = $this->staffDetail->insert($staffData);

            // Handle staff insertion errors
            if (!$insertedStaffID) {
                // Rollback user insertion
                $this->users->delete($insertedUserID);
                return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Failed to add staff. Please try again.');
            }

            // Redirect with success message
            return redirect()->to(base_url('/admin-staffaccounts'))->with('success', 'Staff added successfully.');
        } else {
            // If validation fails, return to the registration form with errors
            $data['validation'] = $this->validator;
            $data['activePage'] = 'Register';
            $data['regions'] = $this->regions->findAll();
            $data['staffs'] = $this->staffDetail
                ->select('staff_details.StaffDetailsID, departments.DepartmentID, departments.DepartmentName, users.UserID, users.FirstName, users.LastName, users.Email, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address')
                ->join('departments', 'staff_details.DepartmentID = departments.DepartmentID')
                ->join('users', 'staff_details.UserID = users.UserID')
                ->findAll();

            return view('Admin\staffAccount', $data);
        }
    }
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
                ->select('feedback.FeedbackID,feedback.UserRating,feedback.FeedbackMessage,feedback.datetime, users.UserID, users.Email')
                ->join('users', 'feedback.UserID = users.UserID')
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
    public function addChat()
    {
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
    public function deleteChat($chatID)
    {
        // Retrieve the product by ID
        $chat = $this->chat->find($chatID);
        
        // Check if the chat exists
        if ($chat) {
            // Delete the roominventory
            $deleted = $this->chat->delete($chatID);
            
            // Check if deletion was successful
            if ($deleted) {
                return redirect()->to(base_url('/admin-chat'))->with('success', 'Menu item deleted successfully.');
            } else {
                return redirect()->to(base_url('/admin-chat'))->with('error', 'Failed to delete menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-chat'))->with('error', 'Menu item not found.');
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
            'roomimages' => $this->roomimages
            ->select('rooms.RoomID, rooms.RoomNumber, rooms.RoomType, rooms.Description, rooms.PricePerNight, rooms.minPerson, rooms.maxPerson, GROUP_CONCAT(room_images.Image) AS Images')
            ->join('rooms', 'room_images.RoomID = rooms.RoomID')
            ->groupBy('rooms.RoomID')
            ->findAll(),
        ];

        // Load the view with the data
        return view('Admin/Hotel/service', $data);
    }
    public function addserviceRoom()
    {
        $file = $this->request->getFile('Image');

        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();

            $data = [
                'RoomNumber' => $this->request->getVar('RoomNumber'),
                'RoomType' => $this->request->getVar('RoomType'),
                'Description' => $this->request->getVar('Description'),
                'PricePerNight' => $this->request->getVar('PricePerNight'),
                'PerNightHead' => $this->request->getVar('PerNightHead'),
                'minPerson' => $this->request->getVar('minPerson'),
                'maxPerson' => $this->request->getVar('maxPerson'),
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
                    if ($file->move(FCPATH . 'uploads', $newFileName)) {
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
            echo ('error');
        }

        return redirect()->to('/admin-hotel/service');
    }
    public function updateserviceRoom()
    {

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
                'PerNightHead' => $this->request->getVar('PerNightHead'),
                'minPerson' => $this->request->getVar('minPerson'),
                'maxPerson' => $this->request->getVar('maxPerson'),
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
                    if ($file->move(FCPATH . 'uploads', $newFileName)) {
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
            echo ('error');
        }
        return redirect()->to('/admin-hotel/service');
    }
    public function deleteServiceRoom($id)
    {
        // Find the room by ID
        $room = $this->rooms->find($id);

        if ($room) {
            // Delete room image file
            $imagePath = FCPATH . 'uploads/' . $room['Image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Delete the room record from the database
            $this->rooms->delete($id);

            return redirect()->to('/admin-hotel/service')->with('status', 'Room deleted successfully');
        } else {
            return redirect()->to('/admin-hotel/service')->with('error', 'Room not found');
        }
    }
    public function addserviceRoomImage()
    {
        // Check if form is submitted
        if ($this->request->getMethod() === 'post') {
            // Get selected room type from form
            $roomNumber = $this->request->getPost('RoomNumber');

            // Validate room type
            if (empty($roomNumber)) {
                return redirect()->back()->with('error', 'Please select a room type.');
            }

            // Get room ID based on selected room type
            $room = $this->rooms->where('RoomNumber', $roomNumber)->first();
            if (!$room) {
                return redirect()->back()->with('error', 'Room not found for the selected room type.');
            }

            $roomID = $room['RoomID'];

            // Handle image upload
            $uploadedFiles = $this->request->getFiles();

            foreach ($uploadedFiles['Images'] as $image) {
                // Check if file is valid
                if ($image->isValid() && !$image->hasMoved()) {
                    // Move the file to the upload directory
                    $newName = $image->getRandomName();
                    $image->move(ROOTPATH . 'public/uploads', $newName);

                    // Save image details to database
                    $this->roomimages->save([
                        'RoomID' => $roomID,
                        'Image' => $newName,
                    ]);
                }
            }

            return redirect()->to(base_url('/admin-hotel/service/'))->with('success', 'Images uploaded successfully.'); // Redirect to room details page
        }

        // If not POST request, redirect back
        return redirect()->back();
    }
    public function restService()
    {
        $data = [
            'adminRoutes' => 'restService',
            'venues' => $this->venues->select('restaurant_venue.VenueID,restaurant_venue.VenueName,restaurant_venue.VenueCapacity,restaurant_venue.AvailableCapacity,restaurant_venue.Image ')->findAll(),
            'menumains' => $this->products
                ->select('menu_product.ProductID, menu_product.ProductName, menu_product.ProductPrice, menu_product.Image, menu_product.MenuID, menu_product.CategoryID, menu_category.CategoryID, menu_category.CategoryName, menu.MenuID, menu.MenuType')
                ->join('menu_category', 'menu_product.CategoryID = menu_category.CategoryID')
                ->join('menu', 'menu_product.MenuID = menu.MenuID')
                ->whereIn('menu_category.CategoryID', range(1, 11))
                ->where('menu.MenuType', 'Main Menu')
                ->findAll(),
            'menubars' => $this->products
                ->select('menu_product.ProductID, menu_product.ProductName, menu_product.ProductPrice, menu_product.Image, menu_product.MenuID, menu_product.CategoryID, menu_category.CategoryID, menu_category.CategoryName, menu.MenuID, menu.MenuType')
                ->join('menu_category', 'menu_product.CategoryID = menu_category.CategoryID')
                ->join('menu', 'menu_product.MenuID = menu.MenuID')
                ->whereIn('menu_category.CategoryID', range(12, 21))
                ->where('menu.MenuType', 'Bar Menu')
                ->findAll(),
            'menucafes' => $this->products
                ->select('menu_product.ProductID, menu_product.ProductName, menu_product.ProductPrice, menu_product.Image, menu_product.MenuID, menu_product.CategoryID, menu_category.CategoryID, menu_category.CategoryName, menu.MenuID, menu.MenuType')
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
        return view('Admin/Restaurant/service', $data);
    }
    public function addserviceTable()
    {
        $file = $this->request->getFile('Image');

        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();

            $data = [
                'VenueID' => $this->request->getVar('VenueID'),
                'VenueName' => $this->request->getVar('VenueName'),
                'VenueCapacity' => $this->request->getVar('VenueCapacity'),
                'AvailableCapacity' => $this->request->getVar('AvailableCapacity'),
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
                        $this->venues->save($data);
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
            echo ('error');
        }

        return redirect()->to('/admin-restaurant/service');
    }
    public function deleteServiceTable($id)
    {
        // Find the room by ID
        $table = $this->venues->find($id);

        if ($table) {
            // Delete table image file
            $imagePath = FCPATH . 'uploads/' . $table['Image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Delete the table record from the database
            $this->venues->delete($id);

            return redirect()->to('/admin-convention/service')->with('status', 'Room deleted successfully');
        } else {
            return redirect()->to('/admin-convention/service')->with('error', 'Room not found');
        }
    }
    public function updateserviceTable()
    {

        $file = $this->request->getFile('Image');

        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();

            $data = [
                'VenueID' => $this->request->getVar('VenueID'),
                'VenueName' => $this->request->getVar('VenueName'),
                'VenueCapacity' => $this->request->getVar('VenueCapacity'),
                'AvailableCapacity' => $this->request->getVar('AvailableCapacity'),
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
                        $this->venues->save($data);
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
            echo ('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function conService()
    {
        $data = [
            'adminRoutes' => 'conService',
            'events' => $this->events->findAll(),
            'convenues' => $this->convenues->findAll(),
        ];

        // Load the view with the data
        return view('Admin/Convention/service', $data);
    }
    public function addserviceconVenue()
    {
        $file = $this->request->getFile('Image');

        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();

            $data = [
                'conVenueName' => $this->request->getVar('conVenueName'),
                'minGuest' => $this->request->getVar('minGuest'),
                'maxGuest' => $this->request->getVar('maxGuest'),
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
                    if ($file->move(FCPATH . 'convention/', $newFileName)) {
                        // Save product data to the database
                        $this->convenues->save($data);
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
            echo ('error');
        }

        return redirect()->to('/admin-convention/service');
    }
    public function deleteServiceConVenue($conVenueID)
    {
        // Find the venue by ID
        $conVenue = $this->convenues->find($conVenueID);

        if ($conVenue) {
            // Get the image file path
            $imagePath = FCPATH . 'convention/' . $conVenue['Image'];

            // Delete the venue record from the database
            $this->convenues->delete($conVenueID);

            // Delete the image file if it exists
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Set a success message
            session()->setFlashdata('success', 'Venue deleted successfully.');
        } else {
            // Set an error message
            session()->setFlashdata('error', 'Venue not found.');
        }

        return redirect()->to('/admin-convention/service');
    }

    public function updateserviceconVenue()
    {

        $file = $this->request->getFile('Image');

        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();

            $data = [
                'conVenueID' => $this->request->getVar('conVenueID'),
                'conVenueName' => $this->request->getVar('conVenueName'),
                'minGuest' => $this->request->getVar('minGuest'),
                'maxGuest' => $this->request->getVar('maxGuest'),
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
                    // Move the file to the 'convention' directory
                    if ($file->move(FCPATH . 'convention/', $newFileName)) {
                        // Save product data to the database
                        $this->convenues->save($data);
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
            echo ('error');
        }
        return redirect()->to('/admin-convention/service');
    }
    public function addserviceEvent()
    {
        $file = $this->request->getFile('Image');

        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();

            $data = [
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
            echo ('error');
        }

        return redirect()->to('/admin-convention/service');
    }
    public function deleteServiceConEvent($EventID)
    {
        // Find the venue by ID
        $conEvent = $this->events->find($EventID);

        if ($conEvent) {
            // Get the image file path
            $imagePath = FCPATH . 'uploads/' . $conEvent['Image'];

            // Delete the venue record from the database
            $this->events->delete($EventID);

            // Delete the image file if it exists
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Set a success message
            session()->setFlashdata('success', 'Venue deleted successfully.');
        } else {
            // Set an error message
            session()->setFlashdata('error', 'Venue not found.');
        }

        return redirect()->to('/admin-convention/service');
    }
    public function updateserviceEvent()
    {

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
            echo ('error');
        }
        return redirect()->to('/admin-convention/service');
    }

    public function Qrcode()
    {
        $data = [
            'adminRoutes' => 'qrcode',
            'qrcodes' => $this->qr->findAll(),
        ];

        // Load the view with the data
        return view('Admin/qrcode', $data);
    }
    public function updateQrcode()
    {

        $file = $this->request->getFile('Image');

        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();

            $data = [
                'QrcodeID' => $this->request->getVar('QrcodeID'),
                'PaymentOption' => $this->request->getVar('PaymentOption'),
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
                    if ($file->move(FCPATH . 'qrimage/', $newFileName)) {
                        // Save product data to the database
                        $this->qr->save($data);
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
            echo ('error');
        }
        return redirect()->to('/admin-qrcode');
    }
    public function setting()
    {
        $data = [
            'adminRoutes' => 'setting',
        ];
        return view('Admin/setting', $data);
    }
    public function viewReservation($reservationID)
    {
        $db = \Config\Database::connect(); // Get database connection

        // SQL Query to fetch reservation, user, and room details
        $query = $db->table('reservations')
        ->select('reservations.*, users.FirstName, users.LastName, users.Email, users.ContactNumber, rooms.RoomNumber, rooms.RoomType, rooms.Description, rooms.PricePerNight, GROUP_CONCAT(reservation_amenities.AmenitiesID) as AmenitiesID, room_inventory.ProductName, reservation_amenities.insertQuantity')
        ->join('users', 'reservations.UserID = users.UserID')
        ->join('rooms', 'reservations.RoomID = rooms.RoomID')
        ->join('reservation_amenities', 'reservations.ReservationID = reservation_amenities.ReservationID', 'left')
        ->join('room_inventory', 'reservation_amenities.roomInventoryID = room_inventory.roomInventoryID', 'left')
        ->where('reservations.ReservationID', $reservationID)
        ->groupBy('reservations.ReservationID, users.FirstName, users.LastName, users.Email, users.ContactNumber, rooms.RoomNumber, rooms.RoomType, rooms.Description, rooms.PricePerNight, room_inventory.ProductName, reservation_amenities.insertQuantity')
        ->get();
    
        $reservationDetails = $query->getRow();
    

        // Check if reservation has expired
        if ($reservationDetails && new DateTime($reservationDetails->CheckOutDate) < new DateTime()) {
            $reservationDetails->Status = 'Expired'; // Set status to Expired if checkout date is past
        } else {
            $reservationDetails->Status = 'Valid';
        }
        if ($reservationDetails && !empty($reservationDetails->AmenitiesID)) {
            $amenitiesArray = explode(',', $reservationDetails->AmenitiesID);
            $reservationDetails->AmenitiesID = $amenitiesArray;
        } else {
            $reservationDetails->AmenitiesID = []; // Set it to an empty array if no amenities selected
        }
        $amenities = [];
        foreach ($query->getResult() as $row) {
            $amenity = [
                'ProductName' => $row->ProductName,
                'insertQuantity' => $row->insertQuantity
            ];
            $amenities[] = $amenity;
        }
        

        if ($reservationDetails) {
            return view('Hotell/reservation_view', ['reservation' => $reservationDetails, 'amenities' => $amenities]);
        } else {
            return redirect()->back()->with('error', 'Reservation not found.');
        }
    }
    public function viewconvetionReservation($reservationID)
    {
        $db = \Config\Database::connect(); // Get database connection

        // SQL Query to fetch reservation, user, and room details
        $query = $db->table('reservations')
            ->select('reservations.*, users.FirstName, users.LastName, users.Email, users.ContactNumber,convention.conventionID, convention.conVenueID, convention_venue.conVenueID, convention_venue.conVenueName, convention_venue.minGuest, convention_venue.maxGuest, convention_venue.Image as venue_image, convention.EventID, events.EventType, events.Description, events.Image as event_image ')
            ->join('users', 'reservations.UserID = users.UserID')
            ->join('convention', 'reservations.conventionID = convention.conventionID')
            ->join('convention_venue', 'convention.conVenueID = convention_venue.conVenueID')
            ->join('events', 'convention.EventID = events.EventID')
            ->where('reservations.ReservationID', $reservationID)
            ->groupBy('reservations.ReservationID, users.FirstName, users.LastName, users.Email, users.ContactNumber, convention_venue.conVenueName, events.EventType, events.Description ')
            ->get();

        $reservationDetails = $query->getRow();

        // Check if reservation has expired
        if ($reservationDetails && new DateTime($reservationDetails->CheckOutDate) < new DateTime()) {
            $reservationDetails->Status = 'Expired'; // Set status to Expired if checkout date is past
        } else {
            $reservationDetails->Status = 'Valid';
        }

        if ($reservationDetails) {
            return view('Hotell/conventionreservation_view', ['reservation' => $reservationDetails]); // Load the view and pass the details
        } else {
            return redirect()->back()->with('error', 'Reservation not found.');
        }
    }

    public function newsPromotion()
    {
        $data = [
            'adminRoutes' => 'newsPromotion',
            'news' => $this->news->findAll(),
        ];
        return view('Admin/news', $data);
    }
    public function addnewsPromotion()
    {
        helper(['form']);
    
        // Validation Rules
        $validationRules = [
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
    
        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('validationErrors', $validationErrors);
        }

        if ($image = $this->request->getFile('Image')) {
            if ($image->isValid() && !$image->hasMoved()) {
                $newFileName = $image->getRandomName();
                $image->move(FCPATH . 'news/', $newFileName);
            } else {
                return redirect()->to(base_url('admin-newspromotion'))->with('error', 'Failed to upload image. Please try again.');
            }
        } else {
            return redirect()->to(base_url('admin-newspromotion'))->with('error', 'Please upload an image.');
        }

        // Insert new menu item
        $newNewsData = [
            'Image' => $newFileName
        ];

        // Insert menu item
        $inserted = $this->news->insert($newNewsData);
        if ($inserted) {
            return redirect()->to(base_url('admin-newspromotion'))->with('success', 'Menu item added successfully.');
        } else {
            return redirect()->to(base_url('admin-newspromotion'))->with('error', 'Failed to add menu item. Please try again.');
        }
    }
    public function editnewsPromotion()
    {
        helper(['form']);
    
        // Validation Rules
        $validationRules = [
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
    
        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-newspromotion'))->with('validationErrors', $validationErrors);
        }
    
        // Retrieve News ID
        $newsID = $this->request->getPost('NewsID');
    
        // Handle Image Upload
        $newFileName = '';
        $image = $this->request->getFile('Image');
        if ($image->isValid() && !$image->hasMoved()) {
            $newFileName = $image->getRandomName();
            $image->move(FCPATH . 'news/', $newFileName);
        } else {
            return redirect()->to(base_url('/admin-newspromotion'))->with('error', 'Failed to upload image. Please try again.');
        }
    
        // Update News Data
        $updatedNewsData = ['Image' => $newFileName];
    
        // Update News
        $updated = $this->news->update($newsID, $updatedNewsData);
        if ($updated) {
            return redirect()->to(base_url('/admin-newspromotion'))->with('success', 'News updated successfully.');
        } else {
            return redirect()->to(base_url('/admin-newspromotion'))->with('error', 'Failed to update news. Please try again.');
        }
    }
    
    public function deleteNews($newsID)
    {
        $newsModel = new NewsModel();

        // Get the news data by ID
        $news = $newsModel->find($newsID);

        if ($news) {
            // Delete the news image from the server
            $imagePath = FCPATH . 'news/' . $news['Image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Delete the news from the database
            $deleted = $newsModel->delete($newsID);

            if ($deleted) {
                // Redirect with success message
                return redirect()->to(base_url('admin-newspromotion'))->with('success', 'News deleted successfully.');
            } else {
                // Redirect with error message
                return redirect()->to(base_url('admin-newspromotion'))->with('error', 'Failed to delete news. Please try again.');
            }
        } else {
            // Redirect with error message
            return redirect()->to(base_url('admin-newspromotion'))->with('error', 'News not found.');
        }
    }
    public function Report()
    {
        $data = [
            'adminRoutes' => 'report',
            'hotelrevs' => $this->reservation
                ->select('reservations.ReservationID, rooms.RoomID, rooms.RoomNumber, rooms.RoomType, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests,reservations.PaymentOption,reservations.ReferenceNumber,reservations.Adult,reservations.Child, reservations.downorfullPayment,reservations.Image, reservations.TotalAmount, reservations.Status, users.UserID, users.FirstName, users.LastName, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address', false)
                ->join('rooms', 'reservations.RoomID = rooms.RoomID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->where('reservations.Status', 'Confirm')
                ->findAll(),
            'restrevs' => $this->reservation
                ->select('reservations.ReservationID, restaurant_venue.VenueID, restaurant_venue.VenueName, reservations.CheckInDate, reservations.NumberOfGuests, reservations.Note, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, reservations.UserID, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address', false)
                ->join('restaurant_venue', 'reservations.VenueID = restaurant_venue.VenueID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->where('reservations.Status', 'Confirm')
                ->findAll(),
            'reevents' => $this->reservation
                ->select('reservations.ReservationID, convention.conventionID, convention.conVenueID, convention_venue.conVenueID, convention_venue.conVenueName, convention_venue.minGuest, convention_venue.maxGuest, convention_venue.Image as venue_image, convention.EventID, events.EventType, events.Description as event_description, events.Image as event_image, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.PaymentOption, reservations.ReferenceNumber, reservations.downorfullPayment, reservations.TotalAmount, reservations.Image as reservation_image, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, users.Email, reservations.UserID, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address', false)
                ->join('convention', 'reservations.conventionID = convention.conventionID')
                ->join('convention_venue', 'convention.conVenueID = convention_venue.conVenueID')
                ->join('events', 'convention.EventID = events.EventID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->where('reservations.Status', 'Confirm')
                ->findAll(),

        ];
        return view('Admin/report', $data);
    }
    public function fetchReportData()
    {
        // Get start date, end date, and data type from the AJAX request
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $dataType = $this->request->getPost('data_type'); // Added to determine which data to fetch

        // Initialize an empty array to hold the fetched data
        $data = [];

        // Determine which data type was requested and fetch the corresponding data
        if ($dataType === 'hotel') {
            // Fetch hotel reservation data
            $data = $this->reservation
                ->select('reservations.ReservationID, rooms.RoomID, rooms.RoomNumber, rooms.RoomType, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.PaymentOption, reservations.ReferenceNumber, reservations.Adult, reservations.Child, reservations.downorfullPayment, reservations.Image, reservations.TotalAmount, reservations.Status, users.UserID, users.FirstName, users.LastName, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address', false)
                ->join('rooms', 'reservations.RoomID = rooms.RoomID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->where('reservations.Status', 'Confirm')
                ->where('reservations.CheckInDate >=', $startDate)
                ->where('reservations.CheckInDate <=', $endDate)
                ->orderBy('reservations.CheckInDate', 'ASC')
                ->findAll();
        } elseif ($dataType === 'restaurant') {
            // Fetch restaurant reservation data
            $data = $this->reservation
                ->select('reservations.ReservationID, restaurant_venue.VenueID, restaurant_venue.VenueName, reservations.CheckInDate, reservations.NumberOfGuests, reservations.Note, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, reservations.UserID, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address', false)
                ->join('restaurant_venue', 'reservations.VenueID = restaurant_venue.VenueID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->where('reservations.Status', 'Confirm')
                ->where('reservations.CheckInDate >=', $startDate)
                ->where('reservations.CheckInDate <=', $endDate)
                ->orderBy('reservations.CheckInDate', 'ASC')
                ->findAll();
        } elseif ($dataType === 'convention') {
            // Fetch convention reservation data
            $data = $this->reservation
                ->select('reservations.ReservationID, convention.conventionID, convention.conVenueID, convention_venue.conVenueID, convention_venue.conVenueName, convention_venue.minGuest, convention_venue.maxGuest, convention_venue.Image as venue_image, convention.EventID, events.EventType, events.Description as event_description, events.Image as event_image, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.PaymentOption, reservations.ReferenceNumber, reservations.downorfullPayment, reservations.TotalAmount, reservations.Image as reservation_image, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, users.Email, reservations.UserID, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address', false)
                ->join('convention', 'reservations.conventionID = convention.conventionID')
                ->join('convention_venue', 'convention.conVenueID = convention_venue.conVenueID')
                ->join('events', 'convention.EventID = events.EventID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->where('reservations.Status', 'Confirm')
                ->where('reservations.CheckInDate >=', $startDate)
                ->where('reservations.CheckInDate <=', $endDate)
                ->orderBy('reservations.CheckInDate', 'ASC')
                ->findAll();
        }

        // Return the fetched data as JSON response
        return $this->response->setJSON($data);
    }


}
