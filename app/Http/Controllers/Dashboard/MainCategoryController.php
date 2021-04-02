<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class MainCategoryController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:categories-read'])->only('index', 'show');
        $this->middleware(['permission:categories-create'])->only('create', 'store');
        $this->middleware(['permission:categories-update'])->only('edit', 'update');
        $this->middleware(['permission:categories-delete'])->only('destroy');
    }
    private function validate_page($request,$data = '')
    {
        $rules = [
            'image' => 'image'
        ];
      if($data){
          $rules += [
              'name' => ['required','max:100',['required', Rule::unique('main_category')->ignore($data->id),]],
              'a_name' => ['required','max:100',['required', Rule::unique('main_category')->ignore($data->id),]],
          ];
      }else{
          $rules += [
              'name' => 'required|max:100|unique:main_category',
              'a_name' => 'required|max:100|unique:main_category',
          ];
      }

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(Request $request)
    {
        $data['title'] = __('site.main_categories');
        $data['categories'] = MainCategory::when($request->search, function ($q) use ($request) {

            return $q->where('name','LIKE' ,'%' . $request->search . '%')->orWhere('a_name','LIKE' ,'%' . $request->search . '%');

        })->latest('id')->paginate(20);
        $data['url'] = route(env('DASH_URL') . '.main_categories.index');
        return view('dashboard.main_category.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = __('site.main_categories');
        $data['url'] = route(env('DASH_URL') . '.main_categories.store');
        return view('dashboard.main_category.create', compact('data'));
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
            if ($request->image) {

                Image::make($request->image)
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('uploads/categories/' . $request->image->hashName()));

                $data['img'] = $request->image->hashName();

            }else{
                $data['img'] = '';
            }

            MainCategory::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = MainCategory::find($id);
        $data['title'] = __('site.edit_main_categories');
        $data['url'] = route(env('DASH_URL') . '.main_categories.update',$form_data->id);
        return view('dashboard.main_category.edit', compact('data','form_data'));
    }

    public function update(Request $request,$id)
    {
        $category = MainCategory::find($id);
        $validator = $this->validate_page($request,$category);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['name'] = $request->name;
            $data['a_name'] = $request->a_name;
            if ($request->image) {

                if ($category->img != '') {

                    Storage::disk('public_uploads')->delete('/categories/' . $category->img);

                }//end of if

                Image::make($request->image)
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('uploads/categories/' . $request->image->hashName()));

                $data['img'] = $request->image->hashName();

            }//end of if
            $category->update($data);

            return response()->json(array('success' => true), 200);
        }
    }

    public function destroy($id)
    {
        $category = MainCategory::find($id);
        if ($category->img != 'default.png') {

            Storage::disk('public_uploads')->delete('/categories/' . $category->img);

        }//end of if

        $category->delete();
        return response()->json(array('success' => true), 200);

    }

    public function active(Request $request){
        $data['status'] = $request->status;
        $c = MainCategory::find($request->id);
        $c->update($data);
        return redirect()->back();
    }

}
