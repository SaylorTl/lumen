<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class ClienthouseModel extends BaseModel{

    protected static $_table="yhy_client_house";

    public static $sql;

    public static $fileds = ['c_house_id','client_id','cell_id','house_id','create_at','update_at'];

}

