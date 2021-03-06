<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: merchant/share4.proto

namespace User\Merchant;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *添加商户
 *
 * Generated from protobuf message <code>user.merchant.McAddReq</code>
 */
class McAddReq extends \Google\Protobuf\Internal\Message
{
    /**
     *商户名
     *
     * Generated from protobuf field <code>string mc_name = 1;</code>
     */
    private $mc_name = '';
    /**
     *停车场id
     *
     * Generated from protobuf field <code>int32 station_id = 2;</code>
     */
    private $station_id = 0;
    /**
     *地址
     *
     * Generated from protobuf field <code>string address = 3;</code>
     */
    private $address = '';

    public function __construct() {
        \GPBMetadata\Merchant\Share4::initOnce();
        parent::__construct();
    }

    /**
     *商户名
     *
     * Generated from protobuf field <code>string mc_name = 1;</code>
     * @return string
     */
    public function getMcName()
    {
        return $this->mc_name;
    }

    /**
     *商户名
     *
     * Generated from protobuf field <code>string mc_name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setMcName($var)
    {
        GPBUtil::checkString($var, True);
        $this->mc_name = $var;

        return $this;
    }

    /**
     *停车场id
     *
     * Generated from protobuf field <code>int32 station_id = 2;</code>
     * @return int
     */
    public function getStationId()
    {
        return $this->station_id;
    }

    /**
     *停车场id
     *
     * Generated from protobuf field <code>int32 station_id = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setStationId($var)
    {
        GPBUtil::checkInt32($var);
        $this->station_id = $var;

        return $this;
    }

    /**
     *地址
     *
     * Generated from protobuf field <code>string address = 3;</code>
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     *地址
     *
     * Generated from protobuf field <code>string address = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setAddress($var)
    {
        GPBUtil::checkString($var, True);
        $this->address = $var;

        return $this;
    }

}

