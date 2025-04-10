<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Token;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Encryption\DecryptException;

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

        if (!$token || $token->used || now()->gt($token->expires_at)) {
            return response()->json(['error' => 'The token expired.'], 401);
        }

        $token->setToUsed();

        return $next($request);
    }
}
