<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table      = 'member';
    protected $primaryKey = 'member_id';
    protected $allowedFields = ['name', 'ward', 'phone', 'status', 'survey_by'];
}
