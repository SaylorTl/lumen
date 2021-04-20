<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

use Illuminate\Http\Request;

class EmployeeextModel extends BaseModel{

    protected static $_table="yhy_employee_ext";

    public static $sql;

    public static $fileds = ['epy_ext_id','employee_id','nation_tag_id','birth_day','political_tag_id','license_tag_id','license_num',
        'education_tag_id','employee_status_tag_id','frame_id','job_tag_id','departure_time','project_id','entry_time','remark',
        'update_at','create_at','email','address','leader','job_level','salary_level'
    ];

}

