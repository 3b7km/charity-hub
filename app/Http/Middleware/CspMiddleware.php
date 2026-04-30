<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CspMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://js.stripe.com https://maps.googleapis.com https://unpkg.com; " .
               "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.tailwindcss.com https://unpkg.com; " .
               "font-src 'self' data: https://fonts.gstatic.com; " .
               "img-src 'self' data: https://images.unsplash.com https://i.pravatar.cc https://images.pexels.com https://plus.unsplash.com https://maps.googleapis.com https://maps.gstatic.com https://*.tile.openstreetmap.org https://unpkg.com; " .
               "frame-src 'self' https://js.stripe.com; " .
               "connect-src 'self' https://*.tile.openstreetmap.org;";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
