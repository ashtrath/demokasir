<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function index() {
        return Inertia::render("login");
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            "username" => "required|string",
            "password" => "required|string"
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return to_route("dashboard");
        }
        
        return back()->withErrors("Username or Password not match");
    }

    public function logout(Request $request) {
        Auth::logout();
 
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();

        return to_route("login");
    }
}
