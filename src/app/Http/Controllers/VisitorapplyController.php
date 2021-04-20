<?php
/*
    进出场接口
    关联数据表 et_client
*/
namespace App\Http\Controllers;

use App\Http\Models\VisitorapplyModel;
use Illuminate\Http\Request;

class VisitorapplyController extends BaseController{

    public function __construct(Request $request)
    {
        $this->rules = [
            'user_id' => 'numeric|digits_between:0,13',
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
        $this->ruleValidator($this->request,$this->rules,$this->message);
    }

    /**
     * @param Request $request
     */
    public function visitor_apply_show()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if(!isTrueKey($P,'visitor_apply_id')){
            dieJson('2001', '参数错误');
        }
        $info = VisitorapplyModel::find($P, VisitorapplyModel::$fileds);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => VisitorapplyModel::$sql]);
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
    public function visitor_apply_lists(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(isset($P['visitor_apply_ids'])){
            $page = 0;
            $pagesize = 0;
        }else{
            $page = empty($P['page'])?1:$P['page'];
            $pagesize = empty($P['pagesize'])?20:$P['pagesize'];
        }
        unset($P['page']);
        unset($P['pagesize']);
        $inParams = [];
        if(isset($P['visitor_apply_ids'])){
            $inParams['visitor_apply_id'] = $P['visitor_apply_ids'];
            unset($P['visitor_apply_ids']);
        }
        if(isset($P['check_status_tag_ids'])){
            $inParams['check_status_tag_id'] = $P['check_status_tag_ids'];
            unset($P['check_status_tag_ids']);
        }
        if(isset($P['apply_status_tag_ids'])){
            $inParams['apply_status_tag_id'] = $P['apply_status_tag_ids'];
            unset($P['apply_status_tag_ids']);
        }
        $info = VisitorapplyModel::apply_list($P,VisitorapplyModel::$fileds,$inParams,['orderby'=>'visitor_apply_id','order'=>'desc'],$page,$pagesize);
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
    public function visitor_apply_count()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $inParams = [];
        if(isset($P['visitor_apply_ids'])){
            $inParams['visitor_apply_id'] = $P['visitor_apply_ids'];
            unset($P['visitor_apply_ids']);
        }
        if(isset($P['check_status_tag_ids'])){
            $inParams['check_status_tag_id'] = $P['check_status_tag_ids'];
            unset($P['check_status_tag_ids']);
        }
        if(isset($P['apply_status_tag_ids'])){
            $inParams['apply_status_tag_id'] = $P['apply_status_tag_ids'];
            unset($P['apply_status_tag_ids']);
        }
        $info = VisitorapplyModel::apply_count($P,$inParams);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => VisitorapplyModel::$sql]);
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
     * 账号注册
     */
    public function visitor_apply_add(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $check_params_info = checkParams($P, ['project_id','apply_user_id','apply_mobile']);
        if ($check_params_info === false) {
            dieJson(4001, '参数的数据类型错误');
        }
        if (is_array($check_params_info)) {
            dieJson(4001, implode('、', $check_params_info) . '参数缺失');
        }
        if(!isMobile($P['apply_mobile']) ){
            dieJson('2001','手机号码不合法');
        }
        $insertData = [
            'project_id'=>$P['project_id']??'',
            'house_id'=>$P['house_id']??'',
            'space_id'=>$P['space_id']??'',
            'cell_id'=>$P['cell_id']??'',
            'apply_user_id'=>$P['apply_user_id']??'',
            'apply_mobile'=>$P['apply_mobile']??'',
            'apply_identify_tag_id'=>$P['apply_identify_tag_id']??'',
            'apply_count'=>$P['apply_count']??'',
            'apply_days'=>$P['apply_days']??'',
            'apply_status_tag_id'=>$P['apply_status_tag_id']??'',
            'check_user_id'=>$P['check_user_id']??'',
            'check_employee_id'=>$P['check_employee_id']??'',
            'create_employee_id'=>$P['create_employee_id']??'',
            'create_user_id'=>$P['create_user_id']??'',
            'check_time'=>$P['check_time']??'',
            'expire_time'=>$P['expire_time']??'',
            'apply_source_tag_id'=>$P['apply_source_tag_id']??'',
            'tenement_mobile'=>$P['tenement_mobile']??'',
            'tenement_name'=>$P['tenement_name']??'',
            'plate'=>$P['plate']??'',
            'update_employee_id'=>$P['update_employee_id']??'',
            'face_resource_id'=>$P['face_resource_id']??'',
            'update_at'=>date('Y-m-d H:i:s', time()),
            'create_at'=>date('Y-m-d H:i:s', time()),
        ];
        $info = VisitorapplyModel::add($insertData);
        if($info === false){
            dieJson('2003','注册失败');
        }
        successJson($info,'注册成功');
    }

    /**
     * @param Request $request
     * 访客更新
     */
    public function visitor_apply_update(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if (!isTrueKey($P, 'visitor_apply_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 'visitor_apply_id')) {
            $where['visitor_apply_id'] = $P['visitor_apply_id'];
        }
        $P['update_at'] = date('Y-m-d H:i:s', time());
        $info = VisitorapplyModel::update($where, $P);
        if($info === false){
            dieJson('2003','更新失败');
        }
        successJson($info,'更新成功');
    }

    /**
     * @param Request $request
     */
    public function visitor_apply_del()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'visitor_apply_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 'visitor_apply_id')) {
            $where['visitor_apply_id'] = $P['visitor_apply_id'];
        }
        $info = VisitorapplyModel::del($where);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => VisitorapplyModel::$sql]);
        if ($info === false) {
            dieJson('2003', '删除失败');
        }
        successJson($info, '更新成功');
    }

    /**
     * @param Request $request
     */
    public function visitor_apply_generate()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $check_params_info = checkParams($P, ['apply_mobile','apply_name',
            'apply_user_id']);
        if ($check_params_info === false) {
            dieJson(4001, '参数的数据类型错误');
        }
        if (is_array($check_params_info)) {
            dieJson(4001, implode('、', $check_params_info) . '参数缺失');
        }
        $info = VisitorapplyModel::generate($P);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => VisitorapplyModel::$sql]);
        if ($info === false) {
            dieJson('2003', '添加失败');
        }
        successJson($info, '添加成功');
    }

    /**
     * @param Request $request
     * 访客申请记录审核
     */
    public function visitor_apply_check()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'visitor_apply_id','apply_status_tag_id')) {
            dieJson('2003', '参数错误');
        }
        $info = VisitorapplyModel::check($P);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => VisitorapplyModel::$sql]);
        if ($info === false) {
            dieJson('2003', '修改失败');
        }
        successJson($info, '修改成功');
    }
}
