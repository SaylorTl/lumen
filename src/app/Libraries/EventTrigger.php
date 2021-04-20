<?php

namespace App\Libraries;

use Exception;

/**
 * 事件触发器
 * Class Comm_EventTrigger
 */
class EventTrigger
{
    /**
     * 推送到事件触发器
     * @param  string  $event_name  事件名称（事件需要提前注册）
     * @param  array  $data  推送数据
     * @return bool
     */
    public static function push($event_name, $data)
    {
        
        try {
            $event_name = trim($event_name);
            if (!$event_name) {
                info(__METHOD__, ['error' => '事件名称错误', 'event_name' => $event_name,]);
                return false;
            }
            $sign = self::signature($data);
            if (!$sign) {
                return false;
            }
            $event_trigger_url = env('EVENT_TRIGGER_URL', '');
            $result = (new Request())->post($event_trigger_url.'/event?evt_name='.$event_name.'&evt_token='.$sign,
                $data, true, 1);
            info(__METHOD__, ['result' => $result, 'sign' => $sign, 'data' => $data]);
            if (!isset($result['code']) || $result['code'] != 0) {
                info(__METHOD__, ['error' => '事件发布失败','msg'=>$result['msg']]);
                return false;
            }
            info(__METHOD__, ['msg' => '事件已发布', 'result' => $result]);
            return true;
        } catch (Exception $e) {
            info(__METHOD__, [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
    
    /**
     * 签名
     * @param $data
     */
    private static function signature($data)
    {
        try {
            $evt_key = env('EVENT_TRIGGER_KEY', '');
            $evt_secret = env('EVENT_TRIGGER_SECRET', '');
            if (!$evt_key || !$evt_secret) {
                info(__METHOD__, ['error' => 'EVENT_TRIGGER_KEY 或 EVENT_TRIGGER_SECRET 配置缺失']);
                return false;
            }
            $data['evt_key'] = $evt_key;
            ksort($data);
            $str = '';
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    continue;
                } else {
                    $str .= $key.'='.$value.'&';
                }
            }
            $str .= 'evt_secret='.$evt_secret;
            return md5(trim($str));
        } catch (Exception $e) {
            info(__METHOD__, [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}