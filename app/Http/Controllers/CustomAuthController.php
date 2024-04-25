<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
 

class CustomAuthController extends Controller
{
    public function home()
    {
        return view('welcome');
    } 

    public function index()
    {
        return view('login');
    }  

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->with('message', 'Signed in!');
        }
   
        return redirect('/login')->with('message', 'Email dan Password salah!');
    }

    public function signup()
    {
        return view('registration');
    }

    public function signupsave(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users',
            'nama_lengkap' => 'required',
            'alamat' => 'required',
        ]);
            
        $data = $request->all();
        $check = $this->create($data);
          
        return redirect("login");
    }

    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'password' => Hash::make($data['password']),
        'email' => $data['email'],
        'nama_lengkap' => $data['nama_lengkap'],
        'alamat' => $data['alamat']
      ]);
    }  

    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
        return redirect('/login');
    }

    public function signOut() {
        Session::flush();
        Auth::logout();
   
        return redirect('');
    }
}
