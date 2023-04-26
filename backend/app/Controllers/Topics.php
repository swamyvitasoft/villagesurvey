<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\TopicsModel;

class Topics extends BaseController
{
    private $loggedInfo;
    private $topicsModel;
    private $loginModel;
    private $topicsInfo;
    public function __construct()
    {
        $this->topicsModel = new TopicsModel();
        $this->loginModel = new LoginModel();
        $this->loggedInfo = session()->get('LoggedData');
    }

    public function index()
    {
        $this->topicsInfo = $this->topicsModel->findAll();
        $data = [
            'pageTitle' => 'Village Survey | Dashboard',
            'pageHeading' => 'Dashboard',
            'loggedInfo' => $this->loggedInfo,
            'topicsInfo'    => $this->topicsInfo
        ];
        return view('common/top', $data)
            . view('topics/index')
            . view('common/bottom');
    }
    public function add()
    {
        csrf_field();
        $values = [
            'topic_name' => 'Name',
            'topic_name_te' => 'పేరు',
            'created_by' => 19,
            'status' => 1,
        ];
        $query = $this->topicsModel->insert($values);
        if (!$query) {
            echo "Something went wrong.";
            exit;
        } else {
            echo "Saved.";
            exit;
        }
    }
}
