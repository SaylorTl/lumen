<?php
namespace App\Libraries;

class ConsistentHashing
{
    // 圆环
    // hash -> 节点
    private $_ring = array();
    // 所有节点
    // 节点 -> hash
    public $nodes = array();
    // 每个节点的虚拟节点
    public $virtual = 64;

    /**
     * 构造
     * @param array $nodes 初始化的节点列表
     */
    public function __construct($nodes = array())
    {
        if (!empty($nodes)) {
            foreach ($nodes as $value) {
                $this->addNode($value);
            }
        }
    }

    /**
     * 获取圆环内容
     * @return array $this->_ring
     */
    public function getRing()
    {
        return $this->_ring;
    }

    /**
     * time33 函数
     * @param  string $str
     * @return 32位正整数
     * @author 大神们
     */
    public function time33($str)
    {
        // hash(i) = hash(i-1) * 33 + str[i]
        // $hash = 5381; ## 将hash设置为0，竟然比设置为5381分布效果更好！！！
        $hash = 0;
        $s    = md5($str); //相比其它版本，进行了md5加密
        $seed = 5;
        $len  = 32;//加密后长度32
        for ($i = 0; $i < $len; $i++) {
            // (hash << 5) + hash 相当于 hash * 33
            //$hash = sprintf("%u", $hash * 33) + ord($s{$i});
            //$hash = ($hash * 33 + ord($s{$i})) & 0x7FFFFFFF;
            $hash = ($hash << $seed) + $hash + ord($s{$i});
        }
        return $hash & 0x7FFFFFFF;
    }

    /**
     * 增加节点
     * @param string $node 节点名称
     * @return object $this
     */
    public function addNode($node)
    {
        if (in_array($node, array_keys($this->nodes))) {
            return;
        }
        for ($i = 1; $i <= $this->virtual; $i++) {
            $key                  = $this->time33($node . '-' . $i);
            $this->_ring[$key]    = $node;
            $this->nodes[$node][] = $key;
        }
        ksort($this->_ring, SORT_NUMERIC);
        return $this;
    }

    /**
     * 获取字符串的HASH在圆环上面映射到的节点
     * @param  string $key
     * @return string $node
     */
    public function getNode($key)
    {
        $node = current($this->_ring);
        $hash = $this->time33($key);
        foreach ($this->_ring as $key => $value) {
            if ($hash <= $key) {
                $node = $value;
                break;
            }
        }
        return $node;
    }

    /**
     * 获取映射到特定节点的KEY
     * 此方法需手动调用，非特殊情况不建议程序中使用此方法
     * @param  string $node
     * @param  string $keyPre
     * @return mixed
     */
    public function getKey($node, $keyPre = ""){
        if(!in_array($node, array_keys($this->nodes))){
            return false;
        }
        $result = false;
        for($i=1;$i<=10000;$i++){
            $key = $keyPre . md5(rand(1000, 9999));
            if($this->getNode($key) == $node){
                $result = true;
                break;
            }
        }
        return $result ? $key : false;
    }

}