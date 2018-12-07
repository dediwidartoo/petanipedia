<?php

namespace App\Http\Controllers\Api;

use DB;
use Auth;
use Response;
use App\Models\User;
use App\Http\Resources\UsersResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function users()
    {
    	$users = User::orderBy('name')->paginate(10);  
		return UsersResource::collection($users);
	}

	public function user($id)
	{
		$user = User::where('id',$id)->first();
		if (count($user) <= 0) {
			return Response::json( [
				'status' => [
					"code"			=> 400,
					"description"	=> 'Bad request!'
				]
			], 400 );
		}

		return (new UsersResource($user))
			-> additional([
				'status' => [
					"code"			=> 200,
					"description"	=> 'ok!'
				]
			])->response()->setStatusCode(200);
	}

	public function login(Request $request)
	{
		if (!Auth::attempt([ "email" => $request->email, "password" => $request->password ])) {
			return Response::json( [
				'status' => [
					"code"			=> 401,
					"description"	=> 'Credential is wrong!'
				]
			], 401 );
		}

		$loggedUser = User::find(Auth::user()->id);

		return (new UsersResource($loggedUser))
			-> additional([
				'status' => [
					"code"			=> 202,
					"description"	=> 'ok!'
				]
			])->response()->setStatusCode(202);
	}

	public function register(Request $request)
	{
		/*return $request->all();*/
		$this->validate($request, [
			'name'		=> 'required|min:3',
			'email'		=> 'required|email|unique:users',
			'password'	=> 'required|min:3'
		]);

		$newUser = User::create([
			'name'		=> $request->name,
			'username'	=> $request->name,
			'email'		=> $request->email,
			'password'	=> bcrypt($request->password),
			'api_token'	=> bcrypt($request->email)
		]);

		return (new UsersResource($newUser))
			-> additional([
				'status' => [
					"code"			=> 201,
					"description"	=> 'ok!'
				]
			])->response()->setStatusCode(201);
	}

	public function logout($id)
	{
		$user = User::where('id',$id)->first();

		if (count($user) <= 0) {
			return Response::json( [
				'status' => [
					"code"			=> 400,
					"description"	=> 'Bad request!'
				]
			], 400 );
		}
		else
		{
			Auth::logout();
			return Response::json( [
				'status' => [
					"code"			=> 200,
					"description"	=> 'OK!'
				]
			], 200 );
		}
	}
}
