<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: share4.proto

namespace User;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *用户车场展示
 *
 * Generated from protobuf message <code>user.MemberStationShowData</code>
 */
class MemberStationShowData extends \Google\Protobuf\Internal\Message
{
    /**
     *用户id
     *
     * Generated from protobuf field <code>int32 member_id = 1;</code>
     */
    private $member_id = 0;
    /**
     *车场id
     *
     * Generated from protobuf field <code>int32 station_id = 2;</code>
     */
    private $station_id = 0;

    public function __construct() {
        \GPBMetadata\Share4::initOnce();
        parent::__construct();
    }

    /**
     *用户id
     *
     * Generated from protobuf field <code>int32 member_id = 1;</code>
     * @return int
     */
    public function getMemberId()
    {
        return $this->member_id;
    }

    /**
     *用户id
     *
     * Generated from protobuf field <code>int32 member_id = 1;</code>
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
     *车场id
     *
     * Generated from protobuf field <code>int32 station_id = 2;</code>
     * @return int
     */
    public function getStationId()
    {
        return $this->station_id;
    }

    /**
     *车场id
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

}

