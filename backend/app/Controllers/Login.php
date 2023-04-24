<?php

namespace App\Controllers;

use App\Libraries\Hash;
use App\Models\LoginModel;

class Login extends BaseController
{
    private $loginModel;
    public function __construct()
    {
        $this->loginModel = new LoginModel();
    }
    public function login()
    {
        $data = [
            'pageTitle' => 'VRS | Login'
        ];
        return view('login/index', $data);
    }
    public function create()
    {
        csrf_field();
        $name = "Admin";
        $email_id = "admin@gmail.com";
        $password = "123456";
        $values = [
            'role' => 'Admin',
            'name' => $name,
            'email_id' => $email_id,
            'password' => Hash::make($password),
        ];
        $query = $this->loginModel->insert($values);
        if (!$query) {
            echo "Something went wrong.";
            exit;
        } else {
            echo "Congratulation. You are now successfully registered.";
            exit;
        }
    }
    public function check()
    {
        if ($this->request->getMethod() == 'post') {
            $validation = $this->validate([
                'email_id' => [
                    'rules'  => 'required|valid_email|is_not_unique[login.email_id]',
                    'errors' => [
                        'required' => 'Email ID is required.',
                        'valid_email' => 'Email ID Incorrect Format.',
                        'is_not_unique' => 'Email ID not registered in our server.'
                    ],
                ],
                'password' => [
                    'rules'  => 'required|min_length[5]|max_length[20]',
                    'errors' => [
                        'required' => 'Password is required.',
                        'min_length' => 'Password must have atleast 5 characters in length.',
                        'max_length' => 'Password must not have characters more thant 20 in length.',
                    ],
                ],
            ]);
            if (!$validation) {
                return  redirect()->back()->with('validation', $this->validator)->withInput();
            } else {
                $email_id = $this->request->getPost('email_id');
                $password = $this->request->getPost('password');
                $logged_info = $this->loginModel->where('email_id', $email_id)->first();
                $check_password = Hash::check($password, $logged_info['password']);
                if (!$check_password) {
                    return  redirect()->back()->with('fail', 'Incorect password.')->withInput();
                } else {
                    session()->set('LoggedData', $logged_info);
                    return  redirect()->to('dashboard/' . Hash::path('index'));
                }
            }
        }
    }
    public function recover()
    {
        if ($this->request->getMethod() == 'post') {
            $validation = $this->validate([
                'email_id' => [
                    'rules'  => 'required|valid_email|is_not_unique[login.email_id]',
                    'errors' => [
                        'required' => 'Email ID is required.',
                        'valid_email' => 'Email ID Incorrect Format.',
                        'is_not_unique' => 'Email ID not registered in our server.'
                    ],
                ],
            ]);
            if (!$validation) {
                return  redirect()->back()->with('validation', $this->validator)->withInput();
            } else {
                $email_id = $this->request->getPost('email_id');
                $logged_info = $this->loginModel->where('email_id', $email_id)->first();
                if (!$logged_info) {
                    return  redirect()->back()->with('fail', 'Email ID Incorrect Format.')->withInput();
                } else {
                    helper('text');
                    $new_password = random_string('alnum', 6);
                    $to = $email_id;
                    $subject = 'Recover Password';
                    $message = 'Hello ' . $logged_info['name'] . ', Your new password ' . $new_password;
                    $email = \Config\Services::email();
                    $email->setTo($to);
                    $email->setFrom('swamy@vitasoft.in', '');
                    $email->setSubject($subject);
                    $email->setMessage($message);
                    if ($email->send()) {
                        $inputData = array(
                            'password' => Hash::make($new_password)
                        );
                        $query = $this->loginModel->update($logged_info['login_id'], $inputData);
                        return  redirect()->back()->with('success', 'Instructions sent your registered e-mail.')->withInput();
                    } else {
                        $data = $email->printDebugger(['headers']);
                        return  redirect()->back()->with('fail', $data)->withInput();
                    }
                }
            }
        }
    }
    public function logout()
    {
        if (session()->has('LoggedData')) {
            session()->remove('LoggedData');
            return  redirect()->to('login')->with('fail', 'You are now logged out.');
        }
    }
    public function view()
    {
        $loggedInfo = session()->get('LoggedData');
        $customerInfo = $this->loginModel->where('role', 'Customer')->get()->getResultArray();
        $data = [
            'pageTitle' => 'Crusher Administrator | Customers',
            'pageHeading' => 'Customers',
            'loggedInfo' => $loggedInfo,
            'logo' => site_url() . 'assets/images/logo.png',
            'customerInfo'  => $customerInfo
        ];
        return view('common/top', $data)
            . view('login/view')
            . view('common/bottom');
    }
}
