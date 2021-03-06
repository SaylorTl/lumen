<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: member/share4.proto

namespace User\Member;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *检查密码
 *
 * Generated from protobuf message <code>user.member.MemberCheckPwdReq</code>
 */
class MemberCheckPwdReq extends \Google\Protobuf\Internal\Message
{
    /**
     *用户名
     *
     * Generated from protobuf field <code>string username = 1;</code>
     */
    private $username = '';
    /**
     *密码
     *
     * Generated from protobuf field <code>string password = 2;</code>
     */
    private $password = '';
    /**
     *角色类别
     *
     * Generated from protobuf field <code>int32 role_type = 3;</code>
     */
    private $role_type = 0;

    public function __construct() {
        \GPBMetadata\Member\Share4::initOnce();
        parent::__construct();
    }

    /**
     *用户名
     *
     * Generated from protobuf field <code>string username = 1;</code>
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     *用户名
     *
     * Generated from protobuf field <code>string username = 1;</code>
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
     *密码
     *
     * Generated from protobuf field <code>string password = 2;</code>
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *密码
     *
     * Generated from protobuf field <code>string password = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setPassword($var)
    {
        GPBUtil::checkString($var, True);
        $this->password = $var;

        return $this;
    }

    /**
     *角色类别
     *
     * Generated from protobuf field <code>int32 role_type = 3;</code>
     * @return int
     */
    public function getRoleType()
    {
        return $this->role_type;
    }

    /**
     *角色类别
     *
     * Generated from protobuf field <code>int32 role_type = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setRoleType($var)
    {
        GPBUtil::checkInt32($var);
        $this->role_type = $var;

        return $this;
    }

}

