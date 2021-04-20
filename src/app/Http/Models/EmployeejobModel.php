<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class EmployeejobModel extends BaseModel{

    protected static $_table="yhy_employee_job";

    public static $sql;

    public static $fileds = ['employee_job_id','employee_id','job_id','create_at'];

}

