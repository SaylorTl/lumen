<?php

namespace App\Libraries;

use Jaeger\Span;
use Exception;

class LumenTracer
{

    /**
     * 获取功能开关
     */
    private static function getSwitch()
    {
        $switch = env('JAEGER_SERVER_SWITCH', 'off');
        if ($switch == 'on') {
            return true;
        }
        return false;
    }

    /**
     * 设置tracer全局变量
     */
    public static function setTracer()
    {
        //获取功能开关，关闭时直接返回false
        if (!self::getSwitch()) {
            return false;
        }
        try {
            $tracer = JaegerTracer::getInstance();
            if ($tracer instanceof JaegerTracer) {
                config(['tracer' => $tracer]);
                return true;
            } else {
                app('log')->info('----LumenTracer/'.__FUNCTION__.'----', [
                    'line' => __LINE__,
                    'error' => 'tracer is not an JaegerTracer object'
                ]);
                return false;
            }
        } catch (Exception $e) {
            app('log')->info('----LumenTracer/'.__FUNCTION__.'----', [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }


    /**
     * 设置span
     * @param  string  $span_name
     * @param  array  $params
     * @param  array  $inject_target
     * @return bool
     */
    public static function setSpan($span_name, $params, $inject_target = [])
    {
        //获取功能开关，关闭时直接返回false
        if (!self::getSwitch()) {
            return false;
        }
        if (self::checkTracer() == false) {
            return false;
        }
        $tracer = config('tracer');
        try {
            $span = $tracer::getSpan($span_name, $inject_target);
            $span_info = $tracer::getSpanInfo($span);
            //记录请求参数信息
            $span->log($params);
            //设置/更新全局变量
            config(['span' => $span]);
            config(['span_info' => $span_info]);
            return true;
        } catch (Exception $e) {
            app('log')->info('----LumenTracer/'.__FUNCTION__.'----', [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * 设置span info的全局变量
     * @return bool
     */
    public static function setSpanInfo()
    {
        //获取功能开关，关闭时直接返回false
        if (!self::getSwitch()) {
            return false;
        }
        if (!self::checkTracer() || !self::checkSpan()) {
            return false;
        }
        $tracer = config('tracer');
        $span = config('span');
        try {
            $span_info = $tracer::getSpanInfo($span);
            config(['span_info' => $span_info], []);
            return true;
        } catch (Exception $e) {
            app('log')->info('----LumenTracer/'.__FUNCTION__.'----', [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * 完成当前节点
     */
    public static function finish()
    {
        if (self::checkSpan()) {
            config('span')->finish();
        }
    }

    /**
     * 推送信息到jaegertracing
     */
    public static function flush()
    {
        if (self::checkTracer()) {
            config('tracer')->flush();
        }
    }

    /**
     * 检查span对象
     * @return bool
     */
    public static function checkSpan()
    {
        //获取功能开关，关闭时直接返回false
        if (!self::getSwitch()) {
            return false;
        }
        $span = $tracer = config('span');
        if (!($span instanceof Span)) {
            app('log')->info('----LumenTracer/'.__FUNCTION__.'----', [
                'line' => __LINE__,
                'error' => 'span is not an \Jaeger\Span object'
            ]);
            return false;
        }
        return true;
    }

    /**
     * 检查tracer对象
     * @return bool
     */
    public static function checkTracer()
    {
        if (!self::getSwitch()) {
            return false;
        }
        $tracer = $tracer = config('tracer');
        if (!($tracer instanceof JaegerTracer)) {
            app('log')->info('----LumenTracer/'.__FUNCTION__.'----', [
                'line' => __LINE__,
                'error' => 'tracer is not an JaegerTracer object'
            ]);
            return false;
        }
        return true;
    }

    /**
     * 从Headers获取jaegertracing相关信息
     * @return array
     */
    public static function getJaegerHeaders()
    {
        $headers = [];
        if (!self::getSwitch() || strpos(PHP_SAPI, 'cli') !== false) {
            return $headers;
        }
        foreach (getallheaders() as $key => $value) {
            $headers[strtolower($key)] = $value;
        }
        $inject_target = [];
        if (isset($headers['x-b3-sampled']) && isset($headers['x-b3-spanid']) &&
            isset($headers['x-b3-parentspanid']) && isset($headers['x-b3-traceid'])) {
            $inject_target = [
                'x-b3-sampled' => $headers['x-b3-sampled'],
                'x-b3-spanid' => $headers['x-b3-spanid'],
                'x-b3-parentspanid' => $headers['x-b3-parentspanid'],
                'x-b3-traceid' => $headers['x-b3-traceid'],
            ];
        }
        return $inject_target;
    }
}