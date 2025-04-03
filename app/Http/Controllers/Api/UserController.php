<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    public function index (Request $request)
    {
        $request->validate([
            'count' => 'integer|min:1|max:100',
            'page' => 'integer|min:1',
        ]);

        $count = $request->query('count', 5);

        $users = User::orderBy('id', 'asc')->paginate($count);
        $users->appends(['count' => $count]);

        if ($users->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found',
            ], 404);
        }

        return new UserCollection($users);
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

    public function store (StoreUserRequest $request)
    {
        $validated = $request->validated();
        
        $photoPath = Storage::disk('public')->put('images/users', $validated['photo']);

        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'phone' => $validated['phone'],
            'position_id' => $validated['position_id'],
            'photo' => $photoPath,
        ]);

        return response()->json([
            'success' => true,
            'id' => $user->id,
            'message' => 'new user successfully registered',
        ],201);
    }
}
