<?php

namespace App\Http\Controllers;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ApiExerciseController extends Controller
{
    public function index(){
        $data['exercises'] = Exercise::all();
        return response()->json($data,200);
    }
}
