<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

	// use RegistersUsers;

	/**
	 * Where to redirect users after registration.
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
		$this->middleware('guest');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function formValidator($request)
	{
		return Validator::make(
			$request->only(
				'email',
				'name',
				'user_level_id'
			),
			[
				'email' => 'required|email',
				'name'  => 'required|string',
				'user_level_id' => 'required|int'
			]
		);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return \App\User
	 */
	protected function create(Request $request)
	{
		$this->formValidator($request);

		return User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make('senon@1234'),
			'user_level_id' => $request->user_level_id
		]);
	}
}