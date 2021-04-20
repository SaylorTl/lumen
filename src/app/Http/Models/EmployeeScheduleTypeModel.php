<?php
namespace App\Http\Models;

class EmployeeScheduleTypeModel extends BaseModel
{
    protected static $_table="yhy_employee_schedule_type";

    public static $sql;

    public static $fileds = ['type_id', 'pid', 'project_id', 'type_name', 'begin_time', 'end_time', 'status', 'creator', 'create_at', 'editor', 'update_at'];

    public static $status_option = [
        '-1' => true,
        '0' => true,
        '1' => true
    ];

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
}
