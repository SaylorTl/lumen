<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class FollowModel extends BaseModel{

    protected static $_table="yhy_visitor_follow";

    public static $sql;

    public static $fileds = ['follow_id','visit_id','follow_name','follow_mobile','create_at'];

}

