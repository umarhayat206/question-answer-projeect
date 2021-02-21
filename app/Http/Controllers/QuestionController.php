<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //
    public function index()
    {
        $questions=Question::latest()->paginate(4);
        return view('questions.index',compact('questions'));
    }
    public function create()
   {
    return view('questions.create-form');
   }
   public function store(Request $request)
   {
     return $request->all();
   }
   public function show($id)
   {
      return "<h1>$id</h1>";
   }
}
