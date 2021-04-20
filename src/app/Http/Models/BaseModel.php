<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 1:30 下午.
 */

namespace App\Http\Models;
use Illuminate\Support\Facades\DB;

class BaseModel{

    protected $table;
    protected static $_table;
    public static $sql;

    public static function add($params){
        if (!$params) {
            return false;
        }
        try {
//            app('db')->enableQueryLog();
            $res = sharedb()->table(static::$_table)->insertGetId($params);
//            static::$sql = sharedb()->getQueryLog();
//            sharedb()->disableQueryLog();
            return $res;
        } catch (\Exception $e) {
            app('log')->info('---Add----',[$e->getMessage()]);
            return false;
        }
    }

    public static function batchAdd($params){
        if (!$params) {
            return false;
        }
        try {
//            app('db')->enableQueryLog();
            $res = sharedb()->table(static::$_table)->insert($params);
//            static::$sql = sharedb()->getQueryLog();
//            sharedb()->disableQueryLog();
            return $res;
        } catch (\Exception $e) {
            app('log')->info('---Add----',[$e->getMessage()]);
            return false;
        }
    }

    public static function findOne($where,$filed="*",$orWhere=''){
        try {
//            app('db')->enableQueryLog();
            $query = sharedb()->table(static::$_table)->select($filed);
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
//            static::$sql = sharedb()->getQueryLog();
//            sharedb()->disableQueryLog();
            static::$sql = $query->toSql();
            return $result;
        } catch (\Exception $e) {
            app('log')->info('---findOne----',[$e->getMessage()]);
            return false;
        }
    }

    public static function find($where,$filed='*',$wherein=[],$order=[],$page='',$pagesize=20,$whereNotIn='',
        $groupby=[],$like=[]){
        try {
//            app('db')->enableQueryLog();
            $query = sharedb()->table(static::$_table)->select($filed);
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
            if(!empty($like)){
                foreach($like as $kh=>$vh){
                    $query = $query->where($kh,'like', $vh.'%');
                }
            }
            if(!empty($order)){
                $query->orderBy($order['orderby'],$order['order']);
            }
            if(!empty($groupby)){
                $query->groupBy($groupby);
            }
            if(!empty($page)){
                $offset = $pagesize * ( max(intval($page), 1) - 1 );
                $query->offset($offset)->limit($pagesize);
            }
            $result = $query->get() ?: [];
//            static::$sql = sharedb()->getQueryLog();
//            sharedb()->disableQueryLog();
            static::$sql = $query->toSql();
            return $result;
        } catch (\Exception $e) {
            app('log')->info('---find----',[$e->getMessage()]);
            return false;
        }
    }

    public static function count($where,$wherein='',$orderby='',$order='desc',$whereNotIn=''){
        try {
//            app('db')->enableQueryLog();
            $query = sharedb()->table(static::$_table);
            if(!empty($where)){
                foreach($where as $k=>$v){
                    $query = $query->where($k,"{$v}");
                }
            }
            if(!empty($wherein)){
                foreach($wherein as $kl=>$vl){
                    $query = $query->whereIn($kl, $vl);
                }
            }
            if(!empty($whereNotIn)){
                foreach($whereNotIn as $kh=>$vh){
                    $query = $query->whereNotIn($kh, $vh);
                }
            }
            $result = $query->count() ?: [];
//            static::$sql = sharedb()->getQueryLog();
//            sharedb()->disableQueryLog();
            static::$sql = $query->toSql();
            return $result;
        } catch (\Exception $e) {
            app('log')->info('---count----',[$e->getMessage()]);
            return false;
        }
    }

    public static function update($where,$data){
        try {
//            app('db')->enableQueryLog();
            $query = sharedb()->table(static::$_table);
            if(!empty($where)){
                foreach($where as $key=>$value){
                    $query = $query->where($key,"{$value}");
                }
            }else{
                return false;
            }
            $res = $query->update($data);
            static::$sql = $query->toSql();
//            static::$sql = sharedb()->getQueryLog();
//            sharedb()->disableQueryLog();
            return $res;
        } catch (\Exception $e) {
            app('log')->info('---update----',[$e->getMessage()]);
            return false;
        }
    }

    public static function del($where,$wherein=''){
        try {
//            app('db')->enableQueryLog();
            $query = sharedb()->table(static::$_table);
            if(!empty($where)){
                foreach($where as $key=>$value){
                    $query = $query->where($key,"{$value}");
                }
            }
            if(!empty($wherein)){
                foreach($wherein as $kl=>$vl){
                    $query = $query->whereIn($kl, $vl);
                }
            }
            $res = $query->delete();
            static::$sql = $query->toSql();
//            static::$sql = sharedb()->getQueryLog();
//            sharedb()->disableQueryLog();
            return $res;
        } catch (\Exception $e) {
            app('log')->info('---del----',[$e->getMessage()]);
            return false;
        }
    }

    /**
     * 批量更新
     * @param array $multipleData 二维数组，$students = [
            [‘id’ => 1, ‘name’ => ‘100010’],
            [‘id’ => 2, ‘name’ => ‘100011’],
        ]
     * return boolean
     * */
    public static function updateBatch($multipleData = [])
    {
        try {
            if (empty($multipleData)) {
                app('log')->info('---updateBatch----批量更新数据为空');
                return false;
            }
            $tableName = static::$_table; // 表名
            $firstRow = current($multipleData);

            $updateColumn = array_keys($firstRow);
            // 默认以id为条件更新，如果没有ID则以第一个字段为条件
            $referenceColumn = isset($firstRow['id']) ? 'id' : current($updateColumn);
            unset($updateColumn[0]);
            // 拼接sql语句
            $updateSql = "UPDATE " . $tableName . " SET ";
            $sets = [];
            $bindings = [];
            foreach ($updateColumn as $uColumn) {
                $setSql = "`" . $uColumn . "` = CASE ";
                foreach ($multipleData as $data) {
                    $setSql .= "WHEN `" . $referenceColumn . "` = ? THEN ? ";
                    $bindings[] = $data[$referenceColumn];
                    $bindings[] = $data[$uColumn];
                }
                $setSql .= "ELSE `" . $uColumn . "` END ";
                $sets[] = $setSql;
            }
            $updateSql .= implode(', ', $sets);
            $whereIn = collect($multipleData)->pluck($referenceColumn)->values()->all();
            $bindings = array_merge($bindings, $whereIn);
            $whereIn = rtrim(str_repeat('?,', count($whereIn)), ',');
            $updateSql = rtrim($updateSql, ", ") . " WHERE `" . $referenceColumn . "` IN (" . $whereIn . ")";

            app('log')->info('---updateBatch----', ['sql' => $updateSql]);
            // 传入预处理sql语句和对应绑定数据
            return DB::update($updateSql, $bindings);
        } catch (\Exception $e) {
            return false;
        }
    }
}
