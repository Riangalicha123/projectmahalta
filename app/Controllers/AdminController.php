<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoomModel;
use App\Models\TableModel;
use App\Models\EventModel;
use App\Models\ReservationModel;

class AdminController extends BaseController
{
    private $rooms;
    private $tables;
    private $events;
    private $reservation;

    function __construct(){
        helper(['form']);
        $this->rooms = new RoomModel();
        $this->tables = new TableModel();
        $this->events = new EventModel();
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
        ];
        return view('Admin\customer', $data);
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
            ->select('reservations.ReservationID, restaurant_dining_tables.TableID, restaurant_dining_tables.TableNumber, reservations.CheckInDate, reservations.CheckOutDate, reservations.NumberOfGuests, reservations.Note, reservations.Status, users.UserID,  users.FirstName,  users.LastName, users.ContactNumber, users.Addresss, reservations.UserID ')
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
            
        ]; 
        return view('Admin\staffAccount',$data);
    }
}
