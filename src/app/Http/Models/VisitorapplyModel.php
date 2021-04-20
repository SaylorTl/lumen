<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class VisitorapplyModel extends BaseModel{

    protected static $_table="yhy_visitor_apply";

    public static $sql;

    public static $fileds = ['visitor_apply_id','project_id','house_id','space_id','cell_id','sfz_num','apply_name','apply_user_id','apply_mobile'
        ,'apply_identify_tag_id','apply_count','apply_days','apply_status_tag_id','check_status_tag_id','check_name','check_user_id',
        'check_employee_id','create_employee_id','create_user_id','check_time','expire_time','apply_source_tag_id','tenement_mobile',
        'tenement_user_id','tenement_name','plate','update_employee_id','face_resource_id','device_ids','create_at','update_at'
    ];

    public  static function apply_list($where,$filed='*',$wherein=[],$order=[],$page='',$pagesize=20,$whereNotIn=''){
        try {
            $query = sharedb()->table(static::$_table)->select(static::$fileds);
            $wheres = [];
            if (isset($where['check_time_begin'])){
                $wheres[] = ["check_time",">=", strtotime($where['check_time_begin'])];
                unset($where['check_time_begin']);
            }
            if (isset($where['check_time_end'])){
                $wheres[] = ["check_time","<", strtotime($where['check_time_end'])];
                unset($where['check_time_end']);
            }
            if (isset($where['create_at_begin'])){
                $wheres[] = ["create_at",">=", $where['create_at_begin']];
                unset($where['create_at_begin']);
            }
            if (isset($where['create_at_end'])){
                $wheres[] = ["create_at","<", $where['create_at_end']];
                unset($where['create_at_end']);
            }
            if (!empty($wheres)){
                $query->where($wheres);
            }
            if(!empty($where)){
                foreach($where as $k=>$v){
                    $query = $query->where($k,"{$v}");
                }
            }
            if(!empty($wherein)){
                foreach($wherein as $kl=>$vl){
                    $query = $query->whereIn($kl,$vl);
                }
            }
            if(!empty($whereNotIn)){
                foreach($whereNotIn as $kh=>$vh){
                    $query = $query->whereNotIn($kh, $vh);
                }
            }
            if(!empty($order)){
                $query->orderBy($order['orderby'],$order['order']);
            }
            if(!empty($page)){
                $offset = $pagesize * ( max(intval($page), 1) - 1 );
                $query->offset($offset)->limit($pagesize);
            }
            $result = $query->get() ?: [];
            static::$sql = $query->toSql();
            return $result;
        } catch (\Exception $e) {
            app('log')->info('---find----',[$e->getMessage()]);
            return false;
        }
    }
    public  static function apply_count($where,$wherein='',$orderby='',$order='desc',$whereNotIn=''){
        try {
            $query = sharedb()->table(static::$_table);
            $wheres = [];
            if (isset($where['check_time_begin'])){
                $wheres[] = ["check_time",">=", strtotime($where['check_time_begin'])];
                unset($where['check_time_begin']);
            }
            if (isset($where['check_time_end'])){
                $wheres[] = ["check_time","<", strtotime($where['check_time_end'])];
                unset($where['check_time_end']);
            }
            if (isset($where['create_at_begin'])){
                $wheres[] = ["create_at",">=", $where['create_at_begin']];
                unset($where['create_at_begin']);
            }
            if (isset($where['create_at_end'])){
                $wheres[] = ["create_at","<", $where['create_at_end']];
                unset($where['create_at_end']);
            }
            if (!empty($wheres)){
                $query->where($wheres);
            }
            if(!empty($where)){
                foreach($where as $k=>$v){
                    $query = $query->where($k,"{$v}");
                }
            }
            if(!empty($wherein)){
                foreach($wherein as $kl=>$vl){
                    $query = $query->whereIn($kl,$vl);
                }
            }
            if(!empty($whereNotIn)){
                foreach($whereNotIn as $kh=>$vh){
                    $query = $query->whereNotIn($kh, $vh);
                }
            }
            $result = $query->count() ?: [];
            static::$sql = $query->toSql();
            return $result;
        } catch (\Exception $e) {
            app('log')->info('---find----',[$e->getMessage()]);
            return false;
        }
    }

    public static function generate($P){
        try{
            sharedb()->beginTransaction();
            if(!empty($P['apply_days'])){
                $P['expire_time'] =  strtotime("+{$P['apply_days']} day");
            }
            $insertData = [
                'project_id'=>$P['project_id']??'',
                'house_id'=>$P['house_id']??'',
                'space_id'=>$P['space_id']??'',
                'cell_id'=>$P['cell_id']??'',
                'sfz_num'=>$P['sfz_num']??'',
                'apply_name'=>$P['apply_name']??'',
                'apply_user_id'=>$P['apply_user_id']??'',
                'apply_mobile'=>$P['apply_mobile']??'',
                'apply_identify_tag_id'=>$P['apply_identify_tag_id']??'',
                'apply_count'=>$P['apply_count']??'',
                'apply_days'=>$P['apply_days']??'',
                'apply_status_tag_id'=>$P['apply_status_tag_id']??'',
                'check_status_tag_id'=>$P['check_status_tag_id']??'',
                'check_name'=>$P['check_name']??'',
                'check_user_id'=>$P['check_user_id']??'',
                'check_employee_id'=>$P['check_employee_id']??'',
                'create_employee_id'=>$P['create_employee_id']??'',
                'create_user_id'=>$P['create_user_id']??'',
                'check_time'=>$P['check_time']??'',
                'expire_time'=>$P['expire_time']??'',
                'apply_source_tag_id'=>$P['apply_source_tag_id']??'',
                'tenement_mobile'=>$P['tenement_mobile']??'',
                'tenement_user_id'=>$P['tenement_user_id']??'',
                'tenement_name'=>$P['tenement_name']??'',
                'plate'=>$P['plate']??'',
                'update_employee_id'=>$P['update_employee_id']??'',
                'face_resource_id'=>$P['face_resource_id']??'',
                'device_ids'=>$P['device_ids']??'',
                'update_at'=>date('Y-m-d H:i:s', time()),
                'create_at'=>date('Y-m-d H:i:s', time()),
            ];
            $info = VisitorapplyModel::add($insertData);
            if($info === false){
                sharedb()->rollback();
                return false;
            }
            app('log')->info('---visitorDevice/updateVisitorDevice1----',[$P]);
            if( isset($P['check_status_tag_id'])&& isset($P['apply_status_tag_id'])&& $P['check_status_tag_id'] == 1170&&
                $P['apply_status_tag_id'] == 1166 && isset($P['house_id']) && isset($P['tenement_user_id']) ){
                $userDeviceArr =  UserdeviceModel::find(['user_id'=>$P['tenement_user_id'],'house_id'=>$P['house_id']]);
                app('log')->info('---visitorDevice/updateVisitorDevice2----',[$userDeviceArr]);
                $userDeviceArr = array_column($userDeviceArr,'device_id');
                if( !empty($userDeviceArr)) {
                    $delRes = VisitordeviceModel::del(['visitor_apply_id' => $info]);
                    app('log')->info('---visitorDevice/updateVisitorDevice3----',[$delRes]);
                    if($delRes === false){
                        sharedb()->rollback();
                        return false;
                    }
                    foreach ($userDeviceArr as $value) {
                        $deviceData = [
                            'tenement_user_id' => $P['tenement_user_id'] ?? '',
                            'visitor_apply_id' => $info,
                            'project_id'=>$P['project_id']??'',
                            'user_id' => $P['apply_user_id'] ?? '',
                            'house_id' => $P['house_id'] ?? '',
                            'valid_count'=>!empty($P['apply_count'])?$P['apply_count']:'99999',
                            'expire_time'=>$updateVisitData['expire_time'] ?? '',
                            'device_id' => $value,
                            'last_use_time'=>date('Y-m-d H:i:s', time()),
                            'update_at' => date('Y-m-d H:i:s', time()),
                            'create_at' => date('Y-m-d H:i:s', time()),];
                        $deviceAddRes = VisitordeviceModel::add($deviceData);
                        app('log')->info('---visitorDevice/updateVisitorDevice2----',[$deviceData]);
                        if (false === $deviceAddRes) {
                            sharedb()->rollback();
                            return false;
                        }
                    }
                }
            }
            sharedb()->commit();
            return $info;
        } catch (\Exception $e) {
            app('log')->info('---device/add----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }

    public static function updateData($P){
        try{
            sharedb()->beginTransaction();
            if(!empty($P['apply_days'])){
                $P['expire_time'] =  strtotime("+{$P['apply_days']} day");
            }
            $insertData = [
                'project_id'=>$P['project_id']??'',
                'house_id'=>$P['house_id']??'',
                'space_id'=>$P['space_id']??'',
                'cell_id'=>$P['cell_id']??'',
                'sfz_num'=>$P['sfz_num']??'',
                'apply_name'=>$P['apply_name']??'',
                'apply_user_id'=>$P['apply_user_id']??'',
                'apply_mobile'=>$P['apply_mobile']??'',
                'apply_identify_tag_id'=>$P['apply_identify_tag_id']??'',
                'apply_count'=>$P['apply_count']??'',
                'apply_days'=>$P['apply_days']??'',
                'apply_status_tag_id'=>$P['apply_status_tag_id']??'',
                'check_status_tag_id'=>$P['check_status_tag_id']??'',
                'check_name'=>$P['check_name']??'',
                'check_user_id'=>$P['check_user_id']??'',
                'check_employee_id'=>$P['check_employee_id']??'',
                'create_employee_id'=>$P['create_employee_id']??'',
                'create_user_id'=>$P['create_user_id']??'',
                'check_time'=>$P['check_time']??'',
                'expire_time'=>$P['expire_time']??'',
                'apply_source_tag_id'=>$P['apply_source_tag_id']??'',
                'tenement_mobile'=>$P['tenement_mobile']??'',
                'tenement_user_id'=>$P['tenement_user_id']??'',
                'tenement_name'=>$P['tenement_name']??'',
                'plate'=>$P['plate']??'',
                'update_employee_id'=>$P['update_employee_id']??'',
                'face_resource_id'=>$P['face_resource_id']??'',
                'device_ids'=>$P['device_ids']??'',
                'update_at'=>date('Y-m-d H:i:s', time()),
                'create_at'=>date('Y-m-d H:i:s', time()),
            ];
            $info = VisitorapplyModel::update([],$insertData);
            if($info === false){
                sharedb()->rollback();
                return false;
            }
            sharedb()->commit();
            return $info;
        } catch (\Exception $e) {
            app('log')->info('---device/add----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }

    public static function check($P){
        try{
            sharedb()->beginTransaction();
            $updateVisitData= [];
            if(!empty($P['apply_days'])){
                $updateVisitData['expire_time'] =  strtotime("+{$P['apply_days']} day");
            }
            if(!empty($P['visitor_apply_id'])){
                $updateVisitData['visitor_apply_id'] = $P['visitor_apply_id'];
            }
            if(isset($P['tenement_name'])){
                $updateVisitData['tenement_name'] = $P['tenement_name'];
            }
            if(isset($P['tenement_mobile'])){
                $updateVisitData['tenement_mobile'] = $P['tenement_mobile'];
            }
            if(!empty($P['tenement_user_id'])){
                $updateVisitData['tenement_user_id'] = $P['tenement_user_id'];
            }
            if(isset($P['apply_mobile'])){
                $updateVisitData['apply_mobile'] = $P['apply_mobile'];
            }
            if(!empty($P['check_status_tag_id'])){
                $updateVisitData['check_status_tag_id'] = $P['check_status_tag_id'];
            }
            if(!empty($P['apply_user_id'])){
                $updateVisitData['apply_user_id'] = $P['apply_user_id'];
            }
            if(isset($P['apply_name'])){
                $updateVisitData['apply_name'] = $P['apply_name'];
            }
            if(isset($P['apply_count'])){
                $updateVisitData['apply_count'] = $P['apply_count']??'';
            }
            if(isset($P['apply_days'])){
                $updateVisitData['apply_days'] = $P['apply_days']??'';
            }
            if(!empty($P['face_resource_id'])){
                $updateVisitData['face_resource_id'] = $P['face_resource_id'];
            }
            if(!empty($P['sfz_num'])){
                $updateVisitData['sfz_num'] = $P['sfz_num'];
            }
            if(isset($P['plate'])){
                $updateVisitData['plate'] = $P['plate']??'';
            }
            $user_face_device_ids = [];
            if(!empty($P['house_id'])){
                $user_device_arr =  UserdeviceModel::find(['user_id'=>$P['tenement_user_id'],'house_id'=>$P['house_id']]);
                app('log')->info('---ai_device_send11----',[$user_device_arr]);
                $userDeviceArr = array_column($user_device_arr,'device_id');
                $deviceIds = implode(',',$userDeviceArr);
                $updateVisitData['device_ids'] = $deviceIds;
                $user_face_device_arr = array_filter($user_device_arr,function ($val){return $val['device_template_type_tag_id'] == 1148;});
                $user_face_device_ids = array_column($user_face_device_arr,'device_id');
            }
            if(!empty($P['apply_status_tag_id'])){
                $updateVisitData['apply_status_tag_id'] = $P['apply_status_tag_id'];
            }
            if(!empty($P['project_id'])){
                $updateVisitData['project_id'] = $P['project_id'];
            }
            if(!empty($P['space_id'])){
                $updateVisitData['space_id'] = $P['space_id'];
            }
            if(!empty($P['house_id'])){
                $updateVisitData['house_id'] = $P['house_id'];
            }
            if(!empty($P['check_employee_id'])){
                $updateVisitData['check_employee_id'] = $P['check_employee_id'];
            }
            if(isset($P['check_name'])){
                $updateVisitData['check_name'] = $P['check_name'];
            }
            if(isset($P['check_time'])){
                $updateVisitData['check_time'] = $P['check_time'];
            }
            if(isset($P['update_employee_id'])){
                $updateVisitData['update_employee_id'] = $P['update_employee_id'];
            }

            $info = VisitorapplyModel::update(['visitor_apply_id'=>$P['visitor_apply_id']],$updateVisitData);
            if($info === false){
                sharedb()->rollback();
                return false;
            }
            $delRes = VisitordeviceModel::del(['visitor_apply_id' => $P['visitor_apply_id']]);
            if($delRes === false){
                sharedb()->rollback();
                return false;
            }
            if( isset($P['house_id']) && !empty($user_device_arr) && isset($P['check_status_tag_id'])&&
                isset($P['apply_status_tag_id'])&& $P['check_status_tag_id'] == 1170&&$P['apply_status_tag_id'] == 1166){
                foreach ($user_device_arr as $value) {
                    $deviceData = [
                        'tenement_user_id'=>$P['tenement_user_id'] ?? '',
                        'visitor_apply_id' => $P['visitor_apply_id'],
                        'project_id'=>$P['project_id']??'',
                        'house_id'=>$P['house_id']??'',
                        'valid_count'=>!empty($P['apply_count'])?$P['apply_count']:'99999',
                        'expire_time'=>$updateVisitData['expire_time'] ?? '',
                        'device_template_type_tag_id'=>$value['device_template_type_tag_id'],
                        'user_id' => $P['apply_user_id'] ?? '',
                        'device_id' => $value['device_id'],
                        'last_use_time'=>date('Y-m-d H:i:s', time()),
                        'update_at' => date('Y-m-d H:i:s', time()),
                        'create_at' => date('Y-m-d H:i:s', time()),];
                    $deviceAddRes = VisitordeviceModel::add($deviceData);
                    if (false === $deviceAddRes) {
                        sharedb()->rollback();
                        return false;
                    }
                }
                if(!empty($user_face_device_ids) && !empty($P['face_resource_id'])){
                    $aiAddParams = ['user_id'=>$P['apply_user_id'],'real_name'=>$P['apply_name'],'face_resource_id'=>$P['face_resource_id'],
                        'action'=>'add','device_ids'=>$user_face_device_ids];
                    app('redis')->lpush("user_device:ai_device_send", json_encode($aiAddParams));
                }
            }else{
                app('log')->info('---ai_device_send22----',[$user_face_device_ids]);
                if(!empty($user_face_device_ids)  && !empty($P['face_resource_id'])){
                    $aiReduceParams = ['user_id'=>$P['apply_user_id'],'real_name'=>$P['apply_name'],'face_resource_id'=>$P['face_resource_id'],
                        'action'=>'reduce','device_ids'=>$user_face_device_ids];
                    app('redis')->lpush("user_device:ai_device_send", json_encode($aiReduceParams));
                }
            }
            sharedb()->commit();
            return $info;
        } catch (\Exception $e) {
            app('log')->info('---device/check----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }

}

