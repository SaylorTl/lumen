<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: userext/share4.proto

namespace User\Userext;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *用户拓展信息添加请求体
 *
 * Generated from protobuf message <code>user.userext.UserextAddReq</code>
 */
class UserextAddReq extends \Google\Protobuf\Internal\Message
{
    /**
     *用户id
     *
     * Generated from protobuf field <code>int64 user_id = 1;</code>
     */
    private $user_id = 0;
    /**
     *身份证号
     *
     * Generated from protobuf field <code>string govid = 2;</code>
     */
    private $govid = '';
    /**
     *身份证文件
     *
     * Generated from protobuf field <code>string govidfile = 3;</code>
     */
    private $govidfile = '';
    /**
     *月
     *
     * Generated from protobuf field <code>string balance = 4;</code>
     */
    private $balance = '';
    /**
     *驾驶证文件
     *
     * Generated from protobuf field <code>string jsz_id = 5;</code>
     */
    private $jsz_id = '';
    /**
     *审核状态
     *
     * Generated from protobuf field <code>.user.Enumerate check_status = 6;</code>
     */
    private $check_status = 0;
    /**
     *用户地址
     *
     * Generated from protobuf field <code>string address = 7;</code>
     */
    private $address = '';

    public function __construct() {
        \GPBMetadata\Userext\Share4::initOnce();
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
     *身份证号
     *
     * Generated from protobuf field <code>string govid = 2;</code>
     * @return string
     */
    public function getGovid()
    {
        return $this->govid;
    }

    /**
     *身份证号
     *
     * Generated from protobuf field <code>string govid = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setGovid($var)
    {
        GPBUtil::checkString($var, True);
        $this->govid = $var;

        return $this;
    }

    /**
     *身份证文件
     *
     * Generated from protobuf field <code>string govidfile = 3;</code>
     * @return string
     */
    public function getGovidfile()
    {
        return $this->govidfile;
    }

    /**
     *身份证文件
     *
     * Generated from protobuf field <code>string govidfile = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setGovidfile($var)
    {
        GPBUtil::checkString($var, True);
        $this->govidfile = $var;

        return $this;
    }

    /**
     *月
     *
     * Generated from protobuf field <code>string balance = 4;</code>
     * @return string
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     *月
     *
     * Generated from protobuf field <code>string balance = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setBalance($var)
    {
        GPBUtil::checkString($var, True);
        $this->balance = $var;

        return $this;
    }

    /**
     *驾驶证文件
     *
     * Generated from protobuf field <code>string jsz_id = 5;</code>
     * @return string
     */
    public function getJszId()
    {
        return $this->jsz_id;
    }

    /**
     *驾驶证文件
     *
     * Generated from protobuf field <code>string jsz_id = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setJszId($var)
    {
        GPBUtil::checkString($var, True);
        $this->jsz_id = $var;

        return $this;
    }

    /**
     *审核状态
     *
     * Generated from protobuf field <code>.user.Enumerate check_status = 6;</code>
     * @return int
     */
    public function getCheckStatus()
    {
        return $this->check_status;
    }

    /**
     *审核状态
     *
     * Generated from protobuf field <code>.user.Enumerate check_status = 6;</code>
     * @param int $var
     * @return $this
     */
    public function setCheckStatus($var)
    {
        GPBUtil::checkEnum($var, \User\Enumerate::class);
        $this->check_status = $var;

        return $this;
    }

    /**
     *用户地址
     *
     * Generated from protobuf field <code>string address = 7;</code>
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     *用户地址
     *
     * Generated from protobuf field <code>string address = 7;</code>
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
