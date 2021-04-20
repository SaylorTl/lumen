<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class VisitorModel extends BaseModel{

    protected static $_table="yhy_visitor";

    public static $sql;

    public static $fileds = ['yhyv.visit_id','yhyv.user_id','yhyv.sfz_number','yhyv.real_name','yhyv.project_id','yhyv.mobile',
        'yhyv.sex','yhyv.appoint_time','yhyv.appoint_status_tag_id','yhyv.face_resource_id','yhyv.authorizer','yhyv.space_id',
        'yhyv.creator','yhyv.editor','yhyv.in_time','yhyv.out_time','yhyv.create_at','yhyv.update_at','yhyv.device_id',
        'yhyv.visitor_extra'
    ];

    /**
     * @param $params
     * @return array
     * 展示用户
     */
    public static function showUser($P,$inParams,$page=0,$pagesize=0){
        $query = sharedb()->table("yhy_visitor as yhyv");
        if (isset($P['plate'])){
            $P['plate'] = strtoupper($P['plate']);
            $query->leftJoin("yhy_visitor_car as yhyc", "yhyv.visit_id", "=", "yhyc.visit_id");
            $query->where("yhyc.plate","like","%".$P['plate']."%");
            unset($P['plate']);
        }
        $query ->select(static::$fileds);
        $where = [];
        if (isset($P['real_name'])){
            $where[] = ['yhyv.real_name','like', "%".$P['real_name']."%"];
            unset($P['real_name']);
        }
        if (isset($P['create_time_begin'])){
            $where[] = ['yhyv.create_at','>=', $P['create_time_begin']];
            unset($P['create_time_begin']);
        }
        if (isset($P['create_time_begin'])){
            $where[] = ['yhyv.create_at','>=', $P['create_time_begin']];
            unset($P['create_time_begin']);
        }
        if (isset($P['create_time_end'])){
            $where[] = ['yhyv.create_at','<', $P['create_time_end']];
            unset($P['create_time_end']);
        }
        if (!empty($inParams)){
            foreach($inParams as $kl=>$vl){
                $query = $query->whereIn("yhyv.".$kl,$vl);
            }
        }
        if (!empty($where)){
            $query = $query->where($where);
        }
        if (!empty($P)){
            foreach($P as $k=>$v){
                $query = $query->where("yhyv.".$k,"{$v}");
            }
        }
        if($page){
            $offset = $pagesize * ( max(intval($page), 1) - 1 );
            $query->offset($offset)->limit($pagesize);
        }
        $result = $query->orderBy('yhyv.visit_id', 'DESC')->get() ?: [];
        static::$sql = $query->toSql();
        return $result;
    }

    /**
     * @param $params
     * @return array
     * 展示用户
     */
    public static function counts($P){
        $query = sharedb()->table("yhy_visitor as yhyv");
        if (isset($P['plate'])){
            $P['plate'] = strtoupper($P['plate']);
            $query->leftJoin('yhy_visitor_car as yhyc', "yhyv.visit_id", "=", "yhyc.visit_id");
            $query->where("yhyc.plate","like","%".$P['plate']."%");
            unset($P['plate']);
        }
        $where = [];
        if (isset($P['real_name'])){
            $where[] = ['yhyv.real_name','like', "%".$P['real_name']."%"];
            unset($P['real_name']);
        }
        if (isset($P['create_time_begin'])){
            $where[] = ['yhyv.create_at','>=', $P['create_time_begin']];
            unset($P['create_time_begin']);
        }
        if (isset($P['create_time_end'])){
            $where[] = ['yhyv.create_at','<', $P['create_time_end']];
            unset($P['create_time_end']);
        }
        if (!empty($inParams)){
            foreach($inParams as $kl=>$vl){
                $query = $query->whereIn("yhyv.".$kl,$vl);
            }
        }
        if (!empty($where)){
            $query = $query->where($where);
        }
        if (!empty($P)){
            foreach($P as $k=>$v){
                $query = $query->where("yhyv.".$k,"{$v}");
            }
        }
        $result = $query->count() ?: [];
        static::$sql = $query->toSql();
        return $result;
    }

    public static function addUser($P){
        try{
            sharedb()->beginTransaction();
            $users = UserModel::findOne(['mobile'=>$P['mobile'],'app_id'=>$P['app_id']],['user_id']);
            if(!empty($users)){
                $user_id = $users[0]['user_id'];
            }else{
                $insertData = [
                    'mobile'=> $P['mobile'],
                    'app_id'=> isset($P['app_id']) ? $P['app_id'] : 0,
                    'autolock'=>isset($P['autolock']) ? $P['autolock'] : 'N',
                    'verify'=>isset($P['verify']) ? $P['verify'] : 'N',
                    'create_at'=>date('Y-m-d H:i:s',time()),
                    'update_at'=>date('Y-m-d H:i:s',time()),
                ];
                $user_id = UserModel::add($insertData);
                if(empty($user_id)){
                    sharedb()->rollback();
                    return false;
                }
            }
            $visitorData = [
                'visit_id'=>$P['visit_id'],
                'user_id'=>$user_id,
                'sfz_number'=>isset($P['sfz_number']) ? $P['sfz_number'] : '' ,
                'real_name'=>isset($P['real_name']) ? $P['real_name'] : '',
                'project_id'=>isset($P['project_id']) ? $P['project_id'] : 0 ,
                'mobile'=>isset($P['mobile']) ? $P['mobile'] : '',
                'sex'=>isset($P['sex']) ? $P['sex'] : '0',
                'appoint_time'=>isset($P['appoint_time']) ? strtotime($P['appoint_time']) : '',
                'appoint_status_tag_id'=>isset($P['appoint_status_tag_id']) ? $P['appoint_status_tag_id'] : '',
                'face_resource_id'=>isset($P['face_resource_id']) ? $P['face_resource_id'] :'',
                'authorizer'=>isset($P['authorizer']) ? $P['authorizer'] : '',
                'destination'=>isset($P['destination']) ? $P['destination'] : '',
                'space_id'=>isset($P['space_id']) ? $P['space_id'] : '',
                'in_time'=> !empty($P['in_time']) ? strtotime($P['in_time']):0,
                'out_time'=> !empty($P['out_time']) ? strtotime($P['out_time']):0,
                'creator'=>isset($P['creator']) ? $P['creator'] : '',
                'app_id'=>isset($P['app_id']) ? $P['app_id'] : '',
                'editor'=>isset($P['editor']) ? $P['editor'] : '',
                'create_at'=>date('Y-m-d H:i:s',time()),
                'update_at'=>date('Y-m-d H:i:s',time()),
                'device_id'=>isset($P['device_id']) ? $P['device_id'] : '0',
                'visitor_extra' => isset($P['visitor_extra']) ? $P['visitor_extra'] : json_encode([]),
            ];

            $visitorRes = self::add($visitorData);
            if($visitorRes === false){
                sharedb()->rollback();
                return false;
            }
            $visitorInfo = $P['visit_id'];
            if(!empty($P['car_list'])){
                foreach ($P['car_list'] as $value){
                    $visitCarData = [
                        'visit_id'=>$visitorInfo,
                        'plate'=>isset($value['plate']) ? strtoupper($value['plate']) : '',
                        'car_type'=>isset($value['car_type']) ? $value['car_type'] : '' ,
                        'car_type_name'=>isset($value['car_type_name']) ? $value['car_type_name'] : '' ,
                        'car_brand'=>isset($value['car_brand']) ? $value['car_brand'] : '',
                        'car_brand_name'=>isset($value['car_brand_name']) ? $value['car_brand_name'] : '',
                        'car_model'=>isset($value['car_model']) ? $value['car_model'] : '',
                        'create_at'=>date('Y-m-d H:i:s',time()),];
                    $visitCarInfo = VisitorcarModel::add($visitCarData);
                    if(empty($visitCarInfo)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            if(!empty($P['follow_list'])){
                foreach ($P['follow_list'] as $val){
                    $followData = [
                        'visit_id'=>$visitorInfo,
                        'follow_name'=>isset($val['follow_name']) ? $val['follow_name'] : '' ,
                        'follow_mobile'=>isset($val['follow_mobile']) ? $val['follow_mobile'] : '' ,
                        'create_at'=>date('Y-m-d H:i:s',time()),];
                    $followInfo = FollowModel::add($followData);
                    if(empty($followInfo)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            if(!empty($P['label_list'])){
                foreach ($P['label_list'] as $val){
                    $visitorLabelData = [
                        'visit_id'=>$visitorInfo,
                        'visit_tag_id'=>isset($val['visit_tag_id']) ? $val['visit_tag_id'] : '' ,
                        'create_at'=>date('Y-m-d H:i:s',time()),
                    ];
                    $visitorLabelRes = VisitorlabelModel::add($visitorLabelData);
                    if(empty($visitorLabelRes)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            sharedb()->commit();
            return $visitorInfo;
        } catch (\Exception $e) {
            app('log')->info('---visit/addVisitot----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }

    public static function updateUser($P){
        try{
            sharedb()->beginTransaction();
            $visitor_id = $P['visit_id'];
            $visitorData = [
                'sfz_number'=>isset($P['sfz_number']) ? $P['sfz_number'] : '' ,
                'real_name'=>isset($P['real_name']) ? $P['real_name'] : '',
                'project_id'=>isset($P['project_id']) ? $P['project_id'] : 0 ,
                'mobile'=>isset($P['mobile']) ? $P['mobile'] : '',
                'sex'=>isset($P['sex']) ? $P['sex'] : '0',
                'appoint_time'=>isset($P['appoint_time']) ? strtotime($P['appoint_time'] ): '',
                'appoint_status_tag_id'=>isset($P['appoint_status_tag_id']) ? $P['appoint_status_tag_id'] : '',
                'face_resource_id'=>isset($P['face_resource_id']) ? $P['face_resource_id'] : '',
                'authorizer'=>isset($P['authorizer']) ? $P['authorizer'] : '',
                'destination'=>isset($P['destination']) ? $P['destination'] : '',
                'space_id'=>isset($P['space_id']) ? $P['space_id'] : '',
                'in_time'=> !empty($P['in_time']) ? strtotime($P['in_time']):0,
                'out_time'=> !empty($P['out_time']) ? strtotime($P['out_time']):0,
                'editor'=>isset($P['editor']) ? $P['editor'] : '',
                'update_at'=>date('Y-m-d H:i:s',time()),
                'device_id'=>isset($P['device_id']) ? $P['device_id'] : '0',
                'visitor_extra' => isset($P['visitor_extra']) ? $P['visitor_extra'] : json_encode([]),
            ];
            $visitor_update_Info = self::update(['visit_id'=>$visitor_id],$visitorData);
            if($visitor_update_Info===false){
                sharedb()->rollback();
                return false;
            }
            $CarDelStatus = VisitorcarModel::del(['visit_id'=>$visitor_id]);
            if($CarDelStatus===false){
                sharedb()->rollback();
                return false;
            }
            if(!empty($P['car_list'])){
                foreach ($P['car_list'] as $value){
                    $visitCarData = [
                        'visit_id'=>$visitor_id,
                        'plate'=>isset($value['plate']) ? strtoupper($value['plate']) : '',
                        'car_type'=>isset($value['car_type']) ? $value['car_type'] : '' ,
                        'car_type_name'=>isset($value['car_type_name']) ? $value['car_type_name'] : '' ,
                        'car_brand'=>isset($value['car_brand']) ? $value['car_brand'] : '',
                        'car_brand_name'=>isset($value['car_brand_name']) ? $value['car_brand_name'] : '',
                        'car_model'=>isset($value['car_model']) ? $value['car_model'] : '',
                        'create_at'=>date('Y-m-d H:i:s',time()),];
                    $visitCarInfo = VisitorcarModel::add($visitCarData);
                    if(empty($visitCarInfo)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            $FollowDelStatus = FollowModel::del(['visit_id'=>$visitor_id]);
            if($FollowDelStatus===false){
                sharedb()->rollback();
                return false;
            }
            if(!empty($P['follow_list'])){
                foreach ($P['follow_list'] as $val){
                    $followData = [
                        'visit_id'=>$visitor_id,
                        'follow_name'=>isset($val['follow_name']) ? $val['follow_name'] : '' ,
                        'follow_mobile'=>isset($val['follow_mobile']) ? $val['follow_mobile'] : '' ,
                        'create_at'=>date('Y-m-d H:i:s',time()),];
                    $followInfo = FollowModel::add($followData);
                    if(empty($followInfo)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            $visitorDelStatus = VisitorlabelModel::del(['visit_id'=>$visitor_id]);
            if($visitorDelStatus===false){
                sharedb()->rollback();
                return false;
            }
            if(!empty($P['label_list'])){
                foreach ($P['label_list'] as $val){
                    $tenementLabelData = [
                        'visit_id'=>$visitor_id,
                        'visit_tag_id'=>isset($val['visit_tag_id']) ? $val['visit_tag_id'] : '' ,
                        'create_at'=>date('Y-m-d H:i:s',time()),
                    ];
                    $visitorLabelRes = VisitorlabelModel::add($tenementLabelData);
                    if(empty($visitorLabelRes)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            sharedb()->commit();
            return $visitor_id;
        } catch (\Exception $e) {
            app('log')->info('---visit/addVisitot----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }

    /**
     * @param $params
     * @return array
     * 根据user_id&device_id分组展示用户
     */
    public static function showUserGroup($P, $inParams, $page = 0, $pagesize = 0)
    {
        $query = sharedb()->table("yhy_visitor as yhyv");
        if (isset($P['plate'])) {
            $P['plate'] = strtoupper($P['plate']);
            $query->leftJoin("yhy_visitor_car as yhyc", "yhyv.visit_id", "=", "yhyc.visit_id");
            $query->where("yhyc.plate", "like", "%" . $P['plate'] . "%");
            unset($P['plate']);
        }
        $query->select(static::$fileds);
        $where = [];
        if (isset($P['real_name'])) {
            $where[] = ['yhyv.real_name', 'like', "%" . $P['real_name'] . "%"];
            unset($P['real_name']);
        }
        if (isset($P['create_time_begin'])) {
            $where[] = ['yhyv.create_at', '>=', $P['create_time_begin']];
            unset($P['create_time_begin']);
        }
        if (isset($P['create_time_begin'])) {
            $where[] = ['yhyv.create_at', '>=', $P['create_time_begin']];
            unset($P['create_time_begin']);
        }
        if (isset($P['create_time_end'])) {
            $where[] = ['yhyv.create_at', '<', $P['create_time_end']];
            unset($P['create_time_end']);
        }

        if (!empty($inParams)) {
            foreach ($inParams as $kl => $vl) {
                $query = $query->whereIn("yhyv." . $kl, $vl);
            }
        }
        if (!empty($where)) {
            $query = $query->where($where);
        }
        if (!empty($P)) {
            foreach ($P as $k => $v) {
                $query = $query->where("yhyv." . $k, "{$v}");
            }
        }
        if ($page) {
            $offset = $pagesize * (max(intval($page), 1) - 1);
            $query->offset($offset)->limit($pagesize);
        }

        $result = $query->groupBy('yhyv.user_id','yhyv.device_id')->orderBy('yhyv.visit_id', 'DESC')->get() ?: [];
        static::$sql = $query->toSql();
        return $result;
    }

}

