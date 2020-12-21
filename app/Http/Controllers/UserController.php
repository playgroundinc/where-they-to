<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\PerformerType;
use App\Enums\UserType;
use BenSampo\Enum\Rules\EnumValue;

class UserController extends Controller
{
	public $timestamps = true;

	public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
			if (!$token = JWTAuth::attempt($credentials)) {
				return response()->json(['error' => 'invalid_credentials'], 400);
			}
        } catch (JWTException $e) {
			return response()->json(['error' => 'could_not_create_token'], 500);
		}
		$user = JWTAuth::user();
		if ($user) {
			$user = array(
				'id' => $user['id'],
			);
			return response()->json(compact('token', 'user'), 201);
		}
		return response()->json(['error' => 'could_not_create_token'], 500);
    }

    public function register(Request $request)
	{
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    

        if($validator->fails()){
			return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
			'email' => $request->get('email'),
			'password' => Hash::make($request->get('password')),
			'country' => $request->get('country'),
			'province' => $request->get('province'),
			'city' => $request->get('city'),
			'timezone' => $request->get('timezone')
        ]);

        $token = JWTAuth::fromUser($user);
        $user = array(
			'id' => $user['id'],
        );
        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser()
	{
		try {
			if (! $user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['user_not_found'], 404);
			}
		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			return response()->json(['token_expired'], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			return response()->json(['token_invalid'], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
			return response()->json(['token_absent'], $e->getStatusCode());
        }
        
		$user['performers'] = $user->performers;
		$user['venues'] = $user->venues;
		$user['events'] = $user->events;
		$user['families'] = $user->families;
		return response()->json(compact('user'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function profile($id) {
		$user = User::find($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->json(array('status' => 'Not found'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return response()->json(array('status' => 'Not found'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        return response()->json(array('status' => 'Not found'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        return response()->json(array('status' => 'Not found'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        //
        return response()->json(array('status' => 'Not found'));
        $user->update(request(['email', 'name']));
        return redirect('/users/'.$user->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        return response()->json(array('status' => 'Not found'));
        $user->delete();
        return redirect('/users');
    }
}
