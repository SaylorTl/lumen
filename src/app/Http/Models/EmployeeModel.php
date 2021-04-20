<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class EmployeeModel extends BaseModel{

    protected static $_table="yhy_employee";

    public static $sql;

    public static $fileds = ['employee_id','app_id','sex','full_name','nick_name','user_name','mobile','status','autolock',
        'verify','update_at','update_at'];

    public static function showMemberUser($P,$page=0,$pagesize=0){
        $query = sharedb()->table("yhy_employee as yhym")
            ->leftJoin('yhy_employee_ext as yhte','yhym.employee_id','=','yhte.employee_id')
            ->leftJoin('yhy_member as yhm','yhm.employee_id','=','yhym.employee_id')
            ->select(['yhym.employee_id','yhym.sex','yhym.full_name','yhym.mobile','yhym.status','yhte.nation_tag_id',
                'yhte.email','yhte.address','yhte.leader','yhym.user_type_tag_id',
                'yhte.birth_day','yhte.political_tag_id','yhte.license_tag_id','yhte.license_num','yhte.education_tag_id',
                'yhte.employee_status_tag_id','yhte.frame_id','yhte.job_tag_id','yhte.departure_time','yhte.entry_time',
                'yhym.creator','yhym.editor','yhte.project_id','yhte.remark','yhym.create_at','yhym.update_at','yhte.epy_ext_id'
                ,'yhte.labor_type_tag_id','yhte.labor_begin_time','yhte.labor_end_time','yhte.salary_level','yhte.job_level']);
        $query = $query->whereNull("yhm.employee_id");
        if(isset($P['mobile'])){
            $query = $query->where("yhym.mobile","{$P['mobile']}");
        }
        if(isset($P['full_name'])){
            $query = $query->where("yhym.full_name","like","%".$P['full_name']."%");
        }
        if(isset($P['user_name'])){
            $query = $query->where("yhym.user_name","like","%".$P['user_name']."%");
        }
        if(isset($P['frame_id'])){
            $query = $query->where("yhte.frame_id","{$P['frame_id']}");
        }
        if(isset($P['status'])){
            $query = $query->where("yhym.status","{$P['status']}");
        }
        if(isset($P['leader_name'])){
            $query = $query->where("yhym.full_name","like","%".$P['leader_name']."%")->orwhere("yhym.mobile",$P['leader_name']);
        }
        if(isset($P['political_tag_id'])){
            $query = $query->where("yhte.political_tag_id","{$P['political_tag_id']}");
        }
        if(isset($P['employee_status_tag_id'])){
            $query = $query->where("yhte.employee_status_tag_id","{$P['employee_status_tag_id']}");
        }
        if(isset($P['employ_begin_time'])){
            $query = $query->where("yhym.create_at",">","{$P['employ_begin_time']}");
        }
        if(isset($P['employ_end_time'])){
            $query = $query->where("yhym.create_at","<","{$P['employ_end_time']}");
        }
        if(isset($P['education_tag_id'])){
            $query = $query->where("yhte.education_tag_id","{$P['education_tag_id']}");
        }
        if(isset($P['employee_id'])){
            $query = $query->where("yhym.employee_id","{$P['employee_id']}");
        }
        if(isset($P['employee_ids'])) {
            $query = $query->whereIn("yhym.employee_id",$P['employee_ids']);
        }
        if(isset($P['project_id'])){
            $query = $query->where("yhte.project_id","{$P['project_id']}");
        }
        if(isset($P['job_tag_id'])){
            $query = $query->where("yhte.job_tag_id","{$P['job_tag_id']}");
        }
        if(isset($P['project_ids'])){
            $query = $query->whereIn("yhte.project_id",$P['project_ids']);
        }
        if(isset($P['app_id'])){
            $query = $query->where("yhym.app_id","{$P['app_id']}");
        }
        if($page){
            $offset = $pagesize * ( max(intval($page), 1) - 1 );
            $query->offset($offset)->limit($pagesize);
        }
        $query->orderBy('yhym.employee_id','desc');
        $result = $query->get() ?: [];
        static::$sql = $query->toSql();
        return $result;
    }

    /**
     * @param $params
     * @return array
     * 展示用户
     */
    public static function memberCounts($P){
        $query = sharedb()->table("yhy_employee as yhym")
            ->leftJoin('yhy_employee_ext as yhte','yhym.employee_id','=','yhte.employee_id')
            ->leftJoin('yhy_member as yhm','yhm.employee_id','=','yhym.employee_id');
        $query = $query->whereNull("yhm.employee_id");
        if(isset($P['mobile'])){
            $query = $query->where("yhym.mobile","{$P['mobile']}");
        }
        if(isset($P['full_name'])){
            $query = $query->where("yhym.full_name","like","%".$P['full_name']."%");
        }
        if(isset($P['leader_name'])){
            $query = $query->where("yhym.full_name","like","%".$P['leader_name']."%")->orwhere("yhym.mobile",$P['leader_name']);
        }
        if(isset($P['user_name'])){
            $query = $query->where("yhym.user_name","like","%".$P['user_name']."%");
        }
        if(isset($P['status'])){
            $query = $query->where("yhym.status","{$P['status']}");
        }
        if(isset($P['political_tag_id'])){
            $query = $query->where("yhte.political_tag_id","{$P['political_tag_id']}");
        }
        if(isset($P['employee_status_tag_id'])){
            $query = $query->where("yhte.employee_status_tag_id","{$P['employee_status_tag_id']}");
        }
        if(isset($P['employ_begin_time'])){
            $query = $query->where("yhym.create_at",">","{$P['employ_begin_time']}");
        }
        if(isset($P['frame_id'])){
            $query = $query->where("yhte.frame_id","{$P['frame_id']}");
        }
        if(isset($P['employ_end_time'])){
            $query = $query->where("yhym.create_at","<","{$P['employ_end_time']}");
        }
        if(isset($P['education_tag_id'])){
            $query = $query->where("yhte.education_tag_id","{$P['education_tag_id']}");
        }
        if(isset($P['employee_id'])){
            $query = $query->where("yhym.employee_id","{$P['employee_id']}");
        }
        if(isset($P['employee_ids'])) {
            $query = $query->whereIn("yhym.employee_id",$P['employee_ids']);
        }
        if(isset($P['project_id'])){
            $query = $query->where("yhte.project_id","{$P['project_id']}");
        }
        if(isset($P['project_ids'])){
            $query = $query->whereIn("yhte.project_id",$P['project_ids']);
        }
        if(isset($P['app_id'])){
            $query = $query->where("yhym.app_id","{$P['app_id']}");
        }
        $result = $query->count() ?: 0;
        static::$sql = $query->toSql();
        return $result;
    }

    /**
     * @param $params
     * @return array
     * 展示用户
     */
    public static function showUser($P,$page=0,$pagesize=0){
        $query = sharedb()->table("yhy_employee as yhym")
            ->leftJoin('yhy_employee_ext as yhte','yhym.employee_id','=','yhte.employee_id')
            ->select(['yhym.employee_id','yhym.sex','yhym.full_name','yhym.mobile','yhym.status','yhte.nation_tag_id',
                'yhte.email','yhte.address','yhte.leader','yhym.user_type_tag_id',
                'yhte.birth_day','yhte.political_tag_id','yhte.license_tag_id','yhte.license_num','yhte.education_tag_id',
                'yhte.employee_status_tag_id','yhte.frame_id','yhte.job_tag_id','yhte.departure_time','yhte.entry_time',
                'yhym.creator','yhym.editor','yhte.project_id','yhte.remark','yhym.create_at','yhym.update_at','yhte.epy_ext_id'
                ,'yhte.labor_type_tag_id','yhte.labor_begin_time','yhte.labor_end_time','yhte.salary_level','yhte.job_level']);
        if(isset($P['mobile'])){
            $query = $query->where("yhym.mobile","{$P['mobile']}");
        }
        if(isset($P['full_name'])){
            $query = $query->where("yhym.full_name","like","%".$P['full_name']."%");
        }
        if(isset($P['user_name'])){
            $query = $query->where("yhym.user_name","like","%".$P['user_name']."%");
        }
        if(isset($P['frame_id'])){
            $query = $query->where("yhte.frame_id","{$P['frame_id']}");
        }
        if(isset($P['job_tag_id'])){
            $query = $query->where("yhte.job_tag_id","{$P['job_tag_id']}");
        }
        if(isset($P['status'])){
            $query = $query->where("yhym.status","{$P['status']}");
        }
        if(isset($P['leader_name'])){
            $query = $query->where("yhym.full_name","like","%".$P['leader_name']."%")->orwhere("yhym.mobile",$P['leader_name']);
        }
        if(isset($P['political_tag_id'])){
            $query = $query->where("yhte.political_tag_id","{$P['political_tag_id']}");
        }
        if(isset($P['employee_status_tag_id'])){
            $query = $query->where("yhte.employee_status_tag_id","{$P['employee_status_tag_id']}");
        }
        if(isset($P['employ_begin_time'])){
            $query = $query->where("yhym.create_at",">","{$P['employ_begin_time']}");
        }
        if(isset($P['employ_end_time'])){
            $query = $query->where("yhym.create_at","<","{$P['employ_end_time']}");
        }
        if(isset($P['education_tag_id'])){
            $query = $query->where("yhte.education_tag_id","{$P['education_tag_id']}");
        }
        if(isset($P['employee_id'])){
            $query = $query->where("yhym.employee_id","{$P['employee_id']}");
        }
        if(isset($P['employee_ids'])) {
            $query = $query->whereIn("yhym.employee_id",$P['employee_ids']);
        }
        if(isset($P['project_id'])){
            $query = $query->where("yhte.project_id","{$P['project_id']}");
        }
        if(isset($P['project_ids'])){
            $query = $query->whereIn("yhte.project_id",$P['project_ids']);
        }
        if(isset($P['app_id'])){
            $query = $query->where("yhym.app_id","{$P['app_id']}");
        }
        if(isset($P['frame_ids'])){
            $query = $query->whereIn("yhte.frame_id",$P['frame_ids']);
        }
        if($page){
            $offset = $pagesize * ( max(intval($page), 1) - 1 );
            $query->offset($offset)->limit($pagesize);
        }

        //排序
        $order_arr = ['yhym.employee_id', 'desc'];
        if (isset($P['order'])) {
            switch ($P['order'][0]) {
                case 'employee_id':
                    $P['order'][0] = 'yhym.employee_id';
                    break;
                default:
                    break;
            }
            $order_arr = $P['order'];
        }
        $query->orderBy($order_arr[0], $order_arr[1]);
        $result = $query->get() ?: [];
        static::$sql = $query->toSql();
        return $result;
    }

    /**
     * @param $params
     * @return array
     * 展示用户
     */
    public static function counts($P){
        $query = sharedb()->table("yhy_employee as yhym")
            ->leftJoin('yhy_employee_ext as yhte','yhym.employee_id','=','yhte.employee_id');
        if(isset($P['mobile'])){
            $query = $query->where("yhym.mobile","{$P['mobile']}");
        }
        if(isset($P['full_name'])){
            $query = $query->where("yhym.full_name","like","%".$P['full_name']."%");
        }
        if(isset($P['leader_name'])){
            $query = $query->where("yhym.full_name","like","%".$P['leader_name']."%")->orwhere("yhym.mobile",$P['leader_name']);
        }
        if(isset($P['user_name'])){
            $query = $query->where("yhym.user_name","like","%".$P['user_name']."%");
        }
        if(isset($P['status'])){
            $query = $query->where("yhym.status","{$P['status']}");
        }
        if(isset($P['political_tag_id'])){
            $query = $query->where("yhte.political_tag_id","{$P['political_tag_id']}");
        }
        if(isset($P['employee_status_tag_id'])){
            $query = $query->where("yhte.employee_status_tag_id","{$P['employee_status_tag_id']}");
        }
        if(isset($P['employ_begin_time'])){
            $query = $query->where("yhym.create_at",">","{$P['employ_begin_time']}");
        }
        if(isset($P['frame_id'])){
            $query = $query->where("yhte.frame_id","{$P['frame_id']}");
        }
        if(isset($P['job_tag_id'])){
            $query = $query->where("yhte.job_tag_id","{$P['job_tag_id']}");
        }
        if(isset($P['employ_end_time'])){
            $query = $query->where("yhym.create_at","<","{$P['employ_end_time']}");
        }
        if(isset($P['education_tag_id'])){
            $query = $query->where("yhte.education_tag_id","{$P['education_tag_id']}");
        }
        if(isset($P['employee_id'])){
            $query = $query->where("yhym.employee_id","{$P['employee_id']}");
        }
        if(isset($P['employee_ids'])) {
            $query = $query->whereIn("yhym.employee_id",$P['employee_ids']);
        }
        if(isset($P['project_id'])){
            $query = $query->where("yhte.project_id","{$P['project_id']}");
        }
        if(isset($P['project_ids'])){
            $query = $query->whereIn("yhte.project_id",$P['project_ids']);
        }
        if(isset($P['frame_ids'])){
            $query = $query->whereIn("yhte.frame_id",$P['frame_ids']);
        }
        if(isset($P['app_id'])){
            $query = $query->where("yhym.app_id","{$P['app_id']}");
        }
        $result = $query->count() ?: 0;
        static::$sql = $query->toSql();
        return $result;
    }

    public static function addEmployee($P){
        try{
            sharedb()->beginTransaction();
            $users = EmployeeModel::findOne(['mobile'=>$P['mobile'],'app_id'=>$P['app_id']],['employee_id']);
            app('log')->info('----11111111---', [$users]);
            if(!empty($users)){
                $employee_id = $users[0]['employee_id'];
            }else{
                $employeeData = [
                    'employee_id'=>$P['employee_id'],
                    'sex'=>isset($P['sex']) ? $P['sex'] : '',
                    'full_name'=> isset($P['full_name']) ? $P['full_name'] : '',
                    'nick_name'=>isset($P['nick_name']) ? $P['nick_name'] : '',
                    'user_name'=>isset($P['user_name']) ? $P['user_name'] : md5($P['mobile'].$P['app_id']),
                    'user_type_tag_id'=>isset($P['user_type_tag_id']) ? $P['user_type_tag_id'] : '',
                    'mobile'=>$P['mobile'],
                    'app_id'=>isset($P['app_id']) ? $P['app_id'] : '',
                    'status'=>isset($P['status']) ? $P['status'] : 'Y',
                    'autolock'=>isset($P['autolock']) ? $P['autolock'] : 'N',
                    'verify'=>isset($P['verify']) ? $P['verify'] : 'N',
                    'creator'=>isset($P['creator']) ? $P['creator'] : '',
                    'editor'=>isset($P['editor']) ? $P['editor'] : '',
                    'create_at'=>date('Y-m-d H:i:s',time()),
                    'update_at'=>date('Y-m-d H:i:s',time()),
                ];
                app('log')->info('---2222----', [$employeeData]);
                $employee_res = EmployeeModel::add($employeeData);
                app('log')->info('---3333----', [$employee_res]);
                if($employee_res ===false){
                    sharedb()->rollback();
                    return false;
                }
                $employee_id = $P['employee_id'];
            }
            $employeeExtData = [
                'employee_id'=>$employee_id,
                'nation_tag_id'=>isset($P['nation_tag_id']) ? $P['nation_tag_id'] : '',
                'birth_day'=>isset($P['birth_day']) ? $P['birth_day'] : '',
                'political_tag_id'=>isset($P['political_tag_id']) ? $P['political_tag_id'] : '' ,
                'license_tag_id'=>isset($P['license_tag_id']) ? $P['license_tag_id'] : '',
                'license_num'=>isset($P['license_num']) ? $P['license_num'] : '',
                'education_tag_id'=>isset($P['education_tag_id']) ? $P['education_tag_id'] : '',
                'employee_status_tag_id'=>isset($P['employee_status_tag_id']) ? $P['employee_status_tag_id'] : '',
                'frame_id'=>isset($P['frame_id']) ? $P['frame_id'] : '',
                'job_tag_id'=>isset($P['job_tag_id']) ? $P['job_tag_id'] : '',
                'email'=>isset($P['email']) ? $P['email'] : '',
                'address'=>isset($P['address']) ? $P['address'] : '',
                'leader'=>isset($P['leader']) ? $P['leader'] : '',
                'labor_type_tag_id'=>isset($P['labor_type_tag_id']) ? $P['labor_type_tag_id'] : '',
                'labor_begin_time'=>isset($P['labor_begin_time']) ? strtotime($P['labor_begin_time']): '' ,
                'labor_end_time'=>isset($P['labor_end_time']) ? strtotime($P['labor_end_time']): '' ,
                'entry_time'=>isset($P['entry_time']) ? strtotime($P['entry_time']): '' ,
                'departure_time'=>!empty($P['departure_time']) ? strtotime($P['departure_time']):0,
                'remark'=>isset($P['remark']) ? $P['remark'] :'',
                'project_id'=>!empty($P['project_id']) ? $P['project_id'] :'',
                'create_at'=>date('Y-m-d H:i:s',time()),
                'update_at'=>date('Y-m-d H:i:s',time()),
                'job_level'=>isset($P['job_level']) ? $P['job_level'] : '',
                'salary_level'=>isset($P['salary_level']) ? $P['salary_level'] : '',];
            $info = EmployeeextModel::add($employeeExtData);
            app('log')->info('---4444----', [$info]);
            if(empty($info)){
                sharedb()->rollback();
                return false;
            }

            $clientInsertData = [
                'employee_id' => $employee_id,
                'user_id' =>  0,
                'kind' =>  'WEB',
                'openid' => isset($P['mobile']) ? $P['mobile'] : '',
                'app_id' =>  'web',
                'client_app_id' => isset($P['app_id']) ? $P['app_id'] : '',
                'last_login_time'=>date('Y-m-d H:i:s',time()),
                'is_subscribe' => 'N',
                'create_at' => date('Y-m-d H:i:s', time()),
                'update_at' => date('Y-m-d H:i:s', time())];

            $client_add_res  = ClientModel::add($clientInsertData);
            if($client_add_res ===false){
                app('log')->info('---employeeModel/adduser----',["客户端信息添加失败".json_encode($clientInsertData)]);
                sharedb()->rollback();
                return false;
            }

            if(!empty($P['cert_list'])){
                foreach($P['cert_list'] as $value){
                    $certificateExtData = [
                        'employee_id'=>$employee_id,
                        'certificate_name'=>isset($value['certificate_name']) ? $value['certificate_name']:'',
                        'certificate_num'=>isset($value['certificate_num']) ? $value['certificate_num']:'',
                        'cert_resource_id'=>isset($value['cert_resource_id']) ? $value['cert_resource_id']:'',
                        'cert_begin_time'=>isset($value['cert_begin_time']) ? strtotime($value['cert_begin_time']):'',
                        'cert_end_time'=>isset($value['cert_end_time']) ? strtotime($value['cert_end_time']):'',
                        'create_at'=>date('Y-m-d H:i:s',time()),
                    ];
                    $info = CertificateModel::add($certificateExtData);
                    app('log')->info('--5555----', [$info]);
                    if(empty($info)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            if(!empty($P['emergency_list'])){
                foreach($P['emergency_list'] as $val){
                    $EmergencyData = [
                        'employee_id'=>$employee_id,
                        'emergency_name'=>isset($val['emergency_name']) ? $val['emergency_name']:'',
                        'relationship'=>isset($val['relationship']) ? $val['relationship'] :'',
                        'emergency_phone'=>isset($val['emergency_phone']) ?$val['emergency_phone']:''  ,
                        'create_at'=>date('Y-m-d H:i:s',time()),
                        'update_at'=>date('Y-m-d H:i:s',time())
                    ];
                    $info = EmergencyModel::add($EmergencyData);
                    app('log')->info('--6666----', [$info]);
                    if(empty($info)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            sharedb()->commit();
            return $employee_id;
        } catch (\Exception $e) {
            app('log')->info('---employeeModel/adduser----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }


    public static function updateEmployee($P){
        try{
            sharedb()->beginTransaction();
            if(empty($P['employee_id']) && empty($P['epy_ext_id'])){
                app('log')->info('---employeeModel/updateuser0----',[$P]);
                return false;
            }
            $employee_id = $P['employee_id'];
            $employeeData = [
                'sex'=>isset($P['sex']) ? $P['sex'] : '0',
                'full_name'=> $P['full_name'],
                'nick_name'=>isset($P['nick_name']) ? $P['nick_name'] : '',
//                'user_name'=>isset($P['user_name']) ? $P['user_name'] : $P['mobile'],
                'mobile'=>$P['mobile'],
                'status'=>isset($P['status']) ? $P['status'] : 'Y',
                'autolock'=>isset($P['autolock']) ? $P['autolock'] : 'N',
                'verify'=>isset($P['verify']) ? $P['verify'] : 'N',
                'editor'=>isset($P['editor']) ? $P['editor'] : '',
                'update_at'=>date('Y-m-d H:i:s',time()),
            ];
            $employee_status = EmployeeModel::update(['employee_id'=>$employee_id],$employeeData);
            if($employee_status === false){
                sharedb()->rollback();
                app('log')->info('---employeeModel/updateuser1----',[$employeeData]);
                return false;
            }
            $epy_ext_id = $P['epy_ext_id'];
            $employeeExtData = [
                'employee_id'=>$employee_id,
                'nation_tag_id'=>isset($P['nation_tag_id']) ? $P['nation_tag_id'] : '',
                'birth_day'=>isset($P['birth_day']) ? $P['birth_day'] : '',
                'political_tag_id'=>isset($P['political_tag_id']) ? $P['political_tag_id'] : '' ,
                'license_tag_id'=>isset($P['license_tag_id']) ? $P['license_tag_id'] : '',
                'license_num'=>isset($P['license_num']) ? $P['license_num'] : '',
                'education_tag_id'=>isset($P['education_tag_id']) ? $P['education_tag_id'] : '',
                'employee_status_tag_id'=>isset($P['employee_status_tag_id']) ? $P['employee_status_tag_id'] : '',
                'frame_id'=>isset($P['frame_id']) ? $P['frame_id'] : '',
                'job_tag_id'=>isset($P['job_tag_id']) ? $P['job_tag_id'] : '',
                'email'=>isset($P['email']) ? $P['email'] : '',
                'address'=>isset($P['address']) ? $P['address'] : '',
                'leader'=>isset($P['leader']) ? $P['leader'] : '',
                'labor_type_tag_id'=>isset($P['labor_type_tag_id']) ? $P['labor_type_tag_id'] : '',
                'labor_begin_time'=>isset($P['labor_begin_time']) ? strtotime($P['labor_begin_time']): '' ,
                'labor_end_time'=>isset($P['labor_end_time']) ? strtotime($P['labor_end_time']): '' ,
                'entry_time'=>isset($P['entry_time']) ? strtotime($P['entry_time']): '' ,
                'departure_time'=>!empty($P['departure_time']) ? strtotime($P['departure_time']):0,
                'remark'=>isset($P['remark']) ? $P['remark'] :'',
                'project_id'=>!empty($P['project_id']) ? $P['project_id'] :'',
                'update_at'=>date('Y-m-d H:i:s',time()),
                'job_level'=>isset($P['job_level']) ? $P['job_level'] : '',
                'salary_level'=>isset($P['salary_level']) ? $P['salary_level'] : '',];

            $epy_ext_status = EmployeeextModel::update(['epy_ext_id'=>$epy_ext_id],$employeeExtData);
            if($epy_ext_status === false){
                sharedb()->rollback();
                app('log')->info('---employeeModel/updateuser2----',[$employeeExtData]);
                return false;
            }
            $cert_del_status = CertificateModel::del(['employee_id'=>$employee_id]);
            if($cert_del_status === false){
                sharedb()->rollback();
                app('log')->info('---employeeModel/updateuser3----',[$employee_id]);
                return false;
            }
            if(!empty($P['cert_list'])){
                foreach($P['cert_list'] as $value){
                    $certificateExtData = [
                        'employee_id'=>$employee_id,
                        'certificate_name'=>isset($value['certificate_name']) ? $value['certificate_name']:'',
                        'certificate_num'=>isset($value['certificate_num']) ? $value['certificate_num']:'',
                        'cert_resource_id'=>isset($value['cert_resource_id']) ? $value['cert_resource_id']:'',
                        'cert_begin_time'=>isset($value['cert_begin_time']) ? strtotime($value['cert_begin_time']):'',
                        'cert_end_time'=>isset($value['cert_end_time']) ? strtotime($value['cert_end_time']):'',
                        'create_at'=>date('Y-m-d H:i:s',time()),
                    ];
                    $info = CertificateModel::add($certificateExtData);
                    if(empty($info)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            $emergency_del_status = EmergencyModel::del(['employee_id'=>$employee_id]);
            if($emergency_del_status === false){
                sharedb()->rollback();
                app('log')->info('---employeeModel/updateuser4----',[$employee_id]);
                return false;
            }
            if(!empty($P['emergency_list'])){
                foreach($P['emergency_list'] as $val){
                    $EmergencyData = [
                        'employee_id'=>$employee_id,
                        'emergency_name'=>isset($val['emergency_name']) ? $val['emergency_name']:'',
                        'relationship'=>isset($val['relationship']) ? $val['relationship'] :'',
                        'emergency_phone'=>isset($val['emergency_phone']) ?$val['emergency_phone']:''  ,
                        'create_at'=>date('Y-m-d H:i:s',time()),
                        'update_at'=>date('Y-m-d H:i:s',time())
                    ];
                    $info = EmergencyModel::add($EmergencyData);
                    if(empty($info)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            sharedb()->commit();
            return $employee_id;
        } catch (\Exception $e) {
            app('log')->info('---employeeModel/updateuser----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }

    public static function updateUniqueEmployee($P){
        try{
            sharedb()->beginTransaction();
            if(empty($P['employee_id'])){
                app('log')->info('---employeeModel/updateuser0----',[$P]);
                return false;
            }
            $employee_id = $P['employee_id'];
            $employeeData = [
                'sex'=>isset($P['sex']) ? $P['sex'] : '0',
                'full_name'=> $P['full_name'],
                'nick_name'=>isset($P['nick_name']) ? $P['nick_name'] : '',
//                'user_name'=>isset($P['user_name']) ? $P['user_name'] : $P['mobile'],
                'mobile'=>$P['mobile'],
                'status'=>isset($P['status']) ? $P['status'] : 'Y',
                'autolock'=>isset($P['autolock']) ? $P['autolock'] : 'N',
                'verify'=>isset($P['verify']) ? $P['verify'] : 'N',
                'editor'=>isset($P['editor']) ? $P['editor'] : '',
                'update_at'=>date('Y-m-d H:i:s',time()),
            ];
            $employee_status = EmployeeModel::update(['employee_id'=>$employee_id],$employeeData);
            if($employee_status === false){
                sharedb()->rollback();
                app('log')->info('---employeeModel/updateuser1----',[$employeeData]);
                return false;
            }
            $employeeExtData = [
                'employee_id'=>$employee_id,
                'nation_tag_id'=>isset($P['nation_tag_id']) ? $P['nation_tag_id'] : '',
                'birth_day'=>isset($P['birth_day']) ? $P['birth_day'] : '',
                'political_tag_id'=>isset($P['political_tag_id']) ? $P['political_tag_id'] : '' ,
                'license_tag_id'=>isset($P['license_tag_id']) ? $P['license_tag_id'] : '',
                'license_num'=>isset($P['license_num']) ? $P['license_num'] : '',
                'education_tag_id'=>isset($P['education_tag_id']) ? $P['education_tag_id'] : '',
                'employee_status_tag_id'=>isset($P['employee_status_tag_id']) ? $P['employee_status_tag_id'] : '',
                'frame_id'=>isset($P['frame_id']) ? $P['frame_id'] : '',
                'job_tag_id'=>isset($P['job_tag_id']) ? $P['job_tag_id'] : '',
                'email'=>isset($P['email']) ? $P['email'] : '',
                'address'=>isset($P['address']) ? $P['address'] : '',
                'leader'=>isset($P['leader']) ? $P['leader'] : '',
                'labor_type_tag_id'=>isset($P['labor_type_tag_id']) ? $P['labor_type_tag_id'] : '',
                'labor_begin_time'=>isset($P['labor_begin_time']) ? strtotime($P['labor_begin_time']): '' ,
                'labor_end_time'=>isset($P['labor_end_time']) ? strtotime($P['labor_end_time']): '' ,
                'entry_time'=>isset($P['entry_time']) ? $P['entry_time']: '' ,
                'departure_time'=>!empty($P['departure_time']) ? strtotime($P['departure_time']):0,
                'remark'=>isset($P['remark']) ? $P['remark'] :'',
                'project_id'=>!empty($P['project_id']) ? $P['project_id'] :'',
                'update_at'=>date('Y-m-d H:i:s',time()),
                'job_level'=>isset($P['job_level']) ? $P['job_level'] : '',
                'salary_level'=>isset($P['salary_level']) ? $P['salary_level'] : '',];

            $epy_ext_status = EmployeeextModel::update(['employee_id'=>$employee_id],$employeeExtData);
            if($epy_ext_status === false){
                sharedb()->rollback();
                app('log')->info('---employeeModel/updateuser2----',[$employeeExtData]);
                return false;
            }
            $cert_del_status = CertificateModel::del(['employee_id'=>$employee_id]);
            if($cert_del_status === false){
                sharedb()->rollback();
                app('log')->info('---employeeModel/updateuser3----',[$employee_id]);
                return false;
            }
            if(!empty($P['cert_list'])){
                foreach($P['cert_list'] as $value){
                    $certificateExtData = [
                        'employee_id'=>$employee_id,
                        'certificate_name'=>isset($value['certificate_name']) ? $value['certificate_name']:'',
                        'certificate_num'=>isset($value['certificate_num']) ? $value['certificate_num']:'',
                        'cert_resource_id'=>isset($value['cert_resource_id']) ? $value['cert_resource_id']:'',
                        'cert_begin_time'=>isset($value['cert_begin_time']) ? strtotime($value['cert_begin_time']):'',
                        'cert_end_time'=>isset($value['cert_end_time']) ? strtotime($value['cert_end_time']):'',
                        'create_at'=>date('Y-m-d H:i:s',time()),
                    ];
                    $info = CertificateModel::add($certificateExtData);
                    if(empty($info)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            $emergency_del_status = EmergencyModel::del(['employee_id'=>$employee_id]);
            if($emergency_del_status === false){
                sharedb()->rollback();
                app('log')->info('---employeeModel/updateuser4----',[$employee_id]);
                return false;
            }
            if(!empty($P['emergency_list'])){
                foreach($P['emergency_list'] as $val){
                    $EmergencyData = [
                        'employee_id'=>$employee_id,
                        'emergency_name'=>isset($val['emergency_name']) ? $val['emergency_name']:'',
                        'relationship'=>isset($val['relationship']) ? $val['relationship'] :'',
                        'emergency_phone'=>isset($val['emergency_phone']) ?$val['emergency_phone']:''  ,
                        'create_at'=>date('Y-m-d H:i:s',time()),
                        'update_at'=>date('Y-m-d H:i:s',time())
                    ];
                    $info = EmergencyModel::add($EmergencyData);
                    if(empty($info)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            sharedb()->commit();
            return $employee_id;
        } catch (\Exception $e) {
            app('log')->info('---employeeModel/updateuser----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }
}

