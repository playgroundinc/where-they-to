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
          if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'invalid_credentials'], 400);
          }
        } catch (JWTException $e) {
          return response()->json(['error' => 'could_not_create_token'], 500);
      }
      $user = JWTAuth::user();
      $user = array(
        'id' => $user['id'],
        'type' => $user['type'],
        'socialLinks' => $user->socialLinks,
      );
      return response()->json(compact('token', 'user'));
    }

    public function register(Request $request)
      {
        $validator = Validator::make($request->all(), [
          'username' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:users',
          'password' => 'required|string|min:6|confirmed',
          'type' => 'required',
        ]);

        if($validator->fails()){
          return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
          'username' => $request->get('username'),
          'email' => $request->get('email'),
          'password' => Hash::make($request->get('password')),
          'type' => $request->get('type')
        ]);

        $token = JWTAuth::fromUser($user);
        $user = array(
          'id' => $user['id'],
          'type' => $user['type'],
          'socialLinks' => $user->socialLinks
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
      $user['socialLinks'] = $user->socialLinks;
      if ($user['type'] === 1) {
        $user['profile'] = $user->performer;
      } else {
        $user['profile'] = $user->venue;
      }
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
      if ($user['type'] === UserType::VENUE): 
        $venue = $user->venue;
        return response()->json(compact('venue'));
      else: 
        $performer = $user->performer;
        return response()->json(compact('performer'));
      endif;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('users.create');
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
        $attributes = request()->validate([
          'type' => Rule::in(UserType::$types),
          'username' => 'required',
          'password' => 'required',
          'email' => 'required'
        ]);

        $user = User::create($attributes);
        $user_id = $user['id'];
        $performerTypes = PerformerType::all();
        if (intval($attributes['type']) === UserType::VENUE) {
          
          return view('venues.create', compact('user_id', 'performerTypes'));
        } 
        return view('performers/create', compact('user_id', 'performerTypes'));
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
        if (intval($user->type) === UserType::VENUE) {
          $venue = User::find($user->id)->venue;
          return view('users.show', compact('user', 'venue'));

        } else {
          $performer = User::find($user->id)->performer;
          return view('users.show', compact('user', 'performer'));
        }
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
        return view('users.edit', compact('user'));
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
        $user->delete();
        return redirect('/users');
    }
}
