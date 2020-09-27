<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = RouteServiceProvider::HOME;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	protected function formValidator($request)
	{
		return $request->validate([
			'email'    => 'required|email',
			'password' => 'required|string'
		]);
	}

	protected function generateAccessToken($user)
	{
		return $user->createToken($user->email . '-' . now())->accessToken;
	}

	public function login(Request $request)
	{
		$this->formValidator($request);

		$user = User::where('email', $request->email)->first();

		if (!$user) {
			return response()->json(["message" => "User does not exist"], 401);
		}

		if (!Hash::check($request->password, $user->password)) {
			return response()->json(["message" => "Incorrect password"], 401);
		}

		$token = $this->generateAccessToken($user);

		return response()->json([
			'token' => $token,
			'user'	=> $user->name,
			'userLevel' => $user->user_level->user_level
		]);
	}
}
