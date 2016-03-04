<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Models\Dealer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DealerMiddleware
{
    /**
     * Determine which dealer the visitor is viewing and put the dealer ID in a session variable
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url_array = explode('.', parse_url($request->url(), PHP_URL_HOST));
        $subdomain = $url_array[0];

        $dealer = Dealer::where('short_name', strtolower($subdomain))->firstOrFail();
        Session::put('dealerId', $dealer->id);
        Session::put('erpType', $dealer->erp_type);

        return $next($request);
    }
}
