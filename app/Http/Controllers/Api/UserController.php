<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ImageOptimizationService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller implements HasMiddleware
{
    public function __construct(private ImageOptimizationService $imageOptimizationService) {}

    public static function middleware()
    {
        return [
            new Middleware('token-validated', only: ['store']),
        ];
    }

    public function index(Request $request)
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

    public function show(string $id)
    {
        if (! ctype_digit($id)) {
            return response()->json([
                'success' => false,
                'message' => 'The user with the requested id does not exist.',
                'fails' => [
                    'userId' => ['The user ID must be an integer.'],
                ],
            ], 400);
        }

        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'user' => new UserResource($user),
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $originalPhotoName = $validated['photo']->getClientOriginalName();
        $originalPhotoPath = Storage::disk('public')->put('images/users/original', $validated['photo']);
        $optimizedPhotoPath = $this->imageOptimizationService->optimizeAndResize($originalPhotoPath);

        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'phone' => $validated['phone'],
            'position_id' => $validated['position_id'],
        ]);

        $user->userPhoto()->create([
            'original_name' => $originalPhotoName,
            'path_to_original' => $originalPhotoPath,
            'path' => $optimizedPhotoPath,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'id' => $user->id,
            'message' => 'new user successfully registered',
        ], 201);
    }
}
