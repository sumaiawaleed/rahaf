<?php

namespace App\Http\Controllers\Dashboard;

use App\Driver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:drivers-read'])->only('index', 'show');
        $this->middleware(['permission:drivers-create'])->only('create', 'store');
        $this->middleware(['permission:drivers-update'])->only('edit', 'update');
        $this->middleware(['permission:drivers-delete'])->only('destroy');
    }

    private function validate_page($request)
    {
        $rules = [
            'name' => 'required|max:100',
            'phone' => 'required|max:100',
        ];

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(Request $request)
    {
        $data['title'] = __('site.drivers');
        $data['drivers'] = Driver::when($request->search, function ($q) use ($request) {

            return $q->where('name','LIKE' ,'%' . $request->search . '%');

        })->latest('id')->paginate(20);
        $data['url'] = route(env('DASH_URL') . '.drivers.index');
        return view('dashboard.drivers.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = __('site.add_drivers');
        $data['url'] = route(env('DASH_URL') . '.drivers.store');
        return view('dashboard.drivers.create', compact('data'));
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
            $data['phone'] = $request->phone;
            Driver::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = Driver::find($id);
        $data['title'] = __('site.edit_drivers');
        $data['url'] = route(env('DASH_URL') . '.drivers.update',$form_data->id);
        return view('dashboard.drivers.edit', compact('data','form_data'));
    }

    public function update(Request $request,$id)
    {
        $driver = Driver::find($id);
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['name'] = $request->name;
            $data['phone'] = $request->phone;

            $driver->update($data);

            return response()->json(array('success' => true), 200);
        }
    }

    public function destroy($id)
    {
        $driver = Driver::find($id);
        $driver->delete();
        return response()->json(array('success' => true), 200);

    }
}
