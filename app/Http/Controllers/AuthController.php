<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if($user) {
            if($user->id_role == '1') {
                return redirect()->intended('admin');
            }
            else if($user->id_role == '2') {
                return redirect()->intended('verifikator');
            }
        }
        return view('login');
    }

    public function proses_login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credential = $request->only('username', 'password');

        if (Auth::attempt($credential)) {
            $user = Auth::user();

            if($user->id_role == '1') {
                return redirect()->intended('admin');
            }
            else if($user->id_role == '2') {
                return redirect()->intended('verifikator');
            }
            return redirect()->intended('/');
        }
        return redirect('login')
        ->withInput()
        ->withErrors(['login_gagal' => 'Pastikan kalau username dan password sudah benar ya :)']);
    }

    public function register(){
        return view('register');
    }

    public function proses_register(Request $request){
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'no_hp' => 'required',
            'email' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            return redirect('/register')
            ->withErrors($validator)
            ->withInput();
        }

        $request['id_role'] = '2';
        $request['password']= Hash::make($request->password);

        UserModel::create($request->all());

        return redirect()->route('login');
    }

    public function logout(Request $request){
        $request->session()->flush();
        Auth::logout();
        return redirect('login');
    }
}