<?php

namespace App\Controllers;

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
}
