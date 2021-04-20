<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class ClientModel extends BaseModel{

    protected static $_table="yhy_client";

    public static $sql;

    public static $fileds = ['client_id','employee_id','user_id','kind','openid','app_id','client_app_id','last_login_time',
        'create_at','update_at','is_subscribe'];

    public static function ShowClient($where,$filed="*",$orWhere=''){
        try {
            $query = sharedb()->table(static::$_table)->select($filed);
            if(!empty($where['employee_id_not_null']) && "Y"==$where['employee_id_not_null']){
                $query = $query->whereNotNull("employee_id");
                $query = $query->where("employee_id",'!=',0);
                $query = $query->where("employee_id",'!=','');
                unset($where['employee_id_not_null']);
            }
            if(!empty($where)){
                foreach($where as $k=>$v){
                    $query = $query->where($k,"{$v}");
                }
            }
            if(!empty($orWhere)){
                foreach($orWhere as $kl=>$vl){
                    $query = $query->orWhere($kl,"{$vl}");
                }
            }

            $query->offset(0)->limit(1);
            $result = $query->get() ?: [];
            static::$sql = $query->toSql();
            return $result;
        } catch (\Exception $e) {
            app('log')->info('---findOne----',[$e->getMessage()]);
            return false;
        }
    }

}

