<?php

namespace App\Controllers;

use App\Libraries\Hash;
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
        $data = [
            'pageTitle' => 'Village Survey | Dashboard',
            'pageHeading' => 'Dashboard',
            'loggedInfo' => $this->loggedInfo
        ];
        return view('common/top', $data)
            . view('topics/add')
            . view('common/bottom');
    }
    public function addAction()
    {
        $validation = $this->validate([
            'topic_name' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Topic Name is required.'
                ]
            ]
        ]);
        if (!$validation) {
            return  redirect()->back()->with('validation', $this->validator)->withInput();
        } else {
            $values = [
                'topic_name' => $this->request->getPost("topic_name"),
                'topic_name_te' => '',
                'created_by' => $this->loggedInfo['login_id'],
                'status' => 1,
            ];
            $query = $this->topicsModel->insert($values);
        }
        if (!$query) {
            return  redirect()->back()->with('fail', 'Something went wrong Input Data.')->withInput();
        } else {
            return  redirect()->to('topics/' . Hash::path('index'))->with('success', 'Congratulations! Topic Added');
        }
    }
}
