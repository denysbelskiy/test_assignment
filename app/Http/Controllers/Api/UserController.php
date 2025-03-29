<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{

    // ToDo: use LengthAwarePaginator to be able to set items per page

    public function index (Request $request)
    {
        $count = $request->query('count', 5);
        $page = $request->query('page', 1);

        try {
            $request->validate([
                'count' => 'integer|min:1|max:100',
                'page' => 'integer|min:1',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'fails'   => $e->errors(),
            ], 422);
        }

        return new UserCollection(User::paginate(request('count', $count)));
    }

    public function show (string $id)
    {
        if (!ctype_digit($id)) {
            return response()->json([
                'success' => false,
                'message' => 'The user with the requested id does not exist.',
                'fails' => [
                    'userId' => ['The user ID must be an integer.']
                ]
            ], 400);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'user' => new UserResource($user)
        ]);
    }
}
