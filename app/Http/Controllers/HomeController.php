<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $enrolled_courses = Auth::user()->courses;
        $courses = Course::all();

        return view('home', [
            'enrolled_courses' => $enrolled_courses,
            'courses' => $courses
        ]);
    }
}
