<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('is_verified', false)->get();
        return view('verification.index', compact('users'));
    }
    public function verifyUser(Request $request, User $user)
    {
        $user->update(['is_verified' => 1]);
        return response()->json(['success' => true]);
    }

    public function rejectUser(Request $request, User $user)
    {
        return response()->json(['success' => true]);
    }
}

