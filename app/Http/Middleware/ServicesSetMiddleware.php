<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Lib\Utilities\Helper;

class ServicesSetMiddleware
{
    /**
     * Redirect to the Account page if the requested page is not available in the selected services set
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $dealer = Helper::getDealer();
        if ($dealer->erp_type == 'None') {
            return redirect('/account');
        }

        return $next($request);
    }
}