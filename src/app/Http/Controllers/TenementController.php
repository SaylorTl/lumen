<?php
/*
    进出场接口
    关联数据表 et_client
*/
namespace App\Http\Controllers;

use App\Http\Models\TenementModel;
use App\Http\Models\TenementcarModel;
use App\Http\Models\HouseModel;
use App\Http\Models\TenementlabelModel;
use App\Http\Models\TenementfamilyModel;
use Illuminate\Http\Request;
use App\Libraries\EventTrigger;

class TenementController extends BaseController{

    public function __construct(Request $request)
    {
        $this->rules = [
            'tenement_id' => 'numeric|digits_between:0,25',
            'user_id' => 'numeric|digits_between:0,13',
            'project_id' => 'numeric|digits_between:0,30',
            'out_reason_tag_id' => 'numeric|digits_between:0,13',
            'rescue_type_tag_id' => 'numeric|digits_between:0,13',
            'user_tag_id' => 'numeric|digits_between:0,13',
            'pet_remark' => array('regex:/^[^\&\;\'\<\>\/\%\=]+$/u','between:0,300'),
            'pet_num' => 'numeric|digits_between:0,13',
            'tenement_type_tag_id' => 'numeric|digits_between:0,13',
            'space_name' => array('regex:/^[a-zA-Z0-9_\p{Han}]+$/u','between:0,20'),
            'plate' => array('regex:/^[a-zA-Z0-9_\p{Han}]+$/u','between:0,20'),
            'resource_id' => 'numeric|digits_between:0,25',
            'sex' => 'numeric|digits_between:0,25',
            'rule' => array('regex:/^[a-zA-Z0-9_\p{Han}]+$/u','between:0,100'),
            'in_time_begin' => 'date_format:Y-m-d H:i:s',
            'in_time_end' => 'date_format:Y-m-d H:i:s',
            'out_time_begin' => 'date_format:Y-m-d H:i:s',
            'out_time_end' => 'date_format:Y-m-d H:i:s',
            'car_list' => 'array',
            'house_list' => 'array',
        ];
        $this->message = [
            "numeric" => ":attribute 格式不正确",
            "array" => ":attribute 必须为数组格式",
            "digits_between" => ":attribute 长度超标",
            "date_format" => ":attribute 时间格式错误",
            "between" => ":attribute 长度超标",
            "alpha"=>":attribute 必须为字母组合",
            "space_name.regex"=>":attribute  必须为汉字、字母、数字、中划线、下划线组合",
            "plate.regex"=>":attribute  必须为汉字、字母、数字、中划线、下划线组合",
            "rule.regex"=>":attribute  必须为汉字、字母、数字、中划线、下划线组合",
            "pet_remark.regex"=>":attribute 输入字符不合法",
        ];
        $this->request = $request->input();
        if(!empty($_SERVER['HTTP_OAUTH_APP_ID'])) {
            $this->request['app_id'] = empty($_SERVER['HTTP_OAUTH_APP_ID']) ? '':$_SERVER['HTTP_OAUTH_APP_ID'];
        }
        $this->ruleValidator($this->request,$this->rules,$this->message);
    }

    /**
     * @param Request $request
     * et_wechat_user表查找数据
     */
    public function tenement_user_lists(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $page = !isset($P['page'])?1:$P['page'];
        $pagesize = !isset($P['pagesize'])?20:$P['pagesize'];
        unset($P['page']);
        unset($P['pagesize']);
        $inParams = [];
        if(isset($P['user_ids'])){
            $inParams['user_id'] = $P['user_ids'];
            unset($P['user_ids']);
        }
        if(isset($P['house_ids'])){
            $inParams['house_id'] = $P['house_ids'];
            unset($P['house_ids']);
        }
        if(isset($P['cell_ids'])){
            $inParams['cell_id'] = $P['cell_ids'];
            unset($P['cell_ids']);
        }
        if(isset($P['tenement_ids'])){
            $inParams['tenement_id'] = $P['tenement_ids'];
            unset($P['tenement_ids']);
        }
        if(isset($P['project_ids'])){
            $inParams['project_id'] = $P['project_ids'];
            unset($P['project_ids']);
        }
        $info = TenementModel::tenementLists($P,$inParams,$page,$pagesize);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[TenementModel::$sql]);
        if($info === false){
            dieJson('2002','查询失败');
        }
        if(empty($info)){
            successJson([],'查询成功');
        }
        $count = TenementModel::tenementcount($P,$inParams);
        successJson(['lists'=>$info,'count'=>$count],'查询成功');
    }

    /**
     * @param Request $request
     * et_wechat_user表查找数据
     */
    public function tenement_lists()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if(isset($P['tenement_ids']) || isset($P['user_ids'])){
            $page = 0;
            $pagesize = 0;
        }else{
            $page = !isset($P['page'])?1:$P['page'];
            $pagesize = !isset($P['pagesize'])?20:$P['pagesize'];
        }
        unset($P['page']);
        unset($P['pagesize']);
        $inParams = [];
        if(isset($P['tenement_ids'])){
            $inParams['tenement_id'] = $P['tenement_ids'];
            unset($P['tenement_ids']);
        }
        if(isset($P['project_ids'])){
            $inParams['project_id'] = $P['project_ids'];
            unset($P['project_ids']);
        }
        if(isset($P['user_ids'])){
            $inParams['user_id'] = $P['user_ids'];
            unset($P['user_ids']);
        }
        $info = TenementModel::find($P, '*', $inParams, '', $page, $pagesize);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [TenementModel::$sql]);
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
    public function tenement_count(){
        $P = $this->request;
        $inParams = [];
        if(isset($P['tenement_ids'])){
            $inParams['tenement_id'] = $P['tenement_ids'];
            unset($P['tenement_ids']);
        }
        if(isset($P['project_ids'])){
            $inParams['project_id'] = $P['project_ids'];
            unset($P['project_ids']);
        }
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $info = TenementModel::count($P);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[TenementModel::$sql]);
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
    public function tenement_user_add(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(empty($P['tenement_type_tag_id'])){
            dieJson(4001, '住户类型不能为空');
        }
        if($P['tenement_type_tag_id']== '411'){
            $check_params_info = checkParams($P, ['project_id','real_name','mobile',]);
        }else{
            $check_params_info = checkParams($P, ['project_id','real_name','mobile']);
        }
        if ($check_params_info === false) {
            dieJson(4001, '参数的数据类型错误');
        }
        if (is_array($check_params_info)) {
            dieJson(4001, implode('、', $check_params_info) . '参数缺失');
        }
        if(!isMobile($P['mobile']) && !isTel($P['mobile'])){
            dieJson('2001','手机号码不合法');
        }
        if(!empty($P['mobile']) && !empty($P['project_id'])){
            $tenement_res = TenementModel::find(['mobile'=>$P['mobile'],'project_id'=>$P['project_id'],'app_id'=>$P['app_id']]);
            if(!empty($tenement_res)){
                dieJson('2003','该手机号已存在');
            }
        }
        $info = TenementModel::teneAdd($P);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[TenementModel::$sql]);
        if($info === false){
            dieJson('2003','添加失败');
        }

        EventTrigger::push('screen_push', [
            'method'=>'tenementAdd',
            'project_id'=>$P['project_id'],
            'data'=>json_encode($P)]);

        app('redis')->lpush("device_update", json_encode(["tenement_id"=>$info]));
        successJson($info,'添加成功');
    }

    /**
     * @param Request $request
     * et_wechat_user添加信息
     */
    public function tenement_user_update(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(empty($P['tenement_type_tag_id'])){
            dieJson(4001, '住户类型不能为空');
        }
        if($P['tenement_type_tag_id']== '411'){
            $check_params_info = checkParams($P, ['project_id','real_name','mobile',
               ]);
        }else{
            $check_params_info = checkParams($P, ['project_id','real_name','mobile']);
        }
        if ($check_params_info === false) {
            dieJson(4001, '参数的数据类型错误');
        }
        if (is_array($check_params_info)) {
            dieJson(4001, implode('、', $check_params_info) . '参数缺失');
        }
        if(!isMobile($P['mobile']) ){
            dieJson('2001','手机号码不合法');
        }
        if(!empty($P['mobile']) && !empty($P['project_id'])){
            $tenement_res = TenementModel::find(['mobile'=>$P['mobile'],'project_id'=>$P['project_id']]);
            if(!empty($tenement_res) && $tenement_res[0]['tenement_id'] != $P['tenement_id']){
                dieJson('2003','该手机号已存在，无法修改');
            }
        }

        $before = TenementModel::findOne(['tenement_id'=>$P['tenement_id']]);

        $info = TenementModel::teneUpdate($P);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if($info === false){
            dieJson('2003','更新失败');
        }

        EventTrigger::push('screen_push', [
            'method'=>'tenementUpdate',
            'project_id'=>$P['project_id'],
            'data'=>json_encode(['before'=>$before?$before[0]:[],'after'=>$P])]
        );

        app('log')->info('---'.__CLASS__.'_123213'.__FUNCTION__.'----',["tenement_id"=>$P['tenement_id']]);
        app('redis')->lpush("device_update", json_encode(["tenement_id"=>$P['tenement_id']]));
        successJson($info,'更新成功');
    }

    /**
     * @param Request $request
     * 更新et_wechat_user
     */
    public function tenement_update(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(!isTrueKey($P,'tenement_id')){
            dieJson('2003','参数错误');
        }
        $where= [];
        if(isTrueKey($P,'tenement_id')){
            $where['tenement_id'] = $P['tenement_id'];
        }
        $P['update_at'] = date('Y-m-d H:i:s',time());
        $info = TenementModel::update($where,$P);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>TenementModel::$sql]);
        if($info === false){
            dieJson('2003','更新失败');
        }
        successJson($info,'更新成功');
    }

    /**
     * @param Request $request
     * 更新et_wechat_user
     */
    public function tenement_del(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(!isTrueKey($P,'tenement_id')){
            dieJson('2003','参数错误');
        }
        $where= [];
        if(isTrueKey($P,'tenement_id')){
            $where['tenement_id'] = $P['tenement_id'];
        }
        $info = TenementModel::del($where);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>TenementModel::$sql]);
        if($info === false){
            dieJson('2003','删除失败');
        }
        successJson($info,'更新成功');
    }

    /**
     * @param Request $request
     * 业主附加信息
     */
    public function tenement_ext_list(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $check_params_info = checkParams($P, ['tenement_id']);
        if ($check_params_info === false) {
            dieJson(4001, '参数的数据类型错误');
        }
        if (is_array($check_params_info)) {
            dieJson(4001, implode('、', $check_params_info) . '参数缺失');
        }
        $car_list = TenementcarModel::find(['tenement_id'=>$P['tenement_id']]);
        $house_list =  HouseModel::find(['tenement_id'=>$P['tenement_id'],'is_del'=>'N']);
        $label_list =  TenementlabelModel::find(['tenement_id'=>$P['tenement_id']]);
        $family_member_list =  TenementfamilyModel::find(['tenement_id'=>$P['tenement_id']]);
        successJson(['car_list'=>$car_list,'house_list'=>$house_list,'label_list'=>$label_list,'family_member_list'=>$family_member_list],
            '查询成功');
    }

    public function tenement_expire_listen()
    {
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $info = TenementModel::expireTenementWatch();
        if ($info === false) {
            dieJson('2003', '更新失败');
        }
        successJson($info, '更新成功');
    }

    public function tenement_device_watch(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $info = TenementModel::tenementDeviceWatch($P);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$info]);
        if ($info === false) {
            dieJson('2003', '更新失败');
        }

        successJson($info, '更新成功');
    }

}


