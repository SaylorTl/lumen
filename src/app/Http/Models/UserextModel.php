<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class UserextModel extends BaseModel{

    protected static $_table="yhy_user_ext";

    public static $sql;

    public static $fileds = ['user_ext_id','user_id','user_ext_tag_id','detail','create_at','update_at'];

}

