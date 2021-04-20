<?php
/*
    进出场接口
    关联数据表 et_client
*/
namespace App\Http\Controllers;

use App\Http\Models\TenementcarModel;
use Illuminate\Http\Request;

class TenementcarController extends BaseController{

    public function __construct(Request $request)
    {
        $this->rules = [
            'driver_id' => 'numeric|digits_between:0,13',
            'user_id' => 'numeric|digits_between:0,13',
            'car_type_tag_id' => 'numeric|digits_between:0,13',
            'resource_id' => 'numeric|digits_between:0,13',
            'user_name' => 'alpha_dash|between:0,50',
            'plate' =>  array('regex:/^[a-zA-Z0-9_\p{Han}]+$/u','between:0,20'),
            'space_name' =>  array('regex:/^[a-zA-Z0-9_\p{Han}]+$/u','between:0,20'),
            'create_at' => 'date_format:Y-m-d H:i:s',
            'update_at' => 'date_format:Y-m-d H:i:s',
        ];
        $this->message = [
            "numeric" => ":attribute 格式不正确",
            "digits_between" => ":attribute 长度超标",
            "between" => ":attribute 长度超标",
            'ip'=>'不合法的ip格式',
            "alpha_dash" =>":attribute 必须为字母、数字、下划线组合",
            'date_format'=>'不合法的时间格式',
            "space_name.regex"=>":attribute  必须为汉字、字母、数字、中划线、下划线组合",
            "plate.regex"=>":attribute  必须为汉字、字母、数字、中划线、下划线组合",
        ];
        $this->request = $request->input();
        $paramsList = ['driver_ids','driver_id','tenement_id','tenement_ids','user_id','space_name','plate','user_name','car_type_tag_id','rule','resource_id',
            'update_at','update_at','page','pagesize','plate_f'];
        $this->valiParams($this->request, $paramsList);
        $this->ruleValidator($this->request,$this->rules,$this->message);
    }

    /**
     * @param Request $request
     * et_wechat_user表查找数据
     */
    public function tenementcar_lists(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $page = empty($P['page'])?1:$P['page'];
        $pagesize = empty($P['pagesize'])?20:$P['pagesize'];
        unset($P['page']);
        unset($P['pagesize']);
        $inParams = [];
        if(isset($P['driver_ids'])){
            $inParams['driver_id'] = $P['driver_ids'];
            unset($P['driver_ids']);
        }
        $like_params = [];
        if( isset($P['plate_f']) ){
            $like_params['plate'] = $P['plate_f'];
            unset($P['plate_f']);
        }
        $info = TenementcarModel::find($P,TenementcarModel::$fileds,$inParams,'',$page,$pagesize,[],[],$like_params);
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        if($info === false){
            dieJson('2002','查询失败');
        }
        if(empty($info)){
            successJson([],'查询成功');
        }
        successJson($info,'查询成功');
    }

}
