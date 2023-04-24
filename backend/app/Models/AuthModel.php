<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table      = 'auth';
    protected $primaryKey = 'auth_id';
    protected $allowedFields = ['empId', 'tmplval', 'serialNumber', 'imageHeight', 'imageWidth', 'imageDPI', 'nFIQ', 'templateBase64', 'isoImgBase64', 'sessionKey', 'encryptedPidXml', 'encryptedHmac', 'clientIP', 'timestamp', 'fdc', 'status', 'login_id'];
}
