<?php
/*
    进出场接口
    关联数据表 et_client
*/
namespace App\Http\Controllers;

use App\Http\Models\LisenceModel;
use Illuminate\Http\Request;

class LisenceController extends BaseController{

    public function __construct(Request $request)
    {
        $this->rules = [
            'liscence_id' => 'numeric|digits_between:0,13',
            'user_id' => 'numeric|digits_between:0,13',
            'liscense_type' => 'numeric|digits_between:0,5',
            'resource_id' => 'numeric|digits_between:0,20',
            'create_at' => 'date_format:Y-m-d H:i:s',
            'update_at' => 'date_format:Y-m-d H:i:s',
        ];
        $this->message = [
            "numeric" => ":attribute 格式不正确",
            "digits_between" => ":attribute 长度超标",
            "between" => ":attribute 长度超标",
            "alpha"=>":attribute 必须为字母组合",
            'date_format'=>'不合法的时间格式'
        ];
        $this->request = $request->input();
        $paramsList =  ['liscence_ids','user_ids','liscence_id','user_id','liscense_type','resource_id','verify',
            'update_at','update_at'];
        $this->valiParams($this->request, $paramsList);
        $this->ruleValidator($this->request,$this->rules,$this->message);
    }

    /**
     * @param Request $request
     * et_wechat_user表查找数据
     */
    public function lisence_show(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(!isTrueKey($P,'liscence_id')){
            dieJson('2001','参数错误');
        }
        $info = LisenceModel::findOne($P,LisenceModel::$fileds);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>LisenceModel::$sql]);
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
    public function lisence_lists(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $page = empty($P['page'])?1:$P['page'];
        $pagesize = empty($P['pagesize'])?20:$P['pagesize'];
        unset($P['page']);
        unset($P['pagesize']);
        $inParams = [];
        if(isset($P['user_ids'])){
            $inParams['user_id'] = $P['user_ids'];
            unset($P['user_ids']);
        }
        if(isset($P['liscence_ids'])){
            $inParams['liscence_id'] = $P['liscence_ids'];
            unset($P['liscence_ids']);
        }
        $info = LisenceModel::find($P,LisenceModel::$fileds,$inParams,'',$page,$pagesize);
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
    public function lisence_count(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $info = LisenceModel::count($P);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>LisenceModel::$sql]);
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
    public function lisence_add(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(!isTrueKey($P,'user_id')){
            dieJson('2002','user_id不能为空');
        }
        if(!isTrueKey($P,'resource_id')){
            dieJson('2002','resource_id不能为空');
        }
        $insertData = [
            'user_id'=>$P['user_id'],
            'liscense_type'=> isset($P['liscense_type']) ? $P['liscense_type'] : 1 ,
            'resource_id'=>$P['resource_id'],
            'create_at'=>date('Y-m-d H:i:s',time()),
            'update_at'=>date('Y-m-d H:i:s',time()),
            ];

        $info = LisenceModel::add($insertData);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if($info === false){
            dieJson('2003','添加失败');
        }
        successJson($info,'添加成功');
    }

    /**
     * @param Request $request
     * 更新et_wechat_user
     */
    public function lisence_update(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(!isTrueKey($P,'resource_id')){
            dieJson('2003','参数错误');
        }
        $where= [];
        if(isTrueKey($P,'resource_id')){
            $where['resource_id'] = $P['resource_id'];
        }
        $P['update_at'] = date('Y-m-d H:i:s',time());
        $info = LisenceModel::update($where,$P);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>LisenceModel::$sql]);
        if($info === false){
            dieJson('2003','更新失败');
        }
        successJson($info,'更新成功');
    }

    /**
     * @param Request $request
     * 更新et_wechat_user
     */
    public function lisence_del(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if(!isTrueKey($P,'resource_id')){
            dieJson('2003','参数错误');
        }
        $where= [];
        if(isTrueKey($P,'resource_id')){
            $where['resource_id'] = $P['resource_id'];
        }
        $info = LisenceModel::del($where);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',['sql'=>LisenceModel::$sql]);
        if($info === false){
            dieJson('2003','删除失败');
        }
        successJson($info,'更新成功');
    }
}
