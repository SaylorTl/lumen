<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: merchantuser/share4.proto

namespace User\Merchantuser;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *商户用户请求体
 *
 * Generated from protobuf message <code>user.merchantuser.McuserShowuserReq</code>
 */
class McuserShowuserReq extends \Google\Protobuf\Internal\Message
{
    /**
     *用户id
     *
     * Generated from protobuf field <code>int64 user_id = 1;</code>
     */
    private $user_id = 0;
    /**
     *后台id
     *
     * Generated from protobuf field <code>int32 member_id = 2;</code>
     */
    private $member_id = 0;
    /**
     *用户手机号
     *
     * Generated from protobuf field <code>string mobile = 3;</code>
     */
    private $mobile = '';
    /**
     *用户名
     *
     * Generated from protobuf field <code>string username = 4;</code>
     */
    private $username = '';

    public function __construct() {
        \GPBMetadata\Merchantuser\Share4::initOnce();
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
     *后台id
     *
     * Generated from protobuf field <code>int32 member_id = 2;</code>
     * @return int
     */
    public function getMemberId()
    {
        return $this->member_id;
    }

    /**
     *后台id
     *
     * Generated from protobuf field <code>int32 member_id = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setMemberId($var)
    {
        GPBUtil::checkInt32($var);
        $this->member_id = $var;

        return $this;
    }

    /**
     *用户手机号
     *
     * Generated from protobuf field <code>string mobile = 3;</code>
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     *用户手机号
     *
     * Generated from protobuf field <code>string mobile = 3;</code>
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
     *用户名
     *
     * Generated from protobuf field <code>string username = 4;</code>
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     *用户名
     *
     * Generated from protobuf field <code>string username = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setUsername($var)
    {
        GPBUtil::checkString($var, True);
        $this->username = $var;

        return $this;
    }

}

