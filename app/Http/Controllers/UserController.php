<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    /**
     * Show the users view.
     */
    public function index(Request $request)
    {
        return view('users.index', [
            'title' => 'Users management',
            'description' => 'Use this interface to manage users',
        ]);
    }
}
