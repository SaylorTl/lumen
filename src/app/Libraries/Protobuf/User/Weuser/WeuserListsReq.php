<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: weuser/share4.proto

namespace User\Weuser;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *微信拓展信息展示
 *
 * Generated from protobuf message <code>user.weuser.WeuserListsReq</code>
 */
class WeuserListsReq extends \Google\Protobuf\Internal\Message
{
    /**
     *页码
     *
     * Generated from protobuf field <code>int32 page = 1;</code>
     */
    private $page = 0;
    /**
     *条数
     *
     * Generated from protobuf field <code>int32 pagesize = 2;</code>
     */
    private $pagesize = 0;
    /**
     *是否订阅
     *
     * Generated from protobuf field <code>.user.Enumerate subscribe = 3;</code>
     */
    private $subscribe = 0;
    /**
     *微信unionid
     *
     * Generated from protobuf field <code>string unionid = 4;</code>
     */
    private $unionid = '';
    /**
     *客户端id
     *
     * Generated from protobuf field <code>int32 client_id = 5;</code>
     */
    private $client_id = 0;
    /**
     *客户端id集合
     *
     * Generated from protobuf field <code>repeated int64 client_ids = 6;</code>
     */
    private $client_ids;

    public function __construct() {
        \GPBMetadata\Weuser\Share4::initOnce();
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
     *条数
     *
     * Generated from protobuf field <code>int32 pagesize = 2;</code>
     * @return int
     */
    public function getPagesize()
    {
        return $this->pagesize;
    }

    /**
     *条数
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
     *是否订阅
     *
     * Generated from protobuf field <code>.user.Enumerate subscribe = 3;</code>
     * @return int
     */
    public function getSubscribe()
    {
        return $this->subscribe;
    }

    /**
     *是否订阅
     *
     * Generated from protobuf field <code>.user.Enumerate subscribe = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setSubscribe($var)
    {
        GPBUtil::checkEnum($var, \User\Enumerate::class);
        $this->subscribe = $var;

        return $this;
    }

    /**
     *微信unionid
     *
     * Generated from protobuf field <code>string unionid = 4;</code>
     * @return string
     */
    public function getUnionid()
    {
        return $this->unionid;
    }

    /**
     *微信unionid
     *
     * Generated from protobuf field <code>string unionid = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setUnionid($var)
    {
        GPBUtil::checkString($var, True);
        $this->unionid = $var;

        return $this;
    }

    /**
     *客户端id
     *
     * Generated from protobuf field <code>int32 client_id = 5;</code>
     * @return int
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     *客户端id
     *
     * Generated from protobuf field <code>int32 client_id = 5;</code>
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
     *客户端id集合
     *
     * Generated from protobuf field <code>repeated int64 client_ids = 6;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getClientIds()
    {
        return $this->client_ids;
    }

    /**
     *客户端id集合
     *
     * Generated from protobuf field <code>repeated int64 client_ids = 6;</code>
     * @param int[]|string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setClientIds($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::INT64);
        $this->client_ids = $arr;

        return $this;
    }

}
