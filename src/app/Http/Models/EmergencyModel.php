<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class EmergencyModel extends BaseModel{

    protected static $_table="yhy_emergency";

    public static $sql;

    public static $fileds = ['emergency_id','employee_id','emergency_name','relationship','emergency_phone','create_at'
        ,'update_at'
    ];

}

