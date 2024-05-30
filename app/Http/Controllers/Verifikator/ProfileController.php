<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;

use App\Models\RoleModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProfileController extends Controller
{
    public function show(){

    }
    public function editProfile(){
        $user = Auth::user();

        $breadcrumb = (object)[
            'title' => 'Edit Profile',
            'list' => ['Home', 'Profile', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Profile',
        ];

        $activeMenu = 'profile';

        return view('verifikator.profile.edit', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'user' => $user, 
            'activeMenu' => $activeMenu
        ]);
    }

    public function updateProfile(Request $request, $id){
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|string',
            'no_hp' => 'required|string',
            'username' => 'required|string|min:3|unique:users,username,' . $user->id_user . ',id_user',
            'password' => 'nullable|min:5',
        ]);

        // Find the user by ID
        $user = UserModel::find($user->id_user);

        // Update the user fields
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->username = $request->username;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }   

        // Save the updated user
        $user->save();

        return redirect('/verifikator/profile/')->with('success', 'Profilmu Sudah Diupdate!');
    }
}