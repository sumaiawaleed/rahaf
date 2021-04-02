<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
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
            'main_cat_id' => 'required|integer',
            'image' => 'image'
        ];

        if($data){
            $rules += [
                'name' => ['required','max:100',['required', Rule::unique('category')->ignore($data->id),]],
                'a_name' => ['required','max:100',['required', Rule::unique('category')->ignore($data->id),]],
            ];
        }else{
            $rules += [
                'name' => 'required|max:100|unique:category',
                'a_name' => 'required|max:100|unique:category',
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(Request $request)
    {
        $data['title'] = __('site.categories');
        $data['categories'] = Category::when($request->search, function ($q) use ($request) {

            return $q->where('name','LIKE' ,'%' . $request->search . '%')->orWhere('a_name','LIKE' ,'%' . $request->search . '%');

        })->when($request->main_id,function ($q) use ($request){
            return $q->where('main_cat_id',$request->main_id);
        })->latest('id')->paginate(20);
        $data['url'] = route(env('DASH_URL') . '.categories.index');
        $data['main_categories'] = MainCategory::all();

        return view('dashboard.category.index', compact('data','request'));
    }

    public function create()
    {
        $data['title'] = __('site.add_category');
        $data['url'] = route(env('DASH_URL') . '.categories.store');
        $data['main_categories'] = MainCategory::all();
        $data['cat_types'] = MainCategory::all();
        return view('dashboard.category.create', compact('data'));
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
            $data['cat_type'] = 0;
            $data['main_cat_id'] = $request->main_cat_id;
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

            Category::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = Category::find($id);
        $data['title'] = __('site.edit_categories');
        $data['main_categories'] = MainCategory::all();
        $data['cat_types'] = MainCategory::all();
        $data['url'] = route(env('DASH_URL') . '.categories.update',$form_data->id);
        return view('dashboard.category.edit', compact('data','form_data'));
    }

    public function update(Request $request,$id)
    {
        $category = Category::find($id);
        $validator = $this->validate_page($request,$category);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['name'] = $request->name;
            $data['a_name'] = $request->a_name;
            $data['cat_type'] = 0;
            $data['main_cat_id'] = $request->main_cat_id;

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
        $category = Category::find($id);
        if ($category->img != 'default.png') {

            Storage::disk('public_uploads')->delete('/categories/' . $category->img);

        }//end of if

        $category->delete();
        return response()->json(array('success' => true), 200);

    }

    public function get_sub(Request $request){
        $result = "<option>".__('site.select')."</option>";
        if($request->id){
            $data['categories'] = Category::where('main_cat_id',$request->id)->get();
            foreach ($data['categories'] as $category){
                $result .= '<option value="'.$category->id.'">'.$category->getTranslateName(app()->getLocale()).'</option>';
            }
        }
        return $result;
    }

    public function active(Request $request){
        $data['status'] = $request->status;
        $c = Category::find($request->id);
        $c->update($data);
        return redirect()->back();
    }

}
