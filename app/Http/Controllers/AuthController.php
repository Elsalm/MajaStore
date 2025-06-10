<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('Auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],

        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return response()->json(['message' => 'Usuario autenticado'], 200);
        }

        return response()->json(['message' => 'El usuario no existe o campo incorrecto'], 400);
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['message' => 'Usuario Desautenticado'], 200);
    }

    public function me()
    {

        $me = Auth::check();

        return response()->json($me, 200);
    }
}
