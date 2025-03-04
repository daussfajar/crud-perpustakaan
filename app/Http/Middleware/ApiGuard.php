<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = env('API_KEY');
        $apiSecret = env('API_SECRET');

        if (!$apiKey || !$apiSecret) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Not authorized to access this resource. Please contact the administrator.',
            ], 500);
        }

        $authorizationHeader = $request->header('Authorization');

        // Check Authorization header
        if (!$authorizationHeader || !str_starts_with($authorizationHeader, 'Bearer ')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. API Key is required.',
            ], 401);
        }

        // Get token from Authorization header
        $providedToken = substr($authorizationHeader, 7);
        $validToken = base64_encode($apiKey . ':' . $apiSecret);

        // Validate token
        if ($providedToken !== $validToken) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Token API tidak valid.',
            ], 401);
        }

        return $next($request);
    }
}
