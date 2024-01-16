<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoomModel;
use App\Models\TableModel;
use App\Models\EventModel;
use App\Models\ReservationModel;

class StaffController extends BaseController
{
    private $users;
    private $rooms;
    private $tables;
    private $events;
    private $reservation;

    function __construct(){
        helper(['form']);
        $this->users = new UserModel();
        $this->rooms = new RoomModel();
        $this->tables = new TableModel();
        $this->events = new EventModel();
        $this->reservation = new ReservationModel();
    }
    public function index()
    {
        //
    }
    public function home()
    {
        $data = [
            'currentRoute' => 'home',
        ];
        return view('Stafff\HotelStaff\index', $data);
    }
    public function reservation()
    {
        $data = [
            'currentRoute' => 'hotel',
            'hotelrevs' => $this->reservation
            ->select('reservations.ReservationID, rooms.RoomID, rooms.RoomType, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.TotalAmount, reservations.Status, users.UserID,  users.FirstName,  users.LastName, reservations.UserID ')
            ->join ('rooms', 'reservations.RoomID = rooms.RoomID')
            ->join ('users', 'reservations.UserID = users.UserID')
            ->findAll()
        ]; 
        return view('Stafff\HotelStaff\reservation', $data);
    }
    public function room()
    {
        $data = [
            'currentRoute' => 'room',
            'rooms' => $this->rooms->findAll(),
        ]; 
        return view('Stafff\HotelStaff\room', $data);
    }
    public function addReservation()
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
                return redirect()->to(base_url('/bookroom'))->with('success', 'Reservation added successfully.');
            } else {
                return redirect()->to(base_url('/bookroom'))->with('error', 'Failed to add reservation. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/'))->with('error', 'Invalid Username, RoomType, or RoomNumber. Please check your input.');
        }
    }
    public function addRoom(){
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
    
        return redirect()->to('/staff-hotelroom');
    }
    

    public function deleteRoom($RoomID = null){
        $this->rooms->delete($RoomID);
        return redirect()->to('/staff-hotelroom');
    }


    public function updateRoom(){

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
        return redirect()->to('/staff-hotelroom');
    }
    public function reshome()
    {
        $data = [
            'currenttRoute' => 'home',
        ];
        return view('Stafff\RestaurantStaff\index', $data);
    }
    public function resReservation()
    {
        $data = [
            'currenttRoute' => 'restaurant',
            'restrevs' => $this->reservation
            ->select('reservations.ReservationID, restaurant_dining_tables.TableID, restaurant_dining_tables.TableNumber, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.Note, reservations.Status, users.UserID,  users.FirstName,  users.LastName, reservations.UserID ')
            ->join ('restaurant_dining_tables', 'reservations.TableID = restaurant_dining_tables.TableID')
            ->join ('users', 'reservations.UserID = users.UserID')
            ->findAll()
        ]; 
        return view('Stafff\RestaurantStaff\reservation',$data);
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
    
    public function resTable()
    {

        $data = [
            'currenttRoute' => 'table',
            'tables' => $this->tables->findAll(),
        ]; 
        return view('Stafff\RestaurantStaff\table',$data);
    }
    public function conhome()
    {
        $data = [
            'currentttRoute' => 'home',
        ];
        return view('Stafff\ConventionStaff\index', $data);
    }
    public function conReservation()
    {
        $data = [
            'currentttRoute' => 'convention',
            'reevents' => $this->reservation
            ->select('reservations.ReservationID, events.EventID, events.EventName, events.EventType, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.Note, reservations.Status, users.UserID,  users.FirstName,  users.LastName, reservations.UserID ')
            ->join ('events', 'reservations.EventID = events.EventID')
            ->join ('users', 'reservations.UserID = users.UserID')
            ->findAll()
        ]; 
        return view('Stafff\ConventionStaff\reservation', $data);
    }

    public function conEvent()
    {
        $data = [
            'currentttRoute' => 'event',
            'events' => $this->events->findAll(),
        ]; 
        return view('Stafff\ConventionStaff\events', $data);
    }
}

