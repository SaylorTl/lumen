<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class VisitorcarModel extends BaseModel{

    protected static $_table="yhy_visitor_car";

    public static $sql;

    public static $fileds = ['visit_car_id','visit_id','plate','car_type','car_type_name','car_brand_name','car_brand','car_model','create_at'
    ];

}

