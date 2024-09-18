<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('Akun.index', [
            'users' => User::all()
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('Akun.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|max:255',
            'password' => 'required|max:255',
            'no_wa' => 'required|max:255',
        ];

        if ($request->email != $user->email) {
            $rules['email'] = 'required|unique:users|max:255';
        }

        $validated = $request->validate($rules);

        $user->name = $validated['name'];

        if ($request->email != $user->email) {
            $user->email = $validated['email'];
        }
        $user->password = bcrypt($validated['password']);
        $user->no_wa = $validated['no_wa'];
        $user->save();

        return redirect('dashboard/user')->with('success', 'Data user berhasil dirubah!');
    }
}
