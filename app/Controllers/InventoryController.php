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
use App\Models\RoomInventoryModel;

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
    private $roominventory;

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
        $this->roominventory = new RoomInventoryModel();
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
            'ProductName' => 'required|min_length[3]|max_length[100]',
            'Quantity' => 'required',
            'Price' => 'required',
        ];

        if ($this->validate($rules)){
            $data = [
                'ProductName' => $this->request->getVar('ProductName'),
                'Quantity' => $this->request->getVar('Quantity'),
                'Price' => $this->request->getVar('Price'),
                
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
            'Price' => 'required',
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
                    'Price' => $this->request->getPost('Price'),
                ];

        // Update Reservation
        $this->roominventory->update($roomInventoryID, $updateReservationData);

        // Redirect with appropriate message
        return redirect()->to(base_url('/staff-inventory/hotel'))->with('success', 'Reservation updated successfully.');
    }
    public function inventoryHotel()
    {
        $data = [
            'adminRoutes' => 'inventoryHotel',
            'roinvents' => $this->roominventory->findAll(),
        ];
        return view('Admin\inventory_hotel', $data);
    }
    public function adddinHotel()
    {
        helper(['form']);
        $rules = [
            'ProductName' => 'required|min_length[3]|max_length[100]',
            'Quantity' => 'required',
            'Price' => 'required',
        ];

        if ($this->validate($rules)){
            $data = [
                'ProductName' => $this->request->getVar('ProductName'),
                'Quantity' => $this->request->getVar('Quantity'),
                'Price' => $this->request->getVar('Price'),
                
            ];
            $this->roominventory->insert($data);
            return redirect()->to('admin-inventoryhotel');
        }else{
            $data['validation'] = $this->validator;
            return view('Admin\inventory_hotel',$data);
        }
    }
    
    public function deleteAmenitiesItem($roomInventoryID)
    {
        // Retrieve the product by ID
        $roominventory = $this->roominventory->find($roomInventoryID);
        
        // Check if the roominventory exists
        if ($roominventory) {
            // Delete the roominventory
            $deleted = $this->roominventory->delete($roomInventoryID);
            
            // Check if deletion was successful
            if ($deleted) {
                return redirect()->to(base_url('/admin-inventoryhotel'))->with('success', 'Menu item deleted successfully.');
            } else {
                return redirect()->to(base_url('/admin-inventoryhotel'))->with('error', 'Failed to delete menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-inventoryhotel'))->with('error', 'Menu item not found.');
        }
    }
    public function updateeinHotel($roomInventoryID)
    {
        helper(['form']);

        // Validation Rules (you can customize these based on your requirements)
        $validationRules = [
            
            'ProductName' => 'required',
            'Quantity' => 'required|numeric',
            'Price' => 'required',
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
                    'Price' => $this->request->getPost('Price'),
                ];

        // Update Reservation
        $this->roominventory->update($roomInventoryID, $updateReservationData);

        // Redirect with appropriate message
        return redirect()->to(base_url('/admin-inventoryhotel'))->with('success', 'Reservation updated successfully.');
    }

}
