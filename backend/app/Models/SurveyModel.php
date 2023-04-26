<?php

namespace App\Models;

use CodeIgniter\Model;

class SurveyModel extends Model
{
    protected $table      = 'survey';
    protected $primaryKey = 'survey_id';
    protected $allowedFields = ['member_id', 'topic_id', 'topic_replay'];
}
