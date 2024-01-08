<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoomModel;
use App\Models\ReservationModel;
class GuestController extends BaseController
{
    private $users;
    private $rooms;
    private $reservation;

    function __construct(){
        $this->users = new UserModel();
        $this->rooms = new RoomModel();
        $this->reservation = new ReservationModel();
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
        ];
        return view('Hotell\convention',$data);
    }
    public function bookroom()
    {

        $data = [
            'activePage' => 'Reservation',
            'rooms' => $this->rooms->findAll(),
        ];
        return view('Hotell\bookroom',$data);
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

    
    public function contact()
    {
        return view('Hotel\contact');
    }
}
