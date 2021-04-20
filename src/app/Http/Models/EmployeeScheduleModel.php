<?php
namespace App\Http\Models;

use Illuminate\Support\Facades\DB;

class EmployeeScheduleModel extends BaseModel
{
    protected static $_table="yhy_employee_schedule";

    public static $sql;

    public static $fileds = ['schedule_id', 'schedule_date', 'project_id', 'employee_id', 'schedule_type_ids', 'creator', 'create_at', 'editor', 'update_at'];

    public static function counts($where, $whereIn = [], $whereNotIn = [], $like = [])
    {
        $query = sharedb()->table(static::$_table);
        if (!empty($where)) {
            foreach($where as $k=>$v){
                $query = $query->where($k,"{$v}");
            }
        }

        if (!empty($whereIn)) {
            foreach($whereIn as $kl=>$vl){
                $query = $query->whereIn($kl, $vl);
            }
        }

        if (!empty($whereNotIn)) {
            foreach($whereNotIn as $kh=>$vh){
                $query = $query->whereNotIn($kh, $vh);
            }
        }

        if (!empty($like)) {
            foreach($like as $kh=>$vh){
                $query = $query->where($kh,'like', '%'.$vh.'%');
            }
        }

        $result = $query->count() ?: [];
        static::$sql = $query->toSql();
        return $result;
    }

    public static function lists($where, $filed='*', $wherein=[], $order=[], $page='', $pagesize=20, $whereNotIn='', $groupby=[], $like=[])
    {
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
                $query = $query->where($kh,'like', '%'.$vh.'%');
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
    }

    /**
     * 更新排班班次信息
     * */
    public static function updateScheduleType($search_type_id, $replace_type_id, $search_type_info)
    {

        $search_type_id_str = ','.$search_type_id.',';
        $replace_type_id_str = ','.$replace_type_id.',';

        $now_date = date('Y-m-d');
        //$updateSql = 'UPDATE '.static::$_table.' SET `schedule_type_ids` = replace(`schedule_type_ids`,'."'$search_type_id_str'".','."'$replace_type_id_str'".') WHERE `schedule_date` <= '."'$now_date'";

        //$updateSql = 'UPDATE '.static::$_table.' SET `schedule_type_ids` = replace(`schedule_type_ids`,?,?) WHERE `schedule_type_ids` LIKE ? AND `schedule_date` <= ?';
        $updateSql = 'UPDATE '.static::$_table.' SET `schedule_type_ids` = replace(`schedule_type_ids`,?,?) WHERE `schedule_date` <= ? AND `project_id` = ?';
        //$type_ids_like = $search_type_id_str.'%';
        $bindings = [
            $search_type_id_str,
            $replace_type_id_str,
            //$type_ids_like,
            $now_date,
            $search_type_info['project_id']
        ];

        app('log')->info('---updateScheduleType----', ['sql' => $updateSql]);
        // 传入预处理sql语句和对应绑定数据
        return DB::update($updateSql, $bindings);
    }

    public static function replaceInsert($replaceDataUnbinding, $replaceData)
    {
        $filed = '`schedule_date`, `year`, `month`, `project_id`, `employee_id`, `schedule_type_ids`, `creator`, `create_at`, `editor`, `update_at`';
        $replaceSql = 'INSERT IGNORE INTO '.static::$_table.'('.$filed.') VALUES '.$replaceDataUnbinding;
        app('log')->info('---updateScheduleType----', ['sql' => $replaceSql]);

        // 传入预处理sql语句和对应绑定数据
        return DB::insert($replaceSql, $replaceData);
    }

    public static function show($where, $filed = [])
    {
        $filed = empty($filed) ? static::$fileds : $filed;
        $query = sharedb()->table(static::$_table)->select($filed);
        if(!empty($where)){
            foreach($where as $k=>$v){
                $query = $query->where($k,"{$v}");
            }
        }

        $query->offset(0)->limit(1);
        $result = $query->get();
        $result =  empty($result) ? [] : $result[0];

        static::$sql = $query->toSql();
        return $result;
    }
}