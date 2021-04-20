<?php
/*
    进出场接口
    关联数据表 et_client
*/
namespace App\Http\Controllers;

use App\Http\Models\ClientModel;
use Illuminate\Http\Request;

class ClientController extends BaseController{

    public function __construct(Request $request)
    {
        $this->rules = [
            'c_house_id' => 'numeric|digits_between:0,13',
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
        if(!empty($_SERVER['HTTP_OAUTH_APP_ID'])){
            $this->request['client_app_id'] = empty($_SERVER['HTTP_OAUTH_APP_ID']) ? '':$_SERVER['HTTP_OAUTH_APP_ID'];
        }
        $this->ruleValidator($this->request,$this->rules,$this->message);
    }

    /**
     * @param Request $request
     */
    public function client_lists(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(isset($P['client_ids'])){
            $page = 0;
            $pagesize = 0;
        }else{
            $page = empty($P['page'])?1:$P['page'];
            $pagesize = empty($P['pagesize'])?20:$P['pagesize'];
        }
        unset($P['page']);
        unset($P['pagesize']);

        $inParams = [];
        if(isset($P['client_ids'])){
            $inParams['client_id'] = $P['client_ids'];
            unset($P['client_ids']);
        }
        if(isset($P['user_ids'])){
            $inParams['user_id'] = $P['user_ids'];
            unset($P['user_ids']);
        }
        if(isset($P['employee_ids'])){
            $inParams['employee_id'] = $P['employee_ids'];
            unset($P['employee_ids']);
        }
        $info = ClientModel::find($P,ClientModel::$fileds,$inParams,'',$page,$pagesize);
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
    public function client_add()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P,'openid','app_id')) {
            dieJson('2002', 'client_id不能为空');
        }
        if(empty($P['client_app_id'])){
            dieJson('2002', '租户app_id不能为空');
        }
        $insertData = [
            'employee_id' => isset($P['employee_id']) ? $P['employee_id'] : '',
            'user_id' => isset($P['user_id']) ? $P['user_id'] : 0,
            'kind' => isset($P['kind']) ? $P['kind'] : 'WECHAT',
            'openid' => isset($P['openid']) ? $P['openid'] : '',
            'app_id' => isset($P['app_id']) ? $P['app_id'] : '',
            'client_app_id' => isset($P['client_app_id']) ? $P['client_app_id'] : '',
            'last_login_time'=>date('Y-m-d H:i:s',time()),
            'is_subscribe' => $P['is_subscribe'] ?? 'N',
            'create_at' => date('Y-m-d H:i:s', time()),
            'update_at' => date('Y-m-d H:i:s', time())];

        $info = ClientModel::add($insertData);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if ($info === false) {
            dieJson('2003', '添加失败');
        }
        successJson($info, '添加成功');
    }

    /**
     * @param Request $request
     */
    public function client_update()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'client_id') && !isTrueKey($P, 'openid')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 'client_id')) {
            $where['client_id'] = $P['client_id'];
        }

        if (isTrueKey($P, 'openid')) {
            $where['openid'] = $P['openid'];
        }

        $P['update_at'] = date('Y-m-d H:i:s', time());
        $info = ClientModel::update($where, $P);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => ClientModel::$sql]);
        if ($info === false) {
            dieJson('2003', '更新失败');
        }
        successJson($info, '更新成功');
    }

    /**
     * @param Request $request
     */
    public function client_del()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'client_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 'client_id')) {
            $where['client_id'] = $P['client_id'];
        }
        $info = ClientModel::del($where);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => ClientModel::$sql]);
        if ($info === false) {
            dieJson('2003', '删除失败');
        }
        successJson($info, '更新成功');
    }

    /**
     * @param Request $request
     */
    public function client_show()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if(isTrueKey($P,'app_id','employee_id') == false &&isTrueKey($P,'app_id','user_id') == false &&isTrueKey($P,'app_id','openid') == false && !isTrueKey($P,'client_id')){
            dieJson('2001', '参数错误');
        }
        $info = ClientModel::ShowClient($P, ClientModel::$fileds);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => ClientModel::$sql]);
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
    public function client_count()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $inParams = [];
        if(isset($P['client_ids'])){
            $inParams['client_id'] = $P['client_ids'];
            unset($P['client_ids']);
        }
        if(isset($P['user_ids'])){
            $inParams['user_id'] = $P['user_ids'];
            unset($P['user_ids']);
        }
        if(isset($P['employee_ids'])){
            $inParams['employee_id'] = $P['employee_ids'];
            unset($P['employee_ids']);
        }
        $info = ClientModel::count($P,$inParams);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => ClientModel::$sql]);
        if ($info === false) {
            dieJson('2003', '查询失败');
        }
        if (empty($info)) {
            successJson('', '查询成功');
        }
        successJson($info, '查询成功');
    }
}
