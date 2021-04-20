<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;


class UserdeviceModel extends BaseModel{

    protected static $_table="yhy_user_device";

    public static $sql;

    public static $fileds = ['user_device_id','user_id','project_id','house_id','device_id','create_at','update_at',
        'device_template_type_tag_id','last_use_time'];



    public static function userDeviceListen($P){
        try{
            foreach($P as $k=>$value){
                if(empty($value['user_id']) || empty($value['house_id'])){
                    continue;
                }
                $tenementDeviceRes = self::tenementDeviceWatch($value);
                if(!$tenementDeviceRes){
                    throw new \Exception("用户设备更新失败".json_encode($value));
                }
                $visitorDeviceRes = VisitordeviceModel::visitorDeviceWatch($value);
                if(!$visitorDeviceRes){
                    throw new \Exception("访客设备更新失败".json_encode($value));
                }
                if(!empty($value['face_resource_id'])){
                    $device_params['device_template_type_tag_id'] = 1148;
                    $device_params['user_id'] = $value['user_id'];
                    $all_device = UserdeviceModel::find($device_params,['project_id','user_id','device_id','last_use_time']);
                    $all_device_ids = array_unique(array_column($all_device,'device_id'));
                    $aiAddParams = ['user_id'=>$value['user_id'],'real_name'=>$value['real_name'],'face_resource_id'=>$value['face_resource_id'],
                        'action'=>'add','device_ids'=>$all_device_ids];
                    app('log')->info('---userdevice/userDeviceListen777----',[$aiAddParams]);
                    if(!empty($all_device_ids)){
                        app('redis')->lpush("user_device:ai_device_send", json_encode($aiAddParams));
                    }
                }
            }
            return true;
        } catch (\Exception $e) {
            app('log')->info('---userdevice/userDeviceListen----',[$e->getMessage()]);
            return false;
        }
    }

    public static function tenementDeviceWatch($P){
        app('log')->info('---' . __CLASS__ . '_user_device_listen-9999---', [$P]);
        try{
            sharedb()->beginTransaction();
            if(empty($P['user_id']) || empty($P['house_id'])){
                throw new \Exception("000---参数错误".json_encode($P));
            }
            $inParams = [];
            if(isset($P['user_ids'])){
                $inParams['user_id'] = $P['user_ids'];
                unset($P['user_ids']);
            }
            //人脸设备对比，查出增加的或删除的设备
            $params['device_template_type_tag_id'] = 1148;
            if(isTrueKey($P,'user_id') && isTrueKey($P,'project_id')){
                $params['user_id'] = $P['user_id'];
                $params['project_id'] = $P['project_id'];
                $params['house_id'] = $P['house_id'];
            }
            $P['device_ids'] = empty($P['device_ids'])?[]:$P['device_ids'];
            $all_device = UserdeviceModel::find($params,['project_id','user_id','device_id','last_use_time'],$inParams);
            $all_device_ids = array_column($all_device,'device_id');
            $receive_device_ids = array_filter($P['device_ids'],function ($val){return $val == 1148;});
            $receive_device_ids = array_keys($receive_device_ids);
            $reduce_device_arr = array_diff($all_device_ids,$receive_device_ids);
//            $add_device_arr  = array_diff($receive_device_ids,$all_device_ids);
            $user_del_res = UserdeviceModel::del(['house_id' => $P['house_id'],'user_id'=>$P['user_id']]);

            app('log')->info('---' . __CLASS__ . '_user_device_listen-8888---', [['house_id' => $P['house_id'],'user_id'=>$P['user_id']]]);
            if(false === $user_del_res){//用户设备先清空
                throw new \Exception("111---用户设备删除失败".json_encode($P));
            }
            $tenement_res =  HouseModel::TenementHouseLists(['house_id' => $P['house_id'],'user_id'=>$P['user_id']],
                HouseModel::$fileds, [], '', '', '');
            if(!empty($tenement_res)){
                if('Y'==$tenement_res[0]['is_del']){
                    sharedb()->commit();
                    app('log')->info('---' . __CLASS__ . '_user_device_listen-777---', [['house_id' => $P['house_id'],'user_id'=>$P['user_id']]]);
                    $aiReduceParams = ['user_id'=>$P['user_id'],'real_name'=>$P['real_name'],'face_resource_id'=>$P['face_resource_id'],
                        'action'=>'reduce','device_ids'=>$all_device_ids];
                    app('redis')->lpush("user_device:ai_device_send", json_encode($aiReduceParams));
                    return true;
                }
            }else{
                sharedb()->commit();
                app('log')->info('---' . __CLASS__ . '_user_device_listen-666---', [['house_id' => $P['house_id'],'user_id'=>$P['user_id']]]);
                $aiReduceParams = ['user_id'=>$P['user_id'],'real_name'=>$P['real_name'],'face_resource_id'=>$P['face_resource_id'],
                    'action'=>'reduce','device_ids'=>$all_device_ids];
                app('redis')->lpush("user_device:ai_device_send", json_encode($aiReduceParams));
                return true;
            }

            if(empty($P['device_ids'])){
                sharedb()->commit();
                app('log')->info('---' . __CLASS__ . '_user_device_listen-555---', [['house_id' => $P['house_id'],'user_id'=>$P['user_id']]]);
                $aiReduceParams = ['user_id'=>$P['user_id'],'real_name'=>$P['real_name'],'face_resource_id'=>$P['face_resource_id'],
                    'action'=>'reduce','device_ids'=>$all_device_ids];
                app('redis')->lpush("user_device:ai_device_send", json_encode($aiReduceParams));
                return true;
            }
            foreach($P['device_ids'] as $kk=>$v){
                if( ('N'==$tenement_res[0]['tenement_check_status'] ||'N'==$tenement_res[0]['tenement_house_status']) && 1147 != $v){
                    app('log')->info('---' . __CLASS__ . '_user_device_listen-444---', [['house_id' => $P['house_id'],'user_id'=>$P['user_id']]]);
                    //未认证状态,只添加授权的蓝牙设备
                    continue;
                }
                $insertData = [
                    'project_id'=>$P['project_id']??'',
                    'house_id'=>$P['house_id']??'',
                    'user_id'=>$P['user_id']??'',
                    'device_id'=>$kk??'',
                    'device_template_type_tag_id' => $v,
                    'last_use_time'=>date('Y-m-d H:i:s', time()),
                    'create_at'=>date('Y-m-d H:i:s', time()),
                    'update_at'=>date('Y-m-d H:i:s', time())
                ];
                $use_device_res  = UserdeviceModel::add($insertData);
                app('log')->info('---' . __CLASS__ . '_user_device_listen-3333---', [$insertData,$use_device_res]);
                if(false === $use_device_res){
                    app('log')->info('---' . __CLASS__ . '_user_device_listen-2222---', [$insertData,$use_device_res]);
                    continue;
                }
            }
            sharedb()->commit();
            app('log')->info('---' . __CLASS__ . '_user_device_listen-1111--', [$P]);
//            if(!empty($add_device_arr)){
//                $aiAddParams = ['user_id'=>$P['user_id'],'real_name'=>$P['real_name'],'face_resource_id'=>$P['face_resource_id'],
//                    'action'=>'add','device_ids'=>$add_device_arr];
//                app('redis')->lpush("user_device:ai_device_send", json_encode($aiAddParams));
//            }
            if(!empty($reduce_device_arr)){
                $aiReduceParams = ['user_id'=>$P['user_id'],'real_name'=>$P['real_name'],'face_resource_id'=>$P['face_resource_id'],
                    'action'=>'reduce','device_ids'=>$reduce_device_arr];
                app('redis')->lpush("user_device:ai_device_send", json_encode($aiReduceParams));
            }
            return true;
        } catch (\Exception $e) {
            app('log')->info('---userdevice/user_device_listen----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }

    public static function userMergeVisitorDevice($P,$inParams){
        $user_device = UserdeviceModel::find($P,['project_id','user_id','device_id','last_use_time'],$inParams);
        if ($user_device === false) {
            return false;
        }
        $visitor_device = VisitordeviceModel::find($P,['project_id','user_id','device_id','last_use_time'],$inParams);
        if ($visitor_device === false) {
            return false;
        }
        $tmp_arr = array_column($user_device,'device_id');
        if(!empty($visitor_device)){
            foreach ($visitor_device as $k => $v) {
                if (in_array($v['device_id'], $tmp_arr)) {//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
                    unset($visitor_device[$k]);
                }
            }
        }
        $all_device = array_merge($user_device,$visitor_device);
        $tmp_device_ids = [];
        if(!empty($all_device)){
            foreach ($all_device as $kl => $vl) {
                if (in_array($vl['device_id'], $tmp_device_ids)) {//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
                    unset($all_device[$kl]);
                }else{
                    $tmp_device_ids[] = $vl['device_id'];
                }
            }
        }
        return $all_device;

    }
}

