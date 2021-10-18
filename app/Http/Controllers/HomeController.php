<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function editPassword()
    {
        $user = User::find(auth()->id());
        return view('auth.change-password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'nullable',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::find(auth()->id());
        $old_password = auth()->user()->password;

        if (Hash::check($request->old_password, $old_password)) {

            if (!Hash::check($request->password, $old_password)) {
                $user->password = bcrypt($request->password);
                $user->save();
                session()->flash('message', 'password updated successfully');
                session()->flash('class', 'success');

                return back();
            } else {
                session()->flash('message', 'new password can not be the old password!');
                session()->flash('class', 'info');
                return back();
            }

        } else {
            session()->flash('message', 'old password doesnt matched ');
            session()->flash('class', 'danger');
            return back();
        }
    }
}
