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
use App\Models\ReservationModel;
use App\Models\RegionModel;
use App\Models\ProvinceModel;
use App\Models\CityModel;
use App\Models\BarangayModel;
use App\Models\MenuModel;
use App\Models\MenuProductModel;
use App\Models\MenuCategoryModel;
use App\Models\MenuProductIcedModel;
use App\Models\RestaurantVenueModel;
use App\Models\ConventionVenueModel;
use App\Models\ConventionModel;
use App\Models\RoomInventoryModel;
use App\Models\RoomImageModel;
use App\Models\ReservationAmenities;
use App\Traits\EmailTrait;
use App\Models\GuestModel;
use App\Models\WalkInModel;
use CodeIgniter\API\ResponseTrait;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;

class StaffController extends BaseController
{
    use ResponseTrait;
    use EmailTrait;
    private $venues;
    private $menus;
    private $products;
    private $categories;
    private $iced;
    private $rooms;
    private $tables;
    private $events;
    private $users;
    private $usersrole;
    private $staffDetail;
    private $department;
    private $admin;
    private $reservation;
    private $regions;
    private $province;
    private $cities;
    private $barangay;
    private $guest;
    private $convenues;
    private $conventions;
    private $roominventory;
    private $reseraminities;
    private $roomimages;
    private $walkins;
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
        $this->reservation = new ReservationModel();
        $this->regions = new RegionModel();
        $this->province = new ProvinceModel();
        $this->cities = new CityModel();
        $this->barangay = new BarangayModel();
        $this->menus = new MenuModel();
        $this->venues = new RestaurantVenueModel();
        $this->products = new MenuProductModel();
        $this->categories = new MenuCategoryModel();
        $this->iced = new MenuProductIcedModel();
        $this->convenues = new ConventionVenueModel();
        $this->conventions = new ConventionModel();
        $this->guest = new GuestModel();
        $this->roominventory = new RoomInventoryModel();
        $this->reseraminities = new ReservationAmenities();
        $this->roomimages = new RoomImageModel();
        $this->walkins = new WalkInModel();
    }
    public function login()
    {
        helper(['form']);
        $data = [
            'activePage' => 'StaffLogin',
        ];
        return view('StaffLogin', $data);
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
                                return redirect()->to('/stafflogin');
                        }
                    } else {
                        return redirect()->to('/stafflogin');
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
            return redirect()->to('/adminlogin');
        }
    }
    public function updatehotelProfile($userID)
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
        return redirect()->to(base_url('/staff-hotelsetting'));
    }
    public function updaterestaurantProfile($userID)
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
        return redirect()->to(base_url('/staff-ressetting'));
    }
    public function updateconventionProfile($userID)
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
        return redirect()->to(base_url('/staff-consetting'));
    }
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/staff-login');
    }
    public function home()
    {
        $data = [
            'currentRoute' => 'home',
            'roinvents' => $this->roominventory->findAll(),
        ];
        return view('Stafff/HotelStaff/index', $data);
    }
    public function reservation()
    {
        $data = [
            'currentRoute' => 'hotel',
            'hotelrevs' => $this->reservation
                ->select('reservations.ReservationID, rooms.RoomID, rooms.RoomNumber, rooms.RoomType, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests,reservations.PaymentOption,reservations.ReferenceNumber,reservations.Adult,reservations.Child, reservations.downorfullPayment,reservations.Image, reservations.TotalAmount, reservations.Status, users.UserID, users.FirstName, users.LastName, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address', false)
                ->join('rooms', 'reservations.RoomID = rooms.RoomID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->findAll(),
            'regions' => $this->regions->findAll(),
        ];
        return view('Stafff/HotelStaff/reservation', $data);
    }
    public function holreservationAmenities()
    {
        $regions = $this->regions->findAll();
        $roomInventories = $this->roominventory->findAll();

        $amihotelrevs = $this->reseraminities
            ->select('
                reservations.ReservationID as resv_ReservationID,
                rooms.RoomID,
                rooms.RoomNumber,
                rooms.RoomType,
                reservations.CheckInDate,
                reservations.CheckOutDate,
                reservations.NumberOfGuests,
                reservations.PaymentOption,
                reservations.ReferenceNumber,
                reservations.Adult,
                reservations.Child,
                reservations.downorfullPayment,
                reservations.Image,
                reservations.TotalAmount,
                reservations.Status,
                users.UserID as user_UserID,
                users.FirstName,
                users.LastName,
                users.ContactNumber,
                CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address,
                GROUP_CONCAT(
                    room_inventory.ProductName 
                    ORDER BY room_inventory.ProductName 
                    SEPARATOR ", "
                ) as ProductNames,
                GROUP_CONCAT(
                    reservation_amenities.insertQuantity 
                    ORDER BY room_inventory.ProductName 
                    SEPARATOR ", "
                ) as InsertQuantities,
                MAX(reservation_amenities.AmenitiesID) as AmenitiesID
            ')
            ->join('reservations', 'reservation_amenities.ReservationID = reservations.ReservationID', 'left')
            ->join('rooms', 'reservations.RoomID = rooms.RoomID')
            ->join('users', 'reservations.UserID = users.UserID')
            ->join('room_inventory', 'reservation_amenities.roomInventoryID = room_inventory.roomInventoryID', 'left')
            ->groupBy('reservations.ReservationID')
            ->findAll();

        $data = [
            'currentRoute' => 'hotelamenities',
            'regions' => $regions,
            'amihotelrevs' => $amihotelrevs,
            'roomInventories' => $roomInventories,
        ];

        return view('Stafff/HotelStaff/reservation_amenities', $data);
    }
    public function addhotelReservation()
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
                    return redirect()->to(base_url('/staff-hotelreservation'))->with('success', 'Reservation added successfully.');
                } else {
                    return redirect()->to(base_url('/staff-hotelreservation'))->with('error', 'Failed to add reservation. Please try again.');
                }
            } else {
                return redirect()->to(base_url('/staff-hotelreservation'))->with('error', 'Invalid RoomType or RoomNumber. Please check your input.');
            }
        } else {
            return redirect()->to(base_url('/staff-hotelreservation'))->with('error', 'Failed to create user. Please try again.');
        }
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
            return redirect()->to('/staff-hotelroom')->with('status', 'Room deleted successfully');
        } else {
            return redirect()->to('/staff-hotelroom')->with('error', 'Room not found');
        }
    }
    public function updatehotelReservation($reservationID)
    {
        helper(['form']);
        $userData = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
        ];
        $reservation = $this->reservation->find($reservationID);
        if (!$reservation) {
            return redirect()->to(base_url('/staff-hotelreservation'))->with('error', 'Reservation not found.');
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
                    return redirect()->to(base_url('/staff-hotelreservation'))->with('success', 'Reservation updated successfully.');
                } else {
                    return redirect()->to(base_url('/staff-hotelreservation'))->with('error', 'Failed to update reservation. Please try again.');
                }
            } else {
                return redirect()->to(base_url('/staff-hotelreservation'))->with('error', 'Invalid RoomType or RoomNumber. Please check your input.');
            }
        } else {
            return redirect()->to(base_url('/staff-hotelreservation'))->with('error', 'Failed to update user information. Please try again.');
        }
    }
    public function addhotelamenitiesReservation()
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
            
            $guestData = ['UserID' => $UserID];
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
                $reservationID = $this->reservation->getInsertID();
                if ($inserted) {
                    $amenitiesData = $this->request->getPost('roomInventoryID');
                    $insertQuantities = $this->request->getPost('insertQuantity');

                    if ($amenitiesData && $insertQuantities) {
                        foreach ($amenitiesData as $amenityID) {
                            $insertQuantity = $insertQuantities[$amenityID] ?? 0;
                            if ($insertQuantity > 0) {
                                $amenityData = [
                                    'ReservationID' => $reservationID,
                                    'roomInventoryID' => $amenityID,
                                    'insertQuantity' => $insertQuantity,
                                    'UserID' => $UserID,
                                ];
                                $this->reseraminities->insert($amenityData);
                                $roomInventory = $this->roominventory->find($amenityID);
                                if ($roomInventory) {
                                    $currentQuantity = $roomInventory['Quantity'];
                                    $newQuantity = $currentQuantity - $insertQuantity;
                                    $this->roominventory->update($amenityID, ['Quantity' => $newQuantity]);
                                }
                            }
                        }
                    } else {
                        
                        $amenityData = [
                            'ReservationID' => $reservationID,
                            'roomInventoryID' => null,
                            'insertQuantity' => null,
                            'UserID' => $UserID,
                        ];
                        $this->reseraminities->insert($amenityData);
                    }

                    return redirect()->to(base_url('/staff-hotelreservation-amenities'))->with('success', 'Reservation added successfully.');
                } else {
                    return redirect()->to(base_url('/staff-hotelreservation-amenities'))->with('error', 'Failed to add reservation. Please try again.');
                }
            } else {
                return redirect()->to(base_url('/staff-hotelreservation-amenities'))->with('error', 'Invalid RoomType or RoomNumber. Please check your input.');
            }
        } else {
            return redirect()->to(base_url('/staff-hotelreservation-amenities'))->with('error', 'Failed to create user. Please try again.');
        }
    }
    public function updatehotelamenitiesReservation($amenitiesID)
    {
        helper(['form']);

        $userData = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
        ];
        $reservation = $this->reseraminities->find($amenitiesID); 
        if (!$reservation) {
            return redirect()->to(base_url('/staff-hotelreservation-amenities'))->with('error', 'Reservation not found.');
        }
        $userID = $reservation['UserID'];
        $updateUserResult = $this->users->update($userID, $userData);

        if ($updateUserResult) {
            $roomNumber = $this->request->getPost('RoomNumber');
            $roomType = $this->request->getPost('RoomType');
            $roomData = $this->rooms->where('RoomNumber', $roomNumber)->where('RoomType', $roomType)->first();
            if ($roomData) {
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
                    'RoomID' => $roomData['RoomID'],
                    'UserID' => $userID,
                ];
                $updateReservationResult = $this->reseraminities->update($amenitiesID, $newReservationData);

                if ($updateReservationResult) {
                    $roomInventoryIDs = $this->request->getPost('roomInventoryID') ?: [];
                    $insertQuantities = $this->request->getPost('insertQuantity') ?: [];

                    $existingRoomInventoryIDs = $this->reseraminities
                        ->where('ReservationID', $reservation['ReservationID'])
                        ->findColumn('roomInventoryID');

                    foreach ($existingRoomInventoryIDs as $existingRoomInventoryID) {
                        if (!in_array($existingRoomInventoryID, $roomInventoryIDs)) {
                            $this->reseraminities
                                ->where('ReservationID', $reservation['ReservationID'])
                                ->where('roomInventoryID', $existingRoomInventoryID)
                                ->delete();
                        }
                    }

                    foreach ($roomInventoryIDs as $roomInventoryID) {
                        $existingRecord = $this->reseraminities
                            ->where('ReservationID', $reservation['ReservationID'])
                            ->where('roomInventoryID', $roomInventoryID)
                            ->first();

                        if ($existingRecord) {

                            $this->reseraminities->update($existingRecord['AmenitiesID'], [
                                'insertQuantity' => $insertQuantities[$roomInventoryID]
                            ]);
                        } else {

                            $this->reseraminities->insert([
                                'ReservationID' => $reservation['ReservationID'],
                                'UserID' => $userID,
                                'roomInventoryID' => $roomInventoryID,
                                'insertQuantity' => $insertQuantities[$roomInventoryID],
                            ]);
                        }
                    }

                    return redirect()->to(base_url('/staff-hotelreservation-amenities'))->with('success', 'Reservation updated successfully.');
                } else {
                    return redirect()->to(base_url('/staff-hotelreservation-amenities'))->with('error', 'Failed to update reservation. Please try again.');
                }
            } else {
                return redirect()->to(base_url('/staff-hotelreservation-amenities'))->with('error', 'Invalid RoomType or RoomNumber. Please check your input.');
            }
        } else {
            return redirect()->to(base_url('/staff-hotelreservation-amenities'))->with('error', 'Failed to update user information. Please try again.');
        }
    }
    public function updateStatus($status, $reservationID)
    {
        $session = session();
        $allowedStatuses = ['Confirm', 'Pending', 'Cancel'];
        if (!in_array($status, $allowedStatuses)) {
            return redirect()->back()->with('error', 'Invalid status');
        }
        $reservation = $this->reservation->where('ReservationID', $reservationID)->first();
        if (!$reservation) {
            return redirect()->back()->with('error', 'Reservation not found');
        }
        $user = $this->users->where('UserID', $reservation['UserID'])->first();
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
            return redirect()->to('/staff-hotelreservation');
        } else {
            return redirect()->back()->with('error', 'Failed to update reservation status');
        }
    }
    protected $googleProjectId = 'push-notif-309d3'; 

    public function sendPushNotification($token, $title, $body, $data = [], $image = null)
    {
        $serviceAccountPath = ROOTPATH . 'pvKey.json'; 

        $credential = new ServiceAccountCredentials(
            "https://www.googleapis.com/auth/firebase.messaging",
            json_decode(file_get_contents($serviceAccountPath), true)
        );

        
        $tokenData = $credential->fetchAuthToken(HttpHandlerFactory::build());
        $accessToken = $tokenData['access_token'] ?? null;

        if (!$accessToken) {
            log_message('error', 'Failed to retrieve access token for Firebase.');
            return false;
        }

        $url = "https://fcm.googleapis.com/v1/projects/{$this->googleProjectId}/messages:send";

        $payload = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'image' => $image, 
                ],
                'webpush' => [
                    'fcm_options' => [
                        'link' => 'https://mahalta.online/'  
                    ]
                ],
                
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $result = curl_exec($ch);

        if ($result === false) {
            log_message('error', 'CURL failed: ' . curl_error($ch));
        } else {
            log_message('info', 'FCM response: ' . $result);
        }

        curl_close($ch);

        return json_decode($result, true);
    }
    public function room()
    {
        $data = [
            'currentRoute' => 'room',
            'rooms' => $this->rooms->findAll(),
            'roomimages' => $this->roomimages
                ->select('rooms.RoomID, rooms.RoomNumber, rooms.RoomType, rooms.Description, rooms.PricePerNight, rooms.minPerson, rooms.maxPerson, GROUP_CONCAT(room_images.Image) AS Images')
                ->join('rooms', 'room_images.RoomID = rooms.RoomID')
                ->groupBy('rooms.RoomID')
                ->findAll(),
        ];
        return view('Stafff/HotelStaff/room', $data);
    }
    public function addRoom()
    {
        $file = $this->request->getFile('Image');
        if ($file) {
            $newFileName = $file->getRandomName();
            $data = [
                'RoomNumber' => $this->request->getVar('RoomNumber'),
                'RoomType' => $this->request->getVar('RoomType'),
                'Description' => $this->request->getVar('Description'),
                'PricePerNight' => $this->request->getVar('PricePerNight'),
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

        return redirect()->to('/staff-hotelroom');
    }
    public function hotelsetting()
    {
        $data = [
            'currenttRoute' => 'hotelsetting',
        ];
        return view('Stafff/HotelStaff/setting', $data);
    }
    public function hotelupdatePassword()
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
                return redirect()->to('/staff-hotelsetting');
            } else {
                $session->setFlashdata('msg', 'Old password is incorrect');
                return redirect()->to('/staff-hotelsetting');
            }
        } else {
            $data['validation'] = $this->validator;
            return view('Stafff/HotelStaff/setting', $data);
        }
    }
    public function updateRoom()
    {

        $file = $this->request->getFile('Image');
        if ($file && $file->isValid()) {
            $newFileName = $file->getRandomName();
            $data = [
                'RoomID' => $this->request->getVar('RoomID'),
                'RoomNumber' => $this->request->getVar('RoomNumber'),
                'RoomType' => $this->request->getVar('RoomType'),
                'Description' => $this->request->getVar('Description'),
                'PricePerNight' => $this->request->getVar('PricePerNight'),
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
                if (!$file->hasMoved()) {
                    if ($file->move(FCPATH . 'uploads/', $newFileName)) {
                        
                        $this->rooms->update($data['RoomID'], $data);
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
        return redirect()->to('/staff-hotelroom');
    }
    public function reshome()
    {
        $data = [
            'currenttRoute' => 'home',
        ];
        return view('Stafff/RestaurantStaff/index', $data);
    }
    public function resReservation()
    {
        $data = [
            'currenttRoute' => 'restaurant',
            'restrevs' => $this->reservation
                ->select('reservations.ReservationID, restaurant_venue.VenueID, restaurant_venue.VenueName, reservations.ArivalDate,reservations.ArivalTime, reservations.CheckInDate, reservations.NumberOfGuests, reservations.Note, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, CONCAT(users.Region, ", ", users.Province, ", ", users.City, ", ", users.Barangay) as Address, reservations.UserID ')
                ->join('restaurant_venue', 'reservations.VenueID = restaurant_venue.VenueID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->findAll()
        ];
        return view('Stafff/RestaurantStaff/reservation', $data);
    }

    public function addrestauReservation()
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
                        'Status' => 'Confirm',
                        'VenueName' => $VenueName,
                        'VenueID' => $restaurantVenue['VenueID'],
                        'UserID' => $UserID,
                    ];
                    $inserted = $this->reservation->insert($restaurantReservation);
                    if ($inserted) {
                        return redirect()->to(base_url('/staff-restaurant-reservation'))->with('success', 'Reservation updated successfully.');
                    } else {
                        return redirect()->to(base_url('/staff-restaurant-reservation'))->with('error', 'Failed to add reservation. Please try again.');
                    }
                } else {
                    return redirect()->to(base_url('/staff-restaurant-reservation'))->with('error', 'Not enough available capacity. Please select a different venue or reduce the number of guests.');
                }
            } else {
                return redirect()->to(base_url('/staff-restaurant-reservation'))->with('error', 'Invalid user or venue information. Please check your input.');
            }
        } else {
            return redirect()->to(base_url('/admin-dashboard'))->with('error', 'Failed to create user. Please try again.');
        }
    }
    public function updaterestauReservation($reservationID)
    {
        helper(['form']);
        $userData = [
            'FirstName' => $this->request->getVar('FirstName'),
            'LastName' => $this->request->getVar('LastName'),
            'ContactNumber' => $this->request->getVar('ContactNumber'),
        ];
        $reservation = $this->reservation->find($reservationID);
        if (!$reservation) {
            return redirect()->to(base_url('/staff-restaurant-reservation'))->with('error', 'Reservation not found.');
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
                        'Status' => 'Confirm',
                        'VenueName' => $VenueName,
                        'VenueID' => $restaurantVenue['VenueID'],
                        'UserID' => $userID,
                    ];
                    $updated = $this->reservation->update($reservationID, $restaurantReservation);
                    if ($updated) {
                        return redirect()->to(base_url('/staff-restaurant-reservation'))->with('success', 'Reservation updated successfully.');
                    } else {
                        $this->venues->update($restaurantVenue['VenueID'], ['AvailableCapacity' => $availableCapacity]);
                        return redirect()->to(base_url('/staff-restaurant-reservation'))->with('error', 'Failed to update reservation. Please try again.');
                    }
                } else {
                    return redirect()->to(base_url('/staff-restaurant-reservation'))->with('error', 'Not enough available capacity. Please select a different venue or reduce the number of guests.');
                }
            } else {
                return redirect()->to(base_url('/staff-restaurant-reservation'))->with('error', 'Invalid venue information. Please check your input.');
            }
        } else {
            return redirect()->to(base_url('/staff-restaurant-reservation'))->with('error', 'Failed to update user information. Please try again.');
        }
    }
    public function updaterestauStatus($status, $reservationID)
    {
        $session = session();
        $allowedStatuses = ['Confirm', 'Pending', 'Cancel'];
        if (!in_array($status, $allowedStatuses)) {

            return redirect()->back()->with('error', 'Invalid status');
        }
        $reservation = $this->reservation->where('ReservationID', $reservationID)->first();
        if (!$reservation) {

            return redirect()->back()->with('error', 'Reservation not found');
        }
        $user = $this->users->where('UserID', $reservation['UserID'])->first();
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
            return redirect()->to('/staff-restaurant-reservation');
        } else {
            return redirect()->back()->with('error', 'Failed to update reservation status');
        }
    }
    public function ressetting()
    {
        $data = [
            'currenttRoute' => 'ressetting',
        ];
        return view('Stafff/RestaurantStaff/setting', $data);
    }
    public function resupdatePassword()
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
                return redirect()->to('/staff-ressetting');
            } else {
                $session->setFlashdata('msg', 'Old password is incorrect');
                return redirect()->to('/staff-ressetting');
            }
        } else {
            $data['validation'] = $this->validator;
            return view('Stafff/RestaurantStaff/setting', $data);
        }
    }
    public function resVenue()
    {
        $data = [
            'currenttRoute' => 'venue',
            'venues' => $this->venues->select('restaurant_venue.VenueID,restaurant_venue.VenueName,restaurant_venue.VenueCapacity,restaurant_venue.AvailableCapacity,restaurant_venue.Image ')->findAll(),
        ];
        return view('Stafff/RestaurantStaff/venue', $data);
    }
    public function addVenue()
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
        return redirect()->to('/staff-restaurant-venue');
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
            return redirect()->to('/staff-restaurant-venue')->with('status', 'Room deleted successfully');
        } else {
            return redirect()->to('/staff-restaurant-venue')->with('error', 'Room not found');
        }
    }
    public function updateVenue()
    {
        $file = $this->request->getFile('Image');
        if ($file && $file->isValid()) {
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
                if (!$file->hasMoved()) {
                    if ($file->move(FCPATH . 'uploads/', $newFileName)) {
                        
                        $this->venues->update($data['VenueID'], $data);
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
        return redirect()->to('/staff-restaurant-venue');
    }
    public function resMenu()
    {
        $data = [
            'currenttRoute' => 'menu',
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
        return view('Stafff/RestaurantStaff/menu', $data);
    }

    public function conhome()
    {
        $data = [
            'currentttRoute' => 'home',
        ];
        return view('Stafff/ConventionStaff/index', $data);
    }
    public function conReservation()
    {
        $data = [
            'currentttRoute' => 'convention',
            'reevents' => $this->reservation
                ->select('reservations.ReservationID, convention.conventionID, convention.conVenueID, convention_venue.conVenueID, convention_venue.conVenueName, convention_venue.minGuest, convention_venue.maxGuest, convention_venue.Image as venue_image, convention.EventID, events.EventType, events.Description as event_description, events.Image as event_image, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.PaymentOption, reservations.ReferenceNumber, reservations.downorfullPayment, reservations.TotalAmount, reservations.Image as reservation_image, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, users.Email, reservations.UserID')
                ->join('convention', 'reservations.conventionID = convention.conventionID')
                ->join('convention_venue', 'convention.conVenueID = convention_venue.conVenueID')
                ->join('events', 'convention.EventID = events.EventID')
                ->join('users', 'reservations.UserID = users.UserID')
                ->findAll()
        ];
        return view('Stafff/ConventionStaff/reservation', $data);
    }
    public function addconReservation()
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
                        return redirect()->to(base_url('/staff-convention-reservation'))->with('success', 'Reservation added successfully.');
                    } else {
                        return redirect()->to(base_url('/staff-convention-reservation'))->with('error', 'Failed to add reservation. Please try again.');
                    }
                } else {
                    return redirect()->to(base_url('/staff-convention-reservation'))->with('error', 'Failed to add convention. Please check your input.');
                }
            } else {
                return redirect()->to(base_url('/staff-convention-reservation'))->with('error', 'Invalid Event Type or Venue Name. Please check your input.');
            }
        } else {
            return redirect()->to(base_url('/staff-convention-reservation'))->with('error', 'Failed to create user. Please try again.');
        }
    }
    public function updateconReservation($reservationID)
    {
        helper(['form']);
        $existingReservation = $this->reservation->find($reservationID);
        if (!$existingReservation) {
            return redirect()->to(base_url('/staff-convention-reservation'))->with('error', 'Reservation not found.');
        }
        $userID = $existingReservation['UserID'];
        $existingUser = $this->users->find($userID);
        if (!$existingUser) {
            return redirect()->to(base_url('/staff-convention-reservation'))->with('error', 'User associated with the reservation not found.');
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
                        return redirect()->to(base_url('/staff-convention-reservation'))->with('success', 'Reservation updated successfully.');
                    } else {
                        return redirect()->to(base_url('/staff-convention-reservation'))->with('error', 'Failed to update reservation. Please try again.');
                    }
                } else {
                    return redirect()->to(base_url('/staff-convention-reservation'))->with('error', 'Failed to update convention. Please check your input.');
                }
            } else {
                return redirect()->to(base_url('/staff-convention-reservation'))->with('error', 'Invalid Event Type or Venue Name. Please check your input.');
            }
        } else {
            return redirect()->to(base_url('/staff-convention-reservation'))->with('error', 'Failed to update user. Please try again.');
        }
    }
    public function updateconStatus($status, $reservationID)
    {
        $session = session();
        $allowedStatuses = ['Confirm', 'Pending', 'Cancel'];

        if (!in_array($status, $allowedStatuses)) {

            return redirect()->back()->with('error', 'Invalid status');
        }
        $reservation = $this->reservation->where('ReservationID', $reservationID)->first();
        if (!$reservation) {
            return redirect()->back()->with('error', 'Reservation not found');
        }
        $user = $this->users->where('UserID', $reservation['UserID'])->first();
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
    public function conVenue()
    {
        $data = [
            'currentttRoute' => 'venue',
            'convenues' => $this->convenues->findAll(),
        ];
        return view('Stafff/ConventionStaff/venue', $data);
    }
    public function addconVenue()
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
        return redirect()->to('/staff-convention-venue');
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
        return redirect()->to('/staff-convention-venue');
    }
    public function updateconVenue()
    {
        $file = $this->request->getFile('Image');
        if ($file && $file->isValid()) {
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
                if (!$file->hasMoved()) {
                    if ($file->move(FCPATH . 'convention/', $newFileName)) {
                        $this->convenues->update($data['conVenueID'], $data);
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
        return redirect()->to('/staff-convention-venue');
    }
    public function conEvent()
    {
        $data = [
            'currentttRoute' => 'event',
            'events' => $this->events->findAll(),
        ];
        return view('Stafff/ConventionStaff/events', $data);
    }

    public function addEvent()
    {
        $file = $this->request->getFile('Image');
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
        return redirect()->to('/staff-convention-event');
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
        return redirect()->to('/staff-convention-event');
    }
    public function updateEvent()
    {
        $file = $this->request->getFile('Image');
        if ($file && $file->isValid()) {
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
                if (!$file->hasMoved()) {
                    if ($file->move(FCPATH . 'uploads/', $newFileName)) {
                        $this->events->update($data['EventID'], $data);
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
        return redirect()->to('/staff-convention-event');
    }
    public function consetting()
    {
        $data = [
            'currenttRoute' => 'consetting',
        ];
        return view('Stafff/ConventionStaff/setting', $data);
    }
    public function conupdatePassword()
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
                return redirect()->to('/staff-consetting');
            } else {
                $session->setFlashdata('msg', 'Old password is incorrect');
                return redirect()->to('/staff-consetting');
            }
        } else {
            $data['validation'] = $this->validator;
            return view('Stafff/ConventionStaff/setting', $data);
        }
    }

    public function walkin()
    {
        $data = [
            'currentRoute' => 'walkin',
            'rooms' => $this->rooms->findAll(),
            'roominventory' => $this->roominventory->findAll(),
            'walkins' => $this->walkins
                ->select('walkin.walkinID,walkin.RoomID, rooms.RoomID, rooms.RoomType, rooms.RoomNumber, walkin.roominventoryID, room_inventory.ProductName, room_inventory.Quantity, walkin.FirstName, walkin.LastName, walkin.ContactNumber,walkin.CheckIn, walkin.CheckOut, walkin.Adult, walkin.Child, walkin.Discount, walkin.TotalAmount')
                ->join('rooms', 'walkin.RoomID = rooms.RoomID')
                ->join('room_inventory', 'walkin.roominventoryID = room_inventory.roominventoryID')
                ->findAll()
        ];
        return view('Stafff/HotelStaff/hotel', $data);
    }
    public function getDataa()
    {
        $session = \Config\Services::session();
        $checkInDate = $this->request->getGet('CheckIn');
        $checkOutDate = $this->request->getGet('CheckOut');
        $numberOfAdults = $this->request->getGet('Adult');
        $numberOfChildren = $this->request->getGet('Child');
        $reservationData = [
            'CheckIn' => $checkInDate,
            'CheckOut' => $checkOutDate,
            'Adult' => $numberOfAdults,
            'Child' => $numberOfChildren,
        ];
        $session->set('reservationData', $reservationData);
        $roomModel = new RoomModel();
        $availableRooms = $roomModel->findAvailableRooms($checkInDate, $checkOutDate, $numberOfAdults, $numberOfChildren);
        return view('Stafff/HotelStaff//hotel', [
            'reservationData' => $reservationData,
            'availableRooms' => $availableRooms,
            'currentRoute' => 'walkin',
            'roomimages' => $this->roomimages
                ->select('rooms.RoomID, rooms.RoomNumber, rooms.RoomType, rooms.Description, rooms.PricePerNight, rooms.minPerson, rooms.maxPerson,  rooms.Image, GROUP_CONCAT(room_images.Image) AS Images')
                ->join('rooms', 'room_images.RoomID = rooms.RoomID')
                ->groupBy('rooms.RoomID')
                ->findAll(),
            'rooms' => $this->rooms->findAll(),
        ]);
    }
    public function getdataRoomm()
    {
        $session = \Config\Services::session();
        $selectedRoomID = $this->request->getGet('selectedRoomID');
        $checkInFieldName = 'CheckIn' . $selectedRoomID;
        $checkOutFieldName = 'CheckOut' . $selectedRoomID;
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
                    'CheckIn' => $checkInDate,
                    'CheckOut' => $checkOutDate,
                    'Adult' => $numberOfAdults,
                    'Child' => $numberOfChildren,
                    'TotalAmount' => $TotalAmount
                ]);
            }
        }
        return view('Stafff/HotelStaff/hotel', [
            'reservationData' => $session->get('reservationData'),
            'availableRooms' => $availableRooms,
            'roomSelected' => $roomSelected,
            'TotalAmount' => $TotalAmount,
            'currentRoute' => 'walkin',
            'roomimages' => $this->roomimages
                ->select('rooms.RoomID, rooms.RoomNumber, rooms.RoomType, rooms.Description, rooms.PricePerNight, rooms.minPerson, rooms.maxPerson,  rooms.Image, GROUP_CONCAT(room_images.Image) AS Images')
                ->join('rooms', 'room_images.RoomID = rooms.RoomID')
                ->groupBy('rooms.RoomID')
                ->findAll(),
            'rooms' => $this->rooms->findAll(),
        ]);
    }
    public function getdataRoomReservationn()
    {
        $session = \Config\Services::session();
        $reservationData = $session->get('reservationData');
        $roomSelected = $session->get('roomSelected');

        if (!empty($reservationData) && !empty($roomSelected)) {
            $checkInDate = new \DateTime($reservationData['CheckIn']);
            $checkOutDate = new \DateTime($reservationData['CheckOut']);
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

            return view('Stafff/HotelStaff/amenities', [
                'reservationData' => $reservationData,
                'roomSelected' => $roomSelected,
                'TotalAmount' => $TotalAmount,
                'currentRoute' => 'walkin',
                'roinvents' => $this->roominventory->findAll(),
            ]);
        } else {
            return redirect()->to(base_url('/error'));
        }
    }

    public function amenitiess()
    {
        $session = \Config\Services::session();
        $roomReservationData = $session->get('roomReservationData');
        $downPaymentAmount = $roomReservationData['TotalAmount'] * 0.5;
        $fullPaymentAmount = $roomReservationData['TotalAmount'];
        $roomReservationData['DownpaymentAmount'] = $downPaymentAmount;
        $roomReservationData['FullpaymentAmount'] = $fullPaymentAmount;
        $data = [
            'currentRoute' => 'walkin',
            'roinvents' => $this->roominventory->findAll(),
            'roomReservationData' => $roomReservationData,
        ];
        return view('Stafff/HotelStaff/amenities', $data);
    }
    public function addAmenitiess()
    {
        $session = \Config\Services::session();
        $roomInventoryIDs = (array) $this->request->getPost('roomInventoryID');
        $insertQuantities = $this->request->getPost('insertQuantity');
        $roinvents = $this->request->getPost('roinvents');
        $skipAmenities = $this->request->getPost('skip'); 

        if ($skipAmenities) {

            $session->remove('amenitiesData');
            return redirect()->to(base_url('/staff-walkin-availability/dataroomreservation/amenities/formdetails'));
        }
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

            $session->set('amenitiesData', $amenitiesData);

            $totalExtraPrice = 0;
            if (!empty($amenitiesData)) {
                foreach ($amenitiesData as $amenity) {
                    $totalExtraPrice += $amenity['Price'] * $amenity['insertQuantity'];
                }
            }

            $roomReservationData = $session->get('roomReservationData');
            $roomReservationData['TotalAmount'] += $totalExtraPrice;
            $session->set('roomReservationData', $roomReservationData);

            return redirect()->to(base_url('/staff-walkin-availability/dataroomreservation/amenities/formdetails'));
        } else {
            return redirect()->to(base_url('/staff-walkin-availability/dataroomreservation/amenities/'))
                ->with('error', 'Please select at least one amenity or skip.');
        }
    }

    public function formdetailss()
    {
        $session = \Config\Services::session();
        $userID = $session->get('userID');
        $amenitiesData = $session->get('amenitiesData');
        $roomReservationData = $session->get('roomReservationData');
        $totalExtraPrice = 0;

        if (isset($amenitiesData) && !empty($amenitiesData)) {
            foreach ($amenitiesData as &$amenity) {
                $amenity['UserID'] = $userID;
                $totalExtraPrice += $amenity['Price'] * $amenity['insertQuantity'];
            }
        }
        $downPaymentAmount = $roomReservationData['TotalAmount'] * 0.5;
        $fullPaymentAmount = $roomReservationData['TotalAmount'];
        $roomReservationData['DownpaymentAmount'] = $downPaymentAmount;
        $roomReservationData['FullpaymentAmount'] = $fullPaymentAmount;

        $session->set('roomReservationData', $roomReservationData);

        $data = [
            'currentRoute' => 'walkin',
            'rooms' => $this->rooms
                ->select('rooms.RoomID, rooms.RoomNumber, rooms.RoomType,rooms.Description,rooms.PricePerNight,rooms.AvailabilityStatus,rooms.Image')
                ->findAll(),
            'roomReservationData' => $roomReservationData,
            'amenitiesData' => $amenitiesData,
            'totalExtraPrice' => $totalExtraPrice, 
        ];

        return view('Stafff/HotelStaff/checkout', $data);
    }
    public function addReservationn()
    {
        helper(['form']);
        $session = session();
        $roomSelected = $session->get('roomSelected');
        $reservationData = $session->get('reservationData');
        $amenitiesData = $session->get('amenitiesData');
        $totalExtraPrice = $session->get('totalExtraPrice');
        $roomReservationData = $session->get('roomReservationData');
        $TotalAmount = $roomReservationData['TotalAmount'] + $totalExtraPrice;

        $skipAmenities = $this->request->getGet('skip') === 'true';

        if ($roomSelected && $reservationData && $TotalAmount) {
            $checkInTime = '14:00:00'; 
            $checkOutTime = '12:00:00'; 
            $checkInDateTime = $reservationData['CheckIn'] . ' ' . $checkInTime;
            $checkOutDateTime = $reservationData['CheckOut'] . ' ' . $checkOutTime;
            $emailSendDate = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($checkInDateTime)));

            $discount = $this->request->getPost('Discount'); 

            if ($discount !== null && $discount !== '') {

                $discountValue = (int) str_replace('%', '', $discount);
                
                $TotalAmount = $TotalAmount * ((100 - $discountValue) / 100);
            } else {
                $discount = null; 
            }

            $contactNumber = $this->request->getVar('ContactNumber');
            $contactNumber = !empty($contactNumber) ? $contactNumber : null;

            if (!$skipAmenities && $amenitiesData) {
                foreach ($amenitiesData as $amenity) {

                    $newReservationData = [
                        'FirstName' => $this->request->getVar('FirstName'),
                        'LastName' => $this->request->getVar('LastName'),
                        'ContactNumber' => $contactNumber, 
                        'CheckIn' => $checkInDateTime,
                        'CheckOut' => $checkOutDateTime,
                        'Adult' => $reservationData['Adult'],
                        'Child' => $reservationData['Child'],
                        'RoomID' => $roomSelected['RoomID'],
                        'TotalAmount' => $TotalAmount,
                        'Discount' => $discount, 
                        'roomInventoryID' => $amenity['roomInventoryID'], 
                        'insertQuantity' => $amenity['insertQuantity'],  
                    ];

                    $inserted = $this->walkins->insert($newReservationData);

                    if ($inserted) {
                        
                        $roomInventoryID = $amenity['roomInventoryID'];
                        $insertQuantity = $amenity['insertQuantity'];
                        $roomInventory = $this->roominventory->find($roomInventoryID);
                        if ($roomInventory) {
                            $currentQuantity = $roomInventory['Quantity'];
                            $newQuantity = $currentQuantity - $insertQuantity;
                            $this->roominventory->update($roomInventoryID, ['Quantity' => $newQuantity]);
                        }
                    } else {
                        return redirect()->to(base_url('/s'))->with('error', 'Failed to add reservation. Please try again.');
                    }
                }
            } else {
                
                $newReservationData = [
                    'FirstName' => $this->request->getVar('FirstName'),
                    'LastName' => $this->request->getVar('LastName'),
                    'ContactNumber' => $contactNumber, 
                    'CheckIn' => $checkInDateTime,
                    'CheckOut' => $checkOutDateTime,
                    'Adult' => $reservationData['Adult'],
                    'Child' => $reservationData['Child'],
                    'RoomID' => $roomSelected['RoomID'],
                    'TotalAmount' => $TotalAmount,
                    'Discount' => $discount, 
                    'roomInventoryID' => null, 
                    'insertQuantity' => null,  
                ];

                $this->walkins->insert($newReservationData);
            }

            $session->setFlashdata('success', 'Reservation added successfully and confirmation email sent.');
            return redirect()->to('/staff-walkin');
        } else {
            return redirect()->to(base_url('/u'))->with('error', 'Invalid data in sessions. Please check your input.');
        }
    }
    public function getNotifications()
    {
        $model = new RoomInventoryModel();

        $lowStockItems = $model->getLowQuantityItems(10);

        return $this->response->setJSON($lowStockItems);
    }
}
