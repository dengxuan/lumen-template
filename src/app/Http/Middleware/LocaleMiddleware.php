<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Locale Middleware.
 */
class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->header('Accept-Language');
        if (empty($locale)) {
            $locale = config('app.locale');
        }
        if ($locale) {
            $locale = explode(',', $locale)[0];
        }
        app()->setLocale($locale);
        return $next($request);
    }
}