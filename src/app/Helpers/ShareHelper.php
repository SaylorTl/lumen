<?php
/**
 * Created by PhpStorm.
 * User: austin
 * Date: 3/16/16
 * Time: 4:38 下午
 */

use App\Libraries\LumenTracer;

require_once __DIR__ . '/GlobalConfig.php';//通用方法

if(! function_exists('sign')){
    function sign($data,$secret){
        ksort($data);
        $str = '';
        foreach($data as $k => $v) {
            $str .=  ($str == '' ? '' : '&') . $k . '=' . urlencode($v);
        }
        return md5($str."&secret=".$secret);
    }
}

if(! function_exists('isTrueKey')){

    /**
     * @return bool
     * 检测数组array中的key是否存在且为真
     * isTrueKey($array,$key1,$key2,$key3,...)
     */
    function isTrueKey(){
        $num = func_num_args();
        if($num <= 1) return false;

        $arg = func_get_args();

        $result = true; $array = $arg[0];
        for($i = 1; $i < $num; $i++) {
            $key = $arg[$i];
            if( !isset($array[$key])){
                $result = false; break;
            }
        }
        return $result;
    }
}


function checkParams($params,$required_params){
    if( !is_array($params) || !is_array($required_params) ) return false;

    $params_keys = array_keys($params);

    if( array_intersect($required_params,$params_keys) != $required_params ){
        $missing = array_diff($required_params,$params_keys);
        if( !empty($missing) ) return $missing;
    }
    return true;
}

function checkEmptyParams($params,$required_params){
    if( !is_array($params) || !is_array($required_params) ){
        return false;
    }
    $missing = [];
    $params_keys = array_keys($params);
    if( array_intersect($required_params,$params_keys) != $required_params ){
        $missing = array_diff($required_params,$params_keys);
    }
    if( !empty($missing) ) return $missing;
    foreach($required_params as $value){
        if(!isset($params[$value])){
            $missing [] = $value;
        }
    }
    if( !empty($missing) ) return $missing;
    return true;
}

if (! function_exists('sharedb')) {
    function sharedb($dbname = 'mysql'){
        if($dbname!='mysql'){
            return app('db')->connection($dbname);
        }
        return app('db');
    }
}

if(!function_exists('shareCache')){
    function shareCache($index = 0){
        app('cache')->setPrefix('et');
        app('cache')->select($index);
        return app('cache');
    }
}

if(!function_exists('curlGet')){
    function curlGet($url){
        $ch = curl_init();
        $header[] = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $temp = curl_exec($ch);
        curl_close($ch);
        return $temp;
    }
}

if(!function_exists('curlPOST')){
    function curlPOST($url, $params, $header = ["Accept-Charset: utf-8"]){
        $data = is_array($params) ? http_build_query($params) : $params;
        $ch = curl_init();
        $header[] = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $temp = curl_exec($ch);
        curl_close($ch);
        return $temp;
    }
}

if(!function_exists('postCurl')){


    /**
     * 发起http 请求
     * @param        $url
     * @param array  $body
     * @param array  $header
     * @param string $method
     * @return bool|mixed
     */
    function postCurl($url, $body=array(), $header = array(), $method = "POST")
    {
        array_push($header, 'Accept:application/json');

        $ch = curl_init();//启动一个curl会话
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        switch ($method){
            case "GET" :
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                break;
            case "POST":
                curl_setopt($ch, CURLOPT_POST,true);
                break;
            case "PUT" :
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                break;
            case "DELETE":
                curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
        }

        curl_setopt($ch, CURLOPT_USERAGENT, 'SSTS Browser/1.0');
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  //原先是FALSE，可改为2
        if (count($body)>0) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($body));
        }
        if (count($header) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        $ret = curl_exec($ch);
        $err = curl_error($ch);


        curl_close($ch);

        if ($err) {
//			return $err;
            return false;
        }

        return $ret;
    }

}



if(!function_exists('generate_code')){

    /**生成随机的N位数字
     * @param int $length
     * @return int
     */
    function generate_code($length = 4) {
        return (int)str_pad(mt_rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    }

}


if(!function_exists('check_email')){


    /**校验email地址
     * @param $email
     * @return bool|mixed
     */
    function check_email($email){

        if(!$email){
            return false;
        }
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

}

if(!function_exists('check_url')){


    /**校验url地址
     * @param $email
     * @return bool|mixed
     */
    function check_url($url){

        if(!$url){
            return false;
        }
        return filter_var($url, FILTER_VALIDATE_URL);
    }

}

if(!function_exists('isMobile')){
    function isMobile($mobile){
        if(!$mobile) return false;
        return preg_match('/^20[\d]{9}$|^13[\d]{9}$|^14[5,7,9]{1}\d{8}$|^15[^4]{1}\d{8}$|^16[\d]{9}$|^17[\d]{9}$|^18[\d]{9}$|^19[\d]{9}$/', (String)$mobile) ? true : false;
    }
}
function isTel($tel)
{
    if (!$tel) return false;
//    return preg_match('/^[0-9]{3,4}(-)?[0-9]{7,8}$/', (String)$tel) ? true : false;

    $len = strlen($tel);
    if ($len < 8 || $len > 15) return false;
    $chars = [];
    for ($i = 0; $i < $len; $i++) {
        if (!in_array($tel[$i], [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]) && $tel[$i] !== '-') {
            return false;
        }
        if ($tel[$i] === '-') $chars[] = $tel[$i];
    }
    if (count($chars) > 1) return false;
    return true;
}
if(!function_exists('isPlate')){
    function isPlate($plate){

        if(preg_match("/^EP[0-9A-Z]{5}$/",$plate)) return true;
        $arr = preg_split("/([ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjklmnpqrstuvwxyz0123456789]+)/", (String)$plate, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $len = count($arr);
        $provine = ['京','沪','粤','津','冀','晋','蒙','辽','吉','黑','苏','浙','皖','闽','赣','鲁','鄂','豫','湘','桂','琼','渝','川','贵','云','藏','陕','甘','青','宁','新','使','彩'];
        $special = ['挂','学','警','港','澳','领'];
        if($len >= 2 && $len <= 3){
            $tmp = preg_split("/([OoIi]+)/", $arr[0], 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
            if(count($tmp) != 1 && count($tmp) != 2) return false;
            if(!in_array($tmp[0],$provine)) return false;
            if(count($tmp) == 1){
                if($len == 2){
                    if( strlen($arr[1]) != 6 && strlen($arr[1]) != 7 ) return false;
                }elseif($len == 3){
                    if(strlen($arr[1]) != 5 || !in_array($arr[2],$special)) return false;
                }
            }else{
                if($len == 2){
                    if( strlen($arr[1]) != 5 && strlen($arr[1]) != 6 ) return false;
                }elseif($len == 3){
                    if(strlen($arr[1]) != 4 || !in_array($arr[2],$special)) return false;
                }
            }
            return true;
        }
        return false;
    }
}

if( !function_exists('validateDate') ){
    /**
     * @function                validateDate          日期格式检测函数
     * @param        string     $date                 要检测的日期
     * @param        string     $format               期望的格式
     * @return       bool
     */
    function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}


if( !function_exists('getPaymethod') ){
    //rule中 paymethod权限值
    function getPaymethod(){
        $arr = [ 'APP'=>1,'iPos'=>2,'manual'=>4,'TCB'=>8,'CWB'=>16,'EFT'=>32 ];
        return $arr;
    }
}

if( !function_exists('randStr')){
    //生成随机车牌数
    function randStr($length){
        if($length<0) return false;
        $str = '1234567890abcdefghjklmnpqrstuvwxyz';
        $res = '';
        for($i=0;$i<5;$i++)
        {
            $res .= $str{mt_rand(0,33)};    //生成随机车牌
        }
        return $res;
    }
}


if(!function_exists('url_generate_code')){

    /**生成随机的N位数字
     * @param int $length
     * @return int
     */
    function url_generate_code($length = 4) {
        // 密码字符集，可任意添加你需要的字符
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $code = '';
        for ( $i = 0; $i < $length; $i++ ) {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            $code .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }

        return $code;
    }
}

if(!function_exists('set_log')) {
    /**
     * 设置jaeger log
     * @param  array  $array
     * @param  null  $timestamp
     */
    function set_log(array $array, $timestamp = null)
    {
        if (LumenTracer::checkSpan()) {
            config('span')->log($array, $timestamp);
        }
    }
}
if(!function_exists('set_tag')) {
    /**
     * 设置jaeger tag
     * @param  string  $key
     * @param $value
     */
    function set_tag($key, $value)
    {
        if (LumenTracer::checkSpan()) {
            config('span')->setTag($key, $value);
        }
    }
}
if(!function_exists('set_tags')) {
    /**
     * 设置jaeger tags
     * @param  array  $array
     */
    function set_tags(array $array)
    {
        if (LumenTracer::checkSpan()) {
            config('span')->setTags($array);
        }
    }
}
if (!function_exists('dieJson')) {
    function dieJson($error_code, $err_msg)
    {
        $data = [
            'trace_id' => '',
            'code' => $error_code,
            'message' => $err_msg,
            'content' => '',
        ];
        $span_info = config('span_info');
        if (isTrueKey($span_info, 'x-b3-traceid')) {
            $data['trace_id'] = $span_info['x-b3-traceid'];
        }
//        header('Content-type: application/json');
        echo json_encode($data);
        if (LumenTracer::checkSpan()) {
            config('span')->log(['code' => $error_code, 'message' => $err_msg,]);
            config('span')->finish();
        }
        if (LumenTracer::checkTracer()) {
            config('tracer')->flush();
        }
        die;
    }
}

if (!function_exists('successJson')) {
    function successJson($content, $msg = 'success')
    {
        $data = [
            'trace_id' => '',
            'code' => 0,
            'message' => $msg,
            'content' => $content
        ];
        $span_info = config('span_info');
        if (isTrueKey($span_info, 'x-b3-traceid')) {
            $data['trace_id'] = $span_info['x-b3-traceid'];
        }
        header('Content-type: application/json');
        echo json_encode($data);
        if (LumenTracer::checkSpan()) {
            config('span')->finish();
        }
        if (LumenTracer::checkTracer()) {
            config('tracer')->flush();
        }
        die;
    }
}

if (!function_exists('unsetEmptyParams')) {
    function unsetEmptyParams(&$params){
        foreach($params as $key=>$value){
            if(empty($value) && $value===''){
                unset($params[$key]);
            }
        }
    }
}


