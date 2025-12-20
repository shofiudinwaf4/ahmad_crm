<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return \view('login');
    }
    public function login(Request $request)
    {
        // \dd($request->all());
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $credentials['username'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            # code...
            session([
                'id' => $user->id,
                'username' => $user->username,
                'role' => $user->jabatan,
                'nama' => $user->name,
            ]);
            Auth::login($user);
            return \redirect('/dashboard');
        }

        return \back()->withErrors(['username' => 'Username atau Password salah']);
    }
    public function logout(Request $request)
    {
        Session::flush();
        return redirect('/login');
    }
}
