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
    public function updateadminProfile($userID)
    {
        helper(['form']);
        $validationRules = [
            'FirstName' => 'required|min_length[2]|max_length[100]',
            'LastName' => 'required|min_length[2]|max_length[100]',
            'Email' => 'required|min_length[4]|max_length[100]|valid_email',
            'ContactNumber' => 'required|max_length[11]',
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
        ];
        $this->users->update($userID, $updatedUserData);
        session()->setFlashdata('success', 'Profile updated successfully.');
        return redirect()->to(base_url('/admin-setting'));
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
                return redirect()->to('/admin-setting');
            } else {
                $session->setFlashdata('msg', 'Old password is incorrect');
                return redirect()->to('/admin-setting');
            }
        } else {
            $data['validation'] = $this->validator;
            return view('Admin/setting', $data);
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
        $positiveCount = 0;
        $neutralCount = 0;
        $negativeCount = 0;

        $feedbackData = $this->feedbacks->findAll();
        foreach ($feedbackData as $feedback) {
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
        $totalRating = count($feedbackData);
        $positivePercentage = ($positiveCount / $totalRating) * 100;
        $neutralPercentage = ($neutralCount / $totalRating) * 100;
        $negativePercentage = ($negativeCount / $totalRating) * 100;
        $roomreservations = $this->reservation->select('reservations.RoomID, rooms.RoomType, MONTH(reservations.CheckInDate) AS CheckInMonth, YEAR(reservations.CheckInDate) AS CheckInYear, COUNT(*) AS ReservationCount')->join('rooms', 'reservations.RoomID = rooms.RoomID')->where('reservations.Status', 'Confirm')->where('reservations.RoomID IS NOT NULL', null, false)->groupBy('reservations.RoomID, rooms.RoomType, CheckInMonth, CheckInYear')->findAll();
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
        return view('Admin/index', $data);
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
        $selectedYear = $this->request->getPost('selectedYear');
        $roomreservations = $this->reservation->select('reservations.RoomID, rooms.RoomType, MONTH(reservations.CheckInDate) AS CheckInMonth, COUNT(*) AS ReservationCount')
                                            ->join('rooms', 'reservations.RoomID = rooms.RoomID')
                                            ->where('YEAR(reservations.CheckInDate)', $selectedYear)
                                            ->where('reservations.Status', 'Confirm')
                                            ->where('reservations.RoomID IS NOT NULL', null, false)
                                            ->groupBy('reservations.RoomID, rooms.RoomType, CheckInMonth')
                                            ->findAll();
        $data['roomreservations'] = $roomreservations;
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
        return view('Admin/customer', $data);
    }
    public function updateCustomer($guestID)
    {
        helper(['form']);
        $updatedUserData = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'Email' => $this->request->getVar('Email'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
        ];
        $this->users->update($this->request->getVar('UserID'), $updatedUserData);
        $updatedGuestData = [
            'UserID' => $this->request->getVar('UserID'),
        ];
        $this->guest->update($guestID, $updatedGuestData);
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
        return view('Admin/Hotel/reservation', $data);
    }
    public function addHotelReservation()
    {
        helper(['form']);
        $regionCode = $this->request->getVar('Region');
        $provinceCode = $this->request->getVar('Province');
        $cityCode = $this->request->getVar('City');
        $barangayCode = $this->request->getVar('Barangay');
        $regionDesc = $this->regions->where('regCode', $regionCode)->first()['regDesc'] ?? '';
        $provinceDesc = $this->province->where('provCode', $provinceCode)->first()['provDesc'] ?? '';
        $cityDesc = $this->cities->where('citymunCode', $cityCode)->first()['citymunDesc'] ?? '';
        $barangayDesc = $this->barangay->where('brgyCode', $barangayCode)->first()['brgyDesc'] ?? '';
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
        $UserID = $this->users->insert($userData, true);
        if ($UserID) {
            $guestData = [
                'UserID' => $UserID,
            ];
            $this->guest->insert($guestData);
            $inputRoomType = $this->request->getPost('RoomType');
            $inputRoomNumber = $this->request->getPost('RoomNumber');
            $roomDataByType = $this->rooms->where('RoomType', $inputRoomType)->first();
            $roomDataByNumber = $this->rooms->where('RoomNumber', $inputRoomNumber)->first();
            if ($roomDataByType && $roomDataByNumber) {
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
                $inserted = $this->reservation->insert($newReservationData);
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
        $userData = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
        ];
        $reservation = $this->reservation->find($reservationID);
        if (!$reservation) {
            return redirect()->to(base_url('/admin-hotel/reservation'))->with('error', 'Reservation not found.');
        }
        $userID = $reservation['UserID'];
        $updateUserResult = $this->users->update($userID, $userData);
        if ($updateUserResult) {
            $inputRoomType = $this->request->getPost('RoomType');
            $inputRoomNumber = $this->request->getPost('RoomNumber');
            $roomDataByType = $this->rooms->where('RoomType', $inputRoomType)->first();
            $roomDataByNumber = $this->rooms->where('RoomNumber', $inputRoomNumber)->first();
            if ($roomDataByType && $roomDataByNumber && $roomDataByType['RoomID'] === $roomDataByNumber['RoomID']) {
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
            $emailMessage .= "Adult: {$reservation['Adult']}<br>";
            $emailMessage .= "Kid: {$reservation['Child']}<br>";
            $emailMessage .= "Payment Option: {$reservation['PaymentOption']}<br>";
            $emailMessage .= "ReferenceNumber: {$reservation['ReferenceNumber']}<br>";
            $emailMessage .= "Down or Full Payment: {$reservation['downorfullPayment']}<br>";
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
            return redirect()->to('/admin-hotel/reservation');
        } else {
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
        return view('Admin/Restaurant/reservation', $data);
    }
    public function addRestauReservation()
    {
        helper(['form']);
        $userData = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
            'verification_token' => bin2hex(random_bytes(16)),
            'is_verified' => 1,
        ];
        $UserID = $this->users->insert($userData, true);
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
        $userData = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
        ];
        $reservation = $this->reservation->find($reservationID);
        if (!$reservation) {
            return redirect()->to(base_url('/admin-restaurant/reservation'))->with('error', 'Reservation not found.');
        }
        $userID = $reservation['UserID'];
        $updateUserResult = $this->users->update($userID, $userData);
        if ($updateUserResult) {
            $VenueName = $this->request->getPost('VenueName');
            $restaurantVenue = $this->venues->where('VenueName', $VenueName)->first();
            if ($restaurantVenue) {
                $availableCapacity = $restaurantVenue['AvailableCapacity'];
                $numberOfGuests = $this->request->getPost('NumberOfGuests');
                if ($availableCapacity >= $numberOfGuests) {
                    $newAvailableCapacity = $availableCapacity - $numberOfGuests;
                    $this->venues->update($restaurantVenue['VenueID'], ['AvailableCapacity' => $newAvailableCapacity]);
                    $restaurantReservation = [
                        'NumberOfGuests' => $numberOfGuests,
                        'CheckInDate' => $this->request->getPost('CheckInDate'),
                        'Note' => $this->request->getPost('Note'),
                        'VenueName' => $VenueName,
                        'VenueID' => $restaurantVenue['VenueID'],
                        'UserID' => $userID,
                    ];
                    $updated = $this->reservation->update($reservationID, $restaurantReservation);
                    if ($updated) {
                        return redirect()->to(base_url('/admin-restaurant/reservation'))->with('success', 'Reservation updated successfully.');
                    } else {
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
            return redirect()->to('/admin-restaurant/reservation');
        } else {
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
        return view('Admin/Convention/reservation', $data);
    }
    public function addConReservation()
    {
        helper(['form']);
        $userData = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
            'UserRoleID' => 1,
            'verification_token' => bin2hex(random_bytes(16)),
            'is_verified' => 1,
        ];
        $UserID = $this->users->insert($userData, true);
        if ($UserID) {
            $guestData = [
                'UserID' => $UserID,
            ];
            $this->guest->insert($guestData);
            $inputVenueName = $this->request->getPost('conVenueName');
            $venueDataByName = $this->convenues->where('conVenueName', $inputVenueName)->first();
            $inputEventType = $this->request->getPost('EventType');
            $eventDataByType = $this->events->where('EventType', $inputEventType)->first();
            if ($venueDataByName && $eventDataByType) {
                $conventionData = [
                    'EventID' => $eventDataByType['EventID'], 
                    'conVenueID' => $venueDataByName['conVenueID'],
                ];
                $conventionID = $this->conventions->insert($conventionData);
                if ($conventionID) {
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
                    $inserted = $this->reservation->insert($newReservationData);
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
        $existingReservation = $this->reservation->find($reservationID);

        if (!$existingReservation) {
            return redirect()->to(base_url('/admin-convention/reservation'))->with('error', 'Reservation not found.');
        }
        $userID = $existingReservation['UserID'];
        $existingUser = $this->users->find($userID);
        if (!$existingUser) {
            return redirect()->to(base_url('/admin-convention/reservation'))->with('error', 'User associated with the reservation not found.');
        }
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
                    'EventID' => $eventDataByType['EventID'], 
                    'conVenueID' => $venueDataByName['conVenueID'],
                ];
                $conventionID = $existingReservation['conventionID'];
                $conventionUpdated = $this->conventions->update($conventionID, $conventionData);
                if ($conventionUpdated) {
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
                    $reservationUpdated = $this->reservation->update($reservationID, $updatedReservationData);
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
            return redirect()->to('/admin-hotel/reservation');
        } else {
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
        return view('Admin/staffAccount', $data);
    }
    public function fetchProvince()
    {
        $request = service('request');
        $regCode = $request->getPost('regCode');
        $provinces = $this->province->where('regCode', $regCode)->findAll();
        $data['provinces'] = $provinces;
        return $this->response->setJSON($data);
    }
    public function fetchCity()
    {
        $request = service('request');
        $provCode = $request->getPost('provCode');
        $cities = $this->cities->where('provCode', $provCode)->findAll();
        $data['cities'] = $cities;
        return $this->response->setJSON($data);
    }

    public function fetchBarangay()
    {
        $request = service('request');
        $citymunCode = $request->getPost('citymunCode');
        $barangays = $this->barangay->where('citymunCode', $citymunCode)->findAll();
        $data['barangays'] = $barangays;
        return $this->response->setJSON($data);
    }
    public function addStaffDetails()
    {
        helper(['form']);
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
        if ($this->validate($validationRules, $validationMessages)) {
            $regionCode = $this->request->getVar('Region');
            $provinceCode = $this->request->getVar('Province');
            $cityCode = $this->request->getVar('City');
            $barangayCode = $this->request->getVar('Barangay');
            $regionDesc = $this->regions->where('regCode', $regionCode)->first()['regDesc'];
            $provinceDesc = $this->province->where('provCode', $provinceCode)->first()['provDesc'];
            $cityDesc = $this->cities->where('citymunCode', $cityCode)->first()['citymunDesc'];
            $barangayDesc = $this->barangay->where('brgyCode', $barangayCode)->first()['brgyDesc'];
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
                'UserRoleID' => 2,
            ];
            $verificationToken = bin2hex(random_bytes(16));
            $userData['verification_token'] = $verificationToken;
            $userData['is_verified'] = 1;
            $insertedUserID = $this->users->insert($userData);
            if (!$insertedUserID) {
                return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Failed to add staff. Please try again.');
            }
            $inputDepartmentName = $this->request->getPost('DepartmentName');
            $departmentData = $this->department->where('DepartmentName', $inputDepartmentName)->first();
            if (!$departmentData) {
                return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Invalid department selected.');
            }
            $staffData = [
                'DepartmentID' => $departmentData['DepartmentID'],
                'UserID' => $insertedUserID,
            ];
            $insertedStaffID = $this->staffDetail->insert($staffData);
            if (!$insertedStaffID) {
                $this->users->delete($insertedUserID);
                return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Failed to add staff. Please try again.');
            }
            return redirect()->to(base_url('/admin-staffaccounts'))->with('success', 'Staff added successfully.');
        } else {
            $data['validation'] = $this->validator;
            $data['activePage'] = 'Register';
            $data['regions'] = $this->regions->findAll();
            $data['staffs'] = $this->staffDetail
                ->select('staff_details.StaffDetailsID, departments.DepartmentID, departments.DepartmentName, users.UserID, users.FirstName, users.LastName, users.Email, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address')
                ->join('departments', 'staff_details.DepartmentID = departments.DepartmentID')
                ->join('users', 'staff_details.UserID = users.UserID')
                ->findAll();
            return view('Admin/staffAccount', $data);
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
        $validationRules = [
            'FirstName' => 'required|min_length[4]|max_length[100]',
            'LastName' => 'required|min_length[4]|max_length[100]',
            'Email' => 'required|min_length[4]|max_length[100]|valid_email',
            'ContactNumber' => 'required|max_length[11]',
            'Address' => 'required|min_length[4]|max_length[100]',
            'DepartmentName' => 'required',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return view('/admin-dashboard', ['validationErrors' => $validationErrors]);
        }
        $inputDepartmentName = $this->request->getPost('DepartmentName');
        $staffDataByType = $this->department->where('DepartmentName', $inputDepartmentName)->first();
        if (!$staffDataByType) {
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Invalid DepartmentName. Please check your input.');
        }
        $updatedStaffData = [
            'DepartmentID' => $staffDataByType['DepartmentID'],
            'UserID' => $userID,
        ];
        $this->staffDetail->update($userID, $updatedStaffData);
        $updatedUserData = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'Email' => $this->request->getVar('Email'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
            'Address' => $this->request->getVar('Address'),
        ];
        $this->users->update($userID, $updatedUserData);
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
        return view('Admin/feedback', $data);
    }
    public function chat()
    {
        $data = [
            'adminRoutes' => 'chat',
            'chats' => $this->chat->findAll()
        ];
        return view('Admin/chat', $data);
    }
    public function addChat()
    {
        helper(['form']);
        $validationRules = [
            'Question' => 'required',
            'Answer' => 'required',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return view('/bookroom', ['validationErrors' => $validationErrors]);
        }
        $newReservationData = [
            'Question' => $this->request->getPost('Question'),
            'Answer' => $this->request->getPost('Answer'),
        ];
        $inserted = $this->chat->insert($newReservationData);
        if ($inserted) {
            return redirect()->to(base_url('/admin-chat'))->with('success', 'Reservation added successfully.');
        } else {
            return redirect()->to(base_url('/admin-chat'))->with('error', 'Failed to add reservation. Please try again.');
        }
    }
    public function deleteChat($chatID)
    {
        $chat = $this->chat->find($chatID);
        if ($chat) {
            $deleted = $this->chat->delete($chatID);
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
        $validationRules = [
            'Question' => 'required',
            'Answer' => 'required',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url("/editReservation/{$ChatID}"))->with('validationErrors', $validationErrors);
        }
        $updateReservationData = [
            'Question' => $this->request->getPost('Question'),
            'Answer' => $this->request->getPost('Answer'),
        ];
        $this->chat->update($ChatID, $updateReservationData);
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
        return view('Admin/Hotel/service', $data);
    }
    public function addserviceRoom()
    {
        $file = $this->request->getFile('Image');
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
                    'max_size[Image,10240]', 
                    'ext_in[Image,png,jpg,gif]' 
                ]
            ];
            if ($this->validate($rules)) {
                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->move(FCPATH . 'uploads/', $newFileName)) {
                        $this->rooms->save($data);
                    } else {
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
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
                    'max_size[Image,10240]', 
                    'ext_in[Image,png,jpg,gif]'
                ]
            ];
            if ($this->validate($rules)) {
                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->move(FCPATH . 'uploads/', $newFileName)) {
                        $this->rooms->save($data);
                    } else {
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                $data['validation'] = $this->validator;
            }
        } else {
            echo ('error');
        }
        return redirect()->to('/admin-hotel/service');
    }
    public function deleteServiceRoom($id)
    {
        $room = $this->rooms->find($id);
        if ($room) {
            $imagePath = FCPATH . 'uploads/' . $room['Image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $this->rooms->delete($id);
            return redirect()->to('/admin-hotel/service')->with('status', 'Room deleted successfully');
        } else {
            return redirect()->to('/admin-hotel/service')->with('error', 'Room not found');
        }
    }
    public function addserviceRoomImage()
    {
        if ($this->request->getMethod() === 'post') {
            $roomNumber = $this->request->getPost('RoomNumber');
            if (empty($roomNumber)) {
                return redirect()->back()->with('error', 'Please select a room type.');
            }
            $room = $this->rooms->where('RoomNumber', $roomNumber)->first();
            if (!$room) {
                return redirect()->back()->with('error', 'Room not found for the selected room type.');
            }
            $roomID = $room['RoomID'];
            $uploadedFiles = $this->request->getFiles();
            foreach ($uploadedFiles['Images'] as $image) {
                if ($image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getRandomName();
                    $image->move(ROOTPATH . 'public/uploads', $newName);
                    $this->roomimages->save([
                        'RoomID' => $roomID,
                        'Image' => $newName,
                    ]);
                }
            }
            return redirect()->to(base_url('/admin-hotel/service/'))->with('success', 'Images uploaded successfully.'); // Redirect to room details page
        }
        return redirect()->back();
    }
    public function deleteServiceRoomImage($roomID)
    {
        if (empty($roomID)) {
            return redirect()->back()->with('error', 'Room ID is required.');
        }
        $this->roomimages->where('RoomID', $roomID)->delete();
        return redirect()->to(base_url('/admin-hotel/service/'))->with('success', 'Room image deleted successfully.');
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
                    'max_size[Image,10240]', 
                    'ext_in[Image,png,jpg,gif]'
                ]
            ];
            if ($this->validate($rules)) {
                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->move(FCPATH . 'uploads/', $newFileName)) {
                        $this->venues->save($data);
                    } else {
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                $data['validation'] = $this->validator;
            }
        } else {
            echo ('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function deleteServiceTable($id)
    {
        $table = $this->venues->find($id);
        if ($table) {
            $imagePath = FCPATH . 'uploads/' . $table['Image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $this->venues->delete($id);
            return redirect()->to('/admin-convention/service')->with('status', 'Room deleted successfully');
        } else {
            return redirect()->to('/admin-convention/service')->with('error', 'Room not found');
        }
    }
    public function updateserviceTable()
    {
        $file = $this->request->getFile('Image');
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
                    'max_size[Image,10240]',
                    'ext_in[Image,png,jpg,gif]' 
                ]
            ];
            if ($this->validate($rules)) {
                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->move(FCPATH . 'uploads/', $newFileName)) {
                        $this->venues->save($data);
                    } else {
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
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
        return view('Admin/Convention/service', $data);
    }
    public function addserviceconVenue()
    {
        $file = $this->request->getFile('Image');
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
                    'max_size[Image,10240]', 
                    'ext_in[Image,png,jpg,gif]' 
                ]
            ];
            if ($this->validate($rules)) {
                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->move(FCPATH . 'convention/', $newFileName)) {
                        $this->convenues->save($data);
                    } else {
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                $data['validation'] = $this->validator;
            }
        } else {
            echo ('error');
        }
        return redirect()->to('/admin-convention/service');
    }
    public function deleteServiceConVenue($conVenueID)
    {
        $conVenue = $this->convenues->find($conVenueID);
        if ($conVenue) {
            $imagePath = FCPATH . 'convention/' . $conVenue['Image'];
            $this->convenues->delete($conVenueID);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            session()->setFlashdata('success', 'Venue deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Venue not found.');
        }
        return redirect()->to('/admin-convention/service');
    }
    public function updateserviceconVenue()
    {
        $file = $this->request->getFile('Image');
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
                    'max_size[Image,10240]',
                    'ext_in[Image,png,jpg,gif]'
                ]
            ];
            if ($this->validate($rules)) {
                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->move(FCPATH . 'convention/', $newFileName)) {
                        $this->convenues->save($data);
                    } else {
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
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
                    'max_size[Image,10240]', 
                    'ext_in[Image,png,jpg,gif]'
                ]
            ];
            if ($this->validate($rules)) {
                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->move(FCPATH . 'uploads/', $newFileName)) {
                        $this->events->save($data);
                    } else {
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                $data['validation'] = $this->validator;
            }
        } else {
            echo ('error');
        }
        return redirect()->to('/admin-convention/service');
    }
    public function deleteServiceConEvent($EventID)
    {
        $conEvent = $this->events->find($EventID);
        if ($conEvent) {
            $imagePath = FCPATH . 'uploads/' . $conEvent['Image'];
            $this->events->delete($EventID);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            session()->setFlashdata('success', 'Venue deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Venue not found.');
        }
        return redirect()->to('/admin-convention/service');
    }
    public function updateserviceEvent()
    {
        $file = $this->request->getFile('Image');
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
                    'max_size[Image,10240]', 
                    'ext_in[Image,png,jpg,gif]' 
                ]
            ];
            if ($this->validate($rules)) {
                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->move(FCPATH . 'uploads/', $newFileName)) {
                        $this->events->save($data);
                    } else {
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
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
        return view('Admin/qrcode', $data);
    }
    public function updateQrcode()
    {
        $file = $this->request->getFile('Image');
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
                    'max_size[Image,10240]', 
                    'ext_in[Image,png,jpg,gif]' 
                ]
            ];
            if ($this->validate($rules)) {
                if ($file->isValid() && !$file->hasMoved()) {
                    if ($file->move(FCPATH . 'qrimage/', $newFileName)) {
                        $this->qr->save($data);
                    } else {
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
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
        $db = \Config\Database::connect(); 
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
        if ($reservationDetails && new DateTime($reservationDetails->CheckOutDate) < new DateTime()) {
            $reservationDetails->Status = 'Expired';
        } else {
            $reservationDetails->Status = 'Valid';
        }
        if ($reservationDetails && !empty($reservationDetails->AmenitiesID)) {
            $amenitiesArray = explode(',', $reservationDetails->AmenitiesID);
            $reservationDetails->AmenitiesID = $amenitiesArray;
        } else {
            $reservationDetails->AmenitiesID = [];
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
        $db = \Config\Database::connect(); 
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
        if ($reservationDetails && new DateTime($reservationDetails->CheckOutDate) < new DateTime()) {
            $reservationDetails->Status = 'Expired';
        } else {
            $reservationDetails->Status = 'Valid';
        }
        if ($reservationDetails) {
            return view('Hotell/conventionreservation_view', ['reservation' => $reservationDetails]);
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
        $validationRules = [
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
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
        $newNewsData = [
            'Image' => $newFileName
        ];
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
        $validationRules = [
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-newspromotion'))->with('validationErrors', $validationErrors);
        }
        $newsID = $this->request->getPost('NewsID');
        $newFileName = '';
        $image = $this->request->getFile('Image');
        if ($image->isValid() && !$image->hasMoved()) {
            $newFileName = $image->getRandomName();
            $image->move(FCPATH . 'news/', $newFileName);
        } else {
            return redirect()->to(base_url('/admin-newspromotion'))->with('error', 'Failed to upload image. Please try again.');
        }
        $updatedNewsData = ['Image' => $newFileName];
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
        $news = $newsModel->find($newsID);
        if ($news) {
            $imagePath = FCPATH . 'news/' . $news['Image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $deleted = $newsModel->delete($newsID);
            if ($deleted) {
                return redirect()->to(base_url('admin-newspromotion'))->with('success', 'News deleted successfully.');
            } else {
                return redirect()->to(base_url('admin-newspromotion'))->with('error', 'Failed to delete news. Please try again.');
            }
        } else {
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
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $dataType = $this->request->getPost('data_type');
        $data = [];
        if ($dataType === 'hotel') {
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
        return $this->response->setJSON($data);
    }
}
