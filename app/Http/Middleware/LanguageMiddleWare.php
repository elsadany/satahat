<?php

namespace App\Http\Middleware;
use Elsayednofal\BackendLanguages\Models\Languages;
use Closure;

class LanguageMiddleWare {

    public function handle($request, Closure $next) {

      if($request->has('language_symbol')&&($request->get('language_symbol')=='ar'||$request->get('language_symbol')=='en')){
    
         $language=$request->get('language_symbol');
      }else{
                 $language='ar';

      } 
      \Session::put('language_symbol',$language);

      app()->setLocale($language);   
        return $next($request);
    }

}
