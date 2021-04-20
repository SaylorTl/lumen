<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class CertificateModel extends BaseModel{

    protected static $_table="yhy_certificate";

    public static $sql;

    public static $fileds = ['certificate_id','employee_id','certificate_name','certificate_num','end_time','cert_resource_id','create_at'];

}

