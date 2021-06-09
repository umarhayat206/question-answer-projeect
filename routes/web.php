<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
run composer require laravel/ui
Install Vue php artisan ui vue
if you Install Vue with auth use php artisan ui vue --auth
add after in page master
run npm install
run npm run dev

https://www.bootdey.com/snippets/view/profile-with-data-and-skills
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|composer require laravel/ui
|php artisan ui bootstarp --auth
|composer self-update --2
|step 2 – Database Configuration  Step 3 – Install Laravel UI  composer require laravel/ui
|Step 4 – Install Bootstrap Auth Scaffolding php artisan ui bootstrap --auth|
|Step 5 – Install Npm Packages npm install  npm run dev
|Step 6 – Run php artisan Migrate
|this line is for once db error php artisan config:cache
|https://stackoverflow.com/questions/39767619/menu-filter-permission-with-laratrust
|https://github.com/shamscorner/tinymce-laravel
|
|To display different roles of users 
|@foreach ($roles as $role)
|        <input type="checkbox" value="{{$role->id}}" name="{{$role->name}}" 
|       @if(auth()->check()) 
|            @foreach(auth()->user()->roles as $userRole)
|                 @if($userRole->id==$role->id) {{"checked"}}
|                 @endif
|             @endforeach
|       @endif> {{$role->name}}</input>
|   @endforeach
|
|Menu configuration of admin lte
|https://stackoverflow.com/questions/39760922/admin-lte-with-laratrust
|
|and code is here
|class MyMenuFilter implements FilterInterface
|
|   public function transform($item)
|    {
|       if (isset($item['permission']) && !Laratrust::isAbleTo($item['permission'])) {
|            return false;
|       }
|        return $item;
|   }
|    }
|and in adminlte.php menu is 
|     [
|            'text' => 'All Categories',
|            'url'  => '/admin/categories',
|            'permission'=>'can_view_categories'
|
|
|   //            'icon' => 'fas fa-fw fa-user',
|        ],
|
      // User controller
       public function index()
   {

        //return $clients;
        $users = User::paginate(5);
        $data= ['users'=>$users];
        return view('admin.users.index', $data);
    }

    public function create()
    {
        $roles = Role::all();
        $data['roles'] = $roles;
        return view('admin.users.CreateUser', $data);
    }

    public function store(UserRequest $request)
    {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            $roles = $request->role;
            for ($i = 0; $i < count($roles); $i++) {
                $role = Role::find($roles[$i]);
                $user->attachRole($role);
                //echo $role->id."<br>";
            }

       return redirect()->route('admin.users.index')->with('success', 'User is saved successfully');
        //        before code
//        $role = Role::where('id', $request->role)->first();
//        $user = new User();
//        $user->name = $request->name;
//        $user->email = $request->email;
//        $user->password = Hash::make($request->password);
        //$user->fill($request->all());
//        $user->save();
//        $user->attachRole($role);
//
    }

    public function edit($id)
    {
        $roles = Role::all();
        $user = User::findOrFail($id);
        $rolesIds = $user->roles->pluck('id')->toArray();
        $data = ['user' => $user, 'roles' => $roles, 'rolesIds'=>$rolesIds];
        return view('admin.users.EditUser', $data);
    }

    public function update(EditUserRequest $request, $id)
    {

        $password = $request->input('password', null);
        $request->request->remove('password');
        $user = User::findOrFail($id);
        $user->detachRoles($user->roles);
        $roles = $request->role;
        for ($i = 0; $i < count($roles); $i++) {
            $role = Role::find($roles[$i]);
            $user->attachRole($role);

        }
        $user->fill($request->all());
        if(!empty($password))
        {
            $user->password = Hash::make($password);
        }
        $user->save();
        return redirect()->route('admin.users.index')->with('success', 'User is saved successfully');


    }
    public function delete($id)
    {
        $currentUser = Auth::user();
        $user = User::findOrFail($id);

        if ($currentUser->id != $user->id) {
            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'User is deleted successfully');
        }

        return back()->with('error','You cannot delete yourself');
    }
    public function show($id)
    {

        $user = User::findOrFail($id);
        $data['user']=$user;
        return view('admin.users.ShowUser',$data);

    }
    
    
    //posts controller
    
    public function index()
    {
        if (Auth::user()->hasRole(['super_admin', 'admin'])) {
            $posts = Post::latest()->paginate(5);
            $data = ['posts' => $posts];
            return view('admin.post.index', $data);
        } else {
            $userId = Auth::user()->id;
            $posts = Post::where('user_id', '=', $userId)->paginate(5);
            $data = ['posts' => $posts];
            return view('admin.post.index', $data);

        }


    }

    public function show($slug)
    {

        $categories = Category::all();
        $post = Post::where('slug', $slug)->first();
        $data =['post'=>$post,'categories'=>$categories];
        if (!empty($post)) {
            return view('Posts.showpost', $data);
        } else {
            return view('errors.404');
        }
    }
    public function showByCategory($id)
    {

        $categories = Category::all();
        $posts = Post::where('category_id','=', $id)->paginate(8);
        $category=$id;
        $data =['posts'=>$posts,'categories'=>$categories];
        return view('Posts.showByCategory',$data);

    }

    public function create()
    {
        $authors = User::whereHas('roles', function ($role) {
            $role->where('name', '=', 'author');
        })->get();
        $categories = Category::all();
        $data = ['categories' => $categories, 'authors' => $authors];
        return view('admin.post.CreatePost', $data);
    }

    public function store(StorePostRequest $request)
    {
        $post = new Post();
        $post->fill($request->all());
        $post->category_id = $request->category;
        if ($imagefile = $request->file('image')) {
            $name = time() . $imagefile->getClientOriginalName();
            $imagefile->move('images', $name);
            $post->image = $name;
        }
        $post->user_id = $request->author;
        $post->save();
        return redirect()->route('admin.posts.index')->with('success', 'Post is saved successfully');

    }

    public function edit($id)
    {
        $authors = User::whereHas('roles', function ($role) {
            $role->where('name', '=', 'author');
        })->get();
        $categories = Category::all();
        $post = Post::findOrFail($id);
        $data = ['categories' => $categories, 'post' => $post, 'authors' => $authors];
        return view('admin.post.EditPost', $data);
    }

    public function update(EditPostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());
        if ($imagefile = $request->file('image')) {
            $name = time() . $imagefile->getClientOriginalName();
            $imagefile->move('images', $name);
            $post->image = $name;
        }
        $post->user_id = $request->author;
        $post->category_id = $request->category;

        $post->update();
        return redirect()->route('admin.posts.index')->with('success', 'Post is saved successfully');
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post is Deleted successfully');
    }

    public function uploadImage(Request $request)
    {


        $file = $request->file('file');
        $path = url('/uploads/') . '/' . $file->getClientOriginalName();
        $imgpath = $file->move(public_path('/uploads/') . $file->getClientOriginalName());
        $fileNameToStore = $path;


        return json_encode(array('location' => $fileNameToStore));
//        $imgpath = $request->file('file')->store('post', 'public');
//        return response()->json(['location' => "/storage/$imgpath"]);

//        $imgpath = $request->file('file')->store('post', 'public');
//        return response()->json(['location' => "/storage/$imgpath"]);
    }
    
    // user index tabble
    
    @extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('layouts._messages')

                <div class="card">
                    <div class="card-header">All Users
                        <a href="{{route('admin.users.create')}}"class="btn btn-dark float-right">Add New User</a>
                        <hr>
                        <div class="float-right form-group">
                            <form class="form-inline" action="{{route('users.search')}}">
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Search By Name, Email" name="search">
                                {{--                                <input type="text" placeholder="search post" name="search" class="form-control">--}}
                                <button type="submit" class="btn btn-dark mb-2">Search User</button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Edit</th>
                                <th>View</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <div>
                                               {{$role->display_name?$role->display_name:'No Role'}}
                                            </div>
                                        @endforeach
                                    </td>
                                    <td><a href="{{route('admin.users.edit',$user->id)}}" class="btn btn-outline-secondary">Edit</a></td>
                                    <td><a href="{{route('admin.users.show',$user->id)}}" target="" class="btn btn-outline-secondary">Show</a></td>
                                    <td>
                                        <form method="POST" action="{{route('admin.users.delete',$user->id)}}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-outline-secondary">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$users->links('pagination::bootstrap-4')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


//user edit form

@extends('layouts.admin')
<style>
    .checkboxes input{
        margin: 0 5px 0 30px;
    }
</style>

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">Edit User</div>

                    <div class="card-body">
                        <form method="POST" action="{{route('admin.users.update',$user->id)}}" >
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Name :</label>
                                <input type="text" class="form-control {{$errors->has('name')?'is-invalid':''}}" name="name" placeholder="Enter Name" value="{{$user->name}}">
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        <strong>{{$errors->first('name')}}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Email :</label>
                                <input type="Email" class="form-control {{$errors->has('email')?'is-invalid':''}}" name="email" placeholder="Enter Email" value="{{$user->email}}">
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        <strong>{{$errors->first('email')}}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group checkboxes">
                                <label>Select Role :</label>
{{--                                <select class="form-control" name="role[]" multiple>--}}
{{--                                    <option value="">Chose Role</option>--}}
{{--                                    @foreach($roles as $role)--}}
{{--                                        <option value="{{$role->id}}" {{in_array($role->id,$rolesIds)?'selected':''}}>{{$role->display_name}}</option>--}}
{{--                                    @endforeach--}}

{{--                                </select>--}}
                                @foreach($roles as $role)
                                    <input type="checkbox" value="{{$role->id}}" name="role[]"{{in_array($role->id,$rolesIds)?'checked':''}}> {{$role->display_name }}</input>
                                @endforeach
                                @error('role')
                                <strong><p style="color:#dc3545;font-size: 80%;">{{ $message }}</p></strong>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password :</label>
                                <input type="password" class="form-control {{$errors->has('password')?'is-invalid':''}}" name="password" placeholder="Enter Password">
                                @if($errors->has('password'))
                                    <div class="invalid-feedback">
                                        <strong>{{$errors->first('password')}}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Confirm Password :</label>
                                <input type="password" class="form-control {{$errors->has('password_confirmation')?'is-invalid':''}}" name="password_confirmation" placeholder="Confirm Password">
                                @if($errors->has('password_confirmation'))
                                    <div class="invalid-feedback">
                                        <strong>{{$errors->first('password_confirmation')}}</strong>
                                    </div>
                                @endif
                            </div>


                            <center><button type="submit" class="btn btn-secondary btn-block">Save</button></center>



                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


// show user

@section('content')
    <div class="col-md-8">
        @include('layouts._messages')
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{$user->name}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{$user->email}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Roles</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        @foreach($user->roles as $role)
                            <div>
                                {{$role->display_name?$role->display_name:'No Role'}}
                            </div>
                        @endforeach
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Created At</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                     {{$user->created_at->diffForHumans()}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Updated At</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        {{$user->updated_at->diffForHumans()}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <a class="btn btn-info "  href="{{route('admin.users.edit',$user->id)}}">Edit</a>
                    </div>
                    <div class="col-sm-9">
                        <form method="POST" action="{{route('admin.users.delete',$user->id)}}">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
    
    
 {{--@section('js')--}}
{{--    <script>--}}
{{--        $(document).ready( function () {--}}
{{--            $('#laravel_datatable').DataTable();--}}
{{--        });--}}
{{--    </script>--}}
{{--@stop--}}   

*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/question','QuestionController@index')->name('questionhome');

Route::get('/create','QuestionController@create')->name('question.create');

Route::POST('/store','QuestionController@store')->name('question.store');
Route::get('question/{id}/edit','QuestionController@edit')->name('question.edit');
Route::Post('question/{id}/update','QuestionController@update')->name('question.update');
Route::get('question/{id}/delete','QuestionController@destroy')->name('question.delete');
Route::get('/question/{slug}','QuestionController@show')->name('question.show');


// Routes for answers

Route::Post('question/{question}/answer/store','AnswerController@store')->name('question.answer.store');
Route::get('question/{question}/answer/{answer}/edit','AnswerController@edit')->name('question.answer.edit');
Route::Post('question/{question}/answer/{answer}/update','AnswerController@update')->name('question.answer.update');
Route::get('question/{question}/answer/{answer}/delete','AnswerController@destroy')->name('question.answer.delete');
