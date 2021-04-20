<?php

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class QueryListener
{
 /**
  * Create the event listener.
  *
  * @return void
  */
  public function __construct(Request $request)
  {
    $this->query_path = $request->path();
  }
 /**
  * Handle the event.
  *
  * @param QueryExecuted $event
  * @return void
  */
  public function handle(QueryExecuted $event)
  {
    $sql = str_replace("?", "'%s'", $event->sql);
    if(!empty($event->bindings)){
        $log = vsprintf($sql, $event->bindings);
    }else{
        $log = $sql;
    }
    app('log')->info('========'.$this->query_path.'========',['sql'=>$log ] );
  }

}  