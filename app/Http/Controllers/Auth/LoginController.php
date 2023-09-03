<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if ($request->ajax()) {

            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email|exists:users,email',
                    'password' => 'required'

                ],
            );
            if ($validator->fails()) {

                return response()->json(['message' => $validator->errors(), 'status' => false], 400);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $response = [
                    'status' => true,
                    'message' => 'login Successfully',
                    'data' => '/home',
                ];

                return response()->json($response, 200);
                // return redirect('/home');
            }
            return response()->json(['message' => ['error' => "Please Enter correct password"], 'status' => false], 400);
        }
    }

    public function register()
    {

        return view('auth.register');
    }

    public function registerdata(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:40',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:4',
                'password_confirmation' => 'required|same:password'
            ]);
            if ($validator->fails()) {
                $response = [
                    'status' => true,
                    'message' => $validator->errors(),
                ];
                return response()->json($response, 400);
            }
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $request = [
                'status' => true,
                'message' => 'Account Created Successfully.',
                'data' => '/'
            ];
            return response()->json($request, 200);
        }
    }

    public function logout(Request $request)
    {
        if ($request->ajax()) {
            session()->flush();
            Auth::logout();

            $response = [
                'status' => true,
                'message' => 'logout Successfully',
                'data' => '/',
            ];
            return response()->json($response, 200);
        }
    }
}
