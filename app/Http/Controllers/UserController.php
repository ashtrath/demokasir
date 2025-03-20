<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index() {
        return Inertia::render("user", [
            "user" => Auth::user()
        ]);
    }

    public function update(Request $request) {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "store_name" => "required|string|max:255",
            "username" => "exclude_if:username,null|string|max:255",
            "password" => "exclude_if:password,null|string|max:255",
        ]);

        if (auth()->user()->update($data)) {
            return back()->with("success", "Success update credentials");
        }

        return back()->with("error", "Cannot update credentials, try again");
    }
}
