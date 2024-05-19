<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservationAmenities extends Model
{
    protected $table            = 'reservation_amenities';
    protected $primaryKey       = 'AmenitiesID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['ReservationID','UserID','roomInventoryID','insertQuantity'];

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

    public function getMonthlyInventoryData($year)
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT 
                room_inventory.ProductName,
                SUM(reservation_amenities.insertQuantity) AS TotalQuantity,
                MONTH(reservations.CheckInDate) AS ReservationMonth,
                YEAR(reservations.CheckInDate) AS ReservationYear
            FROM 
                reservation_amenities
            JOIN 
                reservations ON reservation_amenities.ReservationID = reservations.ReservationID
            JOIN 
                room_inventory ON reservation_amenities.roomInventoryID = room_inventory.roomInventoryID
            WHERE 
                YEAR(reservations.CheckInDate) = ?
            GROUP BY 
                room_inventory.ProductName, ReservationMonth, ReservationYear
            ORDER BY 
                room_inventory.ProductName", [$year]);

        return $query->getResult();
    }
}
