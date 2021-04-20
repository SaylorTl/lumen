<?php

namespace App\Libraries;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Exception;

class Request
{
    protected $http_client = null;
    
    public function __construct(Array $config = [])
    {
        $this->http_client = new Client($config);
    }
    
    /**
     * @param  string  $url  请求地址
     * @param  array  $params  请求参数
     * @param  bool  $is_array
     * @param  float  $time_out
     * @return bool|array
     * @throws Exception
     */
    public function post($url, $params = [], $is_array = true, $time_out = 5)
    {
        try {
            if (!$url) {
                throw new Exception('url参数缺失');
            }
            info('----request----', ['url' => $url, 'params' => $params]);
            $response = $this->http_client->post($url, [
                'form_params' => $params,
                'time_out' => $time_out,
            ]);
            $result = $response->getBody()->getContents();
            return $is_array === false ? $result : json_decode($result, true);
        } catch (RequestException $e) {
            $info = [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'error' => '请求异常：'.$e->getMessage()
            ];
            info('----Request/'.__FUNCTION__.'----', $info);
            return false;
        }
    }
    
    /**
     * @param  string  $url  请求地址
     * @param  array  $params  请求参数
     * @return mixed
     * @throws Exception
     */
    public function postJson($url, $params = [])
    {
        try {
            if (!$url) {
                throw new Exception('url参数缺失');
            }
            info('----request----', ['url' => $url, 'params' => $params]);
            $response = $this->http_client->post($url, [
                'json' => $params,
            ]);
            $result = $response->getBody()->getContents();
            return json_decode($result, true);
        } catch (RequestException $e) {
            $info = [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'error' => '请求异常：'.$e->getMessage()
            ];
            info('----Request/'.__FUNCTION__.'----', $info);
            return false;
        }
    }
    
    /**
     * @param $url
     * @param $params
     * @return mixed
     * @throws Exception
     */
    public function get($url, $params = [])
    {
        try {
            if (!$url) {
                throw new Exception('url参数缺失');
            }
            info('----request----', ['url' => $url, 'params' => $params]);
            if ($params) {
                $params = ['query' => $params];
            }
            $response = $this->http_client->get($url, $params);
            $result = $response->getBody()->getContents();
            return json_decode($result, true);
        } catch (RequestException $e) {
            info('----Request/'.__FUNCTION__.'----', [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'error' => '请求异常：'.$e->getMessage()
            ]);
            return false;
        }
    }
    
    /**
     * @param  string  $option
     * @return array|mixed|null
     */
    public function getConfig($option = '')
    {
        return $this->http_client->getConfig($option);
    }
}