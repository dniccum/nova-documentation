<?php

namespace Dniccum\NovaDocumentation\Http\Middleware;

use Dniccum\NovaDocumentation\NovaDocumentation;
use Laravel\Nova\Nova;

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
        $tool = collect(Nova::registeredTools())->first([$this, 'matchesTool']);

        return optional($tool)->authorize($request)
            ? $next($request)
            : $this->handleUnauthorizedRequest($request);
    }

    public function matchesTool($tool)
    {
        return $tool instanceof NovaDocumentation;
    }

    protected function handleUnauthorizedRequest($request)
    {
        $loginRoute = config('novadocumentation.login_route');

        if ($loginRoute && auth()->guest()) {
            return redirect()->guest(route($loginRoute));
        }

        abort(403);
    }
}
