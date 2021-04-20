<?php
namespace App\Http\Controllers;

use App\Http\Models\TenementModel;
use App\Http\Models\UserdeviceModel;
use App\Http\Models\VisitorapplyModel;
use App\Http\Models\VisitordeviceModel;
use App\Http\Models\HouseModel;
use Illuminate\Http\Request;

class UserdeviceController extends BaseController{

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
    public function user_device_add(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $check_params_info = checkParams($P, ['user_id','device_id']);
        if ($check_params_info === false) {
            dieJson(4001, '参数的数据类型错误');
        }
        if (is_array($check_params_info)) {
            dieJson(4001, implode('、', $check_params_info) . '参数缺失');
        }
        $insertData = [
            'project_id'=>$P['project_id']??'',
            'house_id'=>$P['house_id']??'',
            'user_id'=>$P['user_id']??'',
            'device_id'=>$P['device_id']??'',
            'device_template_type_tag_id' =>$P['device_template_type_tag_id']??'',
            'create_at'=>date('Y-m-d H:i:s', time()),
            'update_at'=>date('Y-m-d H:i:s', time())
        ];
        $info = UserdeviceModel::add($insertData);
        if($info === false){
            dieJson('2003','添加失败');
        }
        successJson($info,'添加成功');
    }

    /**
     * @param Request $request
     * 访客更新
     */
    public function user_device_update(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if (!isTrueKey($P, 'user_device_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 'user_device_id')) {
            $where['user_device_id'] = $P['user_device_id'];
        }
        $P['update_at'] = date('Y-m-d H:i:s', time());
        $info = UserdeviceModel::update($where,$P);
        if($info === false){
            dieJson('2003','更新失败');
        }
        successJson($info,'更新成功');
    }

    /**
     * @param Request $request
     */
    public function user_device_del()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $where = [];
        if (isTrueKey($P, 'user_device_id')) {
            $where['user_device_id'] = $P['user_device_id'];
        }
        if (isTrueKey($P, 'user_id')) {
            $where['user_id'] = $P['user_id'];
        }
        if (isTrueKey($P, 'house_id')) {
            $where['house_id'] = $P['house_id'];
        }
        $whereIn = [];
        if (isTrueKey($P, 'tenement_id')) {
            $Housearr = HouseModel::find(['tenement_id'=>$P['tenement_id']]);
            if(empty($Housearr)){
                dieJson('2003','房屋信息查询失败');
            }
            $whereIn['house_id'] = array_column($Housearr,'house_id');
            unset($P['tenement_id']);
        }
        if(isset($P['house_ids'])){
            $whereIn['house_id'] = $P['house_ids'];
            unset($P['house_ids']);
        }
        if(empty($where)&&empty($whereIn)){
            dieJson('2003', '参数错误');
        }
        $info = UserdeviceModel::del($where,$whereIn);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => UserdeviceModel::$sql]);
        if ($info === false) {
            dieJson('2003', '删除失败');
        }
        successJson($info, '删除成功');
    }

    /**
     * @param Request $request
     */
    public function user_device_show()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if(isTrueKey($P,'user_id','device_id') == false && !isTrueKey($P,'user_device_id')){
            dieJson('2001', '参数错误');
        }
        $info = UserdeviceModel::findone($P, UserdeviceModel::$fileds);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => UserdeviceModel::$sql]);
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
    public function user_device_lists(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(isset($P['user_device_ids'])){
            $page = 0;
            $pagesize = 0;
        }else{
            $page = empty($P['page'])?1:$P['page'];
            $pagesize = empty($P['pagesize'])?20:$P['pagesize'];
        }
        unset($P['page']);
        unset($P['pagesize']);
        $inParams = [];
        if(isset($P['user_device_ids'])){
            $inParams['user_device_id'] = $P['user_device_ids'];
            unset($P['user_device_ids']);
        }
        $info = UserdeviceModel::find($P,UserdeviceModel::$fileds,$inParams,'',$page,$pagesize);
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
    public function user_device_count()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $inParams = [];
        if(isset($P['user_device_ids'])){
            $inParams['user_device_id'] = $P['user_device_ids'];
            unset($P['user_device_ids']);
        }
        $info = UserdeviceModel::count($P,$inParams);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => UserdeviceModel::$sql]);
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
     */
    public function user_merge_visitor_device()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if(isTrueKey($P,'user_id') == false && isTrueKey($P,'project_id') == false  && isTrueKey($P,'user_ids') == false){
            dieJson('2001', '参数错误');
        }
        $inParams = [];
        if(isset($P['user_ids'])){
            $inParams['user_id'] = $P['user_ids'];
            unset($P['user_ids']);
        }
        $all_device = UserdeviceModel::userMergeVisitorDevice($P,$inParams);
        if($all_device === false){
            dieJson('2001', '查询失败');
        }
        if (empty($all_device)) {
            successJson([], '查询成功');
        }
        successJson($all_device, '查询成功');
    }

    public function user_device_listen()
    {
        $P = $this->request;
        $info = UserdeviceModel::userDeviceListen($P);
        app('log')->info('---' . __CLASS__ . '_user_device_listen-000---', ['sql' => UserdeviceModel::$sql]);
        if ($info === false) {
            dieJson('2003', '更新失败');
        }
        successJson($info, '更新成功');
    }

}
