<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: weuser/share4.proto

namespace User\Weuser;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *微信用户拓展信息添加
 *
 * Generated from protobuf message <code>user.weuser.WeuserAddReq</code>
 */
class WeuserAddReq extends \Google\Protobuf\Internal\Message
{
    /**
     *客户端id
     *
     * Generated from protobuf field <code>int32 client_id = 1;</code>
     */
    private $client_id = 0;
    /**
     *微信unionid
     *
     * Generated from protobuf field <code>string unionid = 2;</code>
     */
    private $unionid = '';
    /**
     *是否订阅
     *
     * Generated from protobuf field <code>.user.Enumerate subscribe = 3;</code>
     */
    private $subscribe = 0;

    public function __construct() {
        \GPBMetadata\Weuser\Share4::initOnce();
        parent::__construct();
    }

    /**
     *客户端id
     *
     * Generated from protobuf field <code>int32 client_id = 1;</code>
     * @return int
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     *客户端id
     *
     * Generated from protobuf field <code>int32 client_id = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setClientId($var)
    {
        GPBUtil::checkInt32($var);
        $this->client_id = $var;

        return $this;
    }

    /**
     *微信unionid
     *
     * Generated from protobuf field <code>string unionid = 2;</code>
     * @return string
     */
    public function getUnionid()
    {
        return $this->unionid;
    }

    /**
     *微信unionid
     *
     * Generated from protobuf field <code>string unionid = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setUnionid($var)
    {
        GPBUtil::checkString($var, True);
        $this->unionid = $var;

        return $this;
    }

    /**
     *是否订阅
     *
     * Generated from protobuf field <code>.user.Enumerate subscribe = 3;</code>
     * @return int
     */
    public function getSubscribe()
    {
        return $this->subscribe;
    }

    /**
     *是否订阅
     *
     * Generated from protobuf field <code>.user.Enumerate subscribe = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setSubscribe($var)
    {
        GPBUtil::checkEnum($var, \User\Enumerate::class);
        $this->subscribe = $var;

        return $this;
    }

}
