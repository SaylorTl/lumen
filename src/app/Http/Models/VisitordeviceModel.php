<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class VisitordeviceModel extends BaseModel{

    protected static $_table="yhy_visitor_device";

    public static $sql;

    public static $fileds = ['visitor_device_id','project_id','visitor_apply_id','valid_count','expire_time','user_id',
        'device_id','create_at','update_at','last_use_time','house_id','tenement_user_id','device_template_type_tag_id'];


    public static function userVisitorEvent(){
        try{
            $pagesize =20;
            $isFinish = false;
            $page = 0;
            while(!$isFinish) {
                $page++;
                $result = VisitorapplyModel::find(['check_status_tag_id'=>'1170'],'*','','',$page,$pagesize);
                if(false === $result){
                    return false;
                }
                if(count($result) < 20){
                    $isFinish = true;
                }
                if(!empty($result)){
                    foreach($result as $key=>$value){
                        sharedb()->beginTransaction();
                        $visitorDeviceArr =  VisitordeviceModel::find(['visitor_apply_id'=>$value['visitor_apply_id']]);
                        $receive_device_ids = array_filter($visitorDeviceArr,function ($val){
                            return $val['device_template_type_tag_id'] == 1148;});
                        $user_face_device_ids = array_column($receive_device_ids,'device_id');
                        if(!empty($visitorDeviceArr[0])){
                            $visitor = $visitorDeviceArr[0];
                            if(0===$visitor['valid_count'] || (!empty($visitor['expire_time'])&&time()>$visitor['expire_time'])){
                                $updateRes = VisitorapplyModel::update(['visitor_apply_id'=>$value['visitor_apply_id']],['check_status_tag_id'=>'1171']);
                                if(false === $updateRes){
                                    sharedb()->rollback();
                                    return false;
                                }
                                $delRes = VisitordeviceModel::del(['visitor_apply_id'=>$value['visitor_apply_id']]);
                                if(false === $delRes){
                                    sharedb()->rollback();
                                    return false;
                                }
                            }
                        }
                        sharedb()->commit();
                        if(!empty($user_face_device_ids) && !empty($value['face_resource_id'])){
                            $aiReduceParams = ['user_id'=>$value['apply_user_id'],'real_name'=>$value['apply_name']??'','face_resource_id'=>$value['face_resource_id'],
                                'action'=>'reduce','device_ids'=>$user_face_device_ids];
                            app('redis')->lpush("user_device:ai_device_send", json_encode($aiReduceParams));
                        }
                    }
                }
                return true;
            }
        } catch (\Exception $e) {
            app('log')->info('---visitorDevice/userVisitorEvent----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }

    public static function updateVisitorDevice($P){
        try{
            sharedb()->beginTransaction();
            $visitorDeviceArr =  VisitordeviceModel::find(['visitor_apply_id'=>$P['visitor_apply_id']]);
            if(!empty($visitorDeviceArr[0])){
                $visitor = $visitorDeviceArr[0];
                if(0===$visitor['valid_count'] || (!empty($visitor['expire_time'])&&time()>$visitor['expire_time'])){
                    $updateRes = VisitorapplyModel::update(['visitor_apply_id'=>$P['visitor_apply_id']],['check_status_tag_id'=>'1171']);
                    if(false === $updateRes){
                        sharedb()->rollback();
                        return false;
                    }
                    $delRes = VisitordeviceModel::del(['visitor_apply_id'=>$P['visitor_apply_id']]);
                    if(false === $delRes){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            sharedb()->commit();
            return true;
        } catch (\Exception $e) {
            app('log')->info('---visitorDevice/updateVisitorDevice----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }

    public static function visitorDeviceWatch($P){
        try{
            $user_device = UserdeviceModel::find(['house_id'=>$P['house_id'],'user_id'=>$P['user_id']],'*');
            $visitor_apply_device = VisitorapplyModel::find(['check_status_tag_id'=>'1170','apply_status_tag_id'=>'1166',
                'tenement_user_id'=>$P['user_id'],'house_id'=>$P['house_id']],'*');
            if(empty($visitor_apply_device)){
                return true;
            }
            sharedb()->beginTransaction();
            foreach($visitor_apply_device as $key=>$value ){
                $visitor_device = sharedb()->table('yhy_visitor_device')->select(VisitordeviceModel::$fileds)
                    ->where('visitor_apply_id',$value['visitor_apply_id'])->get();
                $visitor_device_arr = array_filter($visitor_device,function ($val){return $val['device_template_type_tag_id'] == 1148;});
                app('log')->info('---visitorDevice/updateVisitorDevice----',[$value]);
                $visitor_device_ids = array_column($visitor_device_arr,'device_id');

                //先清空所有访客设备
                $visitor_del_res = VisitordeviceModel::del(['visitor_apply_id' => $value['visitor_apply_id']]);
                if(false === $visitor_del_res){//访客设备先清空
                    throw new \Exception("访客设备删除失败".json_encode($P));
                }

                if(empty($user_device)){
                    $aiReduceParams = ['user_id'=>$value['apply_user_id'],'real_name'=>$value['apply_name'],'face_resource_id'=>$value['face_resource_id'],
                        'action'=>'reduce','device_ids'=>$visitor_device_ids];
                    app('redis')->lpush("user_device:ai_device_send", json_encode($aiReduceParams));
                    continue;
                }
                $user_device_arr = array_filter($user_device,function ($val){return $val['device_template_type_tag_id'] == 1148;});
                $user_device_ids = array_column($user_device_arr,'device_id');
                $reduce_device_arr = array_diff($visitor_device_ids,$user_device_ids);
//                $add_device_arr  = array_diff($user_device_ids,$visitor_device_ids);
                foreach ($user_device as $kk=>$vv){
                    $deviceData = [
                        'visitor_apply_id' => $value['visitor_apply_id'],
                        'project_id'=>$value['project_id'],
                        'house_id'=>$value['house_id'],
                        'tenement_user_id'=>$P['user_id'],
                        'user_id' => $value['apply_user_id'] ,
                        'valid_count'=>$visitor_device[0]['valid_count'] ??'99999',
                        'expire_time'=> $value['expire_time'],
                        'device_id' => $vv['device_id'],
                        'device_template_type_tag_id' => $vv['device_template_type_tag_id'],
                        'last_use_time'=>date('Y-m-d H:i:s', time()),
                        'update_at' => date('Y-m-d H:i:s', time()),
                        'create_at' => date('Y-m-d H:i:s', time()),];
                    app('log')->info('---' . __CLASS__ . '_7777' . __FUNCTION__ . '----', [$deviceData]);
                    $deviceAddRes = VisitordeviceModel::add($deviceData);
                    if (false === $deviceAddRes) {
                        throw new \Exception("访客设备添加失败".json_encode($deviceData));
                    }
                    if(!empty($reduce_device_arr)){
                        $aiReduceParams = ['user_id'=>$value['apply_user_id'],'real_name'=>$value['apply_name'],'face_resource_id'=>$value['face_resource_id'],
                            'action'=>'reduce','device_ids'=>$reduce_device_arr];
                        app('redis')->lpush("user_device:ai_device_send", json_encode($aiReduceParams));
                    }
//                    if(!empty($add_device_arr)){
//                        $aiAddParams = ['user_id'=>$value['apply_user_id'],'real_name'=>$value['apply_name'],'face_resource_id'=>$value['face_resource_id'],
//                            'action'=>'add','device_ids'=>$add_device_arr];
//                        app('redis')->lpush("user_device:ai_device_send", json_encode($aiAddParams));
//                    }
                }
            }
            sharedb()->commit();
            return true;
        } catch (\Exception $e) {
            app('log')->info('---visitorDevice/visitorDeviceWatch----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }

}

