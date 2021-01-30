@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                   

                   @foreach($questions as $question)
                      <div class="media">
                       <div class="media-body">
                       <a href="#"><h3 class="mt-0">{{$question->title}}</h3></a>
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
