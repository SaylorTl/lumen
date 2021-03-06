<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: share4.proto

namespace User;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *展示客户端加用户数据
 *
 * Generated from protobuf message <code>user.ShowUsersData</code>
 */
class ShowUsersData extends \Google\Protobuf\Internal\Message
{
    /**
     *客户端id
     *
     * Generated from protobuf field <code>int32 client_id = 1;</code>
     */
    private $client_id = 0;
    /**
     *用户id
     *
     * Generated from protobuf field <code>int64 user_id = 2;</code>
     */
    private $user_id = 0;
    /**
     *客户端类型
     *
     * Generated from protobuf field <code>.user.Enumerate kind = 3;</code>
     */
    private $kind = 0;
    /**
     *应用id
     *
     * Generated from protobuf field <code>string app_id = 4;</code>
     */
    private $app_id = '';
    /**
     *授权id
     *
     * Generated from protobuf field <code>string openid = 5;</code>
     */
    private $openid = '';
    /**
     *创建时间
     *
     * Generated from protobuf field <code>string create_at = 6;</code>
     */
    private $create_at = '';
    /**
     *更新时间
     *
     * Generated from protobuf field <code>string update_at = 7;</code>
     */
    private $update_at = '';
    /**
     *性别
     *
     * Generated from protobuf field <code>.user.Enumerate sex = 8;</code>
     */
    private $sex = 0;
    /**
     *真实姓名
     *
     * Generated from protobuf field <code>string fullname = 9;</code>
     */
    private $fullname = '';
    /**
     *昵称
     *
     * Generated from protobuf field <code>string nickname = 10;</code>
     */
    private $nickname = '';
    /**
     *用户名
     *
     * Generated from protobuf field <code>string username = 11;</code>
     */
    private $username = '';
    /**
     *手机号
     *
     * Generated from protobuf field <code>string mobile = 12;</code>
     */
    private $mobile = '';
    /**
     *电子邮箱
     *
     * Generated from protobuf field <code>string email = 13;</code>
     */
    private $email = '';
    /**
     *头像
     *
     * Generated from protobuf field <code>string head_img = 14;</code>
     */
    private $head_img = '';
    /**
     *账户状态
     *
     * Generated from protobuf field <code>.user.Enumerate status = 15;</code>
     */
    private $status = 0;
    /**
     *是否锁定
     *
     * Generated from protobuf field <code>.user.Enumerate autolock = 16;</code>
     */
    private $autolock = 0;
    /**
     *是否验证
     *
     * Generated from protobuf field <code>.user.Enumerate verify = 17;</code>
     */
    private $verify = 0;
    /**
     *union表递增id
     *
     * Generated from protobuf field <code>int32 uni_id = 18;</code>
     */
    private $uni_id = 0;
    /**
     *微信公众号unionid
     *
     * Generated from protobuf field <code>string unionid = 19;</code>
     */
    private $unionid = '';

    public function __construct() {
        \GPBMetadata\Share4::initOnce();
        parent::__construct();
    }

    /**
     *客户端id
     *
     * Generated from protobuf field <code>int32 client_id = 1;</code>
     * @return int
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     *客户端id
     *
     * Generated from protobuf field <code>int32 client_id = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setClientId($var)
    {
        GPBUtil::checkInt32($var);
        $this->client_id = $var;

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
     *客户端类型
     *
     * Generated from protobuf field <code>.user.Enumerate kind = 3;</code>
     * @return int
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     *客户端类型
     *
     * Generated from protobuf field <code>.user.Enumerate kind = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setKind($var)
    {
        GPBUtil::checkEnum($var, \User\Enumerate::class);
        $this->kind = $var;

        return $this;
    }

    /**
     *应用id
     *
     * Generated from protobuf field <code>string app_id = 4;</code>
     * @return string
     */
    public function getAppId()
    {
        return $this->app_id;
    }

    /**
     *应用id
     *
     * Generated from protobuf field <code>string app_id = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setAppId($var)
    {
        GPBUtil::checkString($var, True);
        $this->app_id = $var;

        return $this;
    }

    /**
     *授权id
     *
     * Generated from protobuf field <code>string openid = 5;</code>
     * @return string
     */
    public function getOpenid()
    {
        return $this->openid;
    }

    /**
     *授权id
     *
     * Generated from protobuf field <code>string openid = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setOpenid($var)
    {
        GPBUtil::checkString($var, True);
        $this->openid = $var;

        return $this;
    }

    /**
     *创建时间
     *
     * Generated from protobuf field <code>string create_at = 6;</code>
     * @return string
     */
    public function getCreateAt()
    {
        return $this->create_at;
    }

    /**
     *创建时间
     *
     * Generated from protobuf field <code>string create_at = 6;</code>
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
     * Generated from protobuf field <code>string update_at = 7;</code>
     * @return string
     */
    public function getUpdateAt()
    {
        return $this->update_at;
    }

    /**
     *更新时间
     *
     * Generated from protobuf field <code>string update_at = 7;</code>
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
     *性别
     *
     * Generated from protobuf field <code>.user.Enumerate sex = 8;</code>
     * @return int
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     *性别
     *
     * Generated from protobuf field <code>.user.Enumerate sex = 8;</code>
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
     *真实姓名
     *
     * Generated from protobuf field <code>string fullname = 9;</code>
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     *真实姓名
     *
     * Generated from protobuf field <code>string fullname = 9;</code>
     * @param string $var
     * @return $this
     */
    public function setFullname($var)
    {
        GPBUtil::checkString($var, True);
        $this->fullname = $var;

        return $this;
    }

    /**
     *昵称
     *
     * Generated from protobuf field <code>string nickname = 10;</code>
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     *昵称
     *
     * Generated from protobuf field <code>string nickname = 10;</code>
     * @param string $var
     * @return $this
     */
    public function setNickname($var)
    {
        GPBUtil::checkString($var, True);
        $this->nickname = $var;

        return $this;
    }

    /**
     *用户名
     *
     * Generated from protobuf field <code>string username = 11;</code>
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     *用户名
     *
     * Generated from protobuf field <code>string username = 11;</code>
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
     *手机号
     *
     * Generated from protobuf field <code>string mobile = 12;</code>
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     *手机号
     *
     * Generated from protobuf field <code>string mobile = 12;</code>
     * @param string $var
     * @return $this
     */
    public function setMobile($var)
    {
        GPBUtil::checkString($var, True);
        $this->mobile = $var;

        return $this;
    }

    /**
     *电子邮箱
     *
     * Generated from protobuf field <code>string email = 13;</code>
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *电子邮箱
     *
     * Generated from protobuf field <code>string email = 13;</code>
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
     *头像
     *
     * Generated from protobuf field <code>string head_img = 14;</code>
     * @return string
     */
    public function getHeadImg()
    {
        return $this->head_img;
    }

    /**
     *头像
     *
     * Generated from protobuf field <code>string head_img = 14;</code>
     * @param string $var
     * @return $this
     */
    public function setHeadImg($var)
    {
        GPBUtil::checkString($var, True);
        $this->head_img = $var;

        return $this;
    }

    /**
     *账户状态
     *
     * Generated from protobuf field <code>.user.Enumerate status = 15;</code>
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *账户状态
     *
     * Generated from protobuf field <code>.user.Enumerate status = 15;</code>
     * @param int $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkEnum($var, \User\Enumerate::class);
        $this->status = $var;

        return $this;
    }

    /**
     *是否锁定
     *
     * Generated from protobuf field <code>.user.Enumerate autolock = 16;</code>
     * @return int
     */
    public function getAutolock()
    {
        return $this->autolock;
    }

    /**
     *是否锁定
     *
     * Generated from protobuf field <code>.user.Enumerate autolock = 16;</code>
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
     *是否验证
     *
     * Generated from protobuf field <code>.user.Enumerate verify = 17;</code>
     * @return int
     */
    public function getVerify()
    {
        return $this->verify;
    }

    /**
     *是否验证
     *
     * Generated from protobuf field <code>.user.Enumerate verify = 17;</code>
     * @param int $var
     * @return $this
     */
    public function setVerify($var)
    {
        GPBUtil::checkEnum($var, \User\Enumerate::class);
        $this->verify = $var;

        return $this;
    }

    /**
     *union表递增id
     *
     * Generated from protobuf field <code>int32 uni_id = 18;</code>
     * @return int
     */
    public function getUniId()
    {
        return $this->uni_id;
    }

    /**
     *union表递增id
     *
     * Generated from protobuf field <code>int32 uni_id = 18;</code>
     * @param int $var
     * @return $this
     */
    public function setUniId($var)
    {
        GPBUtil::checkInt32($var);
        $this->uni_id = $var;

        return $this;
    }

    /**
     *微信公众号unionid
     *
     * Generated from protobuf field <code>string unionid = 19;</code>
     * @return string
     */
    public function getUnionid()
    {
        return $this->unionid;
    }

    /**
     *微信公众号unionid
     *
     * Generated from protobuf field <code>string unionid = 19;</code>
     * @param string $var
     * @return $this
     */
    public function setUnionid($var)
    {
        GPBUtil::checkString($var, True);
        $this->unionid = $var;

        return $this;
    }

}

