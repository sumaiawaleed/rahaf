<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:users-read'])->only('index', 'show');
        $this->middleware(['permission:users-create'])->only('create', 'store');
        $this->middleware(['permission:users-update'])->only('edit', 'update');
        $this->middleware(['permission:users-delete'])->only('destroy');
    }//end of constructor

    private function validate_page($request,$user = null){
        $rules = [
            'name' => 'required',
            'email' => 'required|max:20',
        ];

        if($user){
            $rules += ['email' => [ 'required','email',
                Rule::unique('users')->ignore($user->id, 'id')
            ]
            ];
        }else{
            $rules += ['email' => [ 'required','email','unique:users' ],
                'password' => 'required|min:6|confirmed'
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(Request $request)
    {
        $data['title'] = __('site.users');
        $data['users'] = User::when($request->search, function ($q) use ($request) {

            return $q->where('name','LIKE' ,'%' . $request->search . '%');
        })->latest('id')->paginate(20);
        $data['url'] = route(env('DASH_URL') . '.users.index');
        return view('dashboard.users.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = __('site.add_users');
        $data['url'] = route(env('DASH_URL') . '.users.store');
        return view('dashboard.users.create', compact('data'));
    }
    public function store(Request $request)
    {
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['password'] = bcrypt($request->password);
            $user = User::create($data);
            $user->syncPermissions($request->permissions);

            return response()->json(array('success' => true), 200);
        }

    }

    public function edit($id)
    {
        $form_data = User::find($id);
        $data['title'] = __('site.edit_users');
        $data['url'] = route(env('DASH_URL') . '.users.update',$form_data->id);
        return view('dashboard.users.edit', compact('data','form_data'));
    }

    public function update(Request $request,$id)
    {
        $user = User::find($id);
        $validator = $this->validate_page($request,$user);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $user->syncPermissions($request->permissions);


            $user->update($data);

            return response()->json(array('success' => true), 200);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(array('success' => true), 200);

    }
}
