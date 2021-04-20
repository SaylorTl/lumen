<?php
namespace App\Http\Controllers;

use App\Http\Models\EmployeeScheduleTypeModel;
use Illuminate\Http\Request;

/*
 * 班次类型控制器
 * author：zmj
 * */

class EmployeeScheduleTypeController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->rules = [
            'type_id' => 'numeric|digits_between:0,11',
            'pid' => 'numeric|digits_between:0,11',
            'project_id' => 'numeric|digits_between:0,25',
            'type_name' => array('regex:/^[a-zA-Z0-9_\s\p{Han}]+$/u','between:0,25'),
            'begin_time' => 'date_format:H:i:s',
            'end_time' => 'date_format:H:i:s',
            'status' => 'alpha_dash|between:0,5',
            'creator' => 'numeric|digits_between:0,25',
            'editor' => 'numeric|digits_between:0,25',
            'create_at' => 'date_format:Y-m-d H:i:s',
            'update_at' => 'date_format:Y-m-d H:i:s',

            'type_ids' => 'array',
            'type_name_f' => 'regex:/^[a-zA-Z0-9_\s\p{Han}]+$/u',
            'not_paging' => 'boolean',
        ];
        $this->message = [
            "numeric" => ":attribute 格式不正确",
            "array" => ":attribute 必须为数组格式",
            "digits_between" => ":attribute 长度超标",
            "between" => ":attribute 长度超标",
            "date_format" => ":attribute 时间格式错误",
            "alpha"=>":attribute 必须为字母组合",
            "type_name.regex"=>"班次名称必须为汉字、字母、数字、中划线、下划线组合",
            "type_name.between" => '班次名称不能超过25字符',
        ];
        $this->request = $request->input();
        if(!empty($_SERVER['HTTP_OAUTH_APP_ID'])){
            $this->request['app_id'] = empty($_SERVER['HTTP_OAUTH_APP_ID']) ? '':$_SERVER['HTTP_OAUTH_APP_ID'];
        }
        $this->ruleValidator($this->request, $this->rules, $this->message);
        date_default_timezone_set('Asia/Shanghai');
    }

    /**
     * 班次类型列表
     * @param Request $request
     * return json
     * */
    public function lists()
    {
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$this->request]);
        $P = $this->request;
        unset($P['app_id']);
        unsetEmptyParams($P);

        if (isTrueKey($P, 'type_ids') || (isTrueKey($P, 'not_paging') && $P['not_paging'] == 1)) {
            $page = 0;
            $pagesize = 0;
        } else {
            $page = empty($P['page']) ? 1 : $P['page'];
            $pagesize = empty($P['pagesize']) ? 20 : $P['pagesize'];
        }

        unset($P['page']);
        unset($P['pagesize']);
        unset($P['not_paging']);
        $inParams = [];
        if (isTrueKey($P, 'type_ids')) {
            if (is_array($P['type_ids'])) {
                $inParams['type_id'] = $P['type_ids'];
            }
            unset($P['type_ids']);
        }
        $likeParams = [];
        if (isTrueKey($P, 'type_name_f')) {
            $likeParams['type_name'] = $P['type_name_f'];
            unset($P['type_name_f']);
        }
        //默认状态
        $notInParam = ['status' => ['-1']];
        if (isTrueKey($P, 'status')) {
            if ($P['status'] == 'all') {
                unset($P['status']);
            }
            $notInParam = [];
        }

        //默认按主键正序
        $order = ['orderby' => 'type_id', 'order' => 'asc'];
        if (isTrueKey($P, 'order')) {
            $order_arr = explode(' ', $P['order']);
            if (count($order_arr) != 2) {
                dieJson('2007', '排序参数错误');
            }
            //支持的排序字段
            $order_filed_option = [
                'type_id' => true
            ];
            if (!isset($order_filed_option[$order_arr[0]])) {
                dieJson('2007', '排序字段暂不支持');
            }
            $order_option = [
                'asc' => true,
                'desc' => true
            ];
            if (!isset($order_option[$order_arr[1]])) {
                dieJson('2007', '排序值参数错误');
            }
            $order = [
                'orderby' => $order_arr[0],
                'order' => $order_arr[1]
            ];
            unset($P['order']);
        }

        $info = EmployeeScheduleTypeModel::lists($P, EmployeeScheduleTypeModel::$fileds, $inParams, $order, $page, $pagesize, $notInParam, [], $likeParams);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>EmployeeScheduleTypeModel::$sql]);
        if($info === false){
            dieJson('2002','查询失败');
        }
        if(empty($info)){
            successJson([],'查询成功');
        }
        successJson($info,'查询成功');
    }

    /**
     * 班次类型总记录数
     * @param Request $request
     * return json
     * */
    public function count()
    {
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$this->request]);
        $P = $this->request;
        unset($P['app_id']);
        unsetEmptyParams($P);

        $inParams = [];
        if (isTrueKey($P, 'type_ids')) {
            $inParams['type_id'] = $P['type_ids'];
            unset($P['type_ids']);
        }

        $likeParams = [];
        if (isTrueKey($P, 'type_name_f')) {
            $likeParams['type_name'] = $P['type_name_f'];
            unset($P['type_name_f']);
        }

        //默认状态
        $notInParam = ['status' => ['-1']];
        if (isTrueKey($P, 'status')) {
            if ($P['status'] == 'all') {
                unset($P['status']);
            }
            $notInParam = [];
        }

        $info = EmployeeScheduleTypeModel::counts($P, $inParams, $notInParam, $likeParams);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>EmployeeScheduleTypeModel::$sql]);
        if($info === false){
            dieJson('2003','查询失败');
        }
        if(empty($info)){
            successJson('','查询成功');
        }
        successJson($info,'查询成功');
    }

    /**
     * 班次详情信息
     * @param Request $request
     * return json
     * */
    public function show()
    {
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$this->request]);
        $P = $this->request;
        unset($P['app_id']);

        $inParams = [];
        $likeParams = [];
        if (isTrueKey($P, 'type_name_f')) {
            $likeParams['type_name'] = $P['type_name_f'];
            unset($P['type_name_f']);
        }

        //默认状态
        $notInParam = ['status' => ['-1']];
        if (isTrueKey($P, 'status')) {
            if ($P['status'] == 'all') {
                unset($P['status']);
            }
            $notInParam = [];
        }

        $info = EmployeeScheduleTypeModel::lists($P, EmployeeScheduleTypeModel::$fileds, $inParams, '', 1, 1, $notInParam, [], $likeParams);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>EmployeeScheduleTypeModel::$sql]);
        if($info === false){
            dieJson('2002','查询失败');
        }

        $result = empty($info) ? [] : $info[0];
        successJson($result,'查询成功');
    }

    /**
     * 新增班次类型
     * @param Request $request
     * return json
     * */
    public function add()
    {
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$this->request]);
        $P = $this->request;

        if (!isTrueKey($P, 'project_id')) {
            dieJson('2002','项目不能为空');
        }
        if (!isTrueKey($P, 'type_name')) {
            dieJson('2002','班次名称不能为空');
        }
        if (!isTrueKey($P, 'begin_time')) {
            dieJson('2002','班次开始时间不能为空');
        }
        if (!validateDate($P['begin_time'], 'H:i:s')) {
            dieJson('2002', '班次开始时间参数错误');
        }

        /*$now_date = date('Y-m-d');
        $begin_date_time = $now_date.' '.$P['begin_time'];
        if (!validateDate($begin_date_time)) {
            dieJson('2002', '班次开始时间参数错误');
        }*/

        if (!isTrueKey($P, 'end_time')) {
            dieJson('2002','班次结束时间不能为空');
        }
        if (!validateDate($P['end_time'], 'H:i:s')) {
            dieJson('2002','班次结束时间参数错误');
        }
        /*$end_date_time = $now_date.' '.$P['end_time'];
        if (!validateDate($end_date_time, 'H:i:s')) {
            dieJson('2002','班次结束时间参数错误');
        }*/

        $date = '2021-01-01 ';
        $begin_time = $date.$P['begin_time'];
        $end_time = $date.$P['end_time'];
        if (strtotime($end_time) <= strtotime($begin_time)) {
            dieJson('2002', '班次结束时间需大于开始时间');
        }

        if (!isTrueKey($P, 'status')) {
            dieJson('2002','班次状态参数不能为空');
        }
        if (!EmployeeScheduleTypeModel::$status_option[$P['status']]) {
            dieJson('2002','班次状态参数错误');
        }

        if (!isTrueKey($P, 'creator')) {
            dieJson('2002', '创建人不能为空');
        }

        $insertData = [
            'project_id' => $P['project_id'],
            'type_name' => $P['type_name'],
            'begin_time' => $P['begin_time'],
            'end_time' => $P['end_time'],
            'status' => $P['status'],
            'creator' => $P['creator'],
            'editor' => empty($P['editor']) ? $P['creator'] : $P['editor'],
            'create_at' => empty($P['create_at']) ? date('Y-m-d H:i:s') : $P['create_at'],
            'update_at' => empty($P['update_at']) ? date('Y-m-d H:i:s') : $P['create_at']
        ];
        $info = EmployeeScheduleTypeModel::add($insertData);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if($info === false){
            dieJson('2003','添加失败');
        }
        successJson($info,'添加成功');
    }

    /**
     * 编辑班次类型
     * @param Request $request
     * return json
     * */
    public function update()
    {
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$this->request]);
        $P = $this->request;

        if (!isTrueKey($P, 'type_id')) {
            dieJson('2002','班次id不能为空');
        }

        //判断班次是否存在
        $info = EmployeeScheduleTypeModel::count(['type_id' => $P['type_id']]);
        if (empty($info)) {
            dieJson('2002', '班次不存在');
        }
        /*if (!isTrueKey($P, 'project_id')) {
            dieJson('2002','项目不能为空');
        }*/
        if (!isTrueKey($P, 'type_name')) {
            dieJson('2002','班次名称不能为空');
        }
        if (!isTrueKey($P, 'begin_time')) {
            dieJson('2002','班次开始时间不能为空');
        }
        if (!validateDate($P['begin_time'], 'H:i:s')) {
            dieJson('2002', '班次开始时间参数错误');
        }

        /*$now_date = date('Y-m-d');
        $begin_date_time = $now_date.' '.$P['begin_time'];
        if (!validateDate($begin_date_time)) {
            dieJson('2002', '班次开始时间参数错误');
        }*/

        if (!isTrueKey($P, 'end_time')) {
            dieJson('2002','班次结束时间不能为空');
        }
        if (!validateDate($P['end_time'], 'H:i:s')) {
            dieJson('2002','班次结束时间参数错误');
        }
        /*$end_date_time = $now_date.' '.$P['end_time'];
        if (!validateDate($end_date_time, 'H:i:s')) {
            dieJson('2002','班次结束时间参数错误');
        }*/

        $date = '2021-01-01 ';
        $begin_time = $date.$P['begin_time'];
        $end_time = $date.$P['end_time'];
        if (strtotime($end_time) <= strtotime($begin_time)) {
            dieJson('2002', '班次结束时间需大于开始时间');
        }

        if (!isTrueKey($P, 'status')) {
            dieJson('2002','班次状态参数不能为空');
        }
        if (!EmployeeScheduleTypeModel::$status_option[$P['status']]) {
            dieJson('2002','班次状态参数错误');
        }

        if (!isTrueKey($P, 'editor')) {
            dieJson('2002', '编辑人不能为空');
        }

        $updateData = [
            'pid' => empty($P['pid']) ? 0 : $P['pid'],
            'type_name' => $P['type_name'],
            'begin_time' => $P['begin_time'],
            'end_time' => $P['end_time'],
            'status' => $P['status'],
            'editor' => empty($P['editor']) ? $P['creator'] : $P['editor'],
            'update_at' => empty($P['update_at']) ? date('Y-m-d H:i:s') : $P['update_at']
        ];

        $where = ['type_id' => $P['type_id']];
        $info = EmployeeScheduleTypeModel::update($where, $updateData);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>EmployeeScheduleTypeModel::$sql]);
        if($info === false){
            dieJson('2003','更新失败');
        }
        successJson($P['type_id'],'更新成功');
    }
}
