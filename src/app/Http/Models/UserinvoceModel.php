<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class UserinvoceModel extends BaseModel{

    protected static $_table="yhy_user_invoce";

    public static $sql;

    public static $fileds = ['user_invoce_id','user_id','employee_id','invoce_type','invoce_title','tax_num','is_default',
        'mobile','email','employ_address','bank_name','bank_account','create_at','update_at'];

}

