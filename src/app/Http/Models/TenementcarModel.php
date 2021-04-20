<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class TenementcarModel extends BaseModel{

    protected static $_table="yhy_tenement_car";

    public static $sql;

    public static $fileds = ['driver_id','tenement_id','space_name','plate','car_type_tag_id','rule','car_resource_id',
      'car_type','car_model','car_brand','car_type_name','car_brand_name','update_at',
        'update_at'];

}

