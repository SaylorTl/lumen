<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: share4.proto

namespace User;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *返回数组
 *
 * Generated from protobuf message <code>user.mc_coupData</code>
 */
class mc_coupData extends \Google\Protobuf\Internal\Message
{
    /**
     *测试
     *
     * Generated from protobuf field <code>repeated string name = 1;</code>
     */
    private $name;
    /**
     *测试字符
     *
     * Generated from protobuf field <code>int32 str = 2;</code>
     */
    private $str = 0;

    public function __construct() {
        \GPBMetadata\Share4::initOnce();
        parent::__construct();
    }

    /**
     *测试
     *
     * Generated from protobuf field <code>repeated string name = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *测试
     *
     * Generated from protobuf field <code>repeated string name = 1;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setName($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->name = $arr;

        return $this;
    }

    /**
     *测试字符
     *
     * Generated from protobuf field <code>int32 str = 2;</code>
     * @return int
     */
    public function getStr()
    {
        return $this->str;
    }

    /**
     *测试字符
     *
     * Generated from protobuf field <code>int32 str = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setStr($var)
    {
        GPBUtil::checkInt32($var);
        $this->str = $var;

        return $this;
    }

}

