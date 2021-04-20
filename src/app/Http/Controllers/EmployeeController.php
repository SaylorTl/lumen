<?php
/*
    进出场接口
    关联数据表 et_client
*/
namespace App\Http\Controllers;

use App\Http\Models\EmployeeModel;
use App\Http\Models\EmergencyModel;
use App\Http\Models\CertificateModel;
use App\Http\Models\EmployeejobModel;
use Illuminate\Http\Request;

class EmployeeController extends BaseController{

    public function __construct(Request $request)
    {
        $this->rules = [
            'employee_id' => 'numeric|digits_between:0,25',
            'full_name' => array('regex:/^[a-zA-Z0-9_\s\p{Han}]+$/u','between:0,25'),
            'nick_name' => array('regex:/^[a-zA-Z0-9_\s\p{Han}]+$/u','between:0,25'),
            'user_name' => 'alpha_dash|between:0,20',
            'mobile' => 'numeric|digits_between:0,13',
            'status' => 'alpha|between:0,5',
            'sex' => 'numeric|digits_between:0,25',
            'autolock' => 'alpha|between:0,5',
            'verify' => 'alpha|between:0,5',
            'create_at' => 'date_format:Y-m-d H:i:s',
            'update_at' => 'date_format:Y-m-d H:i:s',
            'employ_begin_time' => 'date_format:Y-m-d H:i:s',
            'employ_end_time' => 'date_format:Y-m-d H:i:s',
            'birth_day'=>'date_format:Y-m-d',
            'cert_list'=>'array',
            'emergency_list'=>'array',
            'email'=>'email|between:0,50',
            'remark' => array('regex:/^[^\&\;\'\<\>\/\%\=]+$/u','between:0,300'),
        ];
        $this->message = [
            "numeric" => ":attribute 格式不正确",
            "array" => ":attribute 必须为数组格式",
            "digits_between" => ":attribute 长度超标",
            "between" => ":attribute 长度超标",
            "date_format" => ":attribute 时间格式错误",
            "alpha"=>":attribute 必须为字母组合",
            "full_name.regex"=>"姓名必须为汉字、字母、数字、中划线、下划线组合",
            "nick_name.regex"=>"昵称必须为汉字、字母、数字、中划线、下划线组合",
            "remark.regex"=>"备注包含非法字符",
        ];
        $this->request = $request->input();
        if(!empty($_SERVER['HTTP_OAUTH_APP_ID'])){
            $this->request['app_id'] = empty($_SERVER['HTTP_OAUTH_APP_ID']) ? '':$_SERVER['HTTP_OAUTH_APP_ID'];
        }
        $this->ruleValidator($this->request,$this->rules,$this->message);
    }

    /**
     * @param Request $request
     * et_wechat_user表查找数据
     */
    public function employee_show(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(!isTrueKey($P,'employee_id') && !isTrueKey($P,'mobile')){
            dieJson('2001','参数错误');
        }
        $info = EmployeeModel::findOne($P,EmployeeModel::$fileds);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>EmployeeModel::$sql]);
        if($info === false){
            dieJson('2002','查询失败');
        }
        if(empty($info)){
            successJson('','查询成功');
        }
        successJson($info[0],'查询成功');
    }

    /**
     * @param Request $request
     * et_wechat_user表查找数据
     */
    public function employee_list(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(isset($P['employee_ids'])){
            $page = 0;
            $pagesize = 0;
        }else{
            $page = empty($P['page'])?1:$P['page'];
            $pagesize = empty($P['pagesize'])?20:$P['pagesize'];
        }
        unset($P['page']);
        unset($P['pagesize']);
        $inParams = [];
        if(isset($P['employee_ids'])){
            $inParams['employee_id'] = $P['employee_ids'];
            unset($P['employee_ids']);
        }
        if(isset($P['project_ids'])){
            $inParams['project_id'] = $P['project_ids'];
            unset($P['project_ids']);
        }
        $like_params = [];
        if( isset($P['full_name_f']) ){
            $like_params['full_name'] = $P['full_name_f'];
            unset($P['full_name_f']);
        }
        $info = EmployeeModel::find($P,EmployeeModel::$fileds,$inParams,'',$page,$pagesize,[],[],$like_params);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>EmployeeModel::$sql]);
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
     * et_wechat_user表查找数据
     */
    public function employee_count(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $inParams = [];
        if(isset($P['employee_ids'])){
            $inParams['employee_id'] = $P['employee_ids'];
            unset($P['employee_ids']);
        }
        if(isset($P['project_ids'])){
            $inParams['project_id'] = $P['project_ids'];
            unset($P['project_ids']);
        }
        $info = EmployeeModel::count($P,$inParams);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>EmployeeModel::$sql]);
        if($info === false){
            dieJson('2003','查询失败');
        }
        if(empty($info)){
            successJson('','查询成功');
        }
        successJson($info,'查询成功');
    }

    /**
     * @param Request $request
     * et_wechat_user添加信息
     */
    public function employee_add(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(!isTrueKey($P,'mobile')){
            dieJson('2002','mobile不能为空');
        }
        if(!isTrueKey($P,'full_name')){
            dieJson('2002','full_name不能为空');
        }
        if(empty($P['app_id'])){
            dieJson('2002', 'app_id不能为空');
        }
        $insertData = [
            'sex'=>isset($P['sex']) ? $P['sex'] : '0',
            'full_name'=> $P['full_name'],
            'nick_name'=>isset($P['nick_name']) ? $P['nick_name'] : '',
            'user_name'=>isset($P['user_name']) ? $P['user_name'] : $P['mobile'],
            'mobile'=>$P['mobile'],
            'app_id'=>isset($P['app_id']) ? '' : $P['app_id'],
            'status'=>isset($P['status']) ? $P['status'] : 'Y',
            'autolock'=>isset($P['autolock']) ? $P['autolock'] : 'N',
            'verify'=>isset($P['verify']) ? $P['verify'] : 'N',
            'create_at'=>date('Y-m-d H:i:s',time()),
            'update_at'=>date('Y-m-d H:i:s',time()),
        ];

        $info = EmployeeModel::add($insertData);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if($info === false){
            dieJson('2003','添加失败');
        }
        app('redis')->lpush("employee:workorder:list", ['employee_id'=>$info]);
        successJson($info,'添加成功');
    }

    /**
     * @param Request $request
     * 更新et_wechat_user
     */
    public function employee_update(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(!isTrueKey($P,'employee_id')){
            dieJson('2003','参数错误');
        }
        if(!empty($P['mobile'])){
            $employee_res = EmployeeModel::find(['mobile'=>$P['mobile'],'app_id'=>$P['app_id']]);
            if(!empty($employee_res) && $employee_res[0]['employee_id'] != $P['employee_id']){
                dieJson('2003','该手机号已存在');
            }
        }
        if(!empty($P['user_name'])){
            $employee_res = EmployeeModel::find(['user_name'=>$P['user_name']]);
            if(!empty($employee_res) && $employee_res[0]['employee_id'] != $P['employee_id']){
                dieJson('2003','该账号已存在');
            }
        }
        $where= [];
        if(isTrueKey($P,'employee_id')){
            $where['employee_id'] = $P['employee_id'];
        }
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$where]);
        $P['update_at'] = date('Y-m-d H:i:s',time());
        $info = EmployeeModel::update($where,$P);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>EmployeeModel::$sql]);
        if($info === false){
            dieJson('2003','更新失败');
        }
        app('redis')->lpush("employee:modify_workorder:list", ['employee_id'=>$P['employee_id']]);
        successJson($info,'更新成功');
    }

    /**
     * @param Request $request
     * 更新et_wechat_user
     */
    public function employee_del(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(!isTrueKey($P,'employee_id')){
            dieJson('2003','参数错误');
        }
        $where= [];
        if(isTrueKey($P,'employee_id')){
            $where['employee_id'] = $P['employee_id'];
        }
        $info = EmployeeModel::del($where);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>EmployeeModel::$sql]);
        if($info === false){
            dieJson('2003','删除失败');
        }
        successJson($info,'更新成功');
    }

    /**
     * 管理员账号查询
     */
    public function employee_user_show_list(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $page = empty($P['page'])?1:$P['page'];
        $pagesize = empty($P['pagesize'])?20:$P['pagesize'];
        //是否不分页（0：否；1：是）
        if (isTrueKey($P, 'not_paging') && $P['not_paging'] == 1) {
            $page = 0;
        }
        //排序字段+空格+排序规则，如employee_id desc
        if (isTrueKey($P, 'order')) {
            $order_arr = explode(' ', $P['order']);
            if (count($order_arr) != 2) {
                dieJson('2002', '排序参数错误');
            }
            //支持的排序字段
            $order_filed_option = [
                'employee_id' => true
            ];
            if (!isset($order_filed_option[$order_arr[0]])) {
                dieJson('2002', '排序字段暂不支持');
            }
            //支持的排序规则
            $order_option = [
                'asc' => true,
                'desc' => true
            ];
            if (!isset($order_option[$order_arr[1]])) {
                dieJson('2002', '排序值参数错误');
            }
            $P['order'] = $order_arr;
        }

        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $info = EmployeeModel::showUser($P,$page,$pagesize);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>EmployeeModel::$sql]);
        $count = EmployeeModel::counts($P);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>EmployeeModel::$sql]);
        if($info === false){
            dieJson('2003','查询失败');
        }
        if(empty($info)) {
            successJson('','查询成功');
        }
        successJson(['lists'=>$info,'count'=>$count],'查询成功');
    }

    /**
     * 用户查询账号查询
     */
    public function employee_user_member_list(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $page = empty($P['page'])?1:$P['page'];
        $pagesize = empty($P['pagesize'])?20:$P['pagesize'];

        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $info = EmployeeModel::showMemberUser($P,$page,$pagesize);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>EmployeeModel::$sql]);
        $count = EmployeeModel::memberCounts($P);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>EmployeeModel::$sql]);
        if($info === false){
            dieJson('2003','查询失败');
        }
        if(empty($info)) {
            successJson('','查询成功');
        }
        successJson(['lists'=>$info,'count'=>$count],'查询成功');
    }

    /**
     * @param Request $request
     * 账号注册
     */
    public function employee_add_user(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(!isMobile($P['mobile']) ){
            dieJson('2001','手机号码不合法');
        }

        $info = EmployeeModel::showUser(['mobile'=>$P['mobile'],'app_id'=>$P['app_id']]);
        if(!empty($info)){
            dieJson('2001','手机号已被注册');
        }
        $result =  EmployeeModel::addEmployee($P);
        if($result === false){
            dieJson('2003','注册失败');
        }
       app('redis')->lpush("employee:workorder:list", ['employee_id'=>$result]);
        successJson($result,'注册成功');
    }

    /**
     * @param Request $request
     * 账号注册
     */
    public function employee_update_user(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $check_params_info = checkEmptyParams($P, ['employee_id','epy_ext_id','full_name','mobile','sex','nation_tag_id','birth_day','license_tag_id',
            'political_tag_id','license_num','education_tag_id','employee_status_tag_id','frame_id','job_tag_id'
            ,'entry_time','labor_type_tag_id','labor_begin_time','labor_end_time']);
        if ($check_params_info === false) {
            dieJson(4001, '参数的数据类型错误');
        }
        if (is_array($check_params_info)) {
            dieJson(4001, implode('、', $check_params_info) . '参数缺失');
        }
        if(!isMobile($P['mobile']) ){
            dieJson('2001','手机号码不合法');
        }
        $result =  EmployeeModel::updateEmployee($P);
        if($result === false){
            dieJson('2003','更新失败');
        }
        app('redis')->lpush("employee:modify_workorder:list", ['employee_id'=>$P['employee_id']]);
        successJson($result,'更新成功');
    }

    /**
     * @param Request $request
     * 账号注册
     */
    public function employee_ext_list(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $check_params_info = checkParams($P, ['employee_id']);
        if ($check_params_info === false) {
            dieJson(4001, '参数的数据类型错误');
        }
        if (is_array($check_params_info)) {
            dieJson(4001, implode('、', $check_params_info) . '参数缺失');
        }
        $emergency_list = EmergencyModel::find(['employee_id'=>$P['employee_id']]);
        $certificate_list =  CertificateModel::find(['employee_id'=>$P['employee_id']]);
        $employeejob_list = EmployeejobModel::find(['employee_id'=>$P['employee_id']]);
        successJson(['cert_list'=>$certificate_list,'emergency_list'=>$emergency_list,'job_list'=>$employeejob_list],'查询成功');
    }
}
