<?php

namespace App\Http\Controllers\Api;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PositionCollection;

class Positions extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): JsonResponse
    {
        $positions = Position::all();

        if ($positions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Positions not found',
            ], 404);
        }

        return response()->json(new PositionCollection($positions));
    }
}
