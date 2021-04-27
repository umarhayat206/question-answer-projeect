<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{


    public function __construct()
   {
      $this->middleware('auth');
     // return redirect()->route('login');
   }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        //
       $request->validate(['body'=>'required',]);
       $new_answer= new Answer();
       $new_answer->question_id=$id;
       $new_answer->user_id=Auth::id();
       $new_answer->body=$request->body;
       $new_answer->save();

       return back();


       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit($question_id,$answer_id)
    {
        //
         //return "<h1>Question Id  is: $question_id and answwwwer id is $answer_id</h1>";
       // $this->authorize('update', $answer);
      
       //$answer=Answer::where('id','=',$answer_id)->where('question_id','=',$question_id)->get();

       //return $answer;
       $answer=Answer::find($answer_id);
       return view('answers._edit',compact('answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update($question_id,$answer_id,Request $request)
    {
        //
        $request->validate(['body'=>'required',]);
        $answer=Answer::find($answer_id);
        $answer->body=$request->body;
        $answer->save();
        $question=Question::find($question_id);
        return redirect()->route('question.show',$question->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy($question_id,$answer_id)
    {
        //
        $answer=Answer::find($answer_id);
        $answer->delete();
        $question=Question::find($question_id);
        return redirect()->route('question.show',$question->slug);

    }
}
