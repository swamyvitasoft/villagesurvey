<?php

namespace App\Models;

use CodeIgniter\Model;

class TopicsModel extends Model
{
    protected $table      = 'topics';
    protected $primaryKey = 'topic_id';
    protected $allowedFields = ['topic_name', 'topic_name_te', 'created_by', 'status'];
}
