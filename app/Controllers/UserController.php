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
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;

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
    public function register()
    {
        helper(['form']);
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
        $regCode = $request->getVar('regCode');
        $provinces = $this->province->where('regCode', $regCode)->findAll();
        $data['provinces'] = $provinces;
        return $this->respond($data);
    }
    public function fetchCity()
    {
        $request = service('request');
        $provCode = $request->getVar('provCode');
        $cities = $this->cities->where('provCode', $provCode)->findAll();
        $data['cities'] = $cities;
        return $this->respond($data);
    }
    public function fetchBarangay()
    {
        $request = service('request');
        $cityCode = $request->getVar('citymunCode');
        $barangay = $this->barangay->where('citymunCode', $cityCode)->findAll();
        $data['barangay'] = $barangay;
        return $this->respond($data);
    }
    public function registerAuth()
    {
        helper(['form', 'url']);
        $rules = [
            'FirstName' => 'required|min_length[2]|max_length[100]',
            'LastName' => 'required|min_length[2]|max_length[100]',
            'Email' => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.Email]|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/]',
            'Password' => 'required|min_length[8]|max_length[50]|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_])([^\s]){8,}$/]',
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
                $guestData = [
                    'UserID' => $userId,
                ];
                $guestId = $this->guest->insert($guestData);
                if ($guestId) {
                    $verificationUrl = base_url("verify/{$verificationToken}");
                    $emailMessage = "
                        <img src='https://mahaltaresort.online/guest/images/mahaltalogooo.png' alt='Mahalta Resorts Logo' style='width: 150px;'>
                        
                        <p>Dear {$data['FirstName']} {$data['LastName']},</p>
                        
                        <p>We hope this message finds you well.</p>
                        
                        <p>To complete the verification process, please confirm your email address by clicking the link below:</p>
                        
                        <p><a href='{$verificationUrl}'>Verify Email</a></p>
                        
                        <p>If you did not request this, kindly ignore this email. Should you have any questions or need further assistance, feel free to reach out to us.</p>
                        
                        <p>Thank you for helping us maintain the security of your account.</p>
                        
                        <p>Best regards,<br>
                        Mahalta Resorts and Convention Center<br>
                        09812480320</p>
                    ";

                    $this->sendEmail($data['Email'], 'Verify Your Email Address', $emailMessage);
                    session()->setFlashdata('success', 'Successfully Registered. Please check your email to verify your account.');
                    return redirect()->to('/login');
                } else {
                    session()->setFlashdata('error', 'Failed to register as guest. Please try again.');
                    return redirect()->back()->withInput();
                }
            } else {
                session()->setFlashdata('error', 'Registration failed. Please try again.');
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
        $maxAttempts = 5;
        $lockoutTime = 15;
        $loginAttemptModel = new LoginAttempModel();
        $attempts = $loginAttemptModel->where('email', $email)
            ->where('ip_address', $ipAddress)
            ->where('attempt_time >', date('Y-m-d H:i:s', strtotime("-$lockoutTime minutes")))
            ->countAllResults();
        if ($attempts >= $maxAttempts) {
            $session->setFlashdata('msg', 'Too many failed login attempts. Please try again after ' . $lockoutTime . ' minutes.');
            return redirect()->to('/login');
        }
        $data = $this->users->where('Email', $email)->first();
        if ($data) {
            $pass = $data['Password'];
            $authenticatedPassword = password_verify($password, $pass);
            if ($authenticatedPassword) {
                if ($data['is_verified'] == 0) {
                    $session->setFlashdata('msg', 'Account is not verified. Please check your email.');
                    return redirect()->to('/login');
                }
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
                if ($data['UserRoleID'] == 1) {
                    return redirect()->to('/');
                } elseif ($data['UserRoleID'] == 2) {
                    $staffDetails = $this->staffDetail->where('UserID', $data['UserID'])->first();
                    if ($staffDetails) {
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
                                return redirect()->to('/');
                        }
                    } else {
                        return redirect()->to('/');
                    }
                } elseif ($data['UserRoleID'] == 3) {
                    $adminDetails = $this->admin->where('UserID', $data['UserID'])->first();
                    if ($adminDetails) {
                        switch ($adminDetails['AdminID']) {
                            case 1:
                                return redirect()->to('/admin-dashboard');
                            default:
                                return redirect()->to('/');
                        }
                    } else {
                        return redirect()->to('/');
                    }
                }
            } else {
                $loginAttemptModel->insert([
                    'email' => $email,
                    'attempt_time' => date('Y-m-d H:i:s'),
                    'ip_address' => $ipAddress,
                ]);
                $session->setFlashdata('msg', 'Password is incorrect');
                return redirect()->to('/login');
            }
        } else {
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
        $session->destroy();
        return redirect()->to('/login');
    }
    public function verifyEmail($token = null)
    {
        if (!$token) {
            return redirect()->to('/login')->with('msg', 'Verification token is missing.');
        }
        $user = $this->users->where('verification_token', $token)->first();
        if ($user) {
            $data = ['is_verified' => 1, 'verification_token' => null];
            $this->users->update($user['UserID'], $data);
            return redirect()->to('/login')->with('msg', 'Your account has been successfully verified. You can now login.');
        } else {
            return redirect()->to('/login')->with('msg', 'Verification failed. Invalid or expired token.');
        }
    }
    public function saveToken()
    {
        // Start session
        $session = session();
        $userId = $session->get('id');

        // Check if user is logged in
        if (!$userId) {
            return $this->response->setStatusCode(401)
                ->setJSON(['success' => false, 'message' => 'User not logged in.']);
        }

        // Parse the JSON request to get the token
        $tokenData = $this->request->getJSON();

        if (!$tokenData || !isset($tokenData->fcm_token)) {
            return $this->response->setStatusCode(400)
                ->setJSON(['success' => false, 'message' => 'Invalid request: Token missing.']);
        }

        // Update user's FCM token in the database
        $saved = $this->users->update($userId, ['fcm_token' => $tokenData->fcm_token]);

        if ($saved) {
            return $this->response->setStatusCode(200)
                ->setJSON(['success' => true, 'message' => 'Device token updated successfully.']);
        } else {
            return $this->response->setStatusCode(500)
                ->setJSON(['success' => false, 'message' => 'Failed to update device token.']);
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

        $user = $userModel->where('Email', $email)->first();
        if ($user) {
            $tempPass = md5(uniqid());
            $verificationUrl = base_url("resetPassword/$tempPass");
            $emailMessage = "Please click on the following link to reset your password: <a href='{$verificationUrl}'>Reset Password</a>";

            if ($this->sendEmail($email, 'Reset Your Password', $emailMessage)) {
                // Update the user with the verification token
                if ($userModel->update($user['UserID'], ['verification_token' => $tempPass])) {
                    // Send push notification if fcm_token exists
                    if (!empty($user['fcm_token'])) {
                        $this->sendPushNotification($user['fcm_token'], 'Password Reset Request', 'Please check your email to reset your password.');
                    }
                    // Set flashdata message
                    session()->setFlashdata('success', 'Please check your email to reset your password.');
                    return redirect()->to(base_url('recover'));
                }
            } else {
                session()->setFlashdata('error', 'Failed to send email. Please try again.');
                return redirect()->to(base_url('recover'));
            }
        } else {
            session()->setFlashdata('error', 'Your email is not in our database.');
            return redirect()->to(base_url('recover'));
        }
    }




    protected $googleProjectId = 'push-notif-309d3'; // Set your Google Project ID here

    public function sendPushNotification($token, $title, $body, $data = [], $image = null)
    {
        // Path to the service account key file
        $serviceAccountPath = ROOTPATH . 'pvKey.json'; // Store pvKey.json in writable directory

        // Create credentials for Google API using the service account file
        $credential = new ServiceAccountCredentials(
            "https://www.googleapis.com/auth/firebase.messaging",
            json_decode(file_get_contents($serviceAccountPath), true)
        );

        // Get the OAuth2 access token
        $tokenData = $credential->fetchAuthToken(HttpHandlerFactory::build());
        $accessToken = $tokenData['access_token'] ?? null;

        if (!$accessToken) {
            log_message('error', 'Failed to retrieve access token for Firebase.');
            return false;
        }

        $url = "https://fcm.googleapis.com/v1/projects/{$this->googleProjectId}/messages:send";

        // Prepare the notification payload
        $payload = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'image' => $image,  // Optional image field
                ],
                'webpush' => [
                    'fcm_options' => [
                        'link' => 'https://mahalta.online/'  // Replace with your web app link
                    ]
                ],
                // Optional custom data payload
            ]
        ];

        // Initialize CURL request
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        // Execute CURL and log results
        $result = curl_exec($ch);

        if ($result === false) {
            log_message('error', 'CURL failed: ' . curl_error($ch));
        } else {
            log_message('info', 'FCM response: ' . $result);
        }

        curl_close($ch);

        return json_decode($result, true);
    }



    public function resetPassword($tempPass)
    {
        $userModel = new UserModel();
        $user = $userModel->where('verification_token', $tempPass)->first();
        if ($user) {
            return view('Forgot', ['temp_pass' => $tempPass]);
        } else {
            session()->setFlashdata('error', 'The key is not valid.');
            return redirect()->to(base_url('recover'));
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

                $emailMessage = "Your password has been successfully updated.";
                $this->sendEmail($user['Email'], 'Password Updated', $emailMessage);

                if (!empty($user['fcm_token'])) {
                    $this->sendPushNotification($user['fcm_token'], 'Password Updated', 'Your password has been successfully updated.');
                }

                session()->setFlashdata('success', 'Your password has been successfully updated.');
                return redirect()->to(base_url('login'));
            } else {
                session()->setFlashdata('error', 'Invalid token.');
                return redirect()->to(base_url('recover'));
            }
        } else {
            session()->setFlashdata('error', 'Passwords do not match.');
            return redirect()->back();
        }
    }
}
