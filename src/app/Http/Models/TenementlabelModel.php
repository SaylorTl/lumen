<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class TenementlabelModel extends BaseModel{

    protected static $_table="yhy_tenement_label";

    public static $sql;

    public static $fileds = ['label_id','tenement_id','tenement_tag_id','create_at'];

}

