<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Models\Dealer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LocaleMiddleware
{
    /**
     * Set the locale
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        setlocale(LC_MONETARY, 'en_US.UTF-8');
        return $next($request);
    }
}
