<?php

namespace App\Controllers;

use App\Libraries\Hash;
use App\Models\AgentsModel;
use App\Models\LoginModel;

class Agents extends BaseController
{
    private $loggedInfo;
    private $agentsModel;
    private $loginModel;
    private $agentsInfo;
    public function __construct()
    {
        $this->agentsModel = new AgentsModel();
        $this->loginModel = new LoginModel();
        $this->loggedInfo = session()->get('LoggedData');
    }
    public function index()
    {
        $this->agentsModel->table('agents');
        $this->agentsModel->select('login.*');
        $this->agentsModel->join('login', 'login.login_id = agents.login_id');
        $this->agentsInfo = $this->agentsModel->findAll();
        $data = [
            'pageTitle' => 'Village Survey | Dashboard',
            'pageHeading' => 'Dashboard',
            'loggedInfo' => $this->loggedInfo,
            'agentsInfo'    => $this->agentsInfo
        ];
        return view('common/top', $data)
            . view('agents/index')
            . view('common/bottom');
    }
    public function add()
    {
        $data = [
            'pageTitle' => 'Village Survey | Dashboard',
            'pageHeading' => 'Dashboard',
            'loggedInfo' => $this->loggedInfo
        ];
        return view('common/top', $data)
            . view('agents/add')
            . view('common/bottom');
    }
    public function addAction()
    {
        $validation = $this->validate([
            'name' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Name is required.'
                ]
            ],
            'username' => [
                'rules'  => 'required|is_unique[login.username]',
                'errors' => [
                    'required' => 'Phone Number is required.',
                    'is_unique' => 'Phone Number Unique'
                ]
            ]
        ]);
        if (!$validation) {
            return  redirect()->back()->with('validation', $this->validator)->withInput();
        } else {
            $password = '123456';
            $inputData = [
                'role' => 'Agent',
                'name' => $this->request->getPost("name"),
                'username' => $this->request->getPost("username"),
                'password' => Hash::make($password),
            ];
            $this->loginModel->insert($inputData);
            $login_id = $this->loginModel->getInsertID();
            $input = [
                'login_id' => $login_id,
                'created_by' => $this->loggedInfo['login_id'],
                'status' => 1
            ];
            $query = $this->agentsModel->insert($input);
        }
        if (!$query) {
            return  redirect()->back()->with('fail', 'Something went wrong Input Data.')->withInput();
        } else {
            return  redirect()->to('agents/' . Hash::path('index'))->with('success', 'Congratulations! Agent Added');
        }
    }
}
