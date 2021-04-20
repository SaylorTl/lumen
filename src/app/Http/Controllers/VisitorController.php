<?php
/*
    进出场接口
    关联数据表 et_client
*/
namespace App\Http\Controllers;

use App\Http\Models\VisitorModel;
use App\Http\Models\VisitorcarModel;
use App\Http\Models\FollowModel;
use App\Http\Models\VisitorlabelModel;
use Illuminate\Http\Request;

class VisitorController extends BaseController{

    public function __construct(Request $request)
    {
        $this->rules = [
            'visit_id' => 'numeric|digits_between:0,25',
            'user_id' => 'numeric|digits_between:0,13',
            'sfz_number' => 'alpha_dash|between:0,20',
            'real_name' => array('regex:/^[a-zA-Z0-9_\p{Han}]+$/u','between:0,25'),
            'project_id' => 'numeric|digits_between:0,50',
            'sex' => 'numeric|digits_between:0,25',
            'mobile' =>  'numeric|digits_between:0,13',
            'appoint_time' => 'date_format:Y-m-d H:i:s',
            'authorizer' => array('regex:/^[a-zA-Z0-9_\p{Han}]+$/u','between:0,25'),
            'in_time' =>'date_format:Y-m-d H:i:s',
            'out_time' => 'date_format:Y-m-d H:i:s',
            'create_time_begin'=>'date_format:Y-m-d H:i:s',
            'create_time_end'=>'date_format:Y-m-d H:i:s',
            'create_at' => 'date_format:Y-m-d H:i:s',
            'update_at' => 'date_format:Y-m-d H:i:s',
            'car_list' => 'array',
            'follow_list' => 'array',
        ];
        $this->message = [
            "numeric" => ":attribute 格式不正确",
            "array" => ":attribute 必须为数组格式",
            "digits_between" => ":attribute 长度超标",
            "between" => ":attribute 长度超标",
            "alpha_dash" =>":attribute 必须为字母、数字、下划线组合",
            'date_format'=>'不合法的时间格式',
            "real_name.regex"=>":attribute  必须为汉字、字母、数字、中划线、下划线组合",
            "authorizer.regex"=>":attribute  必须为汉字、字母、数字、中划线、下划线组合",
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
    public function visitor_lists(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $page = empty($P['page'])?1:$P['page'];
        $pagesize = empty($P['pagesize'])?20:$P['pagesize'];
        unset($P['page']);
        unset($P['pagesize']);
        $inParams = [];
        if(isset($P['visit_ids'])){
            $inParams['visit_id'] = $P['visit_ids'];
            unset($P['visit_ids']);
        }
        if(isset($P['project_ids'])){
            $inParams['project_id'] = $P['project_ids'];
            unset($P['project_ids']);
        }
        $info = VisitorModel::showUser($P,$inParams,'',$page,$pagesize);
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
     * et_wechat_user表查找数据
     */
    public function visitor_user_lists(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $page = empty($P['page'])?1:$P['page'];
        $pagesize = empty($P['pagesize'])?20:$P['pagesize'];
        unset($P['page']);
        unset($P['pagesize']);
        $inParams = [];
        if(isset($P['visit_ids'])){
            $inParams['visit_id'] = $P['visit_ids'];
            unset($P['visit_ids']);
        }
        if(isset($P['project_ids'])){
            $inParams['project_id'] = $P['project_ids'];
            unset($P['project_ids']);
        }
        $info = VisitorModel::showUser($P,$inParams,$page,$pagesize);
        $count = VisitorModel::counts($P);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if($info === false){
            dieJson('2002','查询失败');
        }
        if(empty($info)){
            successJson('','查询成功');
        }
        successJson(['lists'=>$info,'count'=>$count],'查询成功');
    }

    /**
     * @param Request $request
     * 账号注册
     */
    public function visitor_user_add(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $check_params_info = checkParams($P, ['visit_id','real_name','project_id','mobile']);
        if ($check_params_info === false) {
            dieJson(4001, '参数的数据类型错误');
        }
        if (is_array($check_params_info)) {
            dieJson(4001, implode('、', $check_params_info) . '参数缺失');
        }
        if(!isMobile($P['mobile']) ){
            dieJson('2001','手机号码不合法');
        }
        $info = VisitorModel::addUser($P);
        if($info === false){
            dieJson('2003','注册失败');
        }
        successJson($info,'注册成功');
    }

    /**
     * @param Request $request
     * 访客更新
     */
    public function visitor_user_update(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $check_params_info = checkParams($P, ['visit_id','real_name','project_id','sex','mobile','space_id','authorizer']);
        if ($check_params_info === false) {
            dieJson(4001, '参数的数据类型错误');
        }
        if (is_array($check_params_info)) {
            dieJson(4001, implode('、', $check_params_info) . '参数缺失');
        }
        if(!isMobile($P['mobile']) ){
            dieJson('2001','手机号码不合法');
        }

        $info = VisitorModel::updateUser($P);
        if($info === false){
            dieJson('2003','更新失败');
        }
        successJson($info,'更新成功');
    }


    /**
     * @param Request $request
     * 账号注册
     */
    public function visitor_ext_list(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $check_params_info = checkParams($P, ['visit_id']);
        if ($check_params_info === false) {
            dieJson(4001, '参数的数据类型错误');
        }
        if (is_array($check_params_info)) {
            dieJson(4001, implode('、', $check_params_info) . '参数缺失');
        }
        $car_list = VisitorcarModel::find(['visit_id'=>$P['visit_id']]);
        $follow_list =  FollowModel::find(['visit_id'=>$P['visit_id']]);
        $label_list =  VisitorlabelModel::find(['visit_id'=>$P['visit_id']]);
        successJson(['car_list'=>$car_list,'follow_list'=>$follow_list,'label_list'=>$label_list],'注册成功');
    }


    /**
     * @param Request $request
     * 访客记录列表查找分组
     */
    public function visitor_user_lists_group()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $page = empty($P['page']) ? 1 : $P['page'];
        $pagesize = empty($P['pagesize']) ? 20 : $P['pagesize'];
        unset($P['page']);
        unset($P['pagesize']);
        $inParams = [];
        if (isset($P['visit_ids'])) {
            $inParams['visit_id'] = $P['visit_ids'];
            unset($P['visit_ids']);
        }
        if (isset($P['project_ids'])) {
            $inParams['project_id'] = $P['project_ids'];
            unset($P['project_ids']);
        }
        $info = VisitorModel::showUserGroup($P, $inParams, $page, $pagesize);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if ($info === false) {
            dieJson('2002', '查询失败');
        }
        if (empty($info)) {
            successJson('', '查询成功');
        }
        successJson(['lists' => $info], '查询成功');
    }

}
