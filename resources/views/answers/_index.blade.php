<div class="row mt-3">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h2>{{$answersCount." ".str_plural('Answer',$answersCount)}}</h2>
                 <hr>

                @foreach ( $answers as $answer)
                    <div class="media">
                        <div class="d-flex flex-column vote-controls">
                            <a title="this answer is useful" class="vote-up"><i class="fas fa-caret-up fa-3x"></i></a> 
                            <span class="votes-count">1230</span>
                            <a title="this answer is not useful" class="vote-down off"><i class="fas fa-caret-down fa-3x"></i></a>
                            <a title="Mark this answer as best answer" class="{{$answer->status}} mt-2"><i class="fas fa-check fa-2x"></i><br>
                            
                            </a>
                         </div> 
                        <div class="media-body">
                        <p>{{$answer->body}}</p>
                        <div class="row">
                           <div class="col-4">
                            <div class="ml-auto">
                                @can('update',$answer)
                                {{-- @if(Auth::user()->can('update-question',$question)) --}}
                                <a href="{{route('question.answer.edit',[$question->id,$answer->id])}}"class="btn btn-sm btn-outline-info">Edit</a>
                                {{-- @endif --}}
                                @endcan
                                @can('delete',$answer)
                                {{-- @if(Auth::user()->can('delete-question',$question)) --}}
                                <a href="{{route('question.answer.delete',[$question->id,$answer->id])}}" class="btn btn-sm btn-outline-danger"> Delete</a>
                                {{-- @endif --}}
                                @endcan
                               </div>
                           </div>
                           <div class="col-4">
                               
                           </div>
                           <div class="col-4">
                            
                                <span class="text-muted">Answered {{$answer->created_date}}</span>
                                <div class="media mt-2">
                                    <a href="{{$answer->user->url}}" class="pr-2">
                                       <img src="{{$answer->user->avatar}}">
                                    </a>
                                    <div class="media-body">
                                       <a href="{{$answer->user->url}}" >{{$answer->user->name}}</a>
 
                                    </div>
 
                                </div>
                            

                           </div>
                        </div>
                           
                        
                        </div>

                    </div>
                    <hr>
                @endforeach
            </div>
        </div>  
      </div>

    </div>

</div>