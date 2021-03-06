<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: user/share4.proto

namespace User\User;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *展示用户信息
 *
 * Generated from protobuf message <code>user.user.ShowUsersReq</code>
 */
class ShowUsersReq extends \Google\Protobuf\Internal\Message
{
    /**
     *客户端id
     *
     * Generated from protobuf field <code>int64 client_id = 1;</code>
     */
    private $client_id = 0;
    /**
     *手机号
     *
     * Generated from protobuf field <code>string mobile = 2;</code>
     */
    private $mobile = '';
    /**
     *授权id
     *
     * Generated from protobuf field <code>string openid = 3;</code>
     */
    private $openid = '';
    /**
     *授权类型
     *
     * Generated from protobuf field <code>.user.Enumerate kind = 4;</code>
     */
    private $kind = 0;
    /**
     *应用id
     *
     * Generated from protobuf field <code>string app_id = 5;</code>
     */
    private $app_id = '';

    public function __construct() {
        \GPBMetadata\User\Share4::initOnce();
        parent::__construct();
    }

    /**
     *客户端id
     *
     * Generated from protobuf field <code>int64 client_id = 1;</code>
     * @return int|string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     *客户端id
     *
     * Generated from protobuf field <code>int64 client_id = 1;</code>
     * @param int|string $var
     * @return $this
     */
    public function setClientId($var)
    {
        GPBUtil::checkInt64($var);
        $this->client_id = $var;

        return $this;
    }

    /**
     *手机号
     *
     * Generated from protobuf field <code>string mobile = 2;</code>
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     *手机号
     *
     * Generated from protobuf field <code>string mobile = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setMobile($var)
    {
        GPBUtil::checkString($var, True);
        $this->mobile = $var;

        return $this;
    }

    /**
     *授权id
     *
     * Generated from protobuf field <code>string openid = 3;</code>
     * @return string
     */
    public function getOpenid()
    {
        return $this->openid;
    }

    /**
     *授权id
     *
     * Generated from protobuf field <code>string openid = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setOpenid($var)
    {
        GPBUtil::checkString($var, True);
        $this->openid = $var;

        return $this;
    }

    /**
     *授权类型
     *
     * Generated from protobuf field <code>.user.Enumerate kind = 4;</code>
     * @return int
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     *授权类型
     *
     * Generated from protobuf field <code>.user.Enumerate kind = 4;</code>
     * @param int $var
     * @return $this
     */
    public function setKind($var)
    {
        GPBUtil::checkEnum($var, \User\Enumerate::class);
        $this->kind = $var;

        return $this;
    }

    /**
     *应用id
     *
     * Generated from protobuf field <code>string app_id = 5;</code>
     * @return string
     */
    public function getAppId()
    {
        return $this->app_id;
    }

    /**
     *应用id
     *
     * Generated from protobuf field <code>string app_id = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setAppId($var)
    {
        GPBUtil::checkString($var, True);
        $this->app_id = $var;

        return $this;
    }

}

