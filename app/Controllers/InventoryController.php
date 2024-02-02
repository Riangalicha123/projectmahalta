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
use App\Models\InventoryModel;
use App\Models\RoomInventoryModel;
use App\Models\RestaurantInventoryModel;

class InventoryController extends BaseController
{
    private $rooms;
    private $tables;
    private $events;
    private $users;
    private $usersrole;
    private $staffDetail;
    private $department;
    private $admin;
    private $reservation;
    private $inventory;
    private $roominventory;
    private $restaurantinventory;

    function __construct(){
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
        $this->inventory = new InventoryModel();
        $this->roominventory = new RoomInventoryModel();
        $this->restaurantinventory = new RestaurantInventoryModel();
    }
    public function index()
    {
        //
    }
    public function inhome()
    {
        $data = [
            'inventoryRoutes' => 'home',
        ];
        return view('Stafff\Inventory\index', $data);
    }
    public function inhotel()
    {
        $data = [
            'inventoryRoutes' => 'inhotel',
            'roinvents' => $this->roominventory->findAll(),
        ];
        return view('Stafff\Inventory\hotel', $data);
    }
    public function addinHotel()
    {
        helper(['form']);
        $rules = [
            'ProductName' => 'required|min_length[4]|max_length[100]',
            'Quantity' => 'required',
        ];

        if ($this->validate($rules)){
            $data = [
                'ProductName' => $this->request->getVar('ProductName'),
                'Quantity' => $this->request->getVar('Quantity'),
                
            ];
            $this->roominventory->insert($data);
            return redirect()->to('staff-inventory/hotel');
        }else{
            $data['validation'] = $this->validator;
            return view('Stafff\Inventory\hotel',$data);
        }
    }
    public function updateinHotel($roomInventoryID)
    {
        helper(['form']);

        // Validation Rules (you can customize these based on your requirements)
        $validationRules = [
            
            'ProductName' => 'required',
            'Quantity' => 'required|numeric',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            // You might want to handle validation errors here
            return redirect()->to(base_url("/editReservation/{$roomInventoryID}"))->with('validationErrors', $validationErrors);
        }

                // Prepare Reservation Data
                $updateReservationData = [
                    'ProductName' => $this->request->getPost('ProductName'),
                    'Quantity' => $this->request->getPost('Quantity'),
                ];

        // Update Reservation
        $this->roominventory->update($roomInventoryID, $updateReservationData);

        // Redirect with appropriate message
        return redirect()->to(base_url('/staff-inventory/hotel'))->with('success', 'Reservation updated successfully.');
    }
    public function inrestaurant()
    {
        $data = [
            'inventoryRoutes' => 'inrestaurant',
            'reinvents' => $this->restaurantinventory->findAll(),
        ];
        return view('Stafff\Inventory\restaurant', $data);
    }
    public function addinRestaurant()
    {
        helper(['form']);
        $rules = [
            'ProductName' => 'required|min_length[4]|max_length[100]',
            'Quantity' => 'required',
        ];

        if ($this->validate($rules)){
            $data = [
                'ProductName' => $this->request->getVar('ProductName'),
                'Quantity' => $this->request->getVar('Quantity'),
                
            ];
            $this->roominventory->insert($data);
            return redirect()->to('staff-inventory/restaurant');
        }else{
            $data['validation'] = $this->validator;
            return view('Stafff\Inventory\restaurant',$data);
        }
    }
    public function updateinRestaurant($restaurantInventoryID)
    {
        helper(['form']);

        // Validation Rules (you can customize these based on your requirements)
        $validationRules = [
            
            'ProductName' => 'required',
            'Quantity' => 'required|numeric',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            // You might want to handle validation errors here
            return redirect()->to(base_url("/editReservation/{$restaurantInventoryID}"))->with('validationErrors', $validationErrors);
        }

                // Prepare Reservation Data
                $updateReservationData = [
                    'ProductName' => $this->request->getPost('ProductName'),
                    'Quantity' => $this->request->getPost('Quantity'),
                ];

        // Update Reservation
        $this->restaurantinventory->update($restaurantInventoryID, $updateReservationData);

        // Redirect with appropriate message
        return redirect()->to(base_url('/staff-inventory/restaurant'))->with('success', 'Reservation updated successfully.');
    }
    

}
