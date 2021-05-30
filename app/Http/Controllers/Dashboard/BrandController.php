<?php

namespace App\Http\Controllers\Dashboard;

use App\Brand;
use App\Http\Controllers\Controller;
use App\Product;
use Elibyy\TCPDF\Facades\TCPDF as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:brands-read'])->only('index', 'show');
        $this->middleware(['permission:brands-create'])->only('create', 'store');
        $this->middleware(['permission:brands-update'])->only('edit', 'update');
        $this->middleware(['permission:brands-delete'])->only('destroy');
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
        $data['title'] = __('site.brands');
        $data['brands'] = Brand::when($request->search, function ($q) use ($request) {

            return $q->where('name','LIKE' ,'%' . $request->search . '%')
                ->orWhere('a_name','LIKE' ,'%' . $request->search . '%');
        })->latest('id')->paginate(20);
        $data['url'] = route(env('DASH_URL') . '.brands.index');
        return view('dashboard.brands.index', compact('data'));
    }

    public function report(Request $request){
        $data['title'] = __('site.brands');
        $data['brands'] = Brand::when($request->search, function ($q) use ($request) {

            return $q->where('name','LIKE' ,'%' . $request->search . '%')
                ->orWhere('a_name','LIKE' ,'%' . $request->search . '%');
        })->latest('id')->paginate(20);
        $data['url'] = route(env('DASH_URL') . '.brands.index');

        foreach ($data['brands'] as $b){
            $b->products = Product::where('brand_id',$b->id)->get()->count();
        }
        if($request->pdf){
            $view = \View::make('dashboard.brands._pdf',compact('data'));
            $html_content = $view->render();
            PDF::SetTitle($data['title']);
            PDF::AddPage();
            PDF::setRTL(true);
            PDF::writeHTML($html_content, true, false, true, false, '');
            // userlist is the name of the PDF downloading
            PDF::Output(date('Y-m-d', strtotime(now())));
        }else{
            return view('dashboard.brands.reports', compact('data','request'));
        }
    }

    public function create()
    {
        $data['title'] = __('site.add_brands');
        $data['url'] = route(env('DASH_URL') . '.brands.store');
        return view('dashboard.brands.create', compact('data'));
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
                    ->save(public_path('uploads/brands/' . $request->image->hashName()));

                $data['img'] = $request->image->hashName();

            }else{
                $data['img'] =  "";
            }

            Brand::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = Brand::find($id);
        $data['title'] = __('site.edit_brands');
        $data['url'] = route(env('DASH_URL') . '.brands.update',$form_data->id);
        return view('dashboard.brands.edit', compact('data','form_data'));
    }

    public function update(Request $request,$id)
    {
        $category = Brand::find($id);
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

                if ($category->img != '') {

                    Storage::disk('public_uploads')->delete('/brands/' . $category->img);

                }//end of if

                Image::make($request->image)
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('uploads/brands/' . $request->image->hashName()));

                $data['img'] = $request->image->hashName();

            }//end of if
            $category->update($data);

            return response()->json(array('success' => true), 200);
        }
    }

    public function destroy($id)
    {
        $category = Brand::find($id);
        if ($category->img != 'default.png') {

            Storage::disk('public_uploads')->delete('/brands/' . $category->img);

        }//end of if

        $category->delete();
        return response()->json(array('success' => true), 200);

    }

    public function active(Request $request){
        $data['status'] = $request->status;
        $c = Brand::find($request->id);
        $c->update($data);
        return redirect()->back();
    }

}
