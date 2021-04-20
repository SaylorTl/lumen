<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: member/share4.proto

namespace User\Member;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *用户更新
 *
 * Generated from protobuf message <code>user.member.MemberUpdateReq</code>
 */
class MemberUpdateReq extends \Google\Protobuf\Internal\Message
{
    /**
     *后台id
     *
     * Generated from protobuf field <code>int32 member_id = 1;</code>
     */
    private $member_id = 0;
    /**
     *后台角色id
     *
     * Generated from protobuf field <code>string role_id = 2;</code>
     */
    private $role_id = '';
    /**
     *账户类型
     *
     * Generated from protobuf field <code>.user.Enumerate type = 3;</code>
     */
    private $type = 0;
    /**
     *是否禁用
     *
     * Generated from protobuf field <code>.user.Enumerate is_lock = 4;</code>
     */
    private $is_lock = 0;
    /**
     *部门
     *
     * Generated from protobuf field <code>string dept = 5;</code>
     */
    private $dept = '';
    /**
     *停车场id
     *
     * Generated from protobuf field <code>string stations = 6;</code>
     */
    private $stations = '';
    /**
     *停车场类别
     *
     * Generated from protobuf field <code>.user.Enumerate station_type = 7;</code>
     */
    private $station_type = 0;
    /**
     *邮箱
     *
     * Generated from protobuf field <code>string email = 9;</code>
     */
    private $email = '';
    /**
     *账户类别
     *
     * Generated from protobuf field <code>int32 role_type = 10;</code>
     */
    private $role_type = 0;
    /**
     *公司
     *
     * Generated from protobuf field <code>string companies = 11;</code>
     */
    private $companies = '';
    /**
     *后台用户附加信息
     *
     * Generated from protobuf field <code>string attach = 12;</code>
     */
    private $attach = '';
    /**
     *是否自动登录
     *
     * Generated from protobuf field <code>.user.Enumerate is_auto_login = 13;</code>
     */
    private $is_auto_login = 0;

    public function __construct() {
        \GPBMetadata\Member\Share4::initOnce();
        parent::__construct();
    }

    /**
     *后台id
     *
     * Generated from protobuf field <code>int32 member_id = 1;</code>
     * @return int
     */
    public function getMemberId()
    {
        return $this->member_id;
    }

    /**
     *后台id
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
     *后台角色id
     *
     * Generated from protobuf field <code>string role_id = 2;</code>
     * @return string
     */
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     *后台角色id
     *
     * Generated from protobuf field <code>string role_id = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setRoleId($var)
    {
        GPBUtil::checkString($var, True);
        $this->role_id = $var;

        return $this;
    }

    /**
     *账户类型
     *
     * Generated from protobuf field <code>.user.Enumerate type = 3;</code>
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *账户类型
     *
     * Generated from protobuf field <code>.user.Enumerate type = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setType($var)
    {
        GPBUtil::checkEnum($var, \User\Enumerate::class);
        $this->type = $var;

        return $this;
    }

    /**
     *是否禁用
     *
     * Generated from protobuf field <code>.user.Enumerate is_lock = 4;</code>
     * @return int
     */
    public function getIsLock()
    {
        return $this->is_lock;
    }

    /**
     *是否禁用
     *
     * Generated from protobuf field <code>.user.Enumerate is_lock = 4;</code>
     * @param int $var
     * @return $this
     */
    public function setIsLock($var)
    {
        GPBUtil::checkEnum($var, \User\Enumerate::class);
        $this->is_lock = $var;

        return $this;
    }

    /**
     *部门
     *
     * Generated from protobuf field <code>string dept = 5;</code>
     * @return string
     */
    public function getDept()
    {
        return $this->dept;
    }

    /**
     *部门
     *
     * Generated from protobuf field <code>string dept = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setDept($var)
    {
        GPBUtil::checkString($var, True);
        $this->dept = $var;

        return $this;
    }

    /**
     *停车场id
     *
     * Generated from protobuf field <code>string stations = 6;</code>
     * @return string
     */
    public function getStations()
    {
        return $this->stations;
    }

    /**
     *停车场id
     *
     * Generated from protobuf field <code>string stations = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setStations($var)
    {
        GPBUtil::checkString($var, True);
        $this->stations = $var;

        return $this;
    }

    /**
     *停车场类别
     *
     * Generated from protobuf field <code>.user.Enumerate station_type = 7;</code>
     * @return int
     */
    public function getStationType()
    {
        return $this->station_type;
    }

    /**
     *停车场类别
     *
     * Generated from protobuf field <code>.user.Enumerate station_type = 7;</code>
     * @param int $var
     * @return $this
     */
    public function setStationType($var)
    {
        GPBUtil::checkEnum($var, \User\Enumerate::class);
        $this->station_type = $var;

        return $this;
    }

    /**
     *邮箱
     *
     * Generated from protobuf field <code>string email = 9;</code>
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *邮箱
     *
     * Generated from protobuf field <code>string email = 9;</code>
     * @param string $var
     * @return $this
     */
    public function setEmail($var)
    {
        GPBUtil::checkString($var, True);
        $this->email = $var;

        return $this;
    }

    /**
     *账户类别
     *
     * Generated from protobuf field <code>int32 role_type = 10;</code>
     * @return int
     */
    public function getRoleType()
    {
        return $this->role_type;
    }

    /**
     *账户类别
     *
     * Generated from protobuf field <code>int32 role_type = 10;</code>
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
     *公司
     *
     * Generated from protobuf field <code>string companies = 11;</code>
     * @return string
     */
    public function getCompanies()
    {
        return $this->companies;
    }

    /**
     *公司
     *
     * Generated from protobuf field <code>string companies = 11;</code>
     * @param string $var
     * @return $this
     */
    public function setCompanies($var)
    {
        GPBUtil::checkString($var, True);
        $this->companies = $var;

        return $this;
    }

    /**
     *后台用户附加信息
     *
     * Generated from protobuf field <code>string attach = 12;</code>
     * @return string
     */
    public function getAttach()
    {
        return $this->attach;
    }

    /**
     *后台用户附加信息
     *
     * Generated from protobuf field <code>string attach = 12;</code>
     * @param string $var
     * @return $this
     */
    public function setAttach($var)
    {
        GPBUtil::checkString($var, True);
        $this->attach = $var;

        return $this;
    }

    /**
     *是否自动登录
     *
     * Generated from protobuf field <code>.user.Enumerate is_auto_login = 13;</code>
     * @return int
     */
    public function getIsAutoLogin()
    {
        return $this->is_auto_login;
    }

    /**
     *是否自动登录
     *
     * Generated from protobuf field <code>.user.Enumerate is_auto_login = 13;</code>
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

