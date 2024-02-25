<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HeaderKeyMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {

        if (!$request->hasHeader('x_api_key')) {
            return response()->json(['error' => 'Unauthorized. x_api_key header is missing.'], 401);
        }

        $apiKey = $request->header('x_api_key');
        $validApiKey = config('app.x_api_key');

        if ($apiKey !== $validApiKey) {
            return response()->json(['error' => 'Unauthorized. Invalid x_api key.'], 401);
        }

        return $next($request);
    }
}
