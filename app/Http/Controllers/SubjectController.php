<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use Illuminate\Support\Facades\Cache;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Cache::remember('subjects', 60*60, function () {
            return Subject::where('is_active', TRUE)->get();
        });
        return response()->json($subjects, 200);
    }
}
