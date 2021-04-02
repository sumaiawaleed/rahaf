<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Quantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuantityController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:quantities-read'])->only('index', 'show');
        $this->middleware(['permission:quantities-create'])->only('create', 'store');
        $this->middleware(['permission:quantities-update'])->only('edit', 'update');
        $this->middleware(['permission:quantities-delete'])->only('destroy');
    }
    private function validate_page($request)
    {
        $rules = [
            'name' => 'required|max:100',
            'a_name' => 'required|max:100',
        ];

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(Request $request)
    {
        $data['title'] = __('site.quantities');
        $data['quantities'] = Quantity::when($request->search, function ($q) use ($request) {

            return $q->where('name','LIKE' ,'%' . $request->search . '%')->orWhere('a_name','LIKE' ,'%' . $request->search . '%');

        })->latest('id')->paginate(20);
        $data['url'] = route(env('DASH_URL') . '.quantities.index');
        return view('dashboard.quantities.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = __('site.add_quantities');
        $data['url'] = route(env('DASH_URL') . '.quantities.store');
        return view('dashboard.quantities.create', compact('data'));
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
            $data['a_name'] = $request->a_name;
            $data['trader_id'] = 1;
            Quantity::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = Quantity::find($id);
        $data['title'] = __('site.edit_quantities');
        $data['url'] = route(env('DASH_URL') . '.quantities.update',$form_data->id);
        return view('dashboard.quantities.edit', compact('data','form_data'));
    }

    public function update(Request $request,$id)
    {
        $quantity = Quantity::find($id);
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['name'] = $request->name;
            $data['a_name'] = $request->a_name;
            $data['trader_id'] = 1;

            $quantity->update($data);

            return response()->json(array('success' => true), 200);
        }
    }

    public function destroy($id)
    {
        $quantity = Quantity::find($id);
        $quantity->delete();
        return response()->json(array('success' => true), 200);

    }
}
