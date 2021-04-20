<?php
/*
    进出场接口
    关联数据表 et_client
*/
namespace App\Http\Controllers;

use App\Http\Models\MemberModel;
use Illuminate\Http\Request;

class MemberController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->rules = [
            'member_id' => 'numeric|digits_between:0,13',
            'employee_id' => 'alpha_dash|between:0,25',
            'user_name' => 'alpha_dash|between:0,20',
//            'password' => 'alpha_dash|between:0,50',
            'oa' => 'alpha_dash|between:0,50',
            'is_lock' => 'numeric|digits_between:0,5',
            'last_login_time' => 'date_format:Y-m-d H:i:s',
            'last_login_ip' => 'ip',
            'end_time'=>'date_format:Y-m-d',
            'begin_time'=>'date_format:Y-m-d',
            'create_at' => 'date_format:Y-m-d H:i:s',
            'update_at' => 'date_format:Y-m-d H:i:s',
        ];
        $this->message = [
            "user_name.regex"=>"用户名格式不正确",
            "numeric" => ":attribute 格式不正确",
            "digits_between" => ":attribute 长度超标",
            "between" => ":attribute 长度超标",
            'ip' => '不合法的ip格式',
            "alpha_dash" => ":attribute 必须为字母、数字、下划线组合",
            'date_format' => '不合法的时间格式'
        ];
        $this->request = $request->input();
        $this->ruleValidator($this->request, $this->rules, $this->message);
    }

    /**
     * @param Request $request
     * et_wechat_user表查找数据
     */
    public function member_show()
    {

        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'member_id')) {
            dieJson('2001', '参数错误');
        }
        $info = MemberModel::findOne($P, MemberModel::$fileds);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => MemberModel::$sql]);
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
     * et_wechat_user表查找数据
     */
    public function member_lists()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $page = empty($P['page']) ? 1 : $P['page'];
        $pagesize = empty($P['pagesize']) ? 20 : $P['pagesize'];
        unset($P['page']);
        unset($P['pagesize']);
        $inParams = [];
        if (isset($P['member_ids'])) {
            $inParams['member_id'] = $P['member_ids'];
            unset($P['member_ids']);
        }
        if (isset($P['employee_ids'])) {
            $inParams['employee_id'] = $P['employee_ids'];
            unset($P['employee_ids']);
        }
        $info = MemberModel::find($P, MemberModel::$fileds, $inParams, '', $page, $pagesize);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if ($info === false) {
            dieJson('2002', '查询失败');
        }
        if (empty($info)) {
            successJson([], '查询成功');
        }
        successJson($info, '查询成功');
    }


    /**
     * @param Request $request
     * et_wechat_user表查找数据
     */
    public function member_count()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $inParams = [];
        if (isset($P['member_ids'])) {
            $inParams['member_id'] = $P['member_ids'];
            unset($P['member_ids']);
        }
        if (isset($P['employee_ids'])) {
            $inParams['employee_id'] = $P['employee_ids'];
            unset($P['employee_ids']);
        }
        $info = MemberModel::count($P);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => MemberModel::$sql]);
        if ($info === false) {
            dieJson('2003', '查询失败');
        }
        if (empty($info)) {
            successJson('', '查询成功');
        }
        successJson($info, '查询成功');
    }

    /**
     * @param Request $request
     * et_wechat_user添加信息
     */
    public function member_add()
    {
        if(empty($_SERVER['HTTP_OAUTH_APP_ID'])){
            dieJson('2002', 'app_id不能为空');
        }
        $app_id = empty($_SERVER['HTTP_OAUTH_APP_ID']) ? '':$_SERVER['HTTP_OAUTH_APP_ID'];
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'employee_id')) {
            dieJson('2002', 'employee_id不能为空');
        }
        $member_count = MemberModel::count(['employee_id'=>$P['employee_id']]);
        if(!empty($member_count)){
            dieJson('2002', '该用户已存在账号，无法添加');
        }
        $salt = env('PWD_SALT', '');
        $insertData = [
            'employee_id' => $P['employee_id'],
            'type' => isset($P['type']) ? $P['type'] : 1,
            'password' => isset($P['password']) ?  password_hash(md5($P['password'].$app_id.$salt),PASSWORD_DEFAULT): '',
            'oa' => isset($P['oa']) ? $P['oa'] : '',
            'last_login_time' => date('Y-m-d H:i:s', time()),
            'login_max_num' => isset($P['login_max_num']) ? $P['login_max_num'] : 1,
            'last_login_ip' => isset($P['ip']) ? $P['ip'] : '',
            'end_time' => isset($P['end_time']) ? strtotime($P['end_time']) : '',
            'begin_time' => isset($P['begin_time']) ?strtotime($P['begin_time']) : '',
            'create_at' => date('Y-m-d H:i:s', time()),
            'update_at' => date('Y-m-d H:i:s', time())];

        $info = MemberModel::add($insertData);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if ($info === false) {
            dieJson('2003', '添加失败');
        }
        successJson($info, '添加成功');
    }

    /**
     * @param Request $request
     * 更新et_wechat_user
     */
    public function member_update()
    {
        if(empty($_SERVER['HTTP_OAUTH_APP_ID'])){
            dieJson('2002', 'app_id不能为空');
        }
        $app_id = empty($_SERVER['HTTP_OAUTH_APP_ID']) ? '':$_SERVER['HTTP_OAUTH_APP_ID'];
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'member_id') && !isTrueKey($P, 'employee_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 'member_id')) {
            $where['member_id'] = $P['member_id'];
        }
        if (isTrueKey($P, 'employee_id')) {
            $where['employee_id'] = $P['employee_id'];
        }
        if (isTrueKey($P, 'password')) {
            $salt = env('PWD_SALT', '');
            $P['password'] = password_hash(md5($P['password'].$app_id.$salt),PASSWORD_DEFAULT);
        }
        if(isset($P['begin_time'])){
            $P['begin_time'] = strtotime($P['begin_time']);
        }
        if(isset($P['end_time'])){
            $P['end_time'] = strtotime($P['end_time']);
        }
        $P['update_at'] = date('Y-m-d H:i:s', time());
        $info = MemberModel::update($where, $P);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => MemberModel::$sql]);
        if ($info === false) {
            dieJson('2003', '更新失败');
        }
        successJson($info, '更新成功');
    }

    /**
     * @param Request $request
     * 更新et_wechat_user
     */
    public function member_del()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'member_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 'member_id')) {
            $where['member_id'] = $P['member_id'];
        }
        $info = MemberModel::del($where);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => MemberModel::$sql]);
        if ($info === false) {
            dieJson('2003', '删除失败');
        }
        successJson($info, '更新成功');
    }

    /**
     * 管理员账号查询
     */
    public function member_user_show_list()
    {
        if(!empty($_SERVER['HTTP_OAUTH_APP_ID'])){
            $this->request['app_id'] = empty($_SERVER['HTTP_OAUTH_APP_ID']) ? '':$_SERVER['HTTP_OAUTH_APP_ID'];
        }
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $inParams = [];
        if (isTrueKey($P, 'member_ids')) {
            $inParams['member_ids'] = $P['member_ids'];
            unset($P['member_ids']);
        }
        if (isTrueKey($P, 'employee_ids')) {
            $inParams['employee_ids'] = $P['employee_ids'];
            unset($P['employee_ids']);
        }
        $page = empty($P['page']) ? 1 : $P['page'];
        $pagesize = empty($P['pagesize']) ? 20 : $P['pagesize'];
        $info = MemberModel::showUser($P,$inParams,$page, $pagesize);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => MemberModel::$sql]);
        $count = MemberModel::countUser($P,$inParams);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>MemberModel::$sql]);
        if($info === false){
            dieJson('2003','查询失败');
        }
        if(empty($info)) {
            successJson(['lists'=>[],'count'=>0],'查询成功');
        }
        successJson(['lists'=>$info,'count'=>$count],'查询成功');
    }

    /**
     * @param Request $request
     * 密码校对
     */
    public function member_check_password()
    {
        $P = $this->request;
        if(empty($P['app_id'])){
            dieJson('2002', '应用标识不能为空');
        }
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'user_name', 'password')) {
            dieJson('2001', '账号/密码不能为空');
        }
        $data = MemberModel::findPwd(['user_name' => $P['user_name']]);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [MemberModel::$sql]);
        if (empty($data)) {
            dieJson('2001', '请输入正确的账号');
        }
        $salt = env('PWD_SALT', '');
        if ( !password_verify (md5($P['password'].$P['app_id'].$salt),$data[0]['password'])) {
            dieJson('2005', '账号密码不匹配');
        }
        if($data[0]['status'] == "N"){
            dieJson('2005', '该账号已被禁用，请联系管理员');
        }
        $date = time();
        if($date>$data[0]['end_time']){
            dieJson('2005', '该账号已过期，请联系管理员');
        }
        if($date<$data[0]['begin_time']){
            dieJson('2005', '该账号未生效，请联系管理员');
        }
        successJson(true, '密码校对成功');
    }

    /**
     * @param Request $request
     * 密码校对
     */
    public function member_check_status()
    {
        $P = $this->request;
        if(empty($P['app_id'])){
            dieJson('2002', '应用标识不能为空');
        }
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'employee_id')) {
            dieJson('2001', 'employee_id不能为空');
        }
        $data = MemberModel::showUser(['employee_id' => $P['employee_id']]);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [MemberModel::$sql]);
        if($data[0]['status'] == "N"){
            dieJson('2005', '该账号已被锁定，请联系管理员');
        }
        $date = time();
        if($date>$data[0]['end_time']){
            dieJson('2005', '该账号已失效，请联系管理员');
        }
        if($date<$data[0]['begin_time']){
            dieJson('2005', '该账号未生效，请联系管理员');
        }
        successJson(true, '校对成功');
    }

    /**
     * @param Request $request
     * 账号注册
     */
    public function member_register()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!empty($info[0]['employee_id'])) {
            dieJson('2001', '未选择用户');
        }

        if (!empty($info[0]['user_name']) || !empty($info[0]['password'])) {
            dieJson('2001', '账号名和密码不能为空');
        }
        $info = MemberModel::showUser(['user_name' => $P['user_name']]);
        if (!empty($info[0]['member_id'])) {
            dieJson('2001', '该账号已被注册');
        }
        $app_id = empty($_SERVER['HTTP_OAUTH_APP_ID']) ? '':$_SERVER['HTTP_OAUTH_APP_ID'];
        $salt = env('PWD_SALT', '');
        $P['password'] = isset($P['password']) ?  password_hash(md5($P['password'].$app_id.$salt),PASSWORD_DEFAULT): '';
        $result = MemberModel::register($P);
        if ($result === false) {
            dieJson('2003', '注册失败');
        }
        successJson($info, '注册成功');
    }
}


