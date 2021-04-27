<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;
use App\User;
use Illuminate\Support\Facades\Gate;

class QuestionController extends Controller
{
    //
   public function __construct()
   {
      $this->middleware('auth',['except'=>['index','show']]);
     // return redirect()->route('login');
   }



    public function index()
    {
        $questions=Question::latest()->paginate(4);
        return view('questions.index',compact('questions'));
    }
    public function create()
   {
    return view('questions.create-form');
   }
   public function store(AskQuestionRequest $request)
   {
    //  return "<h1>Umar Hayat</h1>";
      $user_id=$request->user()->id;
      $new_question= new Question();

      $new_question->title=$request->title;
     
      $new_question->body=$request->body;
      $new_question->user_id=$user_id;

      $new_question->save();
      return redirect()->route('questionhome')->with('success','Your question are submitted');

   }
   public function edit($id)
   {
      // if(Gate::denies('update-question',$question))
      // {
        
         
      // abort(403,'Access denied');
        
      // }
     // $this->authorize("update", $question);
      $question=Question::findorfail($id);
      return view('questions.edit-question',compact('question',$question));
      
      
      

   }
   public function update(AskQuestionRequest $request, $id)
   {
   //    if(Gate::denies('update-question',$request))
   //    {
   //       abort(403,'Access denied');
        
        
   //    }
   //$this->authorize("update", $question);
      $question=Question::findorfail($id);
      $question->title=$request->title;
      $question->body=$request->body;
      $question->save();

      return redirect()->route('questionhome');
        
    }
    public function destroy($id)
    {
      // if(Gate::denies('delete-question',$question))
      // {
      //    abort(403,'Access denied');
        
        
      // }
      // $this->authorize("delete", $question);
      $question=Question::findorfail($id);
      $question->delete();
      return redirect()->route('questionhome')->with('success','your question has been deleted');
    }
   public function show($slug)
   {
      $question=Question::where('slug',$slug)->first();
     $question->increment('views');
   //   $question->save();
      return view('questions.show',compact('question',$question));
   }
}
