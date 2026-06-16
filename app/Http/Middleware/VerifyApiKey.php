<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');

        if ($apiKey !== 'hgak84j48h495hsnfu3bsknl') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized Access. Invalid API Key.'
            ]);
        }

        return $next($request);
    }
}
