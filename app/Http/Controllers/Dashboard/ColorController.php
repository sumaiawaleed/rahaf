<?php

namespace App\Http\Controllers\Dashboard;

use App\Color;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:colors-read'])->only('index', 'show');
        $this->middleware(['permission:colors-create'])->only('create', 'store');
        $this->middleware(['permission:colors-update'])->only('edit', 'update');
        $this->middleware(['permission:colors-delete'])->only('destroy');
    }

    private function validate_page($request)
    {
        $rules = [
            'name' => 'required|max:100',
            'a_name' => 'required|max:100',
            'image' => 'image'
        ];

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(Request $request)
    {
        $data['title'] = __('site.colors');
        $data['colors'] = Color::when($request->search, function ($q) use ($request) {

            return $q->where('name','LIKE' ,'%' . $request->search . '%')
                ->orWhere('a_name','LIKE' ,'%' . $request->search . '%')
                ->orWhere('notes','LIKE' ,'%' . $request->search . '%');

        })->where('type',1)->latest('id')->paginate(20);
        $data['url'] = route(env('DASH_URL') . '.colors.index');
        return view('dashboard.colors.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = __('site.add_colors');
        $data['url'] = route(env('DASH_URL') . '.colors.store');
        return view('dashboard.colors.create', compact('data'));
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
            $data['color'] = $request->color;
            $data['notes'] = $request->notes;
            Color::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = Color::find($id);
        $data['title'] = __('site.edit_colors');
        $data['url'] = route(env('DASH_URL') . '.colors.update',$form_data->id);
        return view('dashboard.colors.edit', compact('data','form_data'));
    }

    public function update(Request $request,$id)
    {
        $category = Color::find($id);
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['name'] = $request->name;
            $data['a_name'] = $request->a_name;
            $data['notes'] = $request->notes;
            $data['color'] = $request->color;

            $category->update($data);

            return response()->json(array('success' => true), 200);
        }
    }

    public function destroy($id)
    {
        $category = Color::find($id);
        $category->delete();
        return response()->json(array('success' => true), 200);

    }
}
