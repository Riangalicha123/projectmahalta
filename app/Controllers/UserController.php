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

class UserController extends BaseController
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
    }
    public function index()
    {
        //
    }

    public function register(){
        helper(['form']);
        $data = [
            'activePage' => 'Register',
        ];
        return view('Register',$data);
    }
    public function registerAuth(){
        helper(['form']);
        $rules = [
            'FirstName' => 'required|min_length[4]|max_length[100]',
            'LastName' => 'required|min_length[4]|max_length[100]',
            'Email' => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.Email]',
            'Password' => 'required|min_length[4]|max_length[50]',
            'ContactNumber' => 'required|max_length[11]',
            'Address' => 'required|min_length[4]|max_length[100]',
            'confirmPassword' => 'matches[Password]'
        ];

        if ($this->validate($rules)){
            $data = [
                'FirstName' => $this->request->getVar('FirstName'),
                'LastName' => $this->request->getVar('LastName'),
                'Email' => $this->request->getVar('Email'),
                'Password' => password_hash($this->request->getVar('Password'),PASSWORD_DEFAULT),
                'ContactNumber' => $this->request->getVar('ContactNumber'),
                'Address' => $this->request->getVar('Address'),
                'UserRoleID' => 1,
                
            ];
            $this->users->insert($data);
            return redirect()->to('/login');
        }else{
            $data['validation'] = $this->validator;
            echo view('Register',$data);
        }
    }
    public function login(){
        helper(['form']);
        $data = [
            'activePage' => 'Login',
        ];
        return view('Login',$data);
    }
    public function LoginAuth()
    {
        $session = session();
        $email = $this->request->getVar('Email');
        $password = $this->request->getVar('Password');

        // Retrieve user data from the database based on the provided email
        $data = $this->users->where('Email', $email)->first();

        if ($data) {
            // Verify the provided password against the hashed password in the database
            $pass = $data['Password'];
            $authenticatedPassword = password_verify($password, $pass);

            if ($authenticatedPassword) {
                $ses_data = [
                    'id' => $data['UserID'],
                    'username' => $data['Email'],
                    'firstname' => $data['FirstName'],
                    'lastname' => $data['LastName'],
                    'contact' => $data['ContactNumber'],
                    'address' => $data['Address'],
                    'isLoggedIn' => true,
                    'userRole' => $data['UserRoleID'],
                ];

                $session->set($ses_data);

                // Redirect based on user role, staff details, and admin
                if ($data['UserRoleID'] == 1) {
                    // Guest role, redirect to home
                    return redirect()->to('/');
                } elseif ($data['UserRoleID'] == 2) {
                    // Staff role, redirect to the appropriate portal
                    $staffDetails = $this->staffDetail->where('UserID', $data['UserID'])->first();

                    if ($staffDetails) {
                        // Redirect to the corresponding staff portal based on DepartmentID
                        switch ($staffDetails['DepartmentID']) {
                            case 1:
                                return redirect()->to('/staff-convention');
                            case 2:
                                return redirect()->to('/staff-hotel');
                            case 3:
                                return redirect()->to('/staff-restaurant');
                            case 4:
                                return redirect()->to('/staff-inventory');
                            default:
                                // Handle unexpected DepartmentID
                                return redirect()->to('/');
                        }
                    } else {
                        // Handle missing staff details
                        return redirect()->to('/');
                    }
                } elseif ($data['UserRoleID'] == 3) {
                    // Admin role, redirect to admin dashboard
                    $adminDetails = $this->admin->where('UserID', $data['UserID'])->first();

                    if ($adminDetails) {
                        // Redirect to the corresponding admin portal based on AdminID
                        switch ($adminDetails['AdminID']) {
                            case 1:
                                return redirect()->to('/admin-dashboard');
                            default:
                                // Handle unexpected AdminID
                                return redirect()->to('/');
                        }
                    } else {
                        // Handle missing staff details
                        return redirect()->to('/');
                    }
                }
            } else {
                // Incorrect password
                $session->setFlashdata('msg', 'Password is incorrect');
                return redirect()->to('/login');
            }
        } else {
            // Email not found
            $session->setFlashdata('msg', 'Email does not exist');
            return redirect()->to('/login');
        }
    }

    
    public function logout()
    {
        $session = session();
        $session->destroy(); // Destroy the user's session
        return redirect()->to('/login'); // Redirect the user to the login page or any other page after logout
    }
}
