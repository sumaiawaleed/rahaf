<?php

namespace App\Http\Controllers\Dashboard;

use App\Dollar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DollarController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:dollar_cost-read'])->only('index', 'show');
        $this->middleware(['permission:dollar_cost-create'])->only('create', 'store');
        $this->middleware(['permission:dollar_cost-update'])->only('edit', 'update');
        $this->middleware(['permission:dollar_cost-delete'])->only('destroy');
    }
    private function validate_page($request)
    {
        $rules = [
            'the_cost' => 'required',
            'id' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }
    public function index(){
        $form_data = Dollar::orderByDesc('id')->first();
        $data['title'] = __('site.dollars');
        $data['url'] = route(env('DASH_URL') . '.dollars');
        return view('dashboard.dollars.index', compact('data','form_data'));

    }
    public function update(Request $request){
        $dollar = Dollar::find($request->id);
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['the_cost'] = $request->the_cost;

            $dollar->update($data);

            return response()->json(array('success' => true), 200);
        }
    }
}
