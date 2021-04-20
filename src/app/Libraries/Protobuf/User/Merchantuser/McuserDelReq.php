<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: merchantuser/share4.proto

namespace User\Merchantuser;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *商户添加请求体
 *
 * Generated from protobuf message <code>user.merchantuser.McuserDelReq</code>
 */
class McuserDelReq extends \Google\Protobuf\Internal\Message
{
    /**
     *自增id
     *
     * Generated from protobuf field <code>int32 mcuser_id = 1;</code>
     */
    private $mcuser_id = 0;
    /**
     *后台id
     *
     * Generated from protobuf field <code>int32 member_id = 2;</code>
     */
    private $member_id = 0;

    public function __construct() {
        \GPBMetadata\Merchantuser\Share4::initOnce();
        parent::__construct();
    }

    /**
     *自增id
     *
     * Generated from protobuf field <code>int32 mcuser_id = 1;</code>
     * @return int
     */
    public function getMcuserId()
    {
        return $this->mcuser_id;
    }

    /**
     *自增id
     *
     * Generated from protobuf field <code>int32 mcuser_id = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setMcuserId($var)
    {
        GPBUtil::checkInt32($var);
        $this->mcuser_id = $var;

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

}

