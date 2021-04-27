@if(session('success'))
<div class="alert alert-success">
    <strong>Success!</strong> {{session('success')}}
  </div>
@endif