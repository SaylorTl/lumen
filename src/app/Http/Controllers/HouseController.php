<?php
/*
    进出场接口
    关联数据表 et_client
*/
namespace App\Http\Controllers;

use App\Http\Models\HouseModel;
use Illuminate\Http\Request;

class HouseController extends BaseController
{

    public function __construct(Request $request)
    {
        $this->rules = [
            'create_at' => 'date_format:Y-m-d H:i:s',
            'update_at' => 'date_format:Y-m-d H:i:s',
        ];
        $this->message = [
            "numeric" => ":attribute 格式不正确",
            "digits_between" => ":attribute 长度超标",
            "between" => ":attribute 长度超标",
            'ip' => '不合法的ip格式',
            "alpha_dash" => ":attribute 必须为字母、数字、下划线组合",
            'date_format' => '不合法的时间格式'
        ];
        $this->request = $request->input();
        $this->ruleValidator($this->request, $this->rules, $this->message);
    }

    /**
     * @param Request $request
     * et_wechat_user表查找数据
     */
    public function house_show()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 't_house_id')) {
            dieJson('2001', '参数错误');
        }
        $P['is_del'] = 'N';
        $info = HouseModel::findOne($P, HouseModel::$fileds);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => HouseModel::$sql]);
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
    public function house_lists()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $inParams = [];
        if (isTrueKey($P,'tenement_ids') || isTrueKey($P,'house_ids')) {
            $page = 0;
            $pagesize = 0;
        }else{
            $page = empty($P['page'])?1:$P['page'];
            $pagesize = empty($P['pagesize'])?20:$P['pagesize'];
        }
        if(isTrueKey($P,'house_ids')){
            $inParams['house_id'] = $P['house_ids'];
            unset($P['house_ids']);
        }
        if(isTrueKey($P,'tenement_ids')){
            $inParams['tenement_id'] = $P['tenement_ids'];
            unset($P['tenement_ids']);
        }
        if(isTrueKey($P,'all_house_ids')){
            $inParams['house_id'] = $P['all_house_ids'];
            unset($P['all_house_ids']);
        }
        if(isTrueKey($P,'all_tenement_ids')){
            $inParams['tenement_id'] = $P['all_tenement_ids'];
            unset($P['all_tenement_ids']);
        }

        unset($P['page']);
        unset($P['pagesize']);
        $P['is_del'] = 'N';
        $info = HouseModel::HouseLists($P, HouseModel::$fileds, $inParams, '', $page, $pagesize);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [HouseModel::$sql]);
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
    public function tenement_house_lists()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $inParams = [];
        if (isTrueKey($P,'tenement_ids') || isTrueKey($P,'house_ids')) {
            $page = 0;
            $pagesize = 0;
        }else{
            $page = !isset($P['page'])?1:$P['page'];
            $pagesize = !isset($P['pagesize'])?20:$P['pagesize'];
        }
        if(isTrueKey($P,'house_ids')){
            $inParams['house_id'] = $P['house_ids'];
            unset($P['house_ids']);
        }
        if(isTrueKey($P,'tenement_ids')){
            $inParams['tenement_id'] = $P['tenement_ids'];
            unset($P['tenement_ids']);
        }
        if(isTrueKey($P,'all_house_ids')){
            $inParams['house_id'] = $P['all_house_ids'];
            unset($P['all_house_ids']);
        }
        if(isTrueKey($P,'all_tenement_ids')){
            $inParams['tenement_id'] = $P['all_tenement_ids'];
            unset($P['all_tenement_ids']);
        }
        unset($P['page']);
        unset($P['pagesize']);
        if(!empty($P['is_del'])){
            if($P['is_del'] == "all"){
                unset($P['is_del']);
            }
        }else{
            $P['is_del'] = 'N';
        }
        $info = HouseModel::TenementHouseLists($P, HouseModel::$fileds, $inParams, '', $page, $pagesize);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [HouseModel::$sql]);
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
    public function house_count()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        $inParams = [];
        if (isset($P['house_ids'])) {
            $inParams['house_id'] = $P['house_ids'];
            unset($P['house_ids']);
        }
        if (isset($P['tenement_ids'])) {
            $inParams['tenement_id'] = $P['tenement_ids'];
            unset($P['tenement_ids']);
        }
        if(isTrueKey($P,'all_house_ids')){
            $inParams['house_id'] = $P['all_house_ids'];
            unset($P['all_house_ids']);
        }
        if(isTrueKey($P,'all_tenement_ids')){
            $inParams['tenement_id'] = $P['all_tenement_ids'];
            unset($P['all_tenement_ids']);
        }
        $P['is_del'] = 'N';
        $info = HouseModel::count($P,$inParams);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => HouseModel::$sql]);
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
     * 更新et_wechat_user
     */
    public function house_add()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 'tenement_id','house_id')) {
            dieJson('2003', '参数错误');
        }
        $tenementHouseData = [
            'tenement_id'=>$P['tenement_id'],
            'house_id'=>$P['house_id'] ,
            'tenement_house_status'=>isset($P['tenement_house_status']) ? $P['tenement_house_status'] : 'N' ,
            'tenement_identify_tag_id'=>isset($P['tenement_identify_tag_id']) ? $P['tenement_identify_tag_id'] : '0' ,
            'out_time'=>isset($P['out_time']) ? $P['out_time'] : '0' ,
            'in_time'=>isset($P['in_time']) ? $P['in_time'] : '0' ,
            'cell_id'=>isset($P['cell_id']) ? $P['cell_id'] : '' ,
            'create_at'=>date('Y-m-d H:i:s',time()),
            'update_at'=>date('Y-m-d H:i:s',time()),];
        $info = HouseModel::HouseAdd($tenementHouseData);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => HouseModel::$sql]);
        if ($info === false) {
            dieJson('2003', '添加失败');
        }
        app('redis')->lpush("device_update", json_encode(["tenement_id"=>$P['tenement_id']]));
        successJson($info, '添加成功');
    }

    /**
     * @param Request $request
     * 更新et_wechat_user
     */
    public function house_update()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);
        if (!isTrueKey($P, 't_house_id','tenement_id','house_id')) {
            dieJson('2003', '参数错误');
        }
        $where = [];
        if (isTrueKey($P, 't_house_id')) {
            $where['t_house_id'] = $P['t_house_id'];
        }
        if (isTrueKey($P, 'house_id')) {
            $where['house_id'] = $P['house_id'];
        }
        if (isTrueKey($P, 'tenement_id')) {
            $where['tenement_id'] = $P['tenement_id'];
        }
        $P['update_at'] = date('Y-m-d H:i:s', time());
        $info = HouseModel::HouseUpdate($P);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => HouseModel::$sql]);
        if ($info === false) {
            dieJson('2003', '更新失败');
        }
        app('redis')->lpush("device_update", json_encode(["tenement_id"=>$P['tenement_id']]));
        successJson($info, '更新成功');
    }

    /**
     * @param Request $request
     * 更新et_wechat_user
     */
    public function house_del()
    {
        $P = $this->request;
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', [$P]);

        $where = [];
        $inParams = [];
        if (isTrueKey($P, 't_house_id')) {
            $where['t_house_id'] = $P['t_house_id'];
        }
        if (isset($P['t_house_ids'])) {
            $inParams['t_house_id'] = $P['t_house_ids'];
        }

        if ( empty($where) && empty($inParams) ) {
            dieJson('2003', '参数错误');
        }

        $info = HouseModel::del($where,$inParams);
        app('log')->info('---' . __CLASS__ . '_' . __FUNCTION__ . '----', ['sql' => HouseModel::$sql]);
        if ($info === false) {
            dieJson('2003', '删除失败');
        }
        successJson($info, '更新成功');
    }

}


