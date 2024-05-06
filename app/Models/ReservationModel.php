<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservationModel extends Model
{
    protected $table            = 'reservations';
    protected $primaryKey       = 'ReservationID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['UserID', 'RoomID', 'VenueID', 'conventionID','AmenitiesID', 'CheckInDate', 'CheckOutDate', 'ArivalDate', 'ArivalTime', 'NumberOfGuests', 'Adult', 'Child', 'ReferenceNumber', 'PaymentOption', 'downorfullPayment', 'TotalAmount', 'Image', 'Note', 'Status', 'QRCodePath'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    public function getReservationData($month, $year)
    {
        // Fetch reservations where Status is "Confirm"
        // and CheckInDate is in the selected month and year
        $query = $this->db->table($this->table)
            ->select('RoomID, COUNT(*) as reservations')
            ->where('Status', 'Confirm')
            ->where('MONTH(CheckInDate)', $month)
            ->where('YEAR(CheckInDate)', $year)
            ->groupBy('RoomID')
            ->get();

        return $query->getResult();

        
    }
    public function getReservationsByYearMonth($year, $month)
    {
        return $this->select('reservations.*, rooms.RoomNumber, rooms.RoomType')
                    ->join('rooms', 'rooms.RoomID = reservations.RoomID')
                    ->where('Status', 'Confirm')
                    ->where('YEAR(reservations.CheckInDate)', $year)
                    ->where('MONTH(reservations.CheckInDate)', $month)
                    ->groupBy('RoomType')
                    ->findAll();
    } 
    
}
