<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class TenementModel extends BaseModel{

    protected static $_table="yhy_tenement";

    public static $fileds = ['yhyt.tenement_id','yhyt.user_id','yhyt.license_tag_id','yhyt.project_id','yhyt.mobile','yhyt.sex'
        ,'yhyt.real_name','yhyt.in_time','yhyt.out_time','yhyt.out_reason_tag_id','yhyt.rescue_type_tag_id','yhyt.pet_type_tag_id',
        'yhyt.face_resource_id','yhyt.pet_remark','yhyt.pet_num','yhyt.tenement_type_tag_id','yhyt.native_place','yhyt.back_account',
        'yhyt.back_name','yhyt.corporation','yhyt.creator','yhyt.editor','yhyt.create_at','yhyt.update_at',
        'yhyt.license_num','yhyt.bank','yhyt.tax_address','yhyt.customer_type_tag_id','yhyt.birth_day','yhyt.tenement_identify_tag_id',
        'yhyt.account_name','yhyt.tax_number','yhyt.email','yhyt.phone','yhyt.contact_name','yhyt.marital_status_tag_id',
        'yhyt.tenement_check_status','yhyt.liable_employee_id'];

    public static function tenementLists($params,$inParams,$page,$pagesize){
        $query = sharedb()->table("yhy_tenement as yhyt");
        $where = [];
        if (!empty($inParams['cell_id']) || !empty($inParams['house_id']) || !empty($params['in_time_begin'])
            || !empty($params['in_time_end']) || !empty($params['out_time_begin']) || !empty($params['out_time_end']) ||
            isset($params['out_time_service'])){
            $query->leftJoin("yhy_tenement_house as yhyh", "yhyh.tenement_id", "=", "yhyt.tenement_id");
            if(!empty($inParams)){
                foreach($inParams as $kl=>$vl){
                    if ($kl == 'cell_id' ||$kl == 'house_id'){
                        $query = $query->whereIn("yhyh.".$kl,$vl);
                        unset($inParams[$kl]);
                    }
                }
            }
            $query = $query->where("yhyh.is_del",'N');
            if (isset($params['in_time_begin'])){
                $where[] = ["yhyh.in_time",">=", strtotime($params['in_time_begin'])];
                unset($params['in_time_begin']);
            }
            if (isset($params['in_time_end'])){
                $where[] = ["yhyh.in_time","<", strtotime($params['in_time_end'])];
                unset($params['in_time_end']);
            }
            if (isset($params['out_time_begin'])){
                $where[] = ["yhyh.out_time",">", strtotime($params['out_time_begin'])];
                unset($params['out_time_begin']);
            }
            if (isset($params['out_time_end'])){
                $where[] = ["yhyh.out_time","<", strtotime($params['out_time_end'])];
                unset($params['out_time_end']);
            }
            if (isset($params['out_time_service'])){
                $out_time_service = strtotime($params['out_time_service']);
                $query->where(function($query) use($out_time_service){
                    $query->where("yhyh.out_time","="," 0")
                        ->orWhere("yhyh.out_time",">","{$out_time_service}");
                });
                unset($params['out_time_service']);
            }
        }
        $query ->select(static::$fileds);
        if (isset($params['real_name'])){
            $where[] = ["yhyt.real_name","like", "%".$params['real_name']."%"];
            unset($params['real_name']);
        }
        if (isset($params['sex'])){
            $where[] = ["yhyt.sex",'=',$params['sex']];
            unset($params['sex']);
        }


        if (!empty($where)){
            $query->where($where);
        }
        if (!empty($inParams)){
            foreach($inParams as $kl=>$vl){
                $query = $query->whereIn("yhyt.".$kl,$vl);
            }
        }
        if (!empty($params)){
            foreach($params as $k=>$v){
                $query = $query->where("yhyt.".$k,"{$v}");
            }
        }
        if(!empty($page)){
            $offset = $pagesize * ( max(intval($page), 1) - 1 );
            $query->offset($offset)->limit($pagesize);
        }
        static::$sql = $query->toSql();
        return $query->orderBy('yhyt.tenement_id', 'DESC')->groupBy('yhyt.tenement_id')->get();
    }

    public static function tenementCount($params,$inParams){
        $query = sharedb()->table("yhy_tenement as yhyt");
        $where = [];
        if (!empty($inParams['cell_id']) || !empty($inParams['house_id']) || !empty($params['in_time_begin'])
            || !empty($params['in_time_end']) || !empty($params['out_time_begin'])|| !empty($params['out_time_end']) ||
            isset($params['out_time_service'])){
            $query->leftJoin("yhy_tenement_house as yhyh", "yhyh.tenement_id", "=", "yhyt.tenement_id");
            if(!empty($inParams)){
                foreach($inParams as $kl=>$vl){
                    if ($kl == 'cell_id' ||$kl == 'house_id'){
                        $query = $query->whereIn("yhyh.".$kl,$vl);
                        unset($inParams[$kl]);
                    }
                }
            }
            $query = $query->where("yhyh.is_del",'N');
            if (isset($params['in_time_begin'])){
                $where[] = ["yhyh.in_time",">=", strtotime($params['in_time_begin'])];
                unset($params['in_time_begin']);
            }
            if (isset($params['in_time_end'])){
                $where[] = ["yhyh.in_time","<", strtotime($params['in_time_end'])];
                unset($params['in_time_end']);
            }
            if (isset($params['out_time_begin'])){
                $where[] = ["yhyh.out_time",">", strtotime($params['out_time_begin'])];
                unset($params['out_time_begin']);
            }
            if (isset($params['out_time_end'])){
                $where[] = ["yhyh.out_time","<", strtotime($params['out_time_end'])];
                unset($params['out_time_end']);
            }

            if (isset($params['out_time_service'])){
                $out_time_service = strtotime($params['out_time_service']);
                $query->where(function($query) use($out_time_service){
                    $query->where("yhyh.out_time","="," 0")
                        ->orWhere("yhyh.out_time",">","{$out_time_service}");
                });
                unset($params['out_time_service']);
            }
        }
        $query ->select(sharedb()->raw('count(distinct yhyt.tenement_id) as total'));
        if (isset($params['real_name'])){
            $where[] = ["yhyt.real_name","like", "%".$params['real_name']."%"];
            unset($params['real_name']);
        }
        if (isset($params['sex'])){
            $where[] = ["yhyt.sex",'=',$params['sex']];
            unset($params['sex']);
        }
        if (!empty($where)){
            $query->where($where);
        }
        if (!empty($inParams)){
            foreach($inParams as $kl=>$vl){
                $query = $query->whereIn("yhyt.".$kl,$vl);
            }
        }
        if (!empty($params)){
            foreach($params as $k=>$v){
                $query = $query->where("yhyt.".$k,"{$v}");
            }
        }
        static::$sql = $query->toSql();
        $total = $query->get();
        info(__METHOD__, $total);
        return $total[0]['total'] ?? 0;
    }

    public static function teneAdd($P){
        try{
            sharedb()->beginTransaction();
            $users = UserModel::findOne(['mobile'=>$P['mobile'],'app_id'=>$P['app_id']],['user_id']);
            if(!empty($users)){
                $user_id = $users[0]['user_id'];
            }else{
                $insertData = [
                    'mobile'=> $P['mobile'],
                    'autolock'=>isset($P['autolock']) ? $P['autolock'] : 'N',
                    'verify'=>isset($P['verify']) ? $P['verify'] : 'N',
                    'app_id'=>isset($P['app_id']) ? $P['app_id'] : '',
                    'create_at'=>date('Y-m-d H:i:s',time()),
                    'update_at'=>date('Y-m-d H:i:s',time()),
                ];
                $user_id = UserModel::add($insertData);
                if(empty($user_id)){
                    sharedb()->rollback();
                    return false;
                }
            }
            $tenementData = [
                'tenement_id'=>$P['tenement_id'],
                'user_id'=>$user_id,
                'license_tag_id'=>isset($P['license_tag_id']) ? $P['license_tag_id'] : '' ,
                'license_num'=>isset($P['license_num']) ? $P['license_num'] : '' ,
                'project_id'=>isset($P['project_id']) ? $P['project_id'] : '',
                'mobile'=>isset($P['mobile']) ? $P['mobile'] : '' ,
                'email'=>isset($P['email']) ? $P['email'] : '' ,
                'sex'=>isset($P['sex']) ? $P['sex'] : '',
                'birth_day'=>isset($P['birth_day']) ? $P['birth_day'] : '' ,
                'real_name'=>isset($P['real_name']) ? $P['real_name'] : '',
                'out_reason_tag_id'=>isset($P['out_reason_tag_id']) ? $P['out_reason_tag_id'] : '',
                'rescue_type_tag_id'=>isset($P['rescue_type_tag_id']) ? $P['rescue_type_tag_id'] : '',
                'pet_type_tag_id'=>isset($P['pet_type_tag_id']) ? $P['pet_type_tag_id'] : '',
                'face_resource_id'=>isset($P['face_resource_id']) ? $P['face_resource_id'] :'',
                'pet_remark'=>isset($P['pet_remark']) ? $P['pet_remark'] : '',
                'pet_num'=>isset($P['pet_num']) ? $P['pet_num'] : '',
                'tenement_type_tag_id'=>isset($P['tenement_type_tag_id']) ? $P['tenement_type_tag_id'] : '',
                'native_place'=>isset($P['native_place']) ? $P['native_place'] : '',
                'bank'=>isset($P['bank']) ? $P['bank'] : '',
                'back_account'=>isset($P['back_account']) ? $P['back_account'] : '',
                'back_name'=>isset($P['back_name']) ? $P['back_name'] : '',
                'tax_number'=>isset($P['tax_number']) ? $P['tax_number'] : '',
                'tax_address'=>isset($P['tax_address']) ? $P['tax_address'] : '',
                'phone'=>isset($P['phone']) ? $P['phone'] : '',
                'corporation'=>isset($P['corporation']) ? $P['corporation'] : '',
                'contact_name'=>isset($P['contact_name']) ? $P['contact_name'] : '',
                'marital_status_tag_id'=>isset($P['marital_status_tag_id']) ? $P['marital_status_tag_id'] : '',
                'creator'=>isset($P['creator']) ? $P['creator'] : '',
                'editor'=>isset($P['editor']) ? $P['editor'] : '',
                'customer_type_tag_id'=>isset($P['customer_type_tag_id']) ? $P['customer_type_tag_id'] : '',
                'tenement_identify_tag_id'=>isset($P['tenement_identify_tag_id']) ? $P['tenement_identify_tag_id'] : '',
                'liable_employee_id'=>isset($P['liable_employee_id']) ? $P['liable_employee_id'] : '',
                'create_at'=>date('Y-m-d H:i:s',time()),
                'update_at'=>date('Y-m-d H:i:s',time()),
                'tenement_check_status'=>isset($P['tenement_check_status']) ? $P['tenement_check_status'] : 'N',
                'app_id'=>isset($P['app_id']) ? $P['app_id'] : '',];
            $tenementRes = self::add($tenementData);
            if($tenementRes === false){
                sharedb()->rollback();
                return false;
            }
            $tenementInfo = $P['tenement_id'];
            if(!empty($P['car_list'])){
                foreach ($P['car_list'] as $value){
                    $tenementCarData = [
                        'tenement_id'=>$tenementInfo,
                        'space_name'=>isset($value['space_name']) ? $value['space_name'] : '' ,
                        'plate'=>isset($value['plate']) ? strtoupper($value['plate']) : '',
                        'car_type_tag_id'=>isset($value['car_type_tag_id']) ? $value['car_type_tag_id'] :'' ,
                        'car_type'=>isset($value['car_type']) ? $value['car_type'] : '' ,
                        'car_type_name'=>isset($value['car_type_name']) ? $value['car_type_name'] : '',
                        'car_brand_name'=>isset($value['car_brand_name']) ? $value['car_brand_name'] : '',
                        'car_model'=>isset($value['car_model']) ? $value['car_model'] :'' ,
                        'car_brand'=>isset($value['car_brand']) ? $value['car_brand'] :'' ,
                        'rule'=>isset($value['rule']) ? $value['rule'] : '',
                        'car_resource_id'=>isset($value['car_resource_id']) ? $value['car_resource_id'] : '',
                        'create_at'=>date('Y-m-d H:i:s',time()),
                        'update_at'=>date('Y-m-d H:i:s',time()),];
                    $tenementCarInfo = TenementcarModel::add($tenementCarData);
                    if(empty($tenementCarInfo)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            if(!empty($P['house_list'])){
                foreach ($P['house_list'] as $val){
                    $cell_id = $val['cell_id']??'';
                    $tenementHouseShow = HouseModel::find(['tenement_id'=>$tenementInfo,'house_id'=>$val['house_id'],'cell_id'=>$cell_id]);
                    if(!empty($tenementHouseShow)){
                        sharedb()->rollback();
                        dieJson('2003','房屋重复');
                    }
                    $tenementHouseData = [
                        'tenement_id'=>$tenementInfo,
                        'house_id'=>isset($val['house_id']) ? $val['house_id'] : '' ,
                        'tenement_house_status'=>isset($val['tenement_house_status']) ? $val['tenement_house_status'] : 'N' ,
                        'cell_id'=>$cell_id ,
                        'out_time'=>isset($val['out_time']) ? strtotime($val['out_time']) : '' ,
                        'in_time'=>isset($val['in_time']) ? strtotime($val['in_time']) : '' ,
                        'tenement_identify_tag_id'=>isset($val['tenement_identify_tag_id']) ? $val['tenement_identify_tag_id'] : '' ,
                        'create_at'=>date('Y-m-d H:i:s',time()),
                        'update_at'=>date('Y-m-d H:i:s',time()),];
                    $tenementHouseInfo = HouseModel::add($tenementHouseData);
                    if(empty($tenementHouseInfo)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            if(!empty($P['label_list'])){
                foreach ($P['label_list'] as $val){
                    $tenementLabelData = [
                        'tenement_id'=>$tenementInfo,
                        'tenement_tag_id'=>isset($val['tenement_tag_id']) ? $val['tenement_tag_id'] : '' ,
                        'create_at'=>date('Y-m-d H:i:s',time()),
                    ];
                    $tenementLabelData = TenementlabelModel::add($tenementLabelData);
                    if(empty($tenementLabelData)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            if(!empty($P['family_member_list'])){
                foreach ($P['family_member_list'] as $val){
                    $familyData = [
                        'tenement_id'=>$tenementInfo,
                        'tenement_m_name'=>isset($val['tenement_m_name']) ? $val['tenement_m_name'] : '' ,
                        'tenement_m_identify'=>isset($val['tenement_m_identify']) ? $val['tenement_m_identify'] : '' ,
                        'tenement_m_mobile'=>isset($val['tenement_m_mobile']) ? $val['tenement_m_mobile'] : '' ,
                        'update_at'=>date('Y-m-d H:i:s',time()),
                        'create_at'=>date('Y-m-d H:i:s',time()),
                    ];
                    $tenementfamilyData = TenementfamilyModel::add($familyData);
                    if(empty($tenementfamilyData)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            sharedb()->commit();
            return $tenementInfo;
        } catch (\Exception $e) {
            app('log')->info('---tenement/teneAdd----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }

    public static function teneUpdate($P){
        try{
            sharedb()->beginTransaction();
            if(empty($P['tenement_id'])){
                return false;
            }
            $tenement_id = $P['tenement_id'];
            $tenementData =[
                'tenement_id'=>$P['tenement_id'],
                'license_tag_id'=>isset($P['license_tag_id']) ? $P['license_tag_id'] : '' ,
                'license_num'=>isset($P['license_num']) ? $P['license_num'] : '' ,
                'project_id'=>isset($P['project_id']) ? $P['project_id'] : '',
                'mobile'=>isset($P['mobile']) ? $P['mobile'] : '' ,
                'email'=>isset($P['email']) ? $P['email'] : '' ,
                'sex'=>isset($P['sex']) ? $P['sex'] : '',
                'birth_day'=>isset($P['birth_day']) ? $P['birth_day'] : '',
                'real_name'=>isset($P['real_name']) ? $P['real_name'] : '',
                'out_reason_tag_id'=>isset($P['out_reason_tag_id']) ? $P['out_reason_tag_id'] : '',
                'rescue_type_tag_id'=>isset($P['rescue_type_tag_id']) ? $P['rescue_type_tag_id'] : '',
                'pet_type_tag_id'=>isset($P['pet_type_tag_id']) ? $P['pet_type_tag_id'] : '',
                'face_resource_id'=>isset($P['face_resource_id']) ? $P['face_resource_id'] : '',
                'pet_remark'=>isset($P['pet_remark']) ? $P['pet_remark'] : '',
                'pet_num'=>isset($P['pet_num']) ? $P['pet_num'] : '',
                'tenement_type_tag_id'=>isset($P['tenement_type_tag_id']) ? $P['tenement_type_tag_id'] : '',
                'native_place'=>isset($P['native_place']) ? $P['native_place'] : '',
                'bank'=>isset($P['bank']) ? $P['bank'] : '',
                'back_account'=>isset($P['back_account']) ? $P['back_account'] : '',
                'back_name'=>isset($P['back_name']) ? $P['back_name'] : '',
                'tax_number'=>isset($P['tax_number']) ? $P['tax_number'] : '',
                'tax_address'=>isset($P['tax_address']) ? $P['tax_address'] : '',
                'phone'=>isset($P['phone']) ? $P['phone'] : '',
                'corporation'=>isset($P['corporation']) ? $P['corporation'] : '',
                'editor'=>isset($P['editor']) ? $P['editor'] : '',
                'contact_name'=>isset($P['contact_name']) ? $P['contact_name'] : '',
                'marital_status_tag_id'=>isset($P['marital_status_tag_id']) ? $P['marital_status_tag_id'] : '',
                'customer_type_tag_id'=>isset($P['customer_type_tag_id']) ? $P['customer_type_tag_id'] : '',
                'tenement_identify_tag_id'=>isset($P['tenement_identify_tag_id']) ? $P['tenement_identify_tag_id'] : '',
                'tenement_check_status'=>isset($P['tenement_check_status']) ? $P['tenement_check_status'] : 'N',
                'liable_employee_id'=>isset($P['liable_employee_id']) ? $P['liable_employee_id'] : '',
                'update_at'=>date('Y-m-d H:i:s',time())];
            $tenement_status = self::update(['tenement_id'=>$tenement_id],$tenementData);
            if($tenement_status === false){
                sharedb()->rollback();
                return false;
            }
            $tenementcarStatus = TenementcarModel::del(['tenement_id'=>$tenement_id]);
            if($tenementcarStatus === false){
                sharedb()->rollback();
                return false;
            }
            if(!empty($P['car_list'])){
                foreach ($P['car_list'] as $value){
                    $tenementCarData = [
                        'tenement_id'=>$tenement_id,
                        'space_name'=>isset($value['space_name']) ? $value['space_name'] : '',
                        'plate'=>isset($value['plate']) ? strtoupper($value['plate']) : '',
                        'car_type_tag_id'=>isset($value['car_type_tag_id']) ? $value['car_type_tag_id'] : '' ,
                        'car_type'=>isset($value['car_type']) ? $value['car_type'] : '' ,
                        'car_model'=>isset($value['car_model']) ? $value['car_model'] :'' ,
                        'car_type_name'=>isset($value['car_type_name']) ? $value['car_type_name'] : '',
                        'car_brand_name'=>isset($value['car_brand_name']) ? $value['car_brand_name'] : '',
                        'car_brand'=>isset($value['car_brand']) ? $value['car_brand'] :'' ,
                        'rule'=>isset($value['rule']) ? $value['rule'] : '',
                        'car_resource_id'=>isset($value['car_resource_id']) ? $value['car_resource_id'] : '',
                        'create_at'=>date('Y-m-d H:i:s',time()),
                        'update_at'=>date('Y-m-d H:i:s',time()),];
                    $tenementCarInfo = TenementcarModel::add($tenementCarData);
                    if(empty($tenementCarInfo)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            $HouseDelStatus = HouseModel::update(['tenement_id'=>$tenement_id],['is_del'=>'Y']);
            if($HouseDelStatus === false){
                sharedb()->rollback();
                return false;
            }
            if(!empty($P['house_list'])){
                foreach ($P['house_list'] as $val){
                    $cell_id = $val['cell_id']??'';
                    $tenementHouseShowY = HouseModel::find(['tenement_id'=>$tenement_id,'house_id'=>$val['house_id'],
                        'cell_id'=>$cell_id,'is_del'=>'Y']);
                    app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'--111--',[HouseModel::$sql]);

                    app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'--222--',[$tenementHouseShowY]);
                    $t_house_id = '';
                    if(!empty($tenementHouseShowY)){
                        $t_house_id = $tenementHouseShowY[0]['t_house_id'];
                    }
                    $tenementHouseShowN = HouseModel::find(['tenement_id'=>$tenement_id,'house_id'=>$val['house_id'],
                        'cell_id'=>$cell_id,'is_del'=>'N']);
                    if(!empty($tenementHouseShowN)){
                        sharedb()->rollback();
                        dieJson('2003','房屋重复');
                    }
                    if(empty($t_house_id)){
                        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'--333--',[$val]);
                        $tenementHouseData = [
                            'tenement_id'=>$tenement_id,
                            'tenement_house_status'=>isset($val['tenement_house_status']) ? $val['tenement_house_status'] : 'N' ,
                            'house_id'=>isset($val['house_id']) ? $val['house_id'] : '' ,
                            'cell_id'=>$cell_id ,
                            'out_time'=>isset($val['out_time']) ? strtotime($val['out_time']) : '' ,
                            'in_time'=>isset($val['in_time']) ? strtotime($val['in_time']) : '' ,
                            'tenement_identify_tag_id'=>isset($val['tenement_identify_tag_id']) ? $val['tenement_identify_tag_id'] : '' ,
                            'create_at'=>date('Y-m-d H:i:s',time()),
                            'update_at'=>date('Y-m-d H:i:s',time()),];
                        $tenementHouseInfo = HouseModel::add($tenementHouseData);
                    }else{
                        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'--444--',[$val]);
                        $tenementHouseData = [
                            'tenement_id'=>$tenement_id,
                            'tenement_house_status'=>isset($val['tenement_house_status']) ? $val['tenement_house_status'] : 'N' ,
                            'house_id'=>isset($val['house_id']) ? $val['house_id'] : '' ,
                            'cell_id'=>$cell_id ,
                            'out_time'=>isset($val['out_time']) ? strtotime($val['out_time']) : '' ,
                            'in_time'=>isset($val['in_time']) ? strtotime($val['in_time']) : '' ,
                            'tenement_identify_tag_id'=>isset($val['tenement_identify_tag_id']) ? $val['tenement_identify_tag_id'] : '' ,
                            'is_del'=>'N',
                            'update_at'=>date('Y-m-d H:i:s',time()),];
                        $tenementHouseInfo = HouseModel::update(['t_house_id'=>$t_house_id],$tenementHouseData);
                    }

                    if(empty($tenementHouseInfo)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            $LabelDelStatus = TenementlabelModel::del(['tenement_id'=>$tenement_id]);
            if($LabelDelStatus === false){
                sharedb()->rollback();
                return false;
            }
            if(!empty($P['label_list'])){
                foreach ($P['label_list'] as $val){
                    $tenementLabelData = [
                        'tenement_id'=>$tenement_id,
                        'tenement_tag_id'=>isset($val['tenement_tag_id']) ? $val['tenement_tag_id'] : '' ,
                        'create_at'=>date('Y-m-d H:i:s',time()),
                    ];
                    $tenementLabelData = TenementlabelModel::add($tenementLabelData);
                    if(empty($tenementLabelData)){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            $familyStatus = TenementfamilyModel::del(['tenement_id'=>$tenement_id]);
            if($familyStatus === false){
                sharedb()->rollback();
                return false;
            }
            if(!empty($P['family_member_list'])){
                foreach ($P['family_member_list'] as $val){
                    $familyData = [
                        'tenement_id'=>$tenement_id,
                        'tenement_m_name'=>isset($val['tenement_m_name']) ? $val['tenement_m_name'] : '' ,
                        'tenement_m_identify'=>isset($val['tenement_m_identify']) ? $val['tenement_m_identify'] : '' ,
                        'tenement_m_mobile'=>isset($val['tenement_m_mobile']) ? $val['tenement_m_mobile'] : '' ,
                        'update_at'=>date('Y-m-d H:i:s',time()),
                        'create_at'=>date('Y-m-d H:i:s',time()),
                    ];
                    app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'1111111----',[$familyData]);
                    $tenementfamilyData = TenementfamilyModel::add($familyData);
                    app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'1111111----',[$tenementfamilyData]);
                    if(empty($tenementfamilyData)){
                        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'12222----',[$tenementfamilyData]);
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            sharedb()->commit();
            return $tenement_id;
        } catch (\Exception $e) {
            app('log')->info('---tenement/teneAdd----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }


    public static function expireTenementWatch(){
        try{
            sharedb()->beginTransaction();
            $nowTime = time();
            $query = sharedb()->table("yhy_tenement_house as yhyh");
            $query->leftJoin("yhy_tenement as yhyt", "yhyh.tenement_id", "=", "yhyt.tenement_id")
                ->where("yhyh.is_del",'N')
                ->where("yhyh.tenement_house_status",'Y')
                ->where("yhyh.out_time",'!=',0)
                ->where("yhyh.out_time",'<',$nowTime)
                ->select(['yhyh.out_time','yhyh.t_house_id','yhyh.house_id','yhyh.tenement_id']);
            $result = $query->get() ?: [];
            static::$sql = $query->toSql();
            $tempArr = [];

            app('log')->info('---tenement/expireTenementWatch----',[$result]);
            if(!empty($result)){
                foreach($result as $k=>$value){
                    $tenement_house_data = [
                        'tenement_house_status'=>'N',
                        'update_at'=>date('Y-m-d H:i:s',time())];
                    $house_update_res = HouseModel::update(['t_house_id'=>$value['t_house_id']],$tenement_house_data);
                    if(false === $house_update_res){
                        sharedb()->rollback();
                        return false;
                    }
                    app('redis')->lpush("device_update", json_encode(["house_ids"=>[$value['house_id']]]));
                    $tempArr[] = $value['tenement_id'];
                }
            }
            foreach($tempArr as $kk=>$vv){
                $house_arr = sharedb()->table("yhy_tenement_house")
                    ->select(['out_time','t_house_id','tenement_id','tenement_house_status'])
                    ->where("is_del",'N')
                    ->where("tenement_id",$vv)
                    ->get() ?: [];
                $update_res = true;
                foreach($house_arr as $kl=>$vl){
                    if((empty($vl['out_time'])&&'Y' == $vl['tenement_house_status']) ||
                        ($vl['out_time']>time()&&'Y' == $vl['tenement_house_status'])){
                        $update_res = false;
                    }
                }
                if($update_res == true){
                    $tenement_update_res =  TenementModel::update(['tenement_id'=>$vv],['tenement_check_status'=>'N']);
                    if(false === $tenement_update_res){
                        sharedb()->rollback();
                        return false;
                    }
                }
            }
            sharedb()->commit();
            return true;
        } catch (\Exception $e) {
            app('log')->info('---tenement/expireTenementWatch----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }


    public static function tenementDeviceWatch($P){
        try{
            $tenement_content  = sharedb()->table("yhy_tenement")
                ->where("project_id",$P['project_id'])
                ->select('*')->get();
            if(empty($tenement_content)){
                return true;
            }
            $P['device_ids'] = $P['device_ids']??[];
            foreach($tenement_content as $key=>$value){
                sharedb()->beginTransaction();
                $userDevice = UserdeviceModel::find(['project_id'=>$P['project_id'],'user_id'=>$value['user_id'],'device_template_type_tag_id'=>'1148'],'*');
                $user_device_ids = !empty($userDevice)?array_column($userDevice,'device_id'):[];
                $user_del_res = UserdeviceModel::del(['project_id' => $P['project_id'],'user_id'=>$value['user_id'],'house_id'=>'']);
                if(false === $user_del_res){
                    throw new \Exception("000---住户设备删除失败".json_encode($value));
                }
                if('N' == $value['tenement_check_status'] && !empty($user_device_ids)){
                    $aiReduceParams = ['user_id'=>$value['user_id'],'real_name'=>$value['real_name'],'face_resource_id'=>$value['face_resource_id'],
                        'action'=>'reduce','device_ids'=>$user_device_ids];
                    app('redis')->lpush("user_device:ai_device_send", json_encode($aiReduceParams));
                }
                if('N' == $value['tenement_check_status']){
                    sharedb()->commit();
                    continue;
                }
                $receive_device_ids = array_filter($P['device_ids'],function ($val){return $val == 1148;});
                $receive_device_ids = array_keys($receive_device_ids);
                $reduce_device_arr = array_diff($user_device_ids,$receive_device_ids);
                $add_device_arr  = array_diff($receive_device_ids,$user_device_ids);

                app('log')->info('---tenement/tenementDeviceWatch111----',[$P['device_ids']]);
                if(!empty($P['device_ids'])){
                    foreach($P['device_ids'] as $kk=>$vv){
                        $insertData = [
                            'project_id'=>$P['project_id']??'',
                            'house_id'=>'',
                            'user_id'=>$value['user_id']??'',
                            'device_id'=>$kk??'',
                            'device_template_type_tag_id' => $vv,
                            'last_use_time'=>date('Y-m-d H:i:s', time()),
                            'create_at'=>date('Y-m-d H:i:s', time()),
                            'update_at'=>date('Y-m-d H:i:s', time())
                        ];
                        $use_device_res  = UserdeviceModel::add($insertData);
                        app('log')->info('---tenement/tenementDeviceWatch----',[UserdeviceModel::$sql]);
                        if(false === $use_device_res){
                            app('log')->info('---' . __CLASS__ . '_user_device_listen-222---', [$insertData,$use_device_res]);
                            continue;
                        }
                    }
                }
                sharedb()->commit();
                if(!empty($add_device_arr)){
                    $aiAddParams = ['user_id'=>$value['user_id'],'real_name'=>$value['real_name'],'face_resource_id'=>$value['face_resource_id'],
                        'action'=>'add','device_ids'=>$add_device_arr];
                    app('redis')->lpush("user_device:ai_device_send", json_encode($aiAddParams));
                }
                if(!empty($reduce_device_arr)){
                    $aiReduceParams = ['user_id'=>$value['user_id'],'real_name'=>$value['real_name'],'face_resource_id'=>$value['face_resource_id'],
                        'action'=>'reduce','device_ids'=>$reduce_device_arr];
                    app('redis')->lpush("user_device:ai_device_send", json_encode($aiReduceParams));
                }
            }
            return true;
        } catch (\Exception $e) {
            app('log')->info('---tenement/tenementDeviceWatch----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }
}

