<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: address/share4.proto

namespace User\Address;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *用户展示添加
 *
 * Generated from protobuf message <code>user.address.UseraddressShowReq</code>
 */
class UseraddressShowReq extends \Google\Protobuf\Internal\Message
{
    /**
     *地址id
     *
     * Generated from protobuf field <code>int32 address_id = 1;</code>
     */
    private $address_id = 0;

    public function __construct() {
        \GPBMetadata\Address\Share4::initOnce();
        parent::__construct();
    }

    /**
     *地址id
     *
     * Generated from protobuf field <code>int32 address_id = 1;</code>
     * @return int
     */
    public function getAddressId()
    {
        return $this->address_id;
    }

    /**
     *地址id
     *
     * Generated from protobuf field <code>int32 address_id = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setAddressId($var)
    {
        GPBUtil::checkInt32($var);
        $this->address_id = $var;

        return $this;
    }

}

