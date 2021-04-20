<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/1
 * Time: 9:46
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Services\ResponseService as Response;

class BaseController{

    protected $request;

    protected $rules;

    protected $message;

    protected $fileds;

    /**
     * 参数验证
     * @param Request $request
     * @param array $rule
     * @param array $message
     * @return array|null|string
     */
    public function ruleValidator($request, $rule=[], $message=[])
    {
        try{
            $validator = Validator::make($request, $rule, $message);
            if($validator->fails()){
                $messages = $validator->messages();
                if(count($messages) != 0){
                    throw new \Exception(current(current($messages))[0]);
                }
            }
            return null;
        }catch (\Exception $e){
            dieJson('2007',$e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function valiParams($params,$fileds)
    {
        foreach($params as $key=>$value){
            if(!in_array($key,$fileds)){
                dieJson('2006',$key.'参数错误');
            }
        }
    }

}