<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserListCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function formValidator($request)
	{
		return $request->validate([
			'data.email'    => 'required|email',
			'data.name'     => 'required|string',
			'data.user_level_id' => 'required|int'
		]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return UserListCollection::collection(User::all());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return UserListCollection::collection(User::where('id', $id)->get());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user)
	{
		$this->formValidator($request);

		try {
			$user->update([
				'name' => $request->data['name'],
				'email' => $request->data['email'],
				'user_level_id' => $request->data['user_level_id']
			]);

			return response()->json(["message" => "User updated successfully!"], 201);
		} catch (ValidationException $error) {
			return response()->json([
				'message' => 'Something went wrong while updating user. Please try again.',
				'error'   => $error->errors()
			], $error->status);
		} catch (\Throwable $error) {
			return response()->json([
				'message' => 'Something went wrong while updating user. Please try again.',
				'error'   => $error->getMessage()
			], 500);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}