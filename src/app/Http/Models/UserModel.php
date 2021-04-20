<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class UserModel extends BaseModel{

    protected static $_table="yhy_users";

    public static $sql;

    public static $fileds = ['user_id','mobile','autolock','verify','create_at','update_at', 'app_id'];

    public static function updateUser($where, $P){
        try{
            sharedb()->beginTransaction();
            $use_res = self::update($where, $P);
            if(false ===$use_res){
                sharedb()->rollback();
                return false;
            }
            $visitor_res = VisitorModel::update($where,$P);
            if(false ===$visitor_res){
                sharedb()->rollback();
                return false;
            }
            $tenement_res = TenementModel::update($where,$P);
            if(false ===$tenement_res){
                sharedb()->rollback();
                return false;
            }
        } catch (\Exception $e) {
            app('log')->info('---user/updateUser----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }

    }

}

