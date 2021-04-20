<?php
namespace App\Http\Services;
use Google\Protobuf\DescriptorPool;
class AuthService
{
    protected static $replace ='Auth';
    protected static $EMPTY_VALUE = -1008610086;
    protected static $ZERO_VALUE = -1008610087;

    /**
     * @param $func
     * @param string $data
     * 获取数据方法
     */
    public static function getClassName ($func)
    {
        return "\\".static::$replace.$func;
    }


    public static function getParams($func,$input){
        $class = self::getClassName($func)."Req";
        if (!class_exists($class)){
            self::fail(1002,$class.'类不存在');
        }
        $req = new $class();
        $req->mergeFromString($input);
        return static::decode($req);
    }

    public static function reponseData ($func,$data='',$msg='success')
    {
        $class = self::getClassName($func)."Res";
        if (!class_exists($class)){
            self::fail(1002,$class.'类不存在');
        }
        $resData['code'] = 0;
        $resData['content'] = $data;
        $resData['message'] = $msg;
        $res = static::encode($class,$resData);
        exit ($res->serializeToString());
    }
    /***********************************具体加密解密方法********************************************/
    /**
     * @param $class protobuf基类
     * @param $input 传入参数
     * @return array
     * 加密方法
     */
    public static function encode ($class,$input){
        try{
            $req = new $class();
            $pools = DescriptorPool::getGeneratedPool();
            $pools = $pools->getDescriptorByClassName(get_class($req));
            $paramsSet = static::getMessageSet($pools);
            $method_arr = get_class_methods($pools->getClass());
            foreach($input as $k=>$val){
                $index = array_keys($paramsSet,$k);
                if(empty($index)){
                    throw new \Exception($k.'字段不存在，请先在protobuf中添加');
                }
                //获取字段数据类型,取自Google\Protobuf\Internal\GPBType:
                $params_type = $pools->getField($index[0])->getType();
                //获取字段标签类型，取自Google\Protobuf\Internal\GPBLabel
                //1位OPTIONAL,2位REQUIRED,3位REPEATED
                $label_type = $pools->getField($index[0])->getLabel();
                $meth_index = ($index[0]+1)*2;
                $method = $method_arr[$meth_index];
                switch($params_type){
                    case 11: //message类型
                        $value = static::setMessage($pools,$index,$label_type,$val);
                        break;
                    case 14: //枚举类型
                        $value = static::setEnum($pools,$index,$label_type,$val,$k);
                        break;
                    default;//其他类型
                        $value =  static::setEmpty($val,$label_type);
                        break;
                }
                $req->$method($value);
            }
            return $req;
        }catch (\Exception $e){
            self::fail(1009,$k.json_encode($val).','.$e->getMessage());
        }
    }

    /**
     * @param $class protobuf基类
     * @param $input 待解析参数
     * @return array
     * 解密方法
     */
    public static function decode($classObj){
        try{
            $class = get_class($classObj);
            $pools = DescriptorPool::getGeneratedPool();
            $pools = $pools->getDescriptorByClassName($class);
            $paramsSet = static::getMessageSet($pools);
            $method_arr = get_class_methods($pools->getClass());
            $params = [];
            foreach($paramsSet as $val){
                $index = array_keys($paramsSet,$val);
                $params_type = $pools->getField($index[0])->getType();
                //获取字段标签类型，取自Google\Protobuf\Internal\GPBLabel
                //1位OPTIONAL,2位REQUIRED,3位REPEATED
                $label_type = $pools->getField($index[0])->getLabel();
                $meth_index = ($index[0]+1)*2-1;
                $method = $method_arr[$meth_index];
                $repose = $classObj->$method();
                if((empty($repose)) || ($label_type === 3 &&$repose->count() === 0)){
                    continue;
                }
                switch($params_type){
                    case 11: //message类型
                        $value = static::getMessage($repose,$label_type);
                        break;
                    case 14: //枚举类型
                        $value = static::getEnum($pools,$index,$repose,$label_type,$val);
                        break;
                    default;//其他数据类型
                        $value = static::getEmpty($repose,$label_type);
                        break;
                }
                $params[$val] = $value;
            }
            return $params;
        }catch (\Exception $e){
            self::fail(1009,json_encode($classObj).','.$e->getMessage());
        }
    }

    /**
     * @param $pools 静态类型参数，DescriptorPool
     * @param $index 参数索引
     * @param int $label_type 参数标签类型
     * @param $value 参数值
     * @return array
     * 设置message类型参数
     */
    private static function setMessage($pools,$index,$label_type=1,$value){
        $class_name = $pools->getField($index[0])->getMessageType()->getClass();
        $obj = '';
        $arr = [];
        if($label_type==3){
            $arr = new \Google\Protobuf\Internal\RepeatedField(\Google\Protobuf\Internal\GPBType::MESSAGE, $class_name);
            foreach($value as $k=>$v){
                $arr[] = static::encode($class_name,$v);
            }
        }else{
            $obj = static::encode($class_name,$value);
        }
        return empty($arr)?$obj:$arr;
    }

    /**
     * @param $pools 静态类型参数，DescriptorPool
     * @param $index 参数索引
     * @param $label_type 参数标签类型
     * @param $val 参数值
     * @return array
     * @throws Exception
     * 设置枚举类型
     */
    private static function setEnum($pools,$index,$label_type,$val,$name){
        $enum = $pools->getField($index[0])->getEnumType();
        $paramsArr = static::getEnumSet($enum);
        $index = '';
        $arr = [];
        if($label_type==3){//label为repeated类型
            foreach($val as $k=>$v){
                if(!empty(static::$USER_GETENUMERATE[$name])){
                    $USER_GETENUMERATE = static::$USER_GETENUMERATE[$name];
                    $arr = array_flip($USER_GETENUMERATE);
                    $v = $arr[$v];
                }
                $index = array_keys($paramsArr,$v);
                if(empty($index)){
                    throw new \Exception("不存在这个枚举值(".$val.")");
                }
                $index = $index[0];
                $arr[] = $index;
            }
        }else{
            if(!empty(static::$USER_GETENUMERATE[$name])){
                $USER_GETENUMERATE = static::$USER_GETENUMERATE[$name];
                $temparr = array_flip($USER_GETENUMERATE);
                $val = $temparr[$val];
            }
            $index = array_keys($paramsArr,$val);
            if(empty($index)){
                throw new \Exception("不存在这个枚举值(".$val.")");
            }
        }
        return empty($arr)?$index[0]:$arr;
    }

    private static function setEmpty($val,$label_type){
        if(0 === $val ||"0" === $val){
            return ($label_type===3)?[static::$ZERO_VALUE]:static::$ZERO_VALUE;
        }
        if(empty($val) && ($val!==0 || "0" === $val)){
            return ($label_type===3)?[static::$EMPTY_VALUE]:static::$EMPTY_VALUE;
        }
        return $val;
    }

    private static function getEmpty($reponse,$label_type){
        if($label_type===3){
            $value = [];
            foreach($reponse as $v){
                $value[] = $v;
            }
        }else{
            $value = $reponse;
        }
        if(is_numeric($value)){
            if(static::$ZERO_VALUE === intval($value) || [static::$ZERO_VALUE] === $value){
                return 0; //转化为零
            }
            if(static::$EMPTY_VALUE === intval($value) || [static::$EMPTY_VALUE] === $value){
                return '';//转化为空
            }
        }
        return $value;
    }

    /**
     * @param $pools 静态类型参数对象，DescriptorPool
     * @param $index 参数索引
     * @param $repose 参数对象
     * @param int $label_type 参数标签类型
     * @return array
     * 获取message类型
     */
    private static function getMessage($repose,$label_type=1){
        if($repose === static::$EMPTY_VALUE){
            return [];
        }
        $arr = [];
        $obj = '';
        if($label_type==3){
            foreach($repose as $k=>$v){
                $obj = static::decode($v);
                $arr[] = $obj;
            }
        }else{
            $obj = static::decode($repose);
        }
        return empty($arr)?$obj:$arr;
    }

    /**
     * @param $pools 静态类型参数对象，DescriptorPool
     * @param $index 参数索引
     * @param $repose 参数对象
     * @param int $label_type 参数标签类型
     * @return array
     * 获取枚举类型
     */
    private static function getEnum($pools,$index,$repose,$label_type,$name){
        $enum = $pools->getField($index[0])->getEnumType();
        if($repose === static::$EMPTY_VALUE){
            return '';
        }
        $paramsArr = static::getEnumSet($enum);
        $arr = [];
        $enumvalue = '';
        if($label_type==3){//label类型未repeated
            foreach($repose as $k=>$v){
                $enumvalue = $paramsArr[$v];
                if(!empty(static::$USER_GETENUMERATE[$name])){
                    $enumvalue = static::$USER_GETENUMERATE[$name][$paramsArr[$v]];
                }
                if(empty($enumvalue)){
                    throw new \Exception($repose.'字段不存在，请先在枚举类型中添加');
                }
                $arr[] = $enumvalue;
            }
        }else{
            $enumvalue = $paramsArr[$repose];
            if(!empty(static::$USER_GETENUMERATE[$name])){
                $enumvalue = static::$USER_GETENUMERATE[$name][$enumvalue];
            }
            if(empty($enumvalue)&&$enumvalue!=0){
                throw new \Exception($repose.'字段不存在，请先在枚举类型中添加');
            }
        }
        return empty($arr)?$enumvalue:$arr;
    }

    /**
     * @param $pool
     * @return array
     * 获取message参数列表
     */
    private static function getMessageSet($pool){//TODO 此处可做缓存
        $num = $pool->getFieldCount();
        $argvs = [];
        for($i=0;$i<$num;$i++){
            $argvs[] = $pool->getField($i)->getName();
        }
        return $argvs;
    }

    private static function getEnumSet($pool){//TODO 此处可做缓存
        $num = $pool->getValueCount();
        $argvs = [];
        for($i=0;$i<$num;$i++){
            $number = $pool->getValue($i)->getNumber();
            $argvs[$number] = $pool->getValue($i)->getName();
        }
        return $argvs;
    }

    public static function fail($code,$message,$content=''){
        $class = '\\'.static::$replace.'\Response';
        $fail = new $class();
        $fail->setCode((int)$code);
        $fail->setMessage((string)$message);
        $fail->setContent((string)$content);
        exit($fail->serializeToString());
    }
}
