<?php
/**
 * Created by PhpStorm.
 * User: njoulin
 * Date: 24/12/2019
 * Time: 15:00
 */

namespace App\Http\Controllers;

use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    use Notifiable;

    public $loginAfterSignUp = true;

    public function signup(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    public function getAuthUser(Request $request)
    {
        return response()->json(auth()->user());
    }
    public function logout()
    {
        auth()->logout();
        return response()->json(['message'=>'Successfully logged out']);
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}