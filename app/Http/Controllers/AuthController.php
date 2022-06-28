<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => 'logout']);
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function auth(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return response()->json([
                'message' => 'Email not found'
            ]);
        }

        if(!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Password does not match'
            ]);
        }

        $payload = [
            'iss' => config('jwt.iss'),
            'iat' => config('jwt.iat'),
            'nbf' => config('jwt.nbf'),
            'exp' => config('jwt.exp'),
            'name' => $user->name,
            'email' => $user->email,
            'user_id' => $user->id
        ];

        $jwt = JWT::encode($payload, config('jwt.key'), 'HS256');

        $user->update([
            'api_token' => $jwt
        ]);

        return response()->json([
            'access_token' => $jwt,
            'token_type' => 'bearer',
            'expire_in' => config('jwt.exp'),
            'refresh_ttl' => config('jwt.exp'),
            'expire_in_date' => date('d F Y H:i:s', config('jwt.exp'))
        ]);

    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        $request->merge([
            'password' => app('hash')->make($request->password)
        ]);

        $user = User::create($request->all());
        return response()->json($user);
    }

    public function logout(Request $request)
    {
        $jwt = $request->bearerToken();

        $user = User::where('api_token', $jwt)->first();
        $user->api_token = null;
        $user->save();

        return response()->json([
            'message' => 'User successfully signed out'
        ]);
    }
}
