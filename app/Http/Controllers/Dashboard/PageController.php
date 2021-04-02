<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:pages-read'])->only('index', 'show');
        $this->middleware(['permission:pages-create'])->only('create', 'store');
        $this->middleware(['permission:pages-update'])->only('edit', 'update');
        $this->middleware(['permission:pages-delete'])->only('destroy');
    }
    private function validate_page($request)
    {
        $rules = [
            'name' => 'required|max:100',
            'a_name' => 'required|max:100',
            'details' => 'required',
            'a_details' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(Request $request)
    {
        $data['title'] = __('site.pages');
        $data['pages'] = Page::when($request->search, function ($q) use ($request) {

            return $q->where('name', 'LIKE', '%' . $request->search . '%')->orWhere('a_name', 'LIKE', '%' . $request->search . '%');

        })->latest('id')->paginate(20);
        $data['url'] = route(env('DASH_URL') . '.pages.index');
        return view('dashboard.pages.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = __('site.add_pages');
        $data['url'] = route(env('DASH_URL') . '.pages.store');
        return view('dashboard.pages.create', compact('data'));
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
            $data['details'] = $request->details;
            $data['a_details'] = $request->a_details;

            Page::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = Page::find($id);
        $data['title'] = __('site.edit_pages');
        $data['url'] = route(env('DASH_URL') . '.pages.update', $form_data->id);
        return view('dashboard.pages.edit', compact('data', 'form_data'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::find($id);
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['name'] = $request->name;
            $data['a_name'] = $request->a_name;
            $data['details'] = $request->details;
            $data['a_details'] = $request->a_details;

        }//end of if
        $page->update($data);

        return response()->json(array('success' => true), 200);

    }

    public function destroy($id)
    {
        $page = Page::find($id);

        $page->delete();
        return response()->json(array('success' => true), 200);

    }
}
