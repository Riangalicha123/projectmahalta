<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\UserRoleModel;

class UserController extends BaseController
{   
    private $users;
    private $usersrole;

    function __construct(){
        helper(['form']);
        $this->users = new UserModel();
        $this->usersrole = new UserRoleModel();
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
    public function LoginAuth(){
        $session = session();
        $email = $this->request->getVar('Email');
        $password = $this->request->getVar('Password');
    
        $data = $this->users->where('Email', $email)->first();
    
        if ($data) {
            $pass = $data['Password'];
            $authenticatedPassword = password_verify($password, $pass);
    
            if ($authenticatedPassword) {
                $ses_data = [
                    'id' => $data['UserID'], // Assuming 'UserID' is the correct field name for the user's ID
                    'username' => $data['Email'],
                    'firstname' => $data['FirstName'],
                    'lastname' => $data['LastName'],
                    'contact' => $data['ContactNumber'],
                    'address' => $data['Address'],
                    'isLoggedIn' => true,
                    'userRole' => $data['UserRoleID'],
                ];
                $session->set($ses_data);
    
                // Redirect based on user role
                if ($data['UserRoleID'] == 1) {
                    // Guest role
                    return redirect()->to('/');
                } else if ($data['UserRoleID'] == 2) {
                    // Redirect to Staff Dashboard
                    return view('Staff/HotelStaff/index');
                } else if ($data['UserRoleID'] == 3) {
                    // Redirect to Admin Dashboard or any other role-specific page
                    return view('Admin/index');
                }
            } else {
                $session->setFlashdata('msg', 'Password is incorrect');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Email does not exist');
            return redirect()->to('/login');
        }
    }
    
    public function logout()
    {
        $session = session();
        $session->destroy(); // Destroy the user's session
        return redirect()->to('/'); // Redirect the user to the login page or any other page after logout
    }
}
