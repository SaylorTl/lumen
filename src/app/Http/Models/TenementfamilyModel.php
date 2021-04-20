<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class TenementfamilyModel extends BaseModel{

    protected static $_table="yhy_tenement_family";

    public static $sql;

    public static $fileds = ['tenement_m_id','tenement_id','tenement_m_name','tenement_m_mobile','create_at','update_at'];

}

