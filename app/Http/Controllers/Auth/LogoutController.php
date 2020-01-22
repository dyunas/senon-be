<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
  public function logout(Request $request)
  {
    $request->user()->token()->revoke();
    $request->user()->token()->delete();

    $response = 'You have successfully logged out!';
    return response()->json($response, 200);
  }
}
