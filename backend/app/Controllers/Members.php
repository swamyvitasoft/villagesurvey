<?php

namespace App\Controllers;

use App\Models\AgentsModel;
use App\Models\LoginModel;
use App\Models\MemberModel;

class Members extends BaseController
{
    private $loggedInfo;
    private $memberModel;
    private $loginModel;
    private $memberInfo;
    public function __construct()
    {
        $this->memberModel = new MemberModel();
        $this->loginModel = new LoginModel();
        $this->loggedInfo = session()->get('LoggedData');
    }

    public function index()
    {
        $this->memberInfo = $this->memberModel->findAll();
        $data = [
            'pageTitle' => 'Village Survey | Dashboard',
            'pageHeading' => 'Dashboard',
            'loggedInfo' => $this->loggedInfo,
            'memberInfo'    => $this->memberInfo
        ];
        return view('common/top', $data)
            . view('members/index')
            . view('common/bottom');
    }
}
