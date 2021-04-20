<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: userjsz/share4.proto

namespace User\Userjsz;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *驾驶证删除
 *
 * Generated from protobuf message <code>user.userjsz.JszDelReq</code>
 */
class JszDelReq extends \Google\Protobuf\Internal\Message
{
    /**
     *驾驶证id
     *
     * Generated from protobuf field <code>int32 jsz_id = 1;</code>
     */
    private $jsz_id = 0;
    /**
     *驾驶证号码
     *
     * Generated from protobuf field <code>string jsz_number = 2;</code>
     */
    private $jsz_number = '';
    /**
     *用户id
     *
     * Generated from protobuf field <code>int64 user_id = 3;</code>
     */
    private $user_id = 0;

    public function __construct() {
        \GPBMetadata\Userjsz\Share4::initOnce();
        parent::__construct();
    }

    /**
     *驾驶证id
     *
     * Generated from protobuf field <code>int32 jsz_id = 1;</code>
     * @return int
     */
    public function getJszId()
    {
        return $this->jsz_id;
    }

    /**
     *驾驶证id
     *
     * Generated from protobuf field <code>int32 jsz_id = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setJszId($var)
    {
        GPBUtil::checkInt32($var);
        $this->jsz_id = $var;

        return $this;
    }

    /**
     *驾驶证号码
     *
     * Generated from protobuf field <code>string jsz_number = 2;</code>
     * @return string
     */
    public function getJszNumber()
    {
        return $this->jsz_number;
    }

    /**
     *驾驶证号码
     *
     * Generated from protobuf field <code>string jsz_number = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setJszNumber($var)
    {
        GPBUtil::checkString($var, True);
        $this->jsz_number = $var;

        return $this;
    }

    /**
     *用户id
     *
     * Generated from protobuf field <code>int64 user_id = 3;</code>
     * @return int|string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     *用户id
     *
     * Generated from protobuf field <code>int64 user_id = 3;</code>
     * @param int|string $var
     * @return $this
     */
    public function setUserId($var)
    {
        GPBUtil::checkInt64($var);
        $this->user_id = $var;

        return $this;
    }

}
