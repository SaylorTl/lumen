<?php
/*
    进出场接口
    关联数据表 et_client
*/
namespace App\Http\Controllers;

use App\Http\Models\VisitorcarModel;
use Illuminate\Http\Request;

class VisitorcarController extends BaseController{

    public function __construct(Request $request)
    {
        $this->rules = [
            'plate' =>  array('regex:/^[a-zA-Z0-9_\p{Han}]+$/u','between:0,20'),
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
        $this->ruleValidator($this->request,$this->rules,$this->message);
    }

    public function visitorcar_lists(){
        $P = $this->request;
        app('log')->info('---'.__CLASS__.'_'.__FUNCTION__.'----',[$P]);
        $page = empty($P['page'])?1:$P['page'];
        $pagesize = empty($P['pagesize'])?20:$P['pagesize'];
        unset($P['page']);
        unset($P['pagesize']);
        $inParams = [];
        if(isset($P['visit_car_ids'])){
            $inParams['visit_car_id'] = $P['visit_car_ids'];
            unset($P['visit_car_ids']);
        }
        $like_params = [];
        if( isset($P['plate_f']) ){
            $like_params['plate'] = $P['plate_f'];
            unset($P['plate_f']);
        }
        $info = VisitorcarModel::find($P,VisitorcarModel::$fileds,$inParams,'',$page,$pagesize,[],[],$like_params);
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
