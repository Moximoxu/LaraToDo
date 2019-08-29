<?php

namespace LaraToDo\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    //This method will be triggered before your controller constructor
    public function handle($request, Closure $next, ...$guards)
    {
        //Check here if the user is authenticated
        if ( ! $this->auth->user() )
        {
            return redirect('login');
        }

        $this->authenticate($request, $guards);

        return $next($request);
    }
}