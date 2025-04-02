<?php

namespace App\Http\Controllers\Api;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PositionCollection;
use App\Http\Resources\PositionResource;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::all();

        if ($positions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Positions not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'positions' => PositionResource::collection($positions),
        ]);
    }
}
