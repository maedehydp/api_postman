<?php

namespace App\Http\Controllers;

use App\Http\Requests\authRequest;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'firstname' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required',
//                    'role' => 'required',
                ]
            );
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ], 401);
            }

            if ($request->role == 'seller') {
                $user = User::create([
                    'firstname' => $request->firstname,
                    'email' => $request->email,
                    'role' => $request->role,
                    'status' => 'waiting',
                    'password' => Hash::make($request->password)
                ]);
            } else {
                $user = User::create([
                    "role" => $request->role,
                    "firstname" => $request->firstname,
                    "email" => $request->email,
                    'password' => password_hash($request->password, PASSWORD_DEFAULT),
                ]);
            }
            $user->syncRoles('admin');
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function loginUser(authRequest $request)
    {

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['the provided credentials are incorrect.']
            ]);
        }
//        Hash::check($request->password,$user->password);
        if (Hash::make($request->password) == $user->password) {
            throw validationException::withMessages([
                'email' => ['the provided credentials are incorrect.']
            ]);
        }

        $token = $user->createToken('api_token')->plainTextToken;
        return response()->json([
            'token' => $token
        ]);
    }


    public function logoutUser($id)
    {
        $user = User::find($id);
        $user->tokens->each(function ($token) {
            $token->delete();
            Auth::logout();
        });
        return response()->json([
            'message' => 'logged out successfully'
        ]);
    }

    public function index()
    {
        try {
            return User::all();
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }


    public function destroy($id)
    {
//        dd(auth()->user()->getPermissionNames());

        try {
            $user = User::find($id);
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'deleted successfully'

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::find((int)$id)->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'update successfully'

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(user $user)
    {
        try {

            return response()->json([
                'user' => $user,
                'status' => true,
                'message' => 'showed successfully'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
