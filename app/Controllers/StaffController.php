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
            ->select('reservations.ReservationID, rooms.RoomID, rooms.RoomNumber, rooms.RoomType, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.ReferenceNumber, reservations.TotalAmount, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, users.Address, reservations.UserID ')
            ->join ('rooms', 'reservations.RoomID = rooms.RoomID')
            ->join ('users', 'reservations.UserID = users.UserID')
            ->findAll()
        ]; 
        return view('Stafff\HotelStaff\reservation', $data);
    }
    public function addhotelReservation()
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
                return redirect()->to(base_url('/staff-hotelreservation'))->with('success', 'Reservation added successfully.');
            } else {
                return redirect()->to(base_url('/staff-hotelreservation'))->with('error', 'Failed to add reservation. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/staff-hotel'))->with('error', 'Invalid Username, RoomType, or RoomNumber. Please check your input.');
        }
    }
    public function updatehotelReservation($reservationID)
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
        return redirect()->to(base_url('/staff-hotelreservation'))->with('success', 'Reservation updated successfully.');
        } else {
            return redirect()->to(base_url('/staff-hotel'))->with('error', 'Invalid RoomType or RoomNumber. Please check your input.');
        }
    }

    public function updateStatus($status, $reservationID)
    {
        // Get the ReservationID from the request, assuming it's sent via POST
        $allowedStatuses = ['Confirm', 'Pending', 'Cancel'];
        if (!in_array($status, $allowedStatuses)) {
            // Handle invalid status (you may redirect or show an error message)
            return redirect()->back('/staff-hotel')->with('error', 'Invalid status');
        }

        // Update the reservation status in the database
        $updateData = ['Status' => $status];
        $this->reservation->update($reservationID, $updateData);

        // Redirect to the reservation page or wherever appropriate
        return redirect()->to('/staff-hotelreservation')->with('success', 'Reservation status updated successfully');
    }
    public function room()
    {
        $data = [
            'currentRoute' => 'room',
            'rooms' => $this->rooms->findAll(),
        ]; 
        return view('Stafff\HotelStaff\room', $data);
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
            ->select('reservations.ReservationID, restaurant_dining_tables.TableID, restaurant_dining_tables.TableNumber, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.Note, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, users.Address, reservations.UserID ')
            ->join ('restaurant_dining_tables', 'reservations.TableID = restaurant_dining_tables.TableID')
            ->join ('users', 'reservations.UserID = users.UserID')
            ->findAll()
        ]; 
        return view('Stafff\RestaurantStaff\reservation',$data);
    }
    public function addrestauReservation(){
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
                return redirect()->to(base_url('/staff-restaurant-reservation'))->with('success', 'Reservation added successfully.');
            } else {
                return redirect()->to(base_url('/staff-restaurant-reservation'))->with('error', 'Failed to add reservation. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/staff-restaurant'))->with('error', 'Invalid Username, RoomType, or RoomNumber. Please check your input.');
        }
    }
    public function updaterestauReservation($reservationID)
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
        return redirect()->to(base_url('/staff-restaurant-reservation'))->with('success', 'Reservation updated successfully.');
        } else {
            return redirect()->to(base_url('/staff-restaurant'))->with('error', 'Invalid RoomType or RoomNumber. Please check your input.');
        }
    }

    public function updaterestauStatus($status, $reservationID)
    {
        // Get the ReservationID from the request, assuming it's sent via POST
        $allowedStatuses = ['Confirm', 'Pending', 'Cancel'];
        if (!in_array($status, $allowedStatuses)) {
            // Handle invalid status (you may redirect or show an error message)
            return redirect()->back('/staff-restaurant')->with('error', 'Invalid status');
        }

        // Update the reservation status in the database
        $updateData = ['Status' => $status];
        $this->reservation->update($reservationID, $updateData);

        // Redirect to the reservation page or wherever appropriate
        return redirect()->to('/staff-restaurant-reservation')->with('success', 'Reservation status updated successfully');
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
            ->select('reservations.ReservationID, events.EventID, events.EventName, events.EventType, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.Note, reservations.Status, users.UserID,  users.FirstName, users.LastName, users.ContactNumber, users.Email, users.Address, reservations.UserID ')
            ->join ('events', 'reservations.EventID = events.EventID')
            ->join ('users', 'reservations.UserID = users.UserID')
            ->findAll()
        ]; 
        return view('Stafff\ConventionStaff\reservation', $data);
    }
    public function addconReservation()
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
                return redirect()->to(base_url('/staff-convention-reservation'))->with('success', 'Reservation added successfully.');
            } else {
                return redirect()->to(base_url('/staff-convention-reservation'))->with('error', 'Failed to add reservation. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/staff-convention'))->with('error', 'Invalid Username, RoomType, or RoomNumber. Please check your input.');
        }
    }
    public function updateconReservation($reservationID)
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
        return redirect()->to(base_url('/staff-convention-reservation'))->with('success', 'Reservation updated successfully.');
        } else {
            return redirect()->to(base_url('/staff-convention'))->with('error', 'Invalid RoomType or RoomNumber. Please check your input.');
        }
    }
    
    public function updateconStatus($status, $reservationID)
    {
        // Get the ReservationID from the request, assuming it's sent via POST
        $allowedStatuses = ['Confirm', 'Pending', 'Cancel'];
        if (!in_array($status, $allowedStatuses)) {
            // Handle invalid status (you may redirect or show an error message)
            return redirect()->back('/staff-convention')->with('error', 'Invalid status');
        }

        // Update the reservation status in the database
        $updateData = ['Status' => $status];
        $this->reservation->update($reservationID, $updateData);

        // Redirect to the reservation page or wherever appropriate
        return redirect()->to('/staff-convention-reservation')->with('success', 'Reservation status updated successfully');
    }
    public function conEvent()
    {
        $data = [
            'currentttRoute' => 'event',
            'events' => $this->events->findAll(),
        ]; 
        return view('Stafff\ConventionStaff\events', $data);
    }

    public function addEvent(){
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
    
        return redirect()->to('/staff-convention-event');
    }
    public function updateEvent(){

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
        return redirect()->to('/staff-convention-event');
    }
}

