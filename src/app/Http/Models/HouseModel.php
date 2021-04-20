<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 8:59 下午.
 */

namespace App\Http\Models;

class HouseModel extends BaseModel{

    protected static $_table="yhy_tenement_house";

    public static $sql;

    public static $fileds = ['t_house_id','tenement_id','house_id','tenement_house_status','cell_id','out_time','in_time',
        'tenement_identify_tag_id','create_at','update_at'];

    public static function HouseLists($where,$filed='*',$wherein=[],$order=[],$page='',$pagesize=20,$whereNotIn=''){
        try {
            $query = sharedb()->table('yhy_tenement_house')->select($filed);
            $wheres = [];
            if (isset($where['in_time_begin'])){
                $wheres[] = ["in_time",">=", strtotime($where['in_time_begin'])];
                unset($where['in_time_begin']);
            }
            if (isset($where['in_time_end'])){
                $wheres[] = ["in_time","<", strtotime($where['in_time_end'])];
                unset($where['in_time_end']);
            }
            if (isset($where['out_time_begin'])){
                $wheres[] = ["out_time",">", strtotime($where['out_time_begin'])];
                unset($where['out_time_begin']);
            }
            if (isset($where['out_time_end'])){
                $wheres[] = ["out_time","<", strtotime($where['out_time_end'])];
                unset($where['out_time_end']);
            }
            if (isset($where['out_time_service'])){
                $out_time_service = strtotime($where['out_time_service']);
                $query->where(function($query) use($out_time_service){
                    $query->where("out_time","="," 0")
                        ->orWhere("out_time",">","{$out_time_service}");
                });
                unset($where['out_time_service']);
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

    public static function TenementHouseLists($where,$filed='*',$wherein=[],$order=[],$page='',$pagesize=20,$whereNotIn=''){
        try {
            $query = sharedb()->table('yhy_tenement_house as house')
                ->leftJoin("yhy_tenement as tenement", "house.tenement_id", "=", "tenement.tenement_id")
                ->select('house.t_house_id','house.tenement_id','house.house_id','house.tenement_house_status','house.cell_id',
                    'house.out_time','house.in_time','house.tenement_identify_tag_id','house.create_at','house.update_at',
                    'tenement.real_name','tenement.face_resource_id','tenement.user_id','tenement.project_id','house.is_del',
                    'house.tenement_house_status','tenement.tenement_check_status');
            $wheres = [];
            if (isset($where['in_time_begin'])){
                $wheres[] = ["house.in_time",">=", strtotime($where['in_time_begin'])];
                unset($where['in_time_begin']);
            }
            if (isset($where['in_time_end'])){
                $wheres[] = ["house.in_time","<", strtotime($where['in_time_end'])];
                unset($where['in_time_end']);
            }
            if (isset($where['out_time_begin'])){
                $wheres[] = ["house.out_time",">", strtotime($where['out_time_begin'])];
                unset($where['out_time_begin']);
            }
            if (isset($where['out_time_end'])){
                $wheres[] = ["house.out_time","<", strtotime($where['out_time_end'])];
                unset($where['out_time_end']);
            }
            if (isset($where['user_id'])){
                $wheres[] = ["tenement.user_id","=", $where['user_id']];
                unset($where['user_id']);
            }
            if (isset($where['tenement_check_status'])){
                $wheres[] = ["tenement.tenement_check_status","=", $where['tenement_check_status']];
                unset($where['tenement_check_status']);
            }
            if (isset($where['project_id'])){
                $wheres[] = ["tenement.project_id","=", $where['project_id']];
                unset($where['project_id']);
            }
            if (isset($where['out_time_service'])){
                $out_time_service = strtotime($where['out_time_service']);
                $query->where(function($query) use($out_time_service){
                    $query->where("house.out_time","="," 0")
                        ->orWhere("house.out_time",">","{$out_time_service}");
                });
                unset($where['out_time_service']);
            }
            if (!empty($wheres)){
                $query->where($wheres);
            }

            if(!empty($where)){
                foreach($where as $k=>$v){
                    $query = $query->where("house.".$k,"{$v}");
                }
            }
            if(!empty($wherein)){
                foreach($wherein as $kl=>$vl){
                    $query = $query->whereIn("house.".$kl,$vl);
                }
            }
            if(!empty($whereNotIn)){
                foreach($whereNotIn as $kh=>$vh){
                    $query = $query->whereNotIn("house.".$kh, $vh);
                }
            }
            if(!empty($order)){
                $query->orderBy("house.".$order['orderby'],$order['order']);
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


    public static function HouseAdd($P){
        try{
            if(empty($P['tenement_id']) ||empty($P['house_id'])){
                return false;
            }
            sharedb()->beginTransaction();
            $cell_id = $P['cell_id']??'';
            $tenementHouseShowY = self::find(['tenement_id'=>$P['tenement_id'],'house_id'=>$P['house_id'],
                'cell_id'=>$cell_id,'is_del'=>'Y']);
            $t_house_id = '';
            if(!empty($tenementHouseShowY)){
                $t_house_id = $tenementHouseShowY[0]['t_house_id'];
            }
            $tenementHouseShowN = self::find(['tenement_id'=>$P['tenement_id'],'house_id'=>$P['house_id'],
                'cell_id'=>$cell_id,'is_del'=>'N']);
            if(!empty($tenementHouseShowN)){
                sharedb()->rollback();
                dieJson('2003','房屋重复');
            }
            if(empty($t_house_id)){
                $tenementHouseData = [
                    'tenement_id'=>$P['tenement_id'],
                    'tenement_house_status'=>isset($P['tenement_house_status']) ? $P['tenement_house_status'] : 'Y' ,
                    'house_id'=>isset($P['house_id']) ? $P['house_id'] : '' ,
                    'cell_id'=>$cell_id ,
                    'out_time'=>isset($P['out_time']) ? $P['out_time'] : '' ,
                    'in_time'=>isset($P['in_time']) ? $P['in_time'] : '' ,
                    'tenement_identify_tag_id'=>isset($P['tenement_identify_tag_id']) ? $P['tenement_identify_tag_id'] : '' ,
                    'create_at'=>date('Y-m-d H:i:s',time()),
                    'update_at'=>date('Y-m-d H:i:s',time()),];
                $tenementHouseInfo = self::add($tenementHouseData);
            }else{
                $tenementHouseData = [
                    'tenement_id'=>$P['tenement_id'],
                    'tenement_house_status'=>isset($P['tenement_house_status']) ? $P['tenement_house_status'] : 'Y' ,
                    'house_id'=>isset($P['house_id']) ? $P['house_id'] : '' ,
                    'cell_id'=>$cell_id ,
                    'out_time'=>isset($P['out_time']) ? $P['out_time'] : '' ,
                    'in_time'=>isset($P['in_time']) ? $P['in_time'] : '' ,
                    'tenement_identify_tag_id'=>isset($P['tenement_identify_tag_id']) ? $P['tenement_identify_tag_id'] : '' ,
                    'create_at'=>date('Y-m-d H:i:s',time()),
                    'update_at'=>date('Y-m-d H:i:s',time()),
                    'is_del'=>'N',];
                $tenementHouseInfo = self::update(['t_house_id'=>$t_house_id],$tenementHouseData);
            }
            if(false === $tenementHouseInfo){
                sharedb()->rollback();
                return false;
            }
            sharedb()->commit();
            return true;
        } catch (\Exception $e) {
            app('log')->info('---House/HouseAdd----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }

    public static function HouseUpdate($P){
        try{
            if(empty($P['t_house_id']) || empty($P['tenement_id']) ||empty($P['house_id'])){
                return false;
            }
            sharedb()->beginTransaction();
            $HouseDelStatus = self::update(['t_house_id'=>$P['t_house_id']],['is_del'=>'Y']);
            if(false === $HouseDelStatus){
                sharedb()->rollback();
                return false;
            }
            $cell_id = $P['cell_id']??'';
            $tenementHouseShowY = self::find(['tenement_id'=>$P['tenement_id'],'house_id'=>$P['house_id'],
                'cell_id'=>$cell_id,'is_del'=>'Y']);
            $t_house_id = '';
            if(!empty($tenementHouseShowY)){
                $t_house_id = $tenementHouseShowY[0]['t_house_id'];
            }
            $tenementHouseShowN = self::find(['tenement_id'=>$P['tenement_id'],'house_id'=>$P['house_id'],
                'cell_id'=>$cell_id,'is_del'=>'N']);
            if(!empty($tenementHouseShowN)){
                sharedb()->rollback();
                dieJson('2003','房屋重复');
            }
            if(empty($t_house_id)){
                $tenementHouseData = [
                    'tenement_id'=>$P['tenement_id'],
                    'tenement_house_status'=>isset($P['tenement_house_status']) ? $P['tenement_house_status'] : 'N' ,
                    'house_id'=>isset($P['house_id']) ? $P['house_id'] : '' ,
                    'cell_id'=>$cell_id ,
                    'out_time'=>isset($P['out_time']) ? $P['out_time'] : '' ,
                    'in_time'=>isset($P['in_time']) ? $P['in_time'] : '' ,
                    'tenement_identify_tag_id'=>isset($P['tenement_identify_tag_id']) ? $P['tenement_identify_tag_id'] : '' ,
                    'create_at'=>date('Y-m-d H:i:s',time()),
                    'update_at'=>date('Y-m-d H:i:s',time()),];
                $tenementHouseInfo = self::add($tenementHouseData);
            }else{
                $tenementHouseData = [
                    'tenement_id'=>$P['tenement_id'],
                    'tenement_house_status'=>isset($P['tenement_house_status']) ? $P['tenement_house_status'] : 'N' ,
                    'house_id'=>isset($P['house_id']) ? $P['house_id'] : '' ,
                    'cell_id'=>$cell_id ,
                    'out_time'=>isset($P['out_time']) ? $P['out_time'] : '' ,
                    'in_time'=>isset($P['in_time']) ? $P['in_time'] : '' ,
                    'tenement_identify_tag_id'=>isset($P['tenement_identify_tag_id']) ? $P['tenement_identify_tag_id'] : '' ,
                    'update_at'=>date('Y-m-d H:i:s',time()),
                    'is_del'=>'N',];
                $tenementHouseInfo = self::update(['t_house_id'=>$t_house_id],$tenementHouseData);
            }
            if(false === $tenementHouseInfo){
                sharedb()->rollback();
                return false;
            }
            sharedb()->commit();
            return true;
        } catch (\Exception $e) {
            app('log')->info('---House/HouseUpdate----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }

    public static function singleHouseUpdate($P){
        try{
            if(empty($P['t_house_id']) || empty($P['tenement_id']) ||empty($P['house_id'])){
                return false;
            }
            sharedb()->beginTransaction();
            $HouseDelStatus = self::update(['t_house_id'=>$P['t_house_id']],['is_del'=>'Y']);
            if(false === $HouseDelStatus){
                sharedb()->rollback();
                return false;
            }
            $cell_id = $P['cell_id']??'';
            $tenementHouseShowY = self::find(['tenement_id'=>$P['tenement_id'],'house_id'=>$P['house_id'],
                'cell_id'=>$cell_id,'is_del'=>'Y']);
            $t_house_id = '';
            if(!empty($tenementHouseShowY)){
                $t_house_id = $tenementHouseShowY[0]['t_house_id'];
            }
            $tenementHouseShowN = self::find(['tenement_id'=>$P['tenement_id'],'house_id'=>$P['house_id'],
                'cell_id'=>$cell_id,'is_del'=>'N']);
            if(!empty($tenementHouseShowN)){
                sharedb()->rollback();
                dieJson('2003','房屋重复');
            }
            if(empty($t_house_id)){
                $tenementHouseData = [
                    'tenement_id'=>$P['tenement_id'],
                    'tenement_house_status'=>isset($P['tenement_house_status']) ? $P['tenement_house_status'] : 'Y' ,
                    'house_id'=>isset($P['house_id']) ? $P['house_id'] : '' ,
                    'cell_id'=>$cell_id ,
                    'out_time'=>isset($P['out_time']) ? $P['out_time'] : '' ,
                    'in_time'=>isset($P['in_time']) ? $P['in_time'] : '' ,
                    'tenement_identify_tag_id'=>isset($P['tenement_identify_tag_id']) ? $P['tenement_identify_tag_id'] : '' ,
                    'create_at'=>date('Y-m-d H:i:s',time()),
                    'update_at'=>date('Y-m-d H:i:s',time()),];
                $tenementHouseInfo = self::add($tenementHouseData);
            }else{
                $tenementHouseData = [
                    'tenement_id'=>$P['tenement_id'],
                    'tenement_house_status'=>isset($P['tenement_house_status']) ? $P['tenement_house_status'] : 'Y' ,
                    'house_id'=>isset($P['house_id']) ? $P['house_id'] : '' ,
                    'cell_id'=>$cell_id ,
                    'out_time'=>isset($P['out_time']) ? $P['out_time'] : '' ,
                    'in_time'=>isset($P['in_time']) ? $P['in_time'] : '' ,
                    'tenement_identify_tag_id'=>isset($P['tenement_identify_tag_id']) ? $P['tenement_identify_tag_id'] : '' ,
                    'update_at'=>date('Y-m-d H:i:s',time()),
                    'is_del'=>'N',];
                $tenementHouseInfo = self::update(['t_house_id'=>$t_house_id],$tenementHouseData);
            }
            if(false === $tenementHouseInfo){
                sharedb()->rollback();
                return false;
            }
            sharedb()->commit();
            return true;
        } catch (\Exception $e) {
            app('log')->info('---House/HouseUpdate----',[$e->getMessage()]);
            sharedb()->rollback();
            return false;
        }
    }

}

