<?php

namespace App\Models;

use CodeIgniter\Model;
use DateInterval;
use DatePeriod;
use DateTime;

class WalkInModel extends Model
{
    protected $table            = 'walkin';
    protected $primaryKey       = 'walkinID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['RoomID', 'roomInventoryID', 'FirstName', 'LastName', 'ContactNumber', 'CheckIn', 'CheckOut', 'Adult', 'Child', 'TotalAmount', 'insertQuantity'];

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

    public function findAvailableRooms($checkInDate, $checkOutDate, $numberOfAdults, $numberOfChildren)
    {
        $numberOfAdults = (int) $numberOfAdults;
        $numberOfChildren = (int) $numberOfChildren;
        
        // Retrieve rooms that fit the guest requirements
        $availableRooms = $this->where('minPerson <=', $numberOfAdults + $numberOfChildren)
                                ->where('maxPerson >=', $numberOfAdults + $numberOfChildren)
                                ->findAll();
        
        // Iterate over each room to fetch all reservation and walk-in periods
        foreach ($availableRooms as &$room) {
            $roomID = $room['RoomID'];
            
            // Fetch all reservation dates for the room
            $reservationsQuery = $this->db->table('reservations')
                                        ->select('DATE_FORMAT(CheckInDate, "%Y-%m-%d") as StartDate, 
                                                DATE_FORMAT(CheckOutDate, "%Y-%m-%d") as EndDate, Status')
                                        ->where('RoomID', $roomID)
                                        ->get();
            $reservations = $reservationsQuery->getResultArray();
            
            // Fetch all walk-in dates for the room
            $walkInsQuery = $this->db->table('walkin')
                                    ->select('DATE_FORMAT(CheckIn, "%Y-%m-%d") as StartDate, 
                                            DATE_FORMAT(CheckOut, "%Y-%m-%d") as EndDate')
                                    ->where('RoomID', $roomID)
                                    ->get();
            $walkIns = $walkInsQuery->getResultArray();
            
            // Initialize the unavailable dates array
            $room['unavailableDates'] = [];

            // Add dates from reservations
            foreach ($reservations as $dates) {
                $startDate = new DateTime($dates['StartDate']);
                $endDate = new DateTime($dates['EndDate']);
                $endDate->modify('+1 day');   // Add one day to include the check-out day

                $interval = new DateInterval('P1D');
                $period = new DatePeriod($startDate, $interval, $endDate);

                // Only consider dates for reservations with status 'Confirm' or 'Pending'
                if ($dates['Status'] === 'Cancel') {
                    continue;
                }

                foreach ($period as $dt) {
                    $room['unavailableDates'][] = $dt->format("Y-m-d");
                }
            }

            // Add dates from walk-ins
            foreach ($walkIns as $dates) {
                $startDate = new DateTime($dates['StartDate']);
                $endDate = new DateTime($dates['EndDate']);
                $endDate->modify('+1 day');   // Add one day to include the check-out day

                $interval = new DateInterval('P1D');
                $period = new DatePeriod($startDate, $interval, $endDate);

                foreach ($period as $dt) {
                    $room['unavailableDates'][] = $dt->format("Y-m-d");
                }
            }
            
            // Remove duplicates and sort dates
            $room['unavailableDates'] = array_unique($room['unavailableDates']);
            sort($room['unavailableDates']);
        }
        
        return $availableRooms;  // Return the complete room details including all unavailable dates
    }

}

