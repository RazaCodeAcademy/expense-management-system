<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    protected $redirectTo = '/';

    public function index()
    {
        $users = User::where('is_admin', 2)->get();

        return view('managers.index', compact('users'));
    }

    public function register()
    {
        return view('managers.register');
    }


    public function store(Request $request)
    {
        $request->flashExcept(['password', 'password_confirmation']);

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'is_admin' => 2,
        ]);

        return redirect(route('managers.index'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('managers.login');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findorfail($id);

        return view('managers.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->flashExcept(['aadhar_card_scan', 'photo', 'resume']);

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user = User::findorfail($id);
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        if($request->input('password') != null) {
            $this->validate($request, [
                'password' => 'required|confirmed',
            ]);

            $user->update([
                'password' => Hash::make($request->input('password')),
            ]);
        }

        return redirect(route('managers.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findorfail($id);
        $user->active = false;
        $user->save();

        return response()->json([
            'process' => 'success',
        ]);
    }

    public function activate($id)
    {
        $user = User::findorfail($id);
        $user->active = true;
        $user->save();

        return response()->json([
            'process' => 'success',
        ]);
    }

}
