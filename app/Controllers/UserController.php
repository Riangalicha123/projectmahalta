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
use App\Models\RegionModel;
use App\Models\ProvinceModel;
use App\Models\CityModel;
use App\Models\BarangayModel;
use CodeIgniter\API\ResponseTrait;


class UserController extends BaseController
{   
    use ResponseTrait;
    private $rooms;
    private $tables;
    private $events;
    private $users;
    private $usersrole;
    private $staffDetail;
    private $department;
    private $admin;
    private $reservation;
    private $regions;
    private $province;
    private $cities;
    private $barangay;

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
        $this->regions = new RegionModel();
        $this->province = new ProvinceModel();
        $this->cities = new CityModel();
        $this->barangay = new BarangayModel();
    }
    
    public function index()
    {
        //
    }

    public function register(){
        helper(['form']);
    
        // Fetch regions from the model
        $regions = $this->regions->findAll();
    
        $data = [
            'activePage' => 'Register',
            'regions' => $regions,
        ];
    
        return view('Register', $data);
    }
    public function fetchProvince()
    {
        $request = service('request');
    
        // Ensure regCode is set in the request
        $regCode = $request->getVar('regCode');
    
        // Load the model or service responsible for fetching provinces
        $provinces = $this->province->where('regCode', $regCode)->findAll();
    
        $data['provinces'] = $provinces;
    
        return $this->respond($data);
    }
    public function fetchCity()
    {
        $request = service('request');
    
        // Ensure regCode is set in the request
        $provCode = $request->getVar('provCode');
    
        // Load the model or service responsible for fetching provinces
        $cities = $this->cities->where('provCode', $provCode)->findAll();
    
        $data['cities'] = $cities;
    
        return $this->respond($data);
    }
    public function fetchBarangay()
    {
        $request = service('request');
    
        // Ensure regCode is set in the request
        $cityCode = $request->getVar('citymunCode');
    
        // Load the model or service responsible for fetching provinces
        $barangay = $this->barangay->where('citymunCode', $cityCode)->findAll();
    
        $data['barangay'] = $barangay;
    
        return $this->respond($data);
    }
    public function registerAuth(){
        helper(['form']);
    
        // Validation rules
        $rules = [
            'FirstName' => 'required|min_length[4]|max_length[100]',
            'LastName' => 'required|min_length[4]|max_length[100]',
            'Email' => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.Email]|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/]',
            'Password' => 'required|min_length[8]|max_length[50]|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^\w\d\s:])([^\s]){8,}$/]',
            'ContactNumber' => 'required|max_length[11]|numeric|regex_match[/^09\d{9}$/]',
            'confirmPassword' => 'matches[Password]',
            'Region' => 'required',
            'Province' => 'required',
            'City' => 'required',
            'Barangay' => 'required',
            // Add validation rule for region dropdown
        ];
    
        $errors = [
            'Email' => [
                'required' => 'The email field is required.',
                'min_length' => 'The email must be at least 4 characters long.',
                'max_length' => 'The email must not exceed 100 characters.',
                'valid_email' => 'Please enter a valid email address.',
                'is_unique' => 'The email address is already taken.',
                'regex_match' => 'Invalid email format.',
            ],
            'Password' => [
                'required' => 'The password field is required.',
                'min_length' => 'The password must be at least 8 characters long.',
                'max_length' => 'The password must not exceed 50 characters.',
                'regex_match' => 'The password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character.',
            ],
            'confirmPassword' => [
                'matches' => 'The confirm password field must match the password field.',
            ],
            'ContactNumber' => [
                'required' => 'The contact number field is required.',
                'max_length' => 'The contact number must be 11 digits long.',
                'numeric' => 'The contact number must contain only numeric characters.',
                'regex_match' => 'The contact number must start with "09" followed by 9 digits.',
            ],
            'Region' => [
                'required' => 'The region field is required.',
            ],
            'Province' => [
                'required' => 'The province field is required.',
            ],
            'City' => [
                'required' => 'The city/municipality field is required.',
            ],
            'Barangay' => [
                'required' => 'The barangay field is required.',
            ],

            // Other custom error messages...
        ];
    
        if ($this->validate($rules, $errors)){
            // If validation passes, proceed with user registration

            
            $data = [
                'FirstName' => $this->request->getVar('FirstName'),
                'LastName' => $this->request->getVar('LastName'),
                'Email' => $this->request->getVar('Email'),
                'Password' => password_hash($this->request->getVar('Password'), PASSWORD_DEFAULT),
                'ContactNumber' => $this->request->getVar('ContactNumber'),
                'Region' => $this->request->getVar('Region'),
                'Province' => $this->request->getVar('Province'),
                'City' => $this->request->getVar('City'),
                'Barangay' => $this->request->getVar('Barangay'),
                'UserRoleID' => 1,
            ];
            
            // Insert user data into the database
            $this->users->insert($data);
    
            session()->setFlashdata('success', 'Successfully Registered');
            return redirect()->to('/login');
        } else {
            // If validation fails, return to the registration form with errors
            $data['validation'] = $this->validator;
            $data['activePage'] = 'Register';
            $data['regions'] = $this->regions->findAll(); // Fetch regions to repopulate the dropdown
    
            return view('Register', $data);
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
