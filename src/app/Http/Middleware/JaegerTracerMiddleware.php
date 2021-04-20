<?php

namespace App\Http\Middleware;

use App\Libraries\LumenTracer;
use Closure;
use Exception;
use Illuminate\Http\Request;

class JaegerTracerMiddleware
{

    /**
     * @param $request
     * @param  Closure  $next
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        /*-------------------------访问控制器前-------------------------*/
        //创建span，获取上一个span的信息,记录Headers
        app('log')->info('---jaeger-----1',[LumenTracer::getJaegerHeaders()]);
        app('log')->info('---jaeger-----2',[getallheaders()]);
        LumenTracer::setSpan($request->path(),['Headers' => getallheaders()], LumenTracer::getJaegerHeaders());
        $next($request);

        /*-------------------------访问控制器后-------------------------*/

    }


    public function getHeaders(Request $request)
    {
        $headers = [];
        if ($request->hasHeader('x-b3-sampled') && $request->hasHeader('x-b3-spanid') &&
            $request->hasHeader('x-b3-parentspanid') && $request->hasHeader('x-b3-traceid')) {
            $headers = [
                'x-b3-sampled' => $request->header('x-b3-sampled'),
                'x-b3-spanid' => $request->header('x-b3-spanid'),
                'x-b3-parentspanid' => $request->header('x-b3-parentspanid'),
                'x-b3-traceid' => $request->header('x-b3-traceid'),
            ];
        }
        return $headers;
    }
}