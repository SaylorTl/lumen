<?php
/*
    进出场接口
    关联数据表 et_client
*/
namespace App\Http\Controllers;

use App\Http\Models\UserinvoceModel;
use Illuminate\Http\Request;

class UserinvoceController extends BaseController{

    public function __construct(Request $request)
    {
        $this->rules = [
            'user_id' => 'numeric|digits_between:0,13',
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
    public function user_invoce_lists(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(isset($P['user_invoce_ids'])){
            $page = 0;
            $pagesize = 0;
        }else{
            $page = empty($P['page'])?1:$P['page'];
            $pagesize = empty($P['pagesize'])?20:$P['pagesize'];
        }
        unset($P['page']);
        unset($P['pagesize']);

        $inParams = [];
        if(isset($P['user_invoce_ids'])){
            $inParams['user_invoce_id'] = $P['user_invoce_ids'];
            unset($P['user_invoce_ids']);
        }
        $info = UserinvoceModel::find($P,UserinvoceModel::$fileds,$inParams,'',$page,$pagesize);
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
    public function user_invoce_add()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P,'employee_id')&& !isTrueKey($P,'user_id')) {
            dieJson('2002', '参数错误');
        }
        $insertData = [
            'user_id' => isset($P['user_id']) ? $P['user_id'] : '',
            'employee_id' => isset($P['employee_id']) ? $P['employee_id'] : '',
            'invoce_type' => isset($P['invoce_type']) ? $P['invoce_type'] : 'person',
            'invoce_title' => isset($P['invoce_title']) ? $P['invoce_title'] : '',
            'tax_num' => isset($P['tax_num']) ? $P['tax_num'] : '',
            'is_default' => isset($P['is_default']) ? $P['is_default'] : 'Y',
            'mobile' => isset($P['mobile']) ? $P['mobile'] : '',
            'email' => isset($P['email']) ? $P['email'] : '',
            'employ_address' => isset($P['employ_address']) ? $P['employ_address'] : '',
            'bank_name' => isset($P['bank_name']) ? $P['bank_name'] : '',
            'bank_account' => isset($P['bank_account']) ? $P['bank_account'] : '',
            'create_at' => date('Y-m-d H:i:s', time()),
            'update_at' => date('Y-m-d H:i:s', time())];
        if(!empty($P['user_id']) && 'Y' == $insertData['is_default']){
            $updateRes = UserinvoceModel::update(['user_id'=>$P['user_id']],['is_default'=>'N'] );
            if(false === $updateRes){
                dieJson('2003', '状态修改失败');
            }
        }
        if(!empty($P['employee_id']) && 'Y' == $insertData['is_default']){
            $updateRes = UserinvoceModel::update(['employee_id'=>$P['employee_id']],['is_default'=>'N'] );
            if(false === $updateRes){
                dieJson('2003', '状态修改失败');
            }
        }
        $info = UserinvoceModel::add($insertData);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if ($info === false) {
            dieJson('2003', '添加失败');
        }
        successJson($info, '添加成功');
    }

    /**
     * @param Request $request
     */
    public function user_invoce_update()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'user_invoce_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 'user_invoce_id')) {
            $where['user_invoce_id'] = $P['user_invoce_id'];
        }
        if(!empty($P['is_default'])){
            if(!empty($P['user_id']) && 'Y' == $P['is_default']){
                $updateRes = UserinvoceModel::update(['user_id'=>$P['user_id']],['is_default'=>'N'] );
                if(false === $updateRes){
                    dieJson('2003', '状态修改失败');
                }
            }
            if(!empty($P['employee_id']) && 'Y' == $P['is_default']){
                $updateRes = UserinvoceModel::update(['employee_id'=>$P['employee_id']],['is_default'=>'N'] );
                if(false === $updateRes){
                    dieJson('2003', '状态修改失败');
                }
            }
        }
        $P['update_at'] = date('Y-m-d H:i:s', time());
        $info = UserinvoceModel::update($where, $P);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => UserinvoceModel::$sql]);
        if ($info === false) {
            dieJson('2003', '更新失败');
        }
        successJson($info, '更新成功');
    }

    /**
     * @param Request $request
     */
    public function user_invoce_del()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'user_invoce_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 'user_invoce_id')) {
            $where['user_invoce_id'] = $P['user_invoce_id'];
        }
        $info = UserinvoceModel::del($where);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => UserinvoceModel::$sql]);
        if ($info === false) {
            dieJson('2003', '删除失败');
        }
        successJson($info, '更新成功');
    }

    /**
     * @param Request $request
     */
    public function user_invoce_show()
    {
        $P = $this->request;
        if (!isTrueKey($P, 'user_invoce_id')) {
            dieJson('2001', '参数错误');
        }
        $info = UserinvoceModel::findOne($P, UserinvoceModel::$fileds);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => UserinvoceModel::$sql]);
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
    public function user_invoce_count()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $inParams = [];
        if (isset($P['user_invoce_ids'])) {
            $inParams['user_invoce_id'] = $P['user_invoce_ids'];
            unset($P['user_invoce_ids']);
        }
        $info = UserinvoceModel::count($P,$inParams);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => UserinvoceModel::$sql]);
        if ($info === false) {
            dieJson('2003', '查询失败');
        }
        if (empty($info)) {
            successJson('', '查询成功');
        }
        successJson($info, '查询成功');
    }
}
