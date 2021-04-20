<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class MemberModel extends BaseModel{

    protected static $_table="yhy_member";

    public static $sql;

    public static $fileds = ['member_id','employee_id','type','login_max_num','oa','last_login_time',
        'end_time','begin_time','last_login_ip','update_at','update_at'];

    public static function register($P){
        try{
            sharedb()->beginTransaction();
            $employee_id = $P['employee_id'];
            if(!empty($P['user_name'])){
                $employee_res = EmployeeModel::update(['employee_id'=>$employee_id],['user_name'=>$P['user_name']]);
                if($employee_res === false){
                    sharedb()->rollback();
                    return false;
                }
            }
            $memberData = [
                'employee_id'=>$employee_id,
                'type'=>isset($P['type']) ? $P['type'] : 1 ,
                'password'=>isset($P['password']) ? $P['password'] : '' ,
                'oa'=>isset($P['oa']) ? $P['oa'] : '' ,
                'last_login_time'=>date('Y-m-d H:i:s',time()),
                'last_login_ip'=>isset($P['ip']) ? $P['ip'] : '' ,
                'login_max_num' => isset($P['login_max_num']) ? $P['login_max_num'] : 1,
                'end_time'=>isset($P['end_time']) ? strtotime($P['end_time']) : '',
                'begin_time'=>isset($P['begin_time']) ? strtotime($P['begin_time']) : '',
                'create_at'=>date('Y-m-d H:i:s',time()),
                'update_at'=>date('Y-m-d H:i:s',time())];
            $info = MemberModel::add($memberData);
            if(empty($info)){
                sharedb()->rollback();
                return false;
            }
            sharedb()->commit();
            return true;
        } catch (\Exception $e) {
            app('log')->info('---member/register----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }

    /**
     * @param $params
     * @return array
     * 展示用户
     */
    public static function showUser($P,$inParams=[],$page=0,$pagesize=0){
        $table = static::$_table;
        $query = sharedb()->table("{$table} as yhym")
            ->leftJoin('yhy_employee as yhyu','yhym.employee_id','=','yhyu.employee_id')
            ->select(['yhym.member_id','yhym.employee_id','yhym.type','yhym.type','yhym.last_login_time',
                'yhym.create_at','yhym.login_max_num','yhym.update_at','yhym.last_login_ip','yhyu.sex','yhyu.full_name',
                'yhyu.user_name','yhym.end_time','yhym.begin_time','yhym.last_login_project_id',
                'yhyu.mobile','yhyu.status','yhyu.autolock','yhyu.verify','yhyu.app_id']);
        if(isset($P['member_id'])){
            $query = $query->where("yhym.member_id","{$P['member_id']}");
        }
        if(isset($P['mobile'])){
            $query = $query->where("yhyu.mobile","{$P['mobile']}");
        }
        if(isset($P['app_id'])){
            $query = $query->where("yhyu.app_id","{$P['app_id']}");
        }
        if(isset($P['oa'])){
            $query = $query->where("yhym.oa","{$P['oa']}");
        }
        if(isset($P['user_name'])){
            $query = $query->where("yhyu.user_name","{$P['user_name']}");
        }
        if(isset($P['full_name'])){
            $query = $query->where("yhyu.full_name","like","%".$P['full_name']."%");
        }
        if(isset($P['status'])){
            $query = $query->where("yhyu.status","{$P['status']}");
        }
        if(isset($P['time_begin'])){
            $query = $query->where("yhym.create_at",">=","{$P['time_begin']}");
        }
        if(isset($P['time_end'])){
            $query = $query->where("yhym.create_at","<","{$P['time_end']}");
        }
        if(isset($P['employee_id'])){
            $query = $query->where("yhym.employee_id","{$P['employee_id']}");
        }
        if(isset($P['employee_id'])){
            $query = $query->where("yhym.employee_id","{$P['employee_id']}");
        }
        if(isset($inParams['member_ids'])){
            $query = $query->whereIn("yhym.member_id",$P['member_ids']);
        }
        if(isset($inParams['employee_ids'])) {
            $query = $query->whereIn("yhyu.employee_id",$P['employee_ids']);
        }
        if($page){
            $offset = $pagesize * ( max(intval($page), 1) - 1 );
            $query->offset($offset)->limit($pagesize);
        }
        $query->orderBy("yhym.member_id","desc");
        $result = $query->get() ?: [];
        static::$sql = $query->toSql();
        return $result;
    }

    /**
     * @param $params
     * @return array
     * 展示用户
     */
    public static function countUser($P,$inParams){
        $table = static::$_table;
        $query = sharedb()->table("{$table} as yhym")
            ->leftJoin('yhy_employee as yhyu','yhym.employee_id','=','yhyu.employee_id');
        if(isset($P['member_id'])){
            $query = $query->where("yhym.member_id","{$P['member_id']}");
        }
        if(isset($P['mobile'])){
            $query = $query->where("yhyu.mobile","{$P['mobile']}");
        }
        if(isset($P['oa'])){
            $query = $query->where("yhym.oa","{$P['oa']}");
        }
        if(isset($P['app_id'])){
            $query = $query->where("yhyu.app_id","{$P['app_id']}");
        }
        if(isset($P['user_name'])){
            $query = $query->where("yhyu.user_name","{$P['user_name']}");
        }
        if(isset($P['full_name'])){
            $query = $query->where("yhyu.full_name","like","%".$P['full_name']."%");
        }
        if(isset($P['status'])){
            $query = $query->where("yhyu.status","{$P['status']}");
        }
        if(isset($P['time_begin'])){
            $query = $query->where("yhym.create_at",">","{$P['time_begin']}");
        }
        if(isset($P['time_end'])){
            $query = $query->where("yhym.create_at","<","{$P['time_end']}");
        }
        if(isset($P['employee_id'])){
            $query = $query->where("yhym.employee_id","{$P['employee_id']}");
        }
        if(isset($inParams['member_ids'])){
            $query = $query->whereIn("yhym.member_id",$P['member_ids']);
        }
        if(isset($inParams['employee_ids'])) {
            $query = $query->whereIn("yhyu.employee_id",$P['employee_ids']);
        }
        $result = $query->count() ?: [];
        static::$sql = $query->toSql();
        return $result;
    }

    public static function findPwd($P){
        $table = static::$_table;
        $query = sharedb()->table("{$table} as yhym")
            ->leftJoin('yhy_employee as yhyu','yhym.employee_id','=','yhyu.employee_id')
            ->select(['yhym.password','yhym.member_id','yhym.end_time','yhym.begin_time','yhyu.status']);
        if(isset($P['user_name'])){
            $query = $query->where('yhyu.user_name',$P['user_name']);
        }
        $result = $query->get() ?: [];
        static::$sql = $query->toSql();
        return $result;

    }
}

