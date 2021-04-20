<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: station/share4.proto

namespace User\Station;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *车站列表
 *
 * Generated from protobuf message <code>user.station.MemberStationListsReq</code>
 */
class MemberStationListsReq extends \Google\Protobuf\Internal\Message
{
    /**
     *账号id集合
     *
     * Generated from protobuf field <code>string member_ids = 1;</code>
     */
    private $member_ids = '';
    /**
     *停车场id
     *
     * Generated from protobuf field <code>int32 station_id = 2;</code>
     */
    private $station_id = 0;
    /**
     *停车场id集合
     *
     * Generated from protobuf field <code>repeated int32 station_ids = 3;</code>
     */
    private $station_ids;

    public function __construct() {
        \GPBMetadata\Station\Share4::initOnce();
        parent::__construct();
    }

    /**
     *账号id集合
     *
     * Generated from protobuf field <code>string member_ids = 1;</code>
     * @return string
     */
    public function getMemberIds()
    {
        return $this->member_ids;
    }

    /**
     *账号id集合
     *
     * Generated from protobuf field <code>string member_ids = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setMemberIds($var)
    {
        GPBUtil::checkString($var, True);
        $this->member_ids = $var;

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
     *停车场id集合
     *
     * Generated from protobuf field <code>repeated int32 station_ids = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getStationIds()
    {
        return $this->station_ids;
    }

    /**
     *停车场id集合
     *
     * Generated from protobuf field <code>repeated int32 station_ids = 3;</code>
     * @param int[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setStationIds($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::INT32);
        $this->station_ids = $arr;

        return $this;
    }

}
