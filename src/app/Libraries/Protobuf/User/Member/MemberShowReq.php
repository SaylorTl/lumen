<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: member/share4.proto

namespace User\Member;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *用户列表请求
 *
 * Generated from protobuf message <code>user.member.MemberShowReq</code>
 */
class MemberShowReq extends \Google\Protobuf\Internal\Message
{
    /**
     *角色类型
     *
     * Generated from protobuf field <code>int32 role_type = 1;</code>
     */
    private $role_type = 0;
    /**
     *用户id
     *
     * Generated from protobuf field <code>int64 user_id = 2;</code>
     */
    private $user_id = 0;
    /**
     *后台id
     *
     * Generated from protobuf field <code>int32 member_id = 3;</code>
     */
    private $member_id = 0;
    /**
     *oa账号
     *
     * Generated from protobuf field <code>string oa = 4;</code>
     */
    private $oa = '';
    /**
     *是否自动登录
     *
     * Generated from protobuf field <code>.user.Enumerate is_auto_login = 5;</code>
     */
    private $is_auto_login = 0;

    public function __construct() {
        \GPBMetadata\Member\Share4::initOnce();
        parent::__construct();
    }

    /**
     *角色类型
     *
     * Generated from protobuf field <code>int32 role_type = 1;</code>
     * @return int
     */
    public function getRoleType()
    {
        return $this->role_type;
    }

    /**
     *角色类型
     *
     * Generated from protobuf field <code>int32 role_type = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setRoleType($var)
    {
        GPBUtil::checkInt32($var);
        $this->role_type = $var;

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

    /**
     *oa账号
     *
     * Generated from protobuf field <code>string oa = 4;</code>
     * @return string
     */
    public function getOa()
    {
        return $this->oa;
    }

    /**
     *oa账号
     *
     * Generated from protobuf field <code>string oa = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setOa($var)
    {
        GPBUtil::checkString($var, True);
        $this->oa = $var;

        return $this;
    }

    /**
     *是否自动登录
     *
     * Generated from protobuf field <code>.user.Enumerate is_auto_login = 5;</code>
     * @return int
     */
    public function getIsAutoLogin()
    {
        return $this->is_auto_login;
    }

    /**
     *是否自动登录
     *
     * Generated from protobuf field <code>.user.Enumerate is_auto_login = 5;</code>
     * @param int $var
     * @return $this
     */
    public function setIsAutoLogin($var)
    {
        GPBUtil::checkEnum($var, \User\Enumerate::class);
        $this->is_auto_login = $var;

        return $this;
    }

}

