<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {        
        $route = $request->path();
        $arrSkipRoutes = array(
            'logout',
            'signin',
            'login',
            'forgot-password',             
            'admin/user/get-rights',
            'admin/area/get-area',
            'laravel-filemanager',
            'laravel-filemanager/upload',            
        );
        if(!in_array($route, $arrSkipRoutes)){            
            
            if(1 === preg_match('/search/', $request->path())){ 
                $arrWhere = explode("/",$request->path());
                $where = array_splice($arrWhere, 0, -2);
                $route = implode("/",$where);  
            }
            else if(1 === preg_match('~[0-9]~', $request->path())){                                                
                $route = preg_replace('#\/[^/]*$#', '', $request->path()); 
            }                      
            
            if (!in_array("/".$route, \Session::get('routes'))) {             
                return response()->view('admin.errors.403');
            }
        }
        return $next($request);
    }
}
