<?php

namespace Dniccum\NovaDocumentation\Http\Middleware;

use Dniccum\NovaDocumentation\NovaDocumentation;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(NovaDocumentation::class)->authorize($request) ? $next($request) : abort(403);
    }
}
