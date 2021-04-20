<?php
/*
    进出场接口
    关联数据表 et_client
*/
namespace App\Http\Controllers;

use App\Http\Models\EmployeejobModel;
use Illuminate\Http\Request;

class EmployeejobController extends BaseController{

    public function __construct(Request $request)
    {
        $this->rules = [
            'user_id' => 'numeric|digits_between:0,13',
            'client_ids'=>'array',
            'create_at' => 'date_format:Y-m-d H:i:s',
            'update_at' => 'date_format:Y-m-d H:i:s',
        ];
        $this->message = [
            "numeric" => ":attribute 格式不正确",
            "array" => ":attribute 必须为数组格式",
            "digits_between" => ":attribute 长度超标",
            "between" => ":attribute 长度超标",
            "alpha_dash" =>":attribute 必须为字母、数字、下划线组合",
            'date_format'=>'不合法的时间格式',
        ];
        $this->request = $request->input();
        $this->ruleValidator($this->request,$this->rules,$this->message);
    }

    /**
     * @param Request $request
     */
    public function employee_job_lists(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(isset($P['employee_ids'])||isset($P['job_ids'])){
            $page = 0;
            $pagesize = 0;
        }else{
            $page = empty($P['page'])?1:$P['page'];
            $pagesize = empty($P['pagesize'])?20:$P['pagesize'];
        }
        unset($P['page']);
        unset($P['pagesize']);
        $inParams = [];
        if(isset($P['employee_job_ids'])){
            $inParams['employee_job_id'] = $P['employee_job_ids'];
            unset($P['employee_job_ids']);
        }
        if(isset($P['employee_ids'])){
            $inParams['employee_id'] = $P['employee_ids'];
            unset($P['employee_ids']);
        }
        if(isset($P['job_ids'])){
            $inParams['job_id'] = $P['job_ids'];
            unset($P['job_ids']);
        }
        $info = EmployeejobModel::find($P,EmployeejobModel::$fileds,$inParams,'',$page,$pagesize);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if($info === false){
            dieJson('2002','查询失败');
        }
        if(empty($info)){
            successJson([],'查询成功');
        }
        successJson($info,'查询成功');
    }

    /**
     * @param Request $request
     */
    public function employee_job_add()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P,'employee_id','job_id')) {
            dieJson('2002', '参数错误');
        }
        $insertData = [
            'employee_id' => isset($P['employee_id']) ? $P['employee_id'] : '',
            'job_id' => isset($P['job_id']) ? $P['job_id'] : '',
            'create_at' => date('Y-m-d H:i:s', time())];

        $info = EmployeejobModel::add($insertData);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if ($info === false) {
            dieJson('2003', '添加失败');
        }
        successJson($info, '添加成功');
    }

    public function employee_job_batch_add()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P,'data')) {
            dieJson('2002', '参数错误');
        }
        $insert = [];
        foreach($P['data'] as $key=>$value){
            if (!isTrueKey($value,'employee_id','job_id')) {
                dieJson('2002', '参数错误');
            }
            $insert[] = [
                'employee_id' => isset($value['employee_id']) ? $value['employee_id'] : '',
                'job_id' => isset($value['job_id']) ? $value['job_id'] : '',
                'create_at' => date('Y-m-d H:i:s', time())];
        }
        $info = EmployeejobModel::batchAdd($insert);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [EmployeejobModel::$sql]);
        if ($info === false) {
            dieJson('2003', '添加失败');
        }
        successJson($info, '添加成功');
    }

    /**
     * @param Request $request
     */
    public function employee_job_update()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'employee_job_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 'employee_job_id')) {
            $where['employee_job_id'] = $P['employee_job_id'];
        }
        $P['update_at'] = date('Y-m-d H:i:s', time());
        $info = EmployeejobModel::update($where, $P);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => EmployeejobModel::$sql]);
        if ($info === false) {
            dieJson('2003', '更新失败');
        }
        successJson($info, '更新成功');
    }

    /**
     * @param Request $request
     */
    public function employee_job_del()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'employee_job_id')&&!isTrueKey($P, 'employee_id') && !isTrueKey($P, 'job_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 'employee_job_id')) {
            $where['employee_job_id'] = $P['employee_job_id'];
        }
        if (isTrueKey($P, 'employee_id')) {
            $where['employee_id'] = $P['employee_id'];
        }
        if (isTrueKey($P, 'job_id')) {
            $where['job_id'] = $P['job_id'];
        }
        $info = EmployeejobModel::del($where);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => EmployeejobModel::$sql]);
        if ($info === false) {
            dieJson('2003', '删除失败');
        }
        successJson($info, '更新成功');
    }

    /**
     * @param Request $request
     */
    public function employee_job_show()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'employee_job_id')) {
            dieJson('2001', '参数错误');
        }
        $info = EmployeejobModel::findOne($P, EmployeejobModel::$fileds);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => EmployeejobModel::$sql]);
        if ($info === false) {
            dieJson('2002', '查询失败');
        }
        if (empty($info)) {
            successJson('', '查询成功');
        }
        successJson($info[0], '查询成功');
    }

    /**
     * @param Request $request
     */
    public function employee_job_count()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $inParams = [];
        if (isset($P['employee_job_ids'])) {
            $inParams['employee_job_id'] = $P['employee_job_ids'];
            unset($P['employee_job_ids']);
        }
        $info = EmployeejobModel::count($P,$inParams);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => EmployeejobModel::$sql]);
        if ($info === false) {
            dieJson('2003', '查询失败');
        }
        if (empty($info)) {
            successJson('', '查询成功');
        }
        successJson($info, '查询成功');
    }
}
