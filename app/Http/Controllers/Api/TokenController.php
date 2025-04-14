<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $uuid = (string) Str::uuid();

        $token = Token::create([
            'id' => $uuid,
            'expires_at' => now()->addMinutes(40),
        ]);

        $encryptedToken = encrypt($token);

        return response()->json([
            'success' => true,
            'token' => $encryptedToken,
        ]);
    }
}
