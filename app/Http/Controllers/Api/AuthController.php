<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $validated = $request->only(['name', 'email', 'password']);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);
        $token = $user->createToken('api-token')->plainTextToken;
        return $this->successResponse(['user' => $user, 'token' => $token], 'Kayıt başarılı', 201);
    }

    public function login(LoginRequest $request){
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Geçersiz email veya şifre', 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;
        return $this->successResponse(['user' => $user, 'token' => $token], 'Giriş başarılı', 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse(null, 'Çıkış yapıldı');
    }
}
