<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function RegisterSeller(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string',
                'address' => 'required|string',
                'country' => 'required|string',
                'province' => 'required|string',
                'city' => 'required|string',
                'district' => 'required|string',
                'postal_code' => 'required|string',
                'photo' => 'required|image|mimes:jpeg,jpg,png|max:4040'

            ]
        );

        //Image Handler
        $photo = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('assets/user', 'public');
        }

        //
        $user = User::create([
            'name' => $request->name,
            'email' =>  $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' =>  $request->address,
            'country' =>  $request->country,
            'province' =>  $request->province,
            'city' =>  $request->city,
            'district' =>  $request->district,
            'postal_code' =>  $request->postal_code,
            'roles' => 'seller',
            'photo' => $photo,

        ]);

        $token = $user->createToken('token-name')->plainTextToken;

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Akun Seller berhasil dibuat!',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]

                ],201
        );
    }

    public function Login(Request $request) {
       
        // Validasi User yang Login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || Hash::check($request->passwod, $user->password)){
            return response()->json([
                'status' => 'failed',
                'message' => 'Login gagal  : Username atau Password yang anda masukan salah',
            ],401);
        }

        // Berikan Access Token
        $token = $user->createToken('token-name')->plainTextToken;

        // Login Berhasil
        return response()->json([
            'status' => 'success',
            'message' => 'Login Berhasil!',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
            ],200);

    }

    public function Logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        // Logout Berhasil
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Akun Berhasil Logout!',
            ],200
        );
    }


    //////////      REGISTER BUYER
    public function RegisterBuyer(Request $request) {
        $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string'

            ]
        );

     

        //
        $user = User::create([
            'name' => $request->name,
            'email' =>  $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('token-name')->plainTextToken;

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Akun Buyer berhasil dibuat!',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]

                ],201
        );
    }
}




