<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    //custom Spatie\Permission
    use Spatie\Permission\Models\Role;
   // use App\User;
   use App\Models\User;
    use DB;
    use Hash;

    class UserController extends Controller
    {



function __construct()
{
$this->middleware('permission:users_lists|users-create|users-edit|users-delete', ['only' => ['index','store']]);
$this->middleware('permission:users-create', ['only' => ['create','store']]);
$this->middleware('permission:users-edit', ['only' => ['edit','update']]);
$this->middleware('permission:users-delete', ['only' => ['destroy']]);
}



        public function changePassword()
        {
            return view('users.reset-password');
        }

        public function changePasswordSave(Request $request)
        {
            $rules = [
           'name'=>'required',
         'email'=> ['required',Rule::unique('users')->ignore($request->user()->id)],
            // 'email'=>'required|unique:clients',
                'old-password' => 'required',
                'password' => 'required|confirmed',
            ];
            $messages = [
              'name'=>'name is required',
              'email'=>'email is required',
                'old-password.required' => 'old password is required',
                'password.required' => 'password is required',
            ];
            $this->validate($request,$rules,$messages);

            $user = Auth::user();

            if (Hash::check($request->input('old-password'), $user->password)) {
                $user->password = bcrypt($request->input('password'));
                $user->save();
                flash()->success('password is updated');
                return view('users.reset-password');
            }else{
                flash()->error('password is not valid');
                return view('users.reset-password');
            }

        }

    public function index(Request $request)
    {
    $data = User::orderBy('id','DESC')->paginate(5);
    return view('users.index',compact('data'))
    ->with('i', ($request->input('page', 1) - 1) * 5);

    }
    public function create()
    {
    $roles = Role::pluck('name','name')->all();
    return view('users.create',compact('roles'));
    }
    public function store(Request $request)
    {
    $this->validate($request, [
    'name' => 'required',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|same:confirm-password',
    'roles' => 'required'
    ]);

    $input = $request->all();
    $input['password'] =Hash::make($input['password']);

    $user = User::create($input);
    $user->assignRole($request->input('roles'));

    return redirect()->route('users.index')
    ->with('success','User created successfully');
    }
    public function show($id)
    {
    $user = User::find($id);
    return view('users.show',compact('user'));
    }
    public function edit($id)
    {
    $user = User::find($id);
    $roles = Role::pluck('name','name')->all();
    $userRole = $user->roles->pluck('name','name')->all();

    return view('users.edit',compact('user','roles','userRole'));
    }
    public function update(Request $request, $id)
    {
    $this->validate($request, [
    'name' => 'required',
    'email' => 'required|email|unique:users,email,'.$id,
    'password' => 'same:confirm-password',
    'roles' => 'required'
    ]);

    $input = $request->all();
    if(!empty($input['password'])){
    $input['password'] = Hash::make($input['password']);
    }else{
    $input = array_except($input,array('password'));
    }

    $user = User::find($id);
    $user->update($input);
    DB::table('model_has_roles')->where('model_id',$id)->delete();

    $user->assignRole($request->input('roles'));

    return redirect()->route('users.index')
    ->with('success','User updated successfully');
    }
    public function destroy($id)
    {
    User::find($id)->delete();
    return redirect()->route('users.index')
    ->with('success','User deleted successfully');
    }
    }


