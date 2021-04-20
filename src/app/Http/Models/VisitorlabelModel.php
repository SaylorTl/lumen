<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class VisitorlabelModel extends BaseModel{

    protected static $_table="yhy_visitor_label";

    public static $sql;

    public static $fileds = ['visitor_label_id','visit_id','visit_tag_id','create_at'];

}

