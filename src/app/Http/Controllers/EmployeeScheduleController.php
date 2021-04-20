<?php
namespace App\Http\Controllers;

use App\Http\Models\EmployeeScheduleModel;
use App\Http\Models\EmployeeScheduleTypeModel;
use Illuminate\Http\Request;

/*
 * 排班控制器
 * author：zmj
 * */
class EmployeeScheduleController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->rules = [
            'schedule_id' => 'numeric|digits_between:0,11',
            'schedule_date' => 'date_format:Y-m-d',
            'employee_id' => 'numeric|digits_between:0,25',
            'schedule_type_ids' => 'array',
            'creator' => 'numeric|digits_between:0,25',
            'editor' => 'numeric|digits_between:0,25',
            'create_at' => 'date_format:Y-m-d H:i:s',
            'update_at' => 'date_format:Y-m-d H:i:s',

            'schedule_ids' => 'array',
            'not_paging' => 'boolean',
        ];
        $this->message = [
            "numeric" => ":attribute 格式不正确",
            "array" => ":attribute 必须为数组格式",
            "digits_between" => ":attribute 长度超标",
            "between" => ":attribute 长度超标",
            "date_format" => ":attribute 时间格式错误",
            "alpha"=>":attribute 必须为字母组合",
        ];
        $this->request = $request->input();
        if(!empty($_SERVER['HTTP_OAUTH_APP_ID'])){
            $this->request['app_id'] = empty($_SERVER['HTTP_OAUTH_APP_ID']) ? '':$_SERVER['HTTP_OAUTH_APP_ID'];
        }
        $this->ruleValidator($this->request, $this->rules, $this->message);
        date_default_timezone_set('Asia/Shanghai');
    }

    /**
     * 排班列表
     * @param Request $request
     * return json
     * */
    public function lists()
    {
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$this->request]);
        $P = $this->request;
        unset($P['app_id']);
        unsetEmptyParams($P);

        if (isTrueKey($P, 'schedule_ids') || (isTrueKey($P, 'not_paging') && $P['not_paging'] == 1)) {
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
        if (isTrueKey($P, 'schedule_ids')) {
            $inParams['schedule_id'] = $P['schedule_ids'];
            unset($P['schedule_ids']);
        }
        if (isTrueKey($P, 'employee_ids')) {
            $inParams['employee_id'] = $P['employee_ids'];
            unset($P['employee_ids']);
        }

        $notInParam = [];
        $likeParams = [];

        //默认排序为空
        $order = [];
        $info = EmployeeScheduleModel::lists($P, EmployeeScheduleModel::$fileds, $inParams, $order, $page, $pagesize, $notInParam, [], $likeParams);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>EmployeeScheduleModel::$sql]);
        if($info === false){
            dieJson('2002','查询失败');
        }
        if(empty($info)){
            successJson([],'查询成功');
        }
        successJson($info,'查询成功');
    }

    /**
     * 排班总记录数
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
        if (isTrueKey($P, 'schedule_ids')) {
            $inParams['schedule_id'] = $P['schedule_ids'];
            unset($P['schedule_ids']);
        }

        $notInParam = [];
        $likeParams = [];

        $info = EmployeeScheduleModel::counts($P, $inParams, $notInParam, $likeParams);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>EmployeeScheduleModel::$sql]);
        if($info === false){
            dieJson('2003','查询失败');
        }
        if(empty($info)){
            successJson('','查询成功');
        }
        successJson($info,'查询成功');
    }

    /**
     * 保存排班信息
     * @param Request $request
     * return json
     * */
    public function save()
    {
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$this->request]);
        $P = $this->request;
        unsetEmptyParams($P);

        if (!isTrueKey($P, 'lists')) {
            dieJson('2001','排班信息不能为空');
        }
        if (!is_array($P['lists'])) {
            dieJson('2001','排班参数格式错误');
        }

        if (!isTrueKey($P, 'operator')) {
            dieJson('2001','操作人不能为空');
        }

        $addData = $updateData = $del_schedule_ids = [];
        //$replaceData = [];
        //$replaceUnbinding = '';
        $date_time = date('Y-m-d H:i:s', time());
        $now_date = date('Y-m-d');
        foreach ($P['lists'] as $item) {
            //去掉空数组
            if (empty($item)) continue;
            foreach ($item['schedule'] as $value) {
                if (!isTrueKey($value, 'schedule_date') || !validateDate($value['schedule_date'], 'Y-m-d')) {
                    continue;
                }
                $date_arr = explode('-', $value['schedule_date']);

                $project_id = (isTrueKey($value, 'project_id')) ? $value['project_id'] : $item['project_id'];
                //获取排班信息
                $search_where = [
                    'schedule_date' => $value['schedule_date'],
                    'project_id' => $item['project_id'],
                    'employee_id' => $item['employee_id']
                ];
                $info = EmployeeScheduleModel::show($search_where, ['schedule_id']);

                //有排班数据
                if (isTrueKey($value, 'schedule_type_ids')) {
                    if (!is_array($value['schedule_type_ids'])) continue;
                    if (!isTrueKey($value, 'project_id') && !isTrueKey($item, 'project_id')) continue;
                    $schedule_type_ids = ','.implode(',', $value['schedule_type_ids']).',';

                    if (empty($info)) {
                        $addData[] = [
                            'schedule_date' => $value['schedule_date'],
                            'year' => $date_arr[0],
                            'month' => $date_arr[1],
                            'project_id' => $project_id,
                            'employee_id' => $item['employee_id'],
                            'schedule_type_ids' => $schedule_type_ids,
                            'creator' => $P['operator'],
                            'create_at' => $date_time,
                            'editor' => $P['operator'],
                            'update_at' => $date_time
                        ];
                    } else if ($info && $value['schedule_date'] > $now_date) { //之前有数据，且排班日期在今天之后
                        $updateData[] = [
                            'schedule_id' => $info['schedule_id'],
                            'schedule_type_ids' => $schedule_type_ids,
                            'editor' => $P['operator'],
                            'update_at' => $date_time,
                        ];
                    }

                } else {
                    if (!empty($info) && $value['schedule_date'] > $now_date) {
                        //删除当前用户某个日期的排班
                        $del_schedule_ids[] = $info['schedule_id'];
                    }

                    /*$del_where = [
                        'schedule_date' => $value['schedule_date'],
                        'project_id' => $item['project_id'],
                        'employee_id' => $item['employee_id']
                    ];
                    $res = EmployeeScheduleModel::del($del_where);
                    if ($res === false) {
                        app('log')->info('------保存排班数据，删除员工排班信息出错----',['sql' => EmployeeScheduleModel::$sql]);
                    }*/
                }

            }

        }

        if ($addData) {
            $info = EmployeeScheduleModel::batchAdd($addData);
            if ($info === false) {
                dieJson('2003','批量新增排班信息失败');
            }
        }
        //app('log')->info('------insert data------', $addData);
        //app('log')->info('------update data------', $updateData);
        if ($updateData) {
            $info = EmployeeScheduleModel::updateBatch($updateData);
            if ($info === false) {
                dieJson('2003','批量更新排班信息失败');
            }
        }

        if ($del_schedule_ids) {
            $info = EmployeeScheduleModel::del([], ['schedule_id' => $del_schedule_ids]);
            if ($info === false) {
                app('log')->info('------保存排班数据，删除员工排班信息出错----',['sql' => EmployeeScheduleModel::$sql]);
            }
        }

        successJson('','保存成功');
    }

    /**
     * 替换班次信息
     * @param Request $request
     * return json
     * */
    public function updateScheduleType()
    {
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$this->request]);
        $P = $this->request;
        unsetEmptyParams($P);

        $check_params_info = checkParams($P, ['search_type_id', 'replace_type_id']);
        if ($check_params_info === false) {
            dieJson(4001, '参数的数据类型错误');
        }
        if (is_array($check_params_info)) {
            dieJson(4001, implode('、', $check_params_info) . '参数缺失');
        }

        //获取班次详情
        $schedule_type_info = EmployeeScheduleTypeModel::findOne(['type_id' => $P['search_type_id']], ['project_id']);
        if (empty($schedule_type_info)) {
            dieJson(4002, '原班次信息为空');
        }

        $info = EmployeeScheduleModel::updateScheduleType($P['search_type_id'], $P['replace_type_id'], $schedule_type_info[0]);
        if ($info === false) {
            dieJson('2003','更新排班班次信息失败');
        }
        successJson('','保存成功');
    }

    /**
     * 保存排班信息
     * @param Request $request
     * return json
     * */
    public function old_save()
    {
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$this->request]);
        $P = $this->request;
        unsetEmptyParams($P);

        if (!isTrueKey($P, 'schedule')) {
            dieJson('2001','排班信息不能为空');
        }
        if (!is_array($P['schedule'])) {
            dieJson('2001','排班参数格式错误');
        }

        if (!isTrueKey($P, 'operator')) {
            dieJson('2001','操作人不能为空');
        }

        $updateData = $addData = [];
        $date_time = date('Y-m-d H:i:s', time());
        foreach ($P['schedule'] as $item) {
            //去掉空数组
            if (empty($item)) continue;
            if (!isTrueKey($item, 'schedule_date', 'schedule_type_ids') || !validateDate($item['schedule_date'], 'Y-m-d')) {
                continue;
            }

            if (!is_array($item['schedule_type_ids'])) continue;
            $date_arr = explode('-', $item['schedule_date']);
            $schedule_type_ids = implode(',', $item['schedule_type_ids']).',';

            //更新数据
            if (isset($item['schedule_id']) && $item['schedule_id']) {
                $updateData[] = [
                    'schedule_id' => $item['schedule_id'],
                    'schedule_type_ids' => $schedule_type_ids,
                    'editor' => $P['operator'],
                    'update_at' => $date_time,
                ];
            } else { //新增数据

                if (!isTrueKey($item, 'project_id', 'employee_id')) {
                    continue;
                }
                $addData[] = [
                    'schedule_date' => $item['schedule_date'],
                    'year' => $date_arr[0],
                    'month' => $date_arr[1],
                    'project_id' => $item['project_id'],
                    'employee_id' => $item['employee_id'],
                    'schedule_type_ids' => $schedule_type_ids,
                    'creator' => $P['operator'],
                    'create_at' => $date_time,
                    'editor' => $P['operator'],
                    'update_at' => $date_time
                ];
            }
        }

        if ($addData) {
            $info = EmployeeScheduleModel::batchAdd($addData);
            if ($info === false) {
                dieJson('2003','批量新增排班信息失败');
            }
        }
        //app('log')->info('------insert data------', $addData);
        //app('log')->info('------update data------', $updateData);
        if ($updateData) {
            $info = EmployeeScheduleModel::updateBatch($updateData);
            if ($info === false) {
                dieJson('2003','批量更新排班信息失败');
            }
        }

        successJson('','保存成功');
    }


    /**
     * 获取排班详情
     * @param Request $request
     * return json
     * */
    public function show()
    {
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$this->request]);
        $P = $this->request;
        unset($P['app_id']);

        $info = EmployeeScheduleModel::show($P);
        successJson($info);
    }
}
