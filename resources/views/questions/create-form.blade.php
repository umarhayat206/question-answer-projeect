@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2>Ask Questions</h2>
                        <div class="ml-auto">
                           <a href="{{route('questionhome')}}" class="btn btn-outline-secondary">Back To All Questions</a>
                        </div>

                    </div>

                </div>

                <div class="card-body">
                   
               <form action="{{route('question.store')}}" method="POST">
               @csrf
                <div class="form-group">
                    <label>Question Title</label>
                    <input type="text" name="title" id="question-title" class="form-control">
                    @if($errors->has('title'))
                    <div class="invalid-feedback">
                        <strong>{{$errors->first('title')}}</strong>
                    </div>
                    @endif
                </div>
                <div class="form-group">
                    <label>Explain your question</label>
                    <textarea name="body" id="question-body" class="form-control" rows="10">

                    </textarea>
                    @if($errors->has('body'))
                    <div class="invalid-feedback">
                        <strong>{{$errors->first('body')}}</strong>
                    </div>
                    @endif
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-outline-primary btn-lg" value="Ask this Question">
                </div>
               </form>
                  
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
