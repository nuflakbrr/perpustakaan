<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthRequest;
use App\Http\Requests\UpdateAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Define the middleware.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Make a token if the User is valid and excist in storage (Login).
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'error' => $validator->errors(),
            ], 400);
        }

        $credentials = $request->only('username', 'password');
        $usr = User::where('username', $request->username)->first();
        $token = Auth::attempt($credentials);

        try {
            if (!$usr) {
                return response()->json([
                    'message' => 'Oops! Username is not found!',
                ], 404);
            } else if ($usr && !Hash::check($request->password, $usr->password)) {
                return response()->json([
                    'message' => 'Oops! Username or password is invalid!',
                ], 401);
            }

            if (!$token = auth()->attempt($validator->validated())) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return response()->json([
                'success' => true,
                'message' => 'Successfully logged in',
                'user' => $usr,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ], 200);
        } catch (JWTException $err) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to login, please try again.',
                'error' => $err
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(StoreAuthRequest $request, User $usr)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'type' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'error' => $validator->errors(),
            ], 400);
        }

        $user = $usr::create(array_merge(
            $validator->validated(),
            ['password' => Hash::make($request->password)]
        ));

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'user' => $user
        ], 200);
    }

    /**
     * Get the newly generate token (Refresh Token).
     */
    public function refresh()
    {
        return response()->json([
            'success' => true,
            'message' => 'Successfully refreshed token',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthRequest $request, User $usr)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'type' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'error' => $validator->errors(),
            ], 400);
        }

        $user_id = auth()->user()->id;

        $user = $usr::where('id', $user_id)->update(array_merge(
            $validator->validated(),
            ['password' => Hash::make($request->password)]
        ));

        $user_after_update = $usr::where('id', $user_id)->first();

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'user' => $user_after_update
            ], 200);
        } else if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User failed to update',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deletemyaccount(User $usr)
    {
        $user_id = auth()->user()->id;

        $delete = $usr::where('id', $user_id)->delete();

        if ($delete) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal dihapus',
            ], 500);
        }
    }

    /**
     * Get the authenticated User.
     */
    public function user()
    {
        return response()->json(auth()->user());
    }

    /**
     * Remove access endpoint User (Logout).
     */
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out',
        ]);
    }

    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth('api')->factory()->getTTL() * 60 //mention the guard name inside the auth fn
    //     ]);
    // }
}
