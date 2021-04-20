<?php
/*
    进出场接口
    关联数据表 et_client
*/
namespace App\Http\Controllers;

use App\Http\Models\EmployeeextModel;
use App\Http\Models\MemberModel;
use Illuminate\Http\Request;

class EmployeeextController extends BaseController{

    public function __construct(Request $request)
    {
        $this->rules = [
            'employee_id' => 'numeric|digits_between:0,25',
            'create_at' => 'date_format:Y-m-d H:i:s',
            'update_at' => 'date_format:Y-m-d H:i:s',
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
            "remark.regex"=>"备注输入字符不合法",
        ];
        $this->request = $request->input();
        $this->ruleValidator($this->request,$this->rules,$this->message);
    }
    /**
     * @param Request $request
     * 更新et_wechat_user
     */
    public function employeeext_update()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'epy_ext_id')&&!isTrueKey($P, 'employee_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 'epy_ext_id')) {
            $where['epy_ext_id'] = $P['epy_ext_id'];
        }
        if (isTrueKey($P, 'employee_id')) {
            $where['employee_id'] = $P['employee_id'];
        }
        $P['update_at'] = date('Y-m-d H:i:s', time());
        $info = EmployeeextModel::update($where, $P);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => MemberModel::$sql]);
        if ($info === false) {
            dieJson('2003', '更新失败');
        }
        successJson($info, '更新成功');
    }
}
