<?php

namespace App\Models;

use CodeIgniter\Model;

class AgentsModel extends Model
{
    protected $table      = 'agents';
    protected $primaryKey = 'agent_id';
    protected $allowedFields = ['login_id', 'created_by', 'status'];
}
