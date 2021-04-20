<?php

namespace App\Exceptions;

use App\Libraries\LumenTracer;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        if (!config('span', null)) {
            LumenTracer::setSpan('report exception', LumenTracer::getJaegerHeaders());
        }
        $info = [
            'error_file' => $e->getFile(),
            'error_line' => $e->getLine(),
            'error_message' => $e->getMessage(),
            'error_code' => $e->getCode(),
            'trace_string' => $e->getTraceAsString(),
        ];
        set_log($info);
        info('----error----', $info);
        LumenTracer::flush();
        parent::report($e);
        dieJson(20002, '系统出错');

    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
		//正式环境返回错误json
		if(env('APP_DEBUG')!='true'){
			if($e instanceof NotFoundHttpException){
				return response(array('code'=>404,'message'=>'the api you request is not found!','content'=>'','contentEncrypt'=>''));
			}
			else if($e instanceof MethodNotAllowedHttpException){
				return response(array('code'=>404,'message'=>'all request should be post!','content'=>'','contentEncrypt'=>''));
			}

		}
        return parent::render($request, $e);
    }
}
