<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\MainCategory;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class SubCategoryController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:categories-read'])->only('index', 'show');
        $this->middleware(['permission:categories-create'])->only('create', 'store');
        $this->middleware(['permission:categories-update'])->only('edit', 'update');
        $this->middleware(['permission:categories-delete'])->only('destroy');
    }
    private function validate_page($request)
    {
        $rules = [
            'name' => 'required|max:100',
            'a_name' => 'required|max:100',
            'cat_type' => 'required|integer',
            'image' => 'image'
        ];

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(Request $request)
    {
        $data['title'] = __('site.sub_categories');
        $data['sub_categories'] = SubCategory::when($request->search, function ($q) use ($request) {

            return $q->where('name','LIKE' ,'%' . $request->search . '%')->orWhere('a_name','LIKE' ,'%' . $request->search . '%');

        })->when($request->cat_id,function ($q) use ($request){
            return $q->where('cat_id',$request->cat_id);
        })->latest('id')->paginate(20);
        $data['url'] = route(env('DASH_URL') . '.sub_categories.index');
        $data['categories'] = Category::all();

        return view('dashboard.sub_category.index', compact('data','request'));
    }

    public function create()
    {
        $data['title'] = __('site.add_sub_categories');
        $data['url'] = route(env('DASH_URL') . '.sub_categories.store');
        $data['categories'] = Category::all();
        return view('dashboard.sub_category.create', compact('data'));
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
            $data['cat_id'] = $request->cat_type;
            if ($request->image) {

                Image::make($request->image)
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('uploads/categories/' . $request->image->hashName()));

                $data['img'] = $request->image->hashName();

            }//end of if

            SubCategory::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = SubCategory::find($id);
        $data['title'] = __('site.edit_sub_categories');
        $data['categories'] = Category::all();
        $data['url'] = route(env('DASH_URL') . '.sub_categories.update',$id);
        return view('dashboard.sub_category.edit', compact('data','form_data'));
    }

    public function update(Request $request,$id)
    {
        $category = SubCategory::find($id);
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['name'] = $request->name;
            $data['a_name'] = $request->a_name;
            $data['cat_id'] = $request->cat_type;
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
        $category = SubCategory::find($id);
        if ($category->img != 'default.png') {

            Storage::disk('public_uploads')->delete('/categories/' . $category->img);

        }//end of if

        $category->delete();
        return response()->json(array('success' => true), 200);

    }

    public function get_sub(Request $request){
        $result = "<option>".__('site.select')."</option>";
        if($request->id){
            $data['categories'] = SubCategory::where('cat_id',$request->id)->get();
            foreach ($data['categories'] as $category){
                $result .= '<option value="'.$category->id.'">'.$category->getTranslateName(app()->getLocale()).'</option>';
            }
        }
        return $result;
    }
}
