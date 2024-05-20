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
use App\Models\GuestModel;
use App\Models\ReservationModel;
use App\Models\RegionModel;
use App\Models\ProvinceModel;
use App\Models\CityModel;
use App\Models\BarangayModel;
use App\Models\LoginAttempModel;
use App\Traits\EmailTrait;
use CodeIgniter\API\ResponseTrait;
use Config\Services;


class UserController extends BaseController
{
    use ResponseTrait;
    use EmailTrait;
    private $rooms;
    private $tables;
    private $events;
    private $users;
    private $usersrole;
    private $staffDetail;
    private $department;
    private $admin;
    private $guest;
    private $reservation;
    private $regions;
    private $province;
    private $cities;
    private $barangay;

    function __construct()
    {
        helper(['form']);
        $this->rooms = new RoomModel();
        $this->tables = new TableModel();
        $this->events = new EventModel();
        $this->users = new UserModel();
        $this->usersrole = new UserRoleModel();
        $this->staffDetail = new StaffDetailModel();
        $this->department = new DepartmentModel();
        $this->admin = new AdminModel();
        $this->guest = new GuestModel();
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

    public function register()
    {
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
    public function registerAuth()
    {
        helper(['form', 'url']);
        $rules = [
            'FirstName' => 'required|min_length[4]|max_length[100]',
            'LastName' => 'required|min_length[3]|max_length[100]',
            'Email' => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.Email]|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/]',
            'Password' => 'required|min_length[8]|max_length[50]|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^\w\d\s:])([^\s]){8,}$/]',
            'ContactNumber' => 'required|max_length[11]|numeric|regex_match[/^09\d{9}$/]',
            'confirmPassword' => 'matches[Password]',
            'Region' => 'required',
            'Province' => 'required',
            'City' => 'required',
            'Barangay' => 'required',
        ];
        $errors = [
            'Email' => [
                'required' => 'The email field is required.',
                'min_length' => 'The email must be at least 3 characters long.',
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
        ];
        if ($this->validate($rules, $errors)) {
            $regionCode = $this->request->getVar('Region');
            $provinceCode = $this->request->getVar('Province');
            $cityCode = $this->request->getVar('City');
            $barangayCode = $this->request->getVar('Barangay');

            $regionDesc = $this->regions->where('regCode', $regionCode)->first()['regDesc'];
            $provinceDesc = $this->province->where('provCode', $provinceCode)->first()['provDesc'];
            $cityDesc = $this->cities->where('citymunCode', $cityCode)->first()['citymunDesc'];
            $barangayDesc = $this->barangay->where('brgyCode', $barangayCode)->first()['brgyDesc'];

            $data = [
                'FirstName' => $this->request->getVar('FirstName'),
                'LastName' => $this->request->getVar('LastName'),
                'Email' => $this->request->getVar('Email'),
                'Password' => password_hash($this->request->getVar('Password'), PASSWORD_DEFAULT),
                'ContactNumber' => $this->request->getVar('ContactNumber'),
                'Region' => $regionDesc,
                'Province' => $provinceDesc,
                'City' => $cityDesc,
                'Barangay' => $barangayDesc,
                'UserRoleID' => 1,
            ];
            $verificationToken = bin2hex(random_bytes(16));
            $data['verification_token'] = $verificationToken;
            $data['is_verified'] = 0;
            $userId = $this->users->insert($data);
            if ($userId) {
                $newGuestData = ['UserID' => $userId,];
                $insertedGuestID = $this->guest->insert($newGuestData);
                $insertedGuestDetails = $this->guest->find($insertedGuestID);
                if ($insertedGuestDetails) {
                    $verificationUrl = base_url("verify/{$verificationToken}");
                    $emailMessage = "Please click on the following link to verify your email address: <a href='{$verificationUrl}'>Verify Email</a>";
                    $this->sendEmail($data['Email'], 'Verify Your Email Address', $emailMessage);
                    session()->setFlashdata('success', 'Successfully Registered. Please check your email to verify your account.');
                    return redirect()->to('/login');
                } else {
                    session()->setFlashdata('error', 'Registration failed. Please try again.');
                    return redirect()->back()->withInput();
                }
            } else {
                return redirect()->to(base_url('/register'))->with('error', 'Failed to add reservation. Please try again.');
            }
        } else {
            $data['validation'] = $this->validator;
            $data['activePage'] = 'Register';
            $data['regions'] = $this->regions->findAll();
            return view('Register', $data);
        }
    }

    public function login()
    {
        helper(['form']);
        $data = [
            'activePage' => 'Login',
        ];
        return view('Login', $data);
    }
    public function LoginAuth()
    {
        $session = session();
        $email = $this->request->getVar('Email');
        $password = $this->request->getVar('Password');
        $ipAddress = $this->request->getIPAddress();
        $maxAttempts = 5; // Maximum number of allowed attempts
        $lockoutTime = 15; // Lockout time in minutes

        $loginAttemptModel = new LoginAttempModel();

        // Check for previous login attempts
        $attempts = $loginAttemptModel->where('email', $email)
            ->where('ip_address', $ipAddress)
            ->where('attempt_time >', date('Y-m-d H:i:s', strtotime("-$lockoutTime minutes")))
            ->countAllResults();

        if ($attempts >= $maxAttempts) {
            // Too many attempts, lock the account temporarily
            $session->setFlashdata('msg', 'Too many failed login attempts. Please try again after ' . $lockoutTime . ' minutes.');
            return redirect()->to('/login');
        }

        // Retrieve user data from the database based on the provided email
        $data = $this->users->where('Email', $email)->first();

        if ($data) {
            // Verify the provided password against the hashed password in the database
            $pass = $data['Password'];
            $authenticatedPassword = password_verify($password, $pass);

            if ($authenticatedPassword) {
                // Check if user is verified
                if ($data['is_verified'] == 0) {
                    // User is not verified, set flash data and redirect to login with error message
                    $session->setFlashdata('msg', 'Account is not verified. Please check your email.');
                    return redirect()->to('/login');
                }

                // User is verified, proceed with setting session data
                $ses_data = [
                    'id' => $data['UserID'],
                    'username' => $data['Email'],
                    'firstname' => $data['FirstName'],
                    'lastname' => $data['LastName'],
                    'contact' => $data['ContactNumber'],
                    'region' => $data['Region'],
                    'province' => $data['Province'],
                    'city' => $data['City'],
                    'barangay' => $data['Barangay'],
                    'isLoggedIn' => true,
                    'userRole' => $data['UserRoleID'],
                    'address' => $data['Region'] . ', ' . $data['Province'] . ', ' . $data['City'] . ', ' . $data['Barangay'],
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
                        // Handle missing admin details
                        return redirect()->to('/');
                    }
                }
            } else {
                // Incorrect password, log the attempt
                $loginAttemptModel->insert([
                    'email' => $email,
                    'attempt_time' => date('Y-m-d H:i:s'),
                    'ip_address' => $ipAddress,
                ]);

                $session->setFlashdata('msg', 'Password is incorrect');
                return redirect()->to('/login');
            }
        } else {
            // Email not found, log the attempt
            $loginAttemptModel->insert([
                'email' => $email,
                'attempt_time' => date('Y-m-d H:i:s'),
                'ip_address' => $ipAddress,
            ]);

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


    public function verifyEmail($token = null)
    {
        if (!$token) {
            // No token provided, show an error or redirect
            return redirect()->to('/login')->with('msg', 'Verification token is missing.');
        }

        $user = $this->users->where('verification_token', $token)->first();

        if ($user) {
            // User found with the token, verify the account
            $data = ['is_verified' => 1, 'verification_token' => null]; // Mark as verified and clear the token
            $this->users->update($user['UserID'], $data);

            // Show a success message or redirect
            return redirect()->to('/login')->with('msg', 'Your account has been successfully verified. You can now login.');
        } else {
            // No user found with the provided token, show an error or redirect
            return redirect()->to('/login')->with('msg', 'Verification failed. Invalid or expired token.');
        }
    }
    // In your controller
    public function saveToken()
    {
        $session = session();
        $userId = $session->get('id');

        if (!$userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'User not logged in.']);
        }

        $request = \Config\Services::request();
        $tokenData = $request->getJSON();


        // Initialize your UserDeviceModel


        // Check for an existin    if ($tokenData && property_exists($tokenData, 'fcm_token')) {g token for the user to avoid duplicate
        // Assuming 'user_id' is the primary key in your 'users' table.
        // If your primary key is different, replace 'user_id' with the actual primary key column name.
        $saved = $this->users->update($userId, [
            'fcm_token' => $tokenData->fcm_token,
        ]);

        if ($saved) {
            return $this->response->setJSON(['success' => true, 'message' => 'Device token updated successfully.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update device token.']);
        }
    }
    public function recover()
    {
        $data = [
            'activePage' => 'Recover',
        ];
        return view('Recover', $data);
    }

    public function recoverPassword()
{
    $email = $this->request->getPost('email');
    $userModel = new UserModel();

    // Check if email exists in the database
    if ($userModel->where('Email', $email)->first()) {
        // Generate temporary password
        $tempPass = md5(uniqid());

        // Send email with the tempPass as a link
        $verificationUrl = base_url("resetPassword/$tempPass");
        $emailMessage = "Please click on the following link to reset your password: <a href='{$verificationUrl}'>Reset Password</a>";
        $this->sendEmail($email, 'Reset Your Password', $emailMessage);

        // Update the user record with the tempPass
        if ($userModel->update($userModel->where('Email', $email)->first()['UserID'], ['verification_token' => $tempPass])) {
            // Send push notification
            $user = $userModel->where('Email', $email)->first();
            if (!empty($user['fcm_token'])) {
                $this->sendPushNotification($user['fcm_token'], 'Password Reset Request', 'Please check your email to reset your password.');
            }
            return view('Recover');
        }
    } else {
        echo "Your email is not in our database.";
    }
}
protected function sendPushNotification($fcmToken, $title, $body)
    {
        $firebaseServerKey = 'AAAAKoechE8:APA91bEJSQ3bMHlFCb8pFAQ_kJ_xaA5yi4Zy9hR0t1Wqugqy7JUPYgpeNzvl9CJTN67sx4M_f8_9hrKKsnFQaxPCV4bYhtrgrOXdPntM2GpQnPuc07YEa3dkLJhlpzxmv6gXOnRQeNCA';
        $postData = [
            'to' => $fcmToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
        ];
        $headers = [
            'Authorization: key=' . $firebaseServerKey,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        $result = curl_exec($ch);
        curl_close($ch);
    }

    public function resetPassword($tempPass)
    {
        $userModel = new UserModel();
        $user = $userModel->where('verification_token', $tempPass)->first();
        
        if ($user) {
            echo view('Forgot', ['temp_pass' => $tempPass]);
        } else {
            echo "The key is not valid.";
        }
    }
    public function updatePassword()
    {
        $tempPass = $this->request->getPost('temp_pass');
        $password = $this->request->getPost('password');
        $cpassword = $this->request->getPost('cpassword');
    
        if ($password === $cpassword) {
            $userModel = new UserModel();
            $user = $userModel->where('verification_token', $tempPass)->first();
    
            if ($user) {
                $userModel->update($user['UserID'], [
                    'Password' => password_hash($password, PASSWORD_DEFAULT),
                    'verification_token' => null
                ]);
                
                // Send email confirmation
                $emailMessage = "Your password has been successfully updated.";
                $this->sendEmail($user['Email'], 'Password Updated', $emailMessage);
    
                // Send push notification
                if (!empty($user['fcm_token'])) {
                    $this->sendPushNotification($user['fcm_token'], 'Password Updated', 'Your password has been successfully updated.');
                }
    
                echo view('Login');
            } else {
                echo "Invalid token.";
            }
        } else {
            echo "Passwords do not match.";
        }
    }
    
}
