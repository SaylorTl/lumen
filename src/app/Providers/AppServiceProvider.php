<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

	public function boot(){

		//TODO:接口日志调用
//		app('db')->listen(function($query){
//
//			var_dump($query->sql);
//			var_dump($query->time);
//
//		});

	}
}
