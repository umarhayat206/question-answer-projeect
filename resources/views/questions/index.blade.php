@extends('layouts.app')
<style>
    .counters
    {
        margin-right: 30px;
        text-align: center;
        font-size: 10px;
    
        

    }
    strong
        {
            display:block;
            font-size:2em;
            
        }
        .status
        {
            width:60px;
            height:60px;
           border:1px solid rgb(95,187,126);
           color: rgb(95,187,126);
        }
        .unanswered
        {
            border:none;
            color:black;
        }
        .answered
        {
            width:60px;
            height:60px;
            color: rgb(95,187,126);
            border:1px solid rgb(95,187,126)

        }
        .answer-accepted
        {
            width:60px;
            height:60px;
            background-color:rgb(95,187,126);
            color:white;
        }
        .view
        {
            margin-top:10px;
        }
    </style>
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2>All Questions</h2>
                        <div class="ml-auto">
                           <a href="{{route('question.create')}}" class="btn btn-outline-secondary">Ask Question</a>
                        </div>

                    </div>

                </div>

                <div class="card-body">
                   

                   @foreach($questions as $question)
                      <div class="media">
                        <div class="d-flex flex-column counters">
                            <div class="vote">
                               <strong>{{$question->votes}}</strong>{{str_plural('vote',$question->votes)}}
                            </div>
                            <div class=" {{$question->status}}">
                                <strong>{{$question->answers}}</strong>{{str_plural('answer',$question->answers)}}
                             </div>
                             <div class="view">
                                {{$question->views ."  ". str_plural('view',$question->views)}}
                             </div>

                        </div>

                       <div class="media-body">
                       <a href="{{$question->url}}"><h3 class="mt-0">{{$question->title}}</h3></a>
                       <p class="lead">
                         Asked by <a href="{{$question->user->url}}">{{$question->user->name}}</a>
                         <small class="text-muted">{{$question->created_date}}</small>

                       </p>
                       {{str_limit($question->body,250)}}
                       </div>
                    </div>
                    <hr>
                   @endforeach
                   
                  {{$questions->links()}}
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
