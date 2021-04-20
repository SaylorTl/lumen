<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: share4.proto

namespace User;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *驾驶证展示列表
 *
 * Generated from protobuf message <code>user.JszListData</code>
 */
class JszListData extends \Google\Protobuf\Internal\Message
{
    /**
     *驾驶证自增id
     *
     * Generated from protobuf field <code>int32 jsz_id = 1;</code>
     */
    private $jsz_id = 0;
    /**
     *用户id
     *
     * Generated from protobuf field <code>int64 user_id = 2;</code>
     */
    private $user_id = 0;
    /**
     *驾驶证图片
     *
     * Generated from protobuf field <code>string jsz_img = 3;</code>
     */
    private $jsz_img = '';
    /**
     *驾驶证号码
     *
     * Generated from protobuf field <code>string jsz_number = 4;</code>
     */
    private $jsz_number = '';
    /**
     *姓名
     *
     * Generated from protobuf field <code>string real_name = 5;</code>
     */
    private $real_name = '';
    /**
     *性别
     *
     * Generated from protobuf field <code>string sex = 6;</code>
     */
    private $sex = '';
    /**
     *国籍
     *
     * Generated from protobuf field <code>string national = 7;</code>
     */
    private $national = '';
    /**
     *出生日期
     *
     * Generated from protobuf field <code>string birth_date = 8;</code>
     */
    private $birth_date = '';
    /**
     *领证日期
     *
     * Generated from protobuf field <code>string receive_date = 9;</code>
     */
    private $receive_date = '';
    /**
     *准驾车型
     *
     * Generated from protobuf field <code>string drive_type = 10;</code>
     */
    private $drive_type = '';
    /**
     *开始日期
     *
     * Generated from protobuf field <code>string start_date = 11;</code>
     */
    private $start_date = '';
    /**
     *有效日期
     *
     * Generated from protobuf field <code>string valid_date = 12;</code>
     */
    private $valid_date = '';
    /**
     *地址
     *
     * Generated from protobuf field <code>string address = 13;</code>
     */
    private $address = '';
    /**
     *发证单位
     *
     * Generated from protobuf field <code>string issue_unit = 14;</code>
     */
    private $issue_unit = '';
    /**
     *红章
     *
     * Generated from protobuf field <code>string red_chapter = 15;</code>
     */
    private $red_chapter = '';
    /**
     *创建日期
     *
     * Generated from protobuf field <code>string create_at = 16;</code>
     */
    private $create_at = '';
    /**
     *更新日期
     *
     * Generated from protobuf field <code>string update_at = 17;</code>
     */
    private $update_at = '';

    public function __construct() {
        \GPBMetadata\Share4::initOnce();
        parent::__construct();
    }

    /**
     *驾驶证自增id
     *
     * Generated from protobuf field <code>int32 jsz_id = 1;</code>
     * @return int
     */
    public function getJszId()
    {
        return $this->jsz_id;
    }

    /**
     *驾驶证自增id
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
     *驾驶证图片
     *
     * Generated from protobuf field <code>string jsz_img = 3;</code>
     * @return string
     */
    public function getJszImg()
    {
        return $this->jsz_img;
    }

    /**
     *驾驶证图片
     *
     * Generated from protobuf field <code>string jsz_img = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setJszImg($var)
    {
        GPBUtil::checkString($var, True);
        $this->jsz_img = $var;

        return $this;
    }

    /**
     *驾驶证号码
     *
     * Generated from protobuf field <code>string jsz_number = 4;</code>
     * @return string
     */
    public function getJszNumber()
    {
        return $this->jsz_number;
    }

    /**
     *驾驶证号码
     *
     * Generated from protobuf field <code>string jsz_number = 4;</code>
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
     *姓名
     *
     * Generated from protobuf field <code>string real_name = 5;</code>
     * @return string
     */
    public function getRealName()
    {
        return $this->real_name;
    }

    /**
     *姓名
     *
     * Generated from protobuf field <code>string real_name = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setRealName($var)
    {
        GPBUtil::checkString($var, True);
        $this->real_name = $var;

        return $this;
    }

    /**
     *性别
     *
     * Generated from protobuf field <code>string sex = 6;</code>
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     *性别
     *
     * Generated from protobuf field <code>string sex = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setSex($var)
    {
        GPBUtil::checkString($var, True);
        $this->sex = $var;

        return $this;
    }

    /**
     *国籍
     *
     * Generated from protobuf field <code>string national = 7;</code>
     * @return string
     */
    public function getNational()
    {
        return $this->national;
    }

    /**
     *国籍
     *
     * Generated from protobuf field <code>string national = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setNational($var)
    {
        GPBUtil::checkString($var, True);
        $this->national = $var;

        return $this;
    }

    /**
     *出生日期
     *
     * Generated from protobuf field <code>string birth_date = 8;</code>
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     *出生日期
     *
     * Generated from protobuf field <code>string birth_date = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setBirthDate($var)
    {
        GPBUtil::checkString($var, True);
        $this->birth_date = $var;

        return $this;
    }

    /**
     *领证日期
     *
     * Generated from protobuf field <code>string receive_date = 9;</code>
     * @return string
     */
    public function getReceiveDate()
    {
        return $this->receive_date;
    }

    /**
     *领证日期
     *
     * Generated from protobuf field <code>string receive_date = 9;</code>
     * @param string $var
     * @return $this
     */
    public function setReceiveDate($var)
    {
        GPBUtil::checkString($var, True);
        $this->receive_date = $var;

        return $this;
    }

    /**
     *准驾车型
     *
     * Generated from protobuf field <code>string drive_type = 10;</code>
     * @return string
     */
    public function getDriveType()
    {
        return $this->drive_type;
    }

    /**
     *准驾车型
     *
     * Generated from protobuf field <code>string drive_type = 10;</code>
     * @param string $var
     * @return $this
     */
    public function setDriveType($var)
    {
        GPBUtil::checkString($var, True);
        $this->drive_type = $var;

        return $this;
    }

    /**
     *开始日期
     *
     * Generated from protobuf field <code>string start_date = 11;</code>
     * @return string
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     *开始日期
     *
     * Generated from protobuf field <code>string start_date = 11;</code>
     * @param string $var
     * @return $this
     */
    public function setStartDate($var)
    {
        GPBUtil::checkString($var, True);
        $this->start_date = $var;

        return $this;
    }

    /**
     *有效日期
     *
     * Generated from protobuf field <code>string valid_date = 12;</code>
     * @return string
     */
    public function getValidDate()
    {
        return $this->valid_date;
    }

    /**
     *有效日期
     *
     * Generated from protobuf field <code>string valid_date = 12;</code>
     * @param string $var
     * @return $this
     */
    public function setValidDate($var)
    {
        GPBUtil::checkString($var, True);
        $this->valid_date = $var;

        return $this;
    }

    /**
     *地址
     *
     * Generated from protobuf field <code>string address = 13;</code>
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     *地址
     *
     * Generated from protobuf field <code>string address = 13;</code>
     * @param string $var
     * @return $this
     */
    public function setAddress($var)
    {
        GPBUtil::checkString($var, True);
        $this->address = $var;

        return $this;
    }

    /**
     *发证单位
     *
     * Generated from protobuf field <code>string issue_unit = 14;</code>
     * @return string
     */
    public function getIssueUnit()
    {
        return $this->issue_unit;
    }

    /**
     *发证单位
     *
     * Generated from protobuf field <code>string issue_unit = 14;</code>
     * @param string $var
     * @return $this
     */
    public function setIssueUnit($var)
    {
        GPBUtil::checkString($var, True);
        $this->issue_unit = $var;

        return $this;
    }

    /**
     *红章
     *
     * Generated from protobuf field <code>string red_chapter = 15;</code>
     * @return string
     */
    public function getRedChapter()
    {
        return $this->red_chapter;
    }

    /**
     *红章
     *
     * Generated from protobuf field <code>string red_chapter = 15;</code>
     * @param string $var
     * @return $this
     */
    public function setRedChapter($var)
    {
        GPBUtil::checkString($var, True);
        $this->red_chapter = $var;

        return $this;
    }

    /**
     *创建日期
     *
     * Generated from protobuf field <code>string create_at = 16;</code>
     * @return string
     */
    public function getCreateAt()
    {
        return $this->create_at;
    }

    /**
     *创建日期
     *
     * Generated from protobuf field <code>string create_at = 16;</code>
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
     *更新日期
     *
     * Generated from protobuf field <code>string update_at = 17;</code>
     * @return string
     */
    public function getUpdateAt()
    {
        return $this->update_at;
    }

    /**
     *更新日期
     *
     * Generated from protobuf field <code>string update_at = 17;</code>
     * @param string $var
     * @return $this
     */
    public function setUpdateAt($var)
    {
        GPBUtil::checkString($var, True);
        $this->update_at = $var;

        return $this;
    }

}
