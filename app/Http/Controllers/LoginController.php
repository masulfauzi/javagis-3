<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
            return response()->json([
                'success' => true,
                'data' => $success,
                'message' => 'User login successfully.'
            ]);
            // return $this->sendResponse($success, 'User login successfully.');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorised'
            ]);
            // return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}
