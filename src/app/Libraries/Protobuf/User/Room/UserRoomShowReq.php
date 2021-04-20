<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: room/share4.proto

namespace User\Room;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *用户楼栋号展示
 *
 * Generated from protobuf message <code>user.room.UserRoomShowReq</code>
 */
class UserRoomShowReq extends \Google\Protobuf\Internal\Message
{
    /**
     *用户id
     *
     * Generated from protobuf field <code>int64 user_id = 1;</code>
     */
    private $user_id = 0;
    /**
     *用户楼栋单元号
     *
     * Generated from protobuf field <code>int32 room_id = 2;</code>
     */
    private $room_id = 0;
    /**
     *自增id
     *
     * Generated from protobuf field <code>int32 eur_id = 3;</code>
     */
    private $eur_id = 0;
    /**
     *是否自有
     *
     * Generated from protobuf field <code>.user.Enumerate owner = 4;</code>
     */
    private $owner = 0;

    public function __construct() {
        \GPBMetadata\Room\Share4::initOnce();
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
     *用户楼栋单元号
     *
     * Generated from protobuf field <code>int32 room_id = 2;</code>
     * @return int
     */
    public function getRoomId()
    {
        return $this->room_id;
    }

    /**
     *用户楼栋单元号
     *
     * Generated from protobuf field <code>int32 room_id = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setRoomId($var)
    {
        GPBUtil::checkInt32($var);
        $this->room_id = $var;

        return $this;
    }

    /**
     *自增id
     *
     * Generated from protobuf field <code>int32 eur_id = 3;</code>
     * @return int
     */
    public function getEurId()
    {
        return $this->eur_id;
    }

    /**
     *自增id
     *
     * Generated from protobuf field <code>int32 eur_id = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setEurId($var)
    {
        GPBUtil::checkInt32($var);
        $this->eur_id = $var;

        return $this;
    }

    /**
     *是否自有
     *
     * Generated from protobuf field <code>.user.Enumerate owner = 4;</code>
     * @return int
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     *是否自有
     *
     * Generated from protobuf field <code>.user.Enumerate owner = 4;</code>
     * @param int $var
     * @return $this
     */
    public function setOwner($var)
    {
        GPBUtil::checkEnum($var, \User\Enumerate::class);
        $this->owner = $var;

        return $this;
    }

}
