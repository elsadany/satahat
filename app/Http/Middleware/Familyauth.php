<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Familyauth
{
      public function handle(Request $request, Closure $next)
    {
          if($request->user()->type!=2)
              return response ()->json (['status'=>500,'errors'=>['you are not authorised to this data']]);
        
        return $next($request);
    }

}