<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller {
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Unauthorized'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Success',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], Response::HTTP_OK);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Token deleted'
        ], Response::HTTP_OK);
    }

    public function me(Request $request) {
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Success',
            'data' => $request->user()
        ], Response::HTTP_OK);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nomor_hp' => 'nullable',
            'email' => 'required|email|unique:users,email',
            'address' => 'nullable',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'status' => Response::HTTP_CREATED,
            'message' => 'User created',
            'data' => $user
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request) {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'address' => 'required',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user->update(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'User updated',
            'data' => $user
        ], Response::HTTP_OK);
    }

    public function delete(Request $request) {
        $request->user()->delete();

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'User deleted'
        ], Response::HTTP_OK);
    }
}
