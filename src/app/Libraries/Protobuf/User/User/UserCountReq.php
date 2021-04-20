<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: user/share4.proto

namespace User\User;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *用户计数
 *
 * Generated from protobuf message <code>user.user.UserCountReq</code>
 */
class UserCountReq extends \Google\Protobuf\Internal\Message
{
    /**
     *性别
     *
     * Generated from protobuf field <code>.user.Enumerate sex = 1;</code>
     */
    private $sex = 0;
    /**
     *用户名
     *
     * Generated from protobuf field <code>string username = 2;</code>
     */
    private $username = '';
    /**
     *是否锁定
     *
     * Generated from protobuf field <code>.user.Enumerate autolock = 4;</code>
     */
    private $autolock = 0;
    /**
     *用户id
     *
     * Generated from protobuf field <code>string user_ids = 5;</code>
     */
    private $user_ids = '';
    /**
     *用户手机号
     *
     * Generated from protobuf field <code>string mobiles = 6;</code>
     */
    private $mobiles = '';
    /**
     *开始时间
     *
     * Generated from protobuf field <code>string begin_time = 7;</code>
     */
    private $begin_time = '';
    /**
     *结束时间
     *
     * Generated from protobuf field <code>string end_time = 8;</code>
     */
    private $end_time = '';

    public function __construct() {
        \GPBMetadata\User\Share4::initOnce();
        parent::__construct();
    }

    /**
     *性别
     *
     * Generated from protobuf field <code>.user.Enumerate sex = 1;</code>
     * @return int
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     *性别
     *
     * Generated from protobuf field <code>.user.Enumerate sex = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setSex($var)
    {
        GPBUtil::checkEnum($var, \User\Enumerate::class);
        $this->sex = $var;

        return $this;
    }

    /**
     *用户名
     *
     * Generated from protobuf field <code>string username = 2;</code>
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     *用户名
     *
     * Generated from protobuf field <code>string username = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setUsername($var)
    {
        GPBUtil::checkString($var, True);
        $this->username = $var;

        return $this;
    }

    /**
     *是否锁定
     *
     * Generated from protobuf field <code>.user.Enumerate autolock = 4;</code>
     * @return int
     */
    public function getAutolock()
    {
        return $this->autolock;
    }

    /**
     *是否锁定
     *
     * Generated from protobuf field <code>.user.Enumerate autolock = 4;</code>
     * @param int $var
     * @return $this
     */
    public function setAutolock($var)
    {
        GPBUtil::checkEnum($var, \User\Enumerate::class);
        $this->autolock = $var;

        return $this;
    }

    /**
     *用户id
     *
     * Generated from protobuf field <code>string user_ids = 5;</code>
     * @return string
     */
    public function getUserIds()
    {
        return $this->user_ids;
    }

    /**
     *用户id
     *
     * Generated from protobuf field <code>string user_ids = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setUserIds($var)
    {
        GPBUtil::checkString($var, True);
        $this->user_ids = $var;

        return $this;
    }

    /**
     *用户手机号
     *
     * Generated from protobuf field <code>string mobiles = 6;</code>
     * @return string
     */
    public function getMobiles()
    {
        return $this->mobiles;
    }

    /**
     *用户手机号
     *
     * Generated from protobuf field <code>string mobiles = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setMobiles($var)
    {
        GPBUtil::checkString($var, True);
        $this->mobiles = $var;

        return $this;
    }

    /**
     *开始时间
     *
     * Generated from protobuf field <code>string begin_time = 7;</code>
     * @return string
     */
    public function getBeginTime()
    {
        return $this->begin_time;
    }

    /**
     *开始时间
     *
     * Generated from protobuf field <code>string begin_time = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setBeginTime($var)
    {
        GPBUtil::checkString($var, True);
        $this->begin_time = $var;

        return $this;
    }

    /**
     *结束时间
     *
     * Generated from protobuf field <code>string end_time = 8;</code>
     * @return string
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     *结束时间
     *
     * Generated from protobuf field <code>string end_time = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setEndTime($var)
    {
        GPBUtil::checkString($var, True);
        $this->end_time = $var;

        return $this;
    }

}

