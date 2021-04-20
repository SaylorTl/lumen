<?php
namespace App\Http\Controllers;

use App\Http\Models\UserdeviceModel;
use App\Http\Models\VisitordeviceModel;
use Illuminate\Http\Request;

class VisitordeviceController extends BaseController{

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
     * 账号注册
     */
    public function visitor_device_add(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $check_params_info = checkParams($P, ['visitor_apply_id','user_id','device_id']);
        if ($check_params_info === false) {
            dieJson(4001, '参数的数据类型错误');
        }
        if (is_array($check_params_info)) {
            dieJson(4001, implode('、', $check_params_info) . '参数缺失');
        }
        $insertData = [
            'visitor_apply_id'=>$P['visitor_apply_id']??'',
            'tenement_user_id' => $P['tenement_user_id'] ?? '',
            'house_id' => $P['house_id'] ?? '',
            'valid_count'=>!empty($P['valid_count'])?$P['valid_count']:'99999',
            'expire_time'=>$P['expire_time']??'',
            'project_id'=>$P['project_id']??'',
            'user_id'=>$P['user_id']??'',
            'device_id'=>$P['device_id']??'',
            'device_template_type_tag_id' =>$P['device_template_type_tag_id']??'',
            'last_use_time'=>date('Y-m-d H:i:s', time()),
            'create_at'=>date('Y-m-d H:i:s', time()),
            'update_at'=>date('Y-m-d H:i:s', time())
        ];
        $info = VisitordeviceModel::add($insertData);
        if($info === false){
            dieJson('2003','注册失败');
        }
        successJson($info,'注册成功');
    }

    /**
     * @param Request $request
     * 访客更新
     */
    public function visitor_device_update(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if (!isTrueKey($P, 'visitor_device_id') && !isTrueKey($P, 'visitor_apply_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 'visitor_device_id')) {
            $where['visitor_device_id'] = $P['visitor_device_id'];
        }
        if (isTrueKey($P, 'visitor_apply_id')) {
            $where['visitor_apply_id'] = $P['visitor_apply_id'];
        }
        $P['update_at'] = date('Y-m-d H:i:s', time());
        $info = VisitordeviceModel::update($where,$P);
        if($info === false){
            dieJson('2003','更新失败');
        }
        successJson($info,'更新成功');
    }

    /**
     * @param Request $request
     */
    public function visitor_device_del()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'visitor_device_id') && !isTrueKey($P, 'visitor_apply_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 'visitor_device_id')) {
            $where['visitor_device_id'] = $P['visitor_device_id'];
        }
        if (isTrueKey($P, 'visitor_apply_id')) {
            $where['visitor_apply_id'] = $P['visitor_apply_id'];
        }
        $info = VisitordeviceModel::del($where);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => VisitordeviceModel::$sql]);
        if ($info === false) {
            dieJson('2003', '删除失败');
        }
        successJson($info, '更新成功');
    }

    /**
     * @param Request $request
     */
    public function visitor_device_show()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'visitor_device_id')) {
            dieJson('2003', '参数错误');
        }
        $info = VisitordeviceModel::findone($P, VisitordeviceModel::$fileds);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => VisitordeviceModel::$sql]);
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
    public function visitor_device_lists(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(isset($P['visitor_device_ids']) || isset($P['visitor_apply_id'])  || isset($P['visitor_apply_ids'])){
            $page = 0;
            $pagesize = 0;
        }else{
            $page = empty($P['page'])?1:$P['page'];
            $pagesize = empty($P['pagesize'])?20:$P['pagesize'];
        }
        unset($P['page']);
        unset($P['pagesize']);
        $inParams = [];
        if(isset($P['visitor_device_ids'])){
            $inParams['visitor_device_id'] = $P['visitor_device_ids'];
            unset($P['visitor_device_ids']);
        }
        if(isset($P['visitor_apply_ids'])){
            $inParams['visitor_apply_id'] = $P['visitor_apply_ids'];
            unset($P['visitor_apply_ids']);
        }
        $info = VisitordeviceModel::find($P,VisitordeviceModel::$fileds,$inParams,'',$page,$pagesize);
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
    public function visitor_device_count()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $inParams = [];
        if(isset($P['visitor_device_ids'])){
            $inParams['visitor_device_id'] = $P['visitor_device_ids'];
            unset($P['visitor_device_ids']);
        }
        $info = VisitordeviceModel::count($P,$inParams);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => VisitordeviceModel::$sql]);
        if ($info === false) {
            dieJson('2003', '查询失败');
        }
        if (empty($info)) {
            successJson('', '查询成功');
        }
    }

    /**
     * @param Request $request
     */
    public function visitor_device_listen()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $result  = VisitordeviceModel::userVisitorEvent();
        if ($result === false) {
            dieJson('2003', '访客设备初始失败');
        }
        successJson('', '访客设备初始成功');
    }

    /**
     * @param Request $request
     */
    public function visitor_apply_listen()
    {
        $P = $this->request;
        if (!isTrueKey($P, 'visitor_apply_id')) {
            dieJson('2003', '参数错误');
        }
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $res = VisitordeviceModel::updateVisitorDevice($P);
        if ($res === false) {
            dieJson('2003', '设备修改失败');
        }
        successJson('', '设备修改失败');
    }

    public function visitor_device_watch()
    {
        $P = $this->request;
        $info = VisitordeviceModel::visitorDeviceWatch($P);
        app('log')->info('---' . __CLASS__ . '_user_device_listen-000---', ['sql' => VisitordeviceModel::$sql]);
        if ($info === false) {
            dieJson('2003', '更新失败');
        }
        successJson($info, '更新成功');
    }

    /**
     * @param Request $request
     * 访客更新
     */
    public function visitor_device_use(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if (!isTrueKey($P, 'project_id') || !isTrueKey($P, 'user_id')|| !isTrueKey($P, 'device_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        $where['project_id'] = $P['project_id'];
        $where['user_id'] = $P['user_id'];
        $where['device_id'] = $P['device_id'];
        $last_use_time = date('Y-m-d H:i:s', time());
        $userdevice_update_res = UserdeviceModel::update($where,['last_use_time'=>$last_use_time]);
        if (false === $userdevice_update_res) {
            app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '111----', [$where]);
            dieJson('2003', '访客设备使用时间更新失败');
        }
        $use_device_res = UserdeviceModel::findone($where,UserdeviceModel::$fileds);
        if (!empty($use_device_res)) {
            app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '222----', [$where]);
            successJson(['device_type'=>'user','valid_count'=>0],'更新成功');
        }
        $result = VisitordeviceModel::findone($where, VisitordeviceModel::$fileds);
        if (empty($result)) {
            app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '333----', [$where]);
            successJson(['device_type'=>'visitor','valid_count'=>0],'更新成功');
        }
        $updateData=[];
        $updateData['valid_count'] =  (int)$result[0]['valid_count']-1;
        $updateData['update_at'] = date('Y-m-d H:i:s', time());
        $info = VisitordeviceModel::update(['visitor_apply_id'=>$result[0]['visitor_apply_id']],$updateData);
        if($info === false){
            app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '444----', [$info]);
            dieJson('2003','更新访客使用次数失败');
        }
        if((int)$updateData['valid_count'] ==0){
            VisitordeviceModel::updateVisitorDevice(['visitor_apply_id'=>$result[0]['visitor_apply_id']]);
            app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '555----', [$updateData]);
            successJson(['device_type'=>'visitor','valid_count'=>$updateData['valid_count']],'更新成功');
        }
        $visitor_update_res = VisitordeviceModel::update(['visitor_apply_id'=>$result[0]['visitor_apply_id'],'device_id'=>$P['device_id']],
            ['last_use_time'=>$last_use_time]);
        if (false === $visitor_update_res) {
            app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '666----', [$P]);
            dieJson('2003', '访客设备使用时间更新失败');
        }
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '777----', [$updateData]);
        successJson(['device_type'=>'visitor','valid_count'=>$updateData['valid_count']],'更新成功');
    }

}
