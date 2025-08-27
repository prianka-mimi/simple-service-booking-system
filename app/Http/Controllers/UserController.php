<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    final public function index(Request $request)
    {
        $users = (new User())->getUserList($request);
        return view('backend.modules.user-list', compact('users'));
    }
}
