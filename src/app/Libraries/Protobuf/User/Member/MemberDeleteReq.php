<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: member/share4.proto

namespace User\Member;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *会员删除
 *
 * Generated from protobuf message <code>user.member.MemberDeleteReq</code>
 */
class MemberDeleteReq extends \Google\Protobuf\Internal\Message
{
    /**
     *会员id
     *
     * Generated from protobuf field <code>int64 member_id = 1;</code>
     */
    private $member_id = 0;

    public function __construct() {
        \GPBMetadata\Member\Share4::initOnce();
        parent::__construct();
    }

    /**
     *会员id
     *
     * Generated from protobuf field <code>int64 member_id = 1;</code>
     * @return int|string
     */
    public function getMemberId()
    {
        return $this->member_id;
    }

    /**
     *会员id
     *
     * Generated from protobuf field <code>int64 member_id = 1;</code>
     * @param int|string $var
     * @return $this
     */
    public function setMemberId($var)
    {
        GPBUtil::checkInt64($var);
        $this->member_id = $var;

        return $this;
    }

}

