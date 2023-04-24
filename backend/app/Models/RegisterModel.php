<?php

namespace App\Models;

use CodeIgniter\Model;

class RegisterModel extends Model
{
    protected $table      = 'register'; // table name
    protected $primaryKey = 'register_id';
    protected $allowedFields = ['empId', 'fullname', 'fname', 'address', 'email', 'phone', 'aadhar_radio', 'aadhar', 'relieving_radio', 'relieving', 'payslip_radio', 'payslip', 'identitycard_radio', 'identitycard', 'pensionorder_radio', 'pensionorder', 'esipf_radio', 'esipf', 'photo', 'auth_id', 'status', 'login_id', 'created'];
}
