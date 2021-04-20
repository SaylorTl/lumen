<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: merchantuser/share4.proto

namespace User\Merchantuser;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *商户列表请求体
 *
 * Generated from protobuf message <code>user.merchantuser.McuserGetListReq</code>
 */
class McuserGetListReq extends \Google\Protobuf\Internal\Message
{
    /**
     *页码
     *
     * Generated from protobuf field <code>int32 page = 1;</code>
     */
    private $page = 0;
    /**
     *每页数目
     *
     * Generated from protobuf field <code>int32 pagesize = 2;</code>
     */
    private $pagesize = 0;
    /**
     *商户id
     *
     * Generated from protobuf field <code>int32 merchant_id = 3;</code>
     */
    private $merchant_id = 0;
    /**
     *用户id
     *
     * Generated from protobuf field <code>int32 member_id = 4;</code>
     */
    private $member_id = 0;
    /**
     *商户id集合
     *
     * Generated from protobuf field <code>repeated string merchant_ids = 5;</code>
     */
    private $merchant_ids;
    /**
     *后台id
     *
     * Generated from protobuf field <code>repeated string member_ids = 6;</code>
     */
    private $member_ids;

    public function __construct() {
        \GPBMetadata\Merchantuser\Share4::initOnce();
        parent::__construct();
    }

    /**
     *页码
     *
     * Generated from protobuf field <code>int32 page = 1;</code>
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     *页码
     *
     * Generated from protobuf field <code>int32 page = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setPage($var)
    {
        GPBUtil::checkInt32($var);
        $this->page = $var;

        return $this;
    }

    /**
     *每页数目
     *
     * Generated from protobuf field <code>int32 pagesize = 2;</code>
     * @return int
     */
    public function getPagesize()
    {
        return $this->pagesize;
    }

    /**
     *每页数目
     *
     * Generated from protobuf field <code>int32 pagesize = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setPagesize($var)
    {
        GPBUtil::checkInt32($var);
        $this->pagesize = $var;

        return $this;
    }

    /**
     *商户id
     *
     * Generated from protobuf field <code>int32 merchant_id = 3;</code>
     * @return int
     */
    public function getMerchantId()
    {
        return $this->merchant_id;
    }

    /**
     *商户id
     *
     * Generated from protobuf field <code>int32 merchant_id = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setMerchantId($var)
    {
        GPBUtil::checkInt32($var);
        $this->merchant_id = $var;

        return $this;
    }

    /**
     *用户id
     *
     * Generated from protobuf field <code>int32 member_id = 4;</code>
     * @return int
     */
    public function getMemberId()
    {
        return $this->member_id;
    }

    /**
     *用户id
     *
     * Generated from protobuf field <code>int32 member_id = 4;</code>
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
     *商户id集合
     *
     * Generated from protobuf field <code>repeated string merchant_ids = 5;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getMerchantIds()
    {
        return $this->merchant_ids;
    }

    /**
     *商户id集合
     *
     * Generated from protobuf field <code>repeated string merchant_ids = 5;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setMerchantIds($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->merchant_ids = $arr;

        return $this;
    }

    /**
     *后台id
     *
     * Generated from protobuf field <code>repeated string member_ids = 6;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getMemberIds()
    {
        return $this->member_ids;
    }

    /**
     *后台id
     *
     * Generated from protobuf field <code>repeated string member_ids = 6;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setMemberIds($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->member_ids = $arr;

        return $this;
    }

}

