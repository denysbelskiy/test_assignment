<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tokenString = $request->header('token');

        try {
            $data = decrypt($tokenString);
        } catch (DecryptException $e) {
            return response()->json(['error' => 'Invalid token. Try to get a new one by the method GET api/v1/token.'], 401);
        }

        $token = Token::find($data['id'] ?? null);

        if (! $token || $token->used || now()->gt($token->expires_at)) {
            return response()->json(['error' => 'The token expired.'], 401);
        }

        $request->attributes->set('token_id', $token['id']);

        return $next($request);
    }
}
