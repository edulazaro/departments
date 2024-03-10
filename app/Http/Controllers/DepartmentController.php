<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class DepartmentController extends BaseController
{
    /**
     * Show the departments view.
     */
    public function index(Request $request)
    {
        return view('departments.index', [
            'title' => 'Departments management',
            'description' => 'Use this interface to manage departments',
        ]);
    }
}
