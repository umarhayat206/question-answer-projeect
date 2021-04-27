<style>
    .vote-controls
    {
      min-width: 60px;
      margin-right: 30px;
      text-align: center;
      margin-top:-10px;
      color:#495057 ;
    }
    .votes-count
    {
        font-size: 25px;
    }
    .favorites-count
    {
        font-size: 12px;
    }
   a
    {
      cursor: pointer;
      color: #6c757d;
    }
    .off>i
    {
        color:#adb5bd;
    }
    .off:hover
    {
        color:#adb5bd;
    }
    .favorite >i 
    {
        color: yellow;
    }
    .favorite >span
    {
        color: yellow;
    }
    .vote-accepted>i
    {
        color: green;
    }
</style>


@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                  
                <div class="card-title">
                    <div class="d-flex align-items-center">
                        <h2>{{$question->title}}</h2>
                        <div class="ml-auto">
                           <a href="{{route('questionhome')}}" class="btn btn-outline-secondary">Back To All Questions</a>
                        </div>

                    </div>

                </div>
                <hr>

                <div class="media">
                    <div class="d-flex flex-column vote-controls">
                        <a title="this question is useful" class="vote-up"><i class="fas fa-caret-up fa-3x"></i></a> 
                        <span class="votes-count">1230</span>
                        <a title="this question is not useful" class="vote-down off"><i class="fas fa-caret-down fa-3x"></i></a>
                        <a title="click to mark as favorite question(click again to undo)" class="favorite mt-2"><i class="fas fa-star fa-2x"></i><br>
                        <span class="favorites-count">123</span>
                        </a>
                     </div> 
                   <div class="media-body">
                        <p>{{$question->body}}</p>
                        <div class="float-right">
                        <span class="text-muted">Asked {{$question->created_date}}</span>
                        <div class="media mt-2">
                           <a href="{{$question->user->url}}" class="pr-2">
                              <img src="{{$question->user->avatar}}">
                           </a>
                           <div class="media-body">
                              <a href="{{$question->user->url}}" >{{$question->user->name}}</a>
                            </div>
                        </div>
                        </div>
                   </div>
                </div>
              </div>
                
            </div>
        </div>
    </div>
   @include('answers._index',[
       'answersCount'=>$question->answers_count,
       'answers'=>$question->answers,
   ])
   @include('answers._create')
</div>
@endsection
