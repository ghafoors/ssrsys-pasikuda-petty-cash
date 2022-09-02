<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function listUsers(Request $request) {
        $users = User::get();
        return view('users.listing')
            ->with([
                'users' => $users
            ]);
    }

    public function addUserView(Request $request) {
        return view('users.new');
    }

    public function addUserAction(Request $request) {
        $data = $request->only([
            'name',
            'email',
            'password'
        ]);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return redirect()->route('users.listing');
    }

    public function updateUserView(Request $request, $id) {
        $user = User::findOrFail($id);
        return view('users.edit')->with(['user' => $user]);
    }

    public function updateUserAction(Request $request, $id) {
        $user = User::findOrFail($id);
        $data = $request->only([
            'name',
            'email',
            'password'
        ]);
        if(!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return redirect()->route('users.listing');
    }
}
