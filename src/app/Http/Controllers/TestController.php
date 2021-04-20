<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends BaseController
{
    public function index(Request $request)
    {
        set_log(['aaa'=>123123]);
        successJson($request->input());
    }
}