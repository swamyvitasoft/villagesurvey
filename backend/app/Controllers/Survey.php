<?php

namespace App\Controllers;

use App\Libraries\Hash;
use App\Models\LoginModel;
use App\Models\MemberModel;
use App\Models\SurveyModel;
use App\Models\TopicsModel;

class Survey extends BaseController
{
    private $loggedInfo;
    private $topicsModel;
    private $loginModel;
    private $topicsInfo;
    private $surveyModel;
    private $memberModel;
    public function __construct()
    {
        $this->memberModel = new MemberModel();
        $this->surveyModel = new SurveyModel();
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
            'topicsInfo'    => $this->topicsInfo,
            'topicsCount'   => count($this->topicsInfo)
        ];
        return view('common/top', $data)
            . view('survey/index')
            . view('common/bottom');
    }
    public function addAction()
    {
        $validation = $this->validate([
            'name' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Name is required.'
                ],
            ],
            'ward' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Ward is required.'
                ],
            ],
            'phone' => [
                'rules'  => 'required|is_unique[member.phone]',
                'errors' => [
                    'required' => 'Phone is required.',
                    'is_unique' => 'Number already registered in our server.'
                ],
            ]
        ]);
        if (!$validation) {
            return  redirect()->back()->with('validation', $this->validator)->withInput();
        } else {
            $memberInput = [
                'name' => $this->request->getPost("name"),
                'ward' => $this->request->getPost("ward"),
                'phone' => $this->request->getPost("phone"),
                'status' => 1,
                'survey_by' => $this->loggedInfo['login_id']
            ];
            $this->memberModel->insert($memberInput);
            $member_id = $this->memberModel->getInsertID();
            $list = $this->request->getPost("topic_id");
            for ($i = 0; $i < sizeof($list); $i++) {
                $topic_id = $list[$i];
                $topic_replay = $this->request->getPost("topic_replay_{$topic_id}");
                $data[] = [
                    'member_id' => $member_id,
                    'topic_id' => $topic_id,
                    'topic_replay' => $topic_replay
                ];
            }
            $query = $this->surveyModel->insertBatch($data);
        }
        if (!$query) {
            return  redirect()->back()->with('fail', 'Something went wrong Input Data.')->withInput();
        } else {
            return  redirect()->to('dashboard/' . Hash::path('index'))->with('success', 'Thank you Valuable Feedback');
        }
    }
}
