<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function auth(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone_or_email' => 'required',
            'password' => 'required'
        ],
            [
                'password.required' => 'Пароль обязательное поле'
            ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 465);
        }

        $user = User::query()->where('phone', $request->phone_or_email)->orWhere('email', $request->phone_or_email)->first();


        if (Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $token = Auth::user()->createToken('login');
        }

        return response()->json($token->plainTextToken, 201);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'second_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'birthday' => 'required',
            'sex' => 'required|between:0,1',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 472);
        }

        $user = new User();

        $user->first_name = $request->first_name;
        $user->second_name = $request->second_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->birthday = $request->birthday;
        $user->sex = $request->sex;
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json([
            'message' => 'success',
            'data' => new UserResource($user)
        ]);
    }

    public function sync_speciality(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|exists:users,id',
            'specialities' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 456);
        }

//        $user = User::find($request->user);
        $user = User::query()->where('id', $request->user)->with('specialities')->first();

        $user->specialities()->sync($request->specialities);

        return response()->json(new UserResource(User::query()->where('id', $request->user)->with('specialities')->first()));

    }

    public function profile()
    {
        return response()->json(new UserResource(Auth::user()));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
