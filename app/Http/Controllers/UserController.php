<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::get();
        return response()->json($user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if ($user->id !== Auth::user()->id) {
            return redirect()->route('unauthorized');
        }
        $user = User::with('address')->where('id', $user->id)->first();
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        if ($user->id !== Auth::user()->id) {
            return redirect()->route('unauthorized');
        }

        $user = User::find($user->id);

        $rule = [];

        if ($request->first_name !== null || $request->last_name !== null || $request->contact !== null) {
            $rule['first_name'] = 'required';
            $rule['last_name'] = 'required';
            $rule['contact'] = 'required';
        }

        if ($request->email !== null) {
            $rule['email'] = 'email:rfc,dns|unique:users,email,' . $user->id;
        }

        if ($request->password !== null || $request->password_confirmation !== null) {
            $rule['password'] = ['required', 'confirmed', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()];
        }

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $user->update($request->all());
        } catch (\Throwable $th) {
            return response()->json([['message' => 'Given fields must be filled']], 400);
        }
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        return User::destroy($user->id);
    }
}
