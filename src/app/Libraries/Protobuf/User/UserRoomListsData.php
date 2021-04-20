<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: share4.proto

namespace User;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *楼栋列表展示
 *
 * Generated from protobuf message <code>user.UserRoomListsData</code>
 */
class UserRoomListsData extends \Google\Protobuf\Internal\Message
{
    /**
     *自增id
     *
     * Generated from protobuf field <code>int32 eur_id = 1;</code>
     */
    private $eur_id = 0;
    /**
     *用户id
     *
     * Generated from protobuf field <code>int64 user_id = 2;</code>
     */
    private $user_id = 0;
    /**
     *楼栋id
     *
     * Generated from protobuf field <code>int32 build_id = 3;</code>
     */
    private $build_id = 0;
    /**
     *楼栋名称
     *
     * Generated from protobuf field <code>string build_name = 4;</code>
     */
    private $build_name = '';
    /**
     *单元号
     *
     * Generated from protobuf field <code>int32 room_id = 5;</code>
     */
    private $room_id = 0;
    /**
     *单元名称
     *
     * Generated from protobuf field <code>string unit_name = 6;</code>
     */
    private $unit_name = '';
    /**
     *创建时间
     *
     * Generated from protobuf field <code>string create_at = 7;</code>
     */
    private $create_at = '';
    /**
     *更新时间
     *
     * Generated from protobuf field <code>string update_at = 8;</code>
     */
    private $update_at = '';
    /**
     *是否自有
     *
     * Generated from protobuf field <code>.user.Enumerate owner = 9;</code>
     */
    private $owner = 0;

    public function __construct() {
        \GPBMetadata\Share4::initOnce();
        parent::__construct();
    }

    /**
     *自增id
     *
     * Generated from protobuf field <code>int32 eur_id = 1;</code>
     * @return int
     */
    public function getEurId()
    {
        return $this->eur_id;
    }

    /**
     *自增id
     *
     * Generated from protobuf field <code>int32 eur_id = 1;</code>
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
     *用户id
     *
     * Generated from protobuf field <code>int64 user_id = 2;</code>
     * @return int|string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     *用户id
     *
     * Generated from protobuf field <code>int64 user_id = 2;</code>
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
     *楼栋id
     *
     * Generated from protobuf field <code>int32 build_id = 3;</code>
     * @return int
     */
    public function getBuildId()
    {
        return $this->build_id;
    }

    /**
     *楼栋id
     *
     * Generated from protobuf field <code>int32 build_id = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setBuildId($var)
    {
        GPBUtil::checkInt32($var);
        $this->build_id = $var;

        return $this;
    }

    /**
     *楼栋名称
     *
     * Generated from protobuf field <code>string build_name = 4;</code>
     * @return string
     */
    public function getBuildName()
    {
        return $this->build_name;
    }

    /**
     *楼栋名称
     *
     * Generated from protobuf field <code>string build_name = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setBuildName($var)
    {
        GPBUtil::checkString($var, True);
        $this->build_name = $var;

        return $this;
    }

    /**
     *单元号
     *
     * Generated from protobuf field <code>int32 room_id = 5;</code>
     * @return int
     */
    public function getRoomId()
    {
        return $this->room_id;
    }

    /**
     *单元号
     *
     * Generated from protobuf field <code>int32 room_id = 5;</code>
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
     *单元名称
     *
     * Generated from protobuf field <code>string unit_name = 6;</code>
     * @return string
     */
    public function getUnitName()
    {
        return $this->unit_name;
    }

    /**
     *单元名称
     *
     * Generated from protobuf field <code>string unit_name = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setUnitName($var)
    {
        GPBUtil::checkString($var, True);
        $this->unit_name = $var;

        return $this;
    }

    /**
     *创建时间
     *
     * Generated from protobuf field <code>string create_at = 7;</code>
     * @return string
     */
    public function getCreateAt()
    {
        return $this->create_at;
    }

    /**
     *创建时间
     *
     * Generated from protobuf field <code>string create_at = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setCreateAt($var)
    {
        GPBUtil::checkString($var, True);
        $this->create_at = $var;

        return $this;
    }

    /**
     *更新时间
     *
     * Generated from protobuf field <code>string update_at = 8;</code>
     * @return string
     */
    public function getUpdateAt()
    {
        return $this->update_at;
    }

    /**
     *更新时间
     *
     * Generated from protobuf field <code>string update_at = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setUpdateAt($var)
    {
        GPBUtil::checkString($var, True);
        $this->update_at = $var;

        return $this;
    }

    /**
     *是否自有
     *
     * Generated from protobuf field <code>.user.Enumerate owner = 9;</code>
     * @return int
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     *是否自有
     *
     * Generated from protobuf field <code>.user.Enumerate owner = 9;</code>
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

