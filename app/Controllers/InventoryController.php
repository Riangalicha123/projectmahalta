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
    public function inhome()
    {
        $data = [
            'inventoryRoutes' => 'home',
        ];
        return view('Stafff/Inventory/index', $data);
    }
    public function inhotel()
    {
        $data = [
            'inventoryRoutes' => 'inhotel',
            'roinvents' => $this->roominventory->findAll(),
        ];
        return view('Stafff/Inventory/hotel', $data);
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
            return view('Stafff/Inventory/hotel',$data);
        }
    }
    public function deleteAmenitiesItemm($roomInventoryID)
    {
        $roominventory = $this->roominventory->find($roomInventoryID);
        if ($roominventory) {
            $deleted = $this->roominventory->delete($roomInventoryID);
            if ($deleted) {
                return redirect()->to(base_url('/staff-inventory/hotel'))->with('success', 'Menu item deleted successfully.');
            } else {
                return redirect()->to(base_url('/staff-inventory/hotel'))->with('error', 'Failed to delete menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/staff-inventory/hotel'))->with('error', 'Menu item not found.');
        }
    }
    public function updateinHotel($roomInventoryID)
    {
        helper(['form']);
        $validationRules = [
            
            'ProductName' => 'required',
            'Quantity' => 'required|numeric',
            'Price' => 'required',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url("/editReservation/{$roomInventoryID}"))->with('validationErrors', $validationErrors);
        }
                $updateReservationData = [
                    'ProductName' => $this->request->getPost('ProductName'),
                    'Quantity' => $this->request->getPost('Quantity'),
                    'Price' => $this->request->getPost('Price'),
                ];
        $this->roominventory->update($roomInventoryID, $updateReservationData);
        return redirect()->to(base_url('/staff-inventory/hotel'))->with('success', 'Reservation updated successfully.');
    }
    public function invensetting()
    {
        $data = [
            'currenttRoute' => 'invensetting',
        ];
        return view('Stafff/Inventory/setting', $data);
    }
    public function invenupdatePassword()
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
                return redirect()->to('/staff-invensetting');
            } else {
                $session->setFlashdata('msg', 'Old password is incorrect');
                return redirect()->to('/staff-invensetting');
            }
        } else {
            $data['validation'] = $this->validator;
            return view('Stafff/Inventory/setting', $data);
        }
    }
    public function updateinventoryProfile($userID)
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
        return redirect()->to(base_url('/staff-invensetting'));
    }
    public function inventoryHotel()
    {
        $data = [
            'adminRoutes' => 'inventoryHotel',
            'roinvents' => $this->roominventory->findAll(),
        ];
        return view('Admin/inventory_hotel', $data);
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
            return view('Admin/inventory_hotel',$data);
        }
    }
    public function deleteAmenitiesItem($roomInventoryID)
    {
        $roominventory = $this->roominventory->find($roomInventoryID);
        if ($roominventory) {
            $deleted = $this->roominventory->delete($roomInventoryID);
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
        $validationRules = [
            'ProductName' => 'required',
            'Quantity' => 'required|numeric',
            'Price' => 'required',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url("/editReservation/{$roomInventoryID}"))->with('validationErrors', $validationErrors);
        }
                $updateReservationData = [
                    'ProductName' => $this->request->getPost('ProductName'),
                    'Quantity' => $this->request->getPost('Quantity'),
                    'Price' => $this->request->getPost('Price'),
                ];
        $this->roominventory->update($roomInventoryID, $updateReservationData);
        return redirect()->to(base_url('/admin-inventoryhotel'))->with('success', 'Reservation updated successfully.');
    }
}
