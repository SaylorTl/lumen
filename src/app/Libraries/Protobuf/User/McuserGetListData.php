<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: share4.proto

namespace User;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *商户用户数据集合
 *
 * Generated from protobuf message <code>user.McuserGetListData</code>
 */
class McuserGetListData extends \Google\Protobuf\Internal\Message
{
    /**
     *商户用户id
     *
     * Generated from protobuf field <code>int32 mcuser_id = 1;</code>
     */
    private $mcuser_id = 0;
    /**
     *商户id
     *
     * Generated from protobuf field <code>int32 merchant_id = 2;</code>
     */
    private $merchant_id = 0;
    /**
     *后台id
     *
     * Generated from protobuf field <code>int32 member_id = 3;</code>
     */
    private $member_id = 0;

    public function __construct() {
        \GPBMetadata\Share4::initOnce();
        parent::__construct();
    }

    /**
     *商户用户id
     *
     * Generated from protobuf field <code>int32 mcuser_id = 1;</code>
     * @return int
     */
    public function getMcuserId()
    {
        return $this->mcuser_id;
    }

    /**
     *商户用户id
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
     *商户id
     *
     * Generated from protobuf field <code>int32 merchant_id = 2;</code>
     * @return int
     */
    public function getMerchantId()
    {
        return $this->merchant_id;
    }

    /**
     *商户id
     *
     * Generated from protobuf field <code>int32 merchant_id = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setMerchantId($var)
    {
        GPBUtil::checkInt32($var);
        $this->merchant_id = $var;

        return $this;
    }

    /**
     *后台id
     *
     * Generated from protobuf field <code>int32 member_id = 3;</code>
     * @return int
     */
    public function getMemberId()
    {
        return $this->member_id;
    }

    /**
     *后台id
     *
     * Generated from protobuf field <code>int32 member_id = 3;</code>
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

