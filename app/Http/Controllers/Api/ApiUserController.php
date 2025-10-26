<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ApiUserController extends Controller
{
    public function login(Request $request)
    {
        $auth = auth()->attempt($request->only('email', 'password'));

        if (!$auth) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }
        else {
            return response()->json([
                'success' => true,
                'user' => auth()->user(),
                'token' => auth()->user()->createToken('auth_token')->plainTextToken
            ], 200);
        }
    }

    public function register(Request $request){
        try{
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|confirmed'
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            
            ]);

            return response()->json([
                'success' => true,
                'user' => $user,
                
            ], 200);
        }
         catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        }
        catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logout successfully'
        ], 200);
    }

}
