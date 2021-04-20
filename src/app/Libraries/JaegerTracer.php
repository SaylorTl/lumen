<?php

namespace App\Libraries;

use Jaeger\Config;
use OpenTracing\Formats;
use Exception;
use OpenTracing\Span;
use const Jaeger\Constants\PROPAGATOR_ZIPKIN;

class JaegerTracer
{
    //服务名称
    private static $server_name = '';

    //jaeger代理地址和端口
    private static $agent_host_port = '';

    public static $tracer = null;

    public static $span = null;

    public static $instance = null;

    private function __construct()
    {

    }

    private function __clone()
    {

    }

    /**
     * 获取JaegerTracer实例
     * @return JaegerTracer|null
     * @throws Exception
     */
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        self::init();
        return self::$instance;
    }

    /**
     * @throws Exception
     */
    private static function init()
    {
        self::$server_name = env('JAEGER_SERVER_NAME', '');
        self::$agent_host_port = env('JAEGER_AGENT_HOST_PORT', '');

        if (!self::$server_name) {
            throw new Exception("JAEGER_SERVER_NAME undefined in env file");
        }
        if (!self::$agent_host_port) {
            throw new Exception("JAEGER_AGENT_HOST_PORT undefined in env file");
        }

        $config = Config::getInstance();
        $config->gen128bit();
        $config::$propagator = PROPAGATOR_ZIPKIN;
        self::$tracer = $config->initTracer(self::$server_name, self::$agent_host_port);
    }

    /**
     * 获取span
     * @param $span_name
     * @param  array  $inject_target  上一个节点的信息
     * @return mixed
     * @throws \Exception
     */
    public static function getSpan($span_name, $inject_target = [])
    {
        if ($span_name == '') {
            throw new Exception("span_name require");
        }
        app('log')->info('---getSpan-----',$inject_target);
        if (!empty($inject_target)) {
            $span_context = self::$tracer->extract(Formats\TEXT_MAP, $inject_target);
            $options = ['child_of' => $span_context];
        } else {
            $options = [];
        }
        return self::$tracer->startSpan($span_name, $options);
    }

    /**
     * 获取span的traceid、parentspanid、spanid和sampled等信息
     * @param $span
     * @return array
     * @throws Exception
     */
    public static function getSpanInfo($span)
    {
        if (!($span instanceof Span)) {
            throw new \Exception("span is not an \OpenTracing\Span object");
        }
        $info = [];
        self::$tracer->inject($span->spanContext, Formats\TEXT_MAP, $info);
        return $info;
    }

    /**
     * 推送信息到jaeger
     */
    public static function flush()
    {
        self::$tracer->flush();
    }
}