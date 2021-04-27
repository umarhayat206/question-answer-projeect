@extends('layouts.app')
@section('content')
    
<div class="container">
<div class="row mt-3">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h3>Your Answer</h3>
            </div>
            <hr>
            <form action="{{route('question.answer.update',[$answer->question_id,$answer->id])}}" method="POST">
                
               @csrf
               <div class="form-group">
                   <textarea class="form-control {{$errors->has('body')?'is-invalid':''}}" rows="9"columns="12" name="body">{{$answer->body}}</textarea>
                   @if($errors->has('body'))
                   <div class="invalid-feedback">
                   <strong>{{$errors->first('body')}}</strong>
                  </div>
                  @endif
               </div>
               
               <div class="form-group">
                   <button type="submit" class="btn  btn-lg btn-outline-primary">Submit</button>
               </div>

            </form>
        </div>  
      </div>

    </div>

</div>
</div>
@endsection