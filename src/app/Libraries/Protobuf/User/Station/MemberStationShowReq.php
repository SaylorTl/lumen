<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: station/share4.proto

namespace User\Station;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *车场展示
 *
 * Generated from protobuf message <code>user.station.MemberStationShowReq</code>
 */
class MemberStationShowReq extends \Google\Protobuf\Internal\Message
{
    /**
     *账号id
     *
     * Generated from protobuf field <code>int32 member_id = 1;</code>
     */
    private $member_id = 0;

    public function __construct() {
        \GPBMetadata\Station\Share4::initOnce();
        parent::__construct();
    }

    /**
     *账号id
     *
     * Generated from protobuf field <code>int32 member_id = 1;</code>
     * @return int
     */
    public function getMemberId()
    {
        return $this->member_id;
    }

    /**
     *账号id
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

}

