<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: userjsz/share4.proto

namespace User\Userjsz;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *驾驶证返回体
 *
 * Generated from protobuf message <code>user.userjsz.JszShowRes</code>
 */
class JszShowRes extends \Google\Protobuf\Internal\Message
{
    /**
     *返回码
     *
     * Generated from protobuf field <code>int32 code = 1;</code>
     */
    private $code = 0;
    /**
     *返回内容
     *
     * Generated from protobuf field <code>.user.JszShowData content = 2;</code>
     */
    private $content = null;
    /**
     *返回信息
     *
     * Generated from protobuf field <code>string message = 3;</code>
     */
    private $message = '';

    public function __construct() {
        \GPBMetadata\Userjsz\Share4::initOnce();
        parent::__construct();
    }

    /**
     *返回码
     *
     * Generated from protobuf field <code>int32 code = 1;</code>
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     *返回码
     *
     * Generated from protobuf field <code>int32 code = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setCode($var)
    {
        GPBUtil::checkInt32($var);
        $this->code = $var;

        return $this;
    }

    /**
     *返回内容
     *
     * Generated from protobuf field <code>.user.JszShowData content = 2;</code>
     * @return \User\JszShowData
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     *返回内容
     *
     * Generated from protobuf field <code>.user.JszShowData content = 2;</code>
     * @param \User\JszShowData $var
     * @return $this
     */
    public function setContent($var)
    {
        GPBUtil::checkMessage($var, \User\JszShowData::class);
        $this->content = $var;

        return $this;
    }

    /**
     *返回信息
     *
     * Generated from protobuf field <code>string message = 3;</code>
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     *返回信息
     *
     * Generated from protobuf field <code>string message = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setMessage($var)
    {
        GPBUtil::checkString($var, True);
        $this->message = $var;

        return $this;
    }

}

