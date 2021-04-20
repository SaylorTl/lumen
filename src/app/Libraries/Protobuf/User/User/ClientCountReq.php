<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: user/share4.proto

namespace User\User;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *客户端统计
 *
 * Generated from protobuf message <code>user.user.ClientCountReq</code>
 */
class ClientCountReq extends \Google\Protobuf\Internal\Message
{
    /**
     *用户id
     *
     * Generated from protobuf field <code>int64 user_id = 1;</code>
     */
    private $user_id = 0;
    /**
     *类型
     *
     * Generated from protobuf field <code>int32 kind = 2;</code>
     */
    private $kind = 0;
    /**
     *应用id
     *
     * Generated from protobuf field <code>string app_id = 3;</code>
     */
    private $app_id = '';
    /**
     *授权id
     *
     * Generated from protobuf field <code>string openid = 4;</code>
     */
    private $openid = '';

    public function __construct() {
        \GPBMetadata\User\Share4::initOnce();
        parent::__construct();
    }

    /**
     *用户id
     *
     * Generated from protobuf field <code>int64 user_id = 1;</code>
     * @return int|string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     *用户id
     *
     * Generated from protobuf field <code>int64 user_id = 1;</code>
     * @param int|string $var
     * @return $this
     */
    public function setUserId($var)
    {
        GPBUtil::checkInt64($var);
        $this->user_id = $var;

        return $this;
    }

    /**
     *类型
     *
     * Generated from protobuf field <code>int32 kind = 2;</code>
     * @return int
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     *类型
     *
     * Generated from protobuf field <code>int32 kind = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setKind($var)
    {
        GPBUtil::checkInt32($var);
        $this->kind = $var;

        return $this;
    }

    /**
     *应用id
     *
     * Generated from protobuf field <code>string app_id = 3;</code>
     * @return string
     */
    public function getAppId()
    {
        return $this->app_id;
    }

    /**
     *应用id
     *
     * Generated from protobuf field <code>string app_id = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setAppId($var)
    {
        GPBUtil::checkString($var, True);
        $this->app_id = $var;

        return $this;
    }

    /**
     *授权id
     *
     * Generated from protobuf field <code>string openid = 4;</code>
     * @return string
     */
    public function getOpenid()
    {
        return $this->openid;
    }

    /**
     *授权id
     *
     * Generated from protobuf field <code>string openid = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setOpenid($var)
    {
        GPBUtil::checkString($var, True);
        $this->openid = $var;

        return $this;
    }

}
