<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Quantity;
use App\SubQuantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubQuantityController extends Controller
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
            'quantity_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(Request $request)
    {
        $data['title'] = __('site.sub_quantities');
        $data['sub_quantities'] = SubQuantity::when($request->search, function ($q) use ($request) {

            return $q->where('name','LIKE' ,'%' . $request->search . '%')->orWhere('a_name','LIKE' ,'%' . $request->search . '%');

        })->when($request->id, function ($q) use ($request) {
            return $q->where('quantity_id',$request->id);
        })->latest('id')->paginate(20);

        foreach ($data['sub_quantities'] as $q){
            $q->parent = Quantity::find($q->quantity_id);
        }

        $data['quantities'] = Quantity::all();
        $data['url'] = route(env('DASH_URL') . '.sub_quantities.index');
        return view('dashboard.sub_quantities.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = __('site.add_sub_quantities');
        $data['quantities'] = Quantity::all();
        $data['url'] = route(env('DASH_URL') . '.sub_quantities.store');
        return view('dashboard.sub_quantities.create', compact('data'));
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
            $data['quantity_id'] = $request->quantity_id;
            SubQuantity::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = SubQuantity::find($id);
        $data['quantities'] = Quantity::all();
        $data['title'] = __('site.edit_sub_quantities');
        $data['url'] = route(env('DASH_URL') . '.sub_quantities.update',$form_data->id);
        return view('dashboard.sub_quantities.edit', compact('data','form_data'));
    }

    public function update(Request $request,$id)
    {
        $quantity = SubQuantity::find($id);
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['name'] = $request->name;
            $data['a_name'] = $request->a_name;
            $data['quantity_id'] = $request->quantity_id;

            $quantity->update($data);

            return response()->json(array('success' => true), 200);
        }
    }

    public function destroy($id)
    {
        $quantity = SubQuantity::find($id);
        $quantity->delete();
        return response()->json(array('success' => true), 200);

    }
}
