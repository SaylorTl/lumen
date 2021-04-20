<?php
namespace App\Http\Controllers;

use App\Http\Models\UserextModel;
use Illuminate\Http\Request;

class UserextController extends BaseController{

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
    public function user_ext_add(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $check_params_info = checkParams($P, ['user_id','user_ext_tag_id','detail']);
        if ($check_params_info === false) {
            dieJson(4001, '参数的数据类型错误');
        }
        if (is_array($check_params_info)) {
            dieJson(4001, implode('、', $check_params_info) . '参数缺失');
        }
        $userext_res = UserextModel::find(['user_id'=>$P['user_id'],'user_ext_tag_id'=>$P['user_ext_tag_id'],'detail'=>$P['detail']]);
        if(!empty($userext_res)){
            dieJson('2003','该记录已存在');
        }
        $insertData = [
            'user_id'=>$P['user_id']??'',
            'user_ext_tag_id'=>$P['user_ext_tag_id']??'',
            'detail'=>$P['detail']??'',
            'create_at'=>date('Y-m-d H:i:s', time()),
            'update_at'=>date('Y-m-d H:i:s', time())
        ];
        $info = UserextModel::add($insertData);
        if($info === false){
            dieJson('2003','添加失败');
        }
        successJson($info,'添加成功');
    }

    /**
     * @param Request $request
     * 访客更新
     */
    public function user_ext_update(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if (!isTrueKey($P, 'user_ext_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 'user_ext_id')) {
            $where['user_ext_id'] = $P['user_ext_id'];
        }
        $userext_res = UserextModel::find(['user_ext_id'=>$P['user_ext_id']]);
        if(empty($userext_show_res)){
            dieJson('2003','该记录不存在');
        }
        $user_id = empty($P['user_id'])?$userext_res['user_id']:$P['user_id'];
        $user_ext_tag_id = empty($P['user_ext_tag_id'])?$userext_res['user_ext_tag_id']:$P['user_ext_tag_id'];
        $detail = empty($P['detail'])?$userext_res['detail']:$P['detail'];
        $userext_show_res = UserextModel::find(['user_id'=>$user_id,'user_ext_tag_id'=>$user_ext_tag_id,'detail'=>$detail]);
        if(!empty($userext_show_res)){
            dieJson('2003','该记录已存在');
        }
        $P['update_at'] = date('Y-m-d H:i:s', time());
        $info = UserextModel::update($where,$P);
        if($info === false){
            dieJson('2003','更新失败');
        }
        successJson($info,'更新成功');
    }

    /**
     * @param Request $request
     */
    public function user_ext_del()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'user_ext_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 'user_ext_id')) {
            $where['user_ext_id'] = $P['user_ext_id'];
        }
        $info = UserextModel::del($where);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => UserextModel::$sql]);
        if ($info === false) {
            dieJson('2003', '删除失败');
        }
        successJson($info, '更新成功');
    }

    /**
     * @param Request $request
     */
    public function user_ext_show()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if(!isTrueKey($P,'user_ext_id')){
            dieJson('2001', '参数错误');
        }
        $info = UserextModel::findone($P, UserextModel::$fileds);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => UserextModel::$sql]);
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
    public function user_ext_lists(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(isset($P['user_ext_ids'])){
            $page = 0;
            $pagesize = 0;
        }else{
            $page = empty($P['page'])?1:$P['page'];
            $pagesize = empty($P['pagesize'])?20:$P['pagesize'];
        }
        unset($P['page']);
        unset($P['pagesize']);
        $inParams = [];
        if(isset($P['user_ext_ids'])){
            $inParams['user_ext_id'] = $P['user_ext_ids'];
            unset($P['user_ext_ids']);
        }
        $info = UserextModel::find($P,UserextModel::$fileds,$inParams,'',$page,$pagesize);
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
    public function user_ext_count()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $inParams = [];
        if(isset($P['user_ext_ids'])){
            $inParams['user_ext_id'] = $P['user_ext_ids'];
            unset($P['user_ext_ids']);
        }
        $info = UserextModel::count($P,$inParams);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => UserextModel::$sql]);
        if ($info === false) {
            dieJson('2003', '查询失败');
        }
        if (empty($info)) {
            successJson('', '查询成功');
        }
        successJson($info, '查询成功');
    }

}
