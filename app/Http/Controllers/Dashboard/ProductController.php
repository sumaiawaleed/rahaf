<?php

namespace App\Http\Controllers\Dashboard;

use App\Brand;
use App\Category;
use App\ExtraImage;
use App\Favourite;
use App\Functions\ImagesFunctions;
use App\Http\Controllers\Controller;
use App\MainCategory;
use App\OrderDetails;
use App\Product;
use App\Quantity;
use App\SubCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Elibyy\TCPDF\Facades\TCPDF as PDF;


class ProductController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:products-read'])->only('index', 'show');
        $this->middleware(['permission:products-create'])->only('create', 'store');
        $this->middleware(['permission:products-update'])->only('edit', 'update');
        $this->middleware(['permission:products-delete'])->only('destroy');
    }

    private function validate_page($request,$data = '')
    {
        $rules = [
            'available' => 'integer',
            'price_type' => 'required|integer',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'status' => 'integer',
            'is_belong' => 'integer',
            'quantity_id' => 'integer',
            'quantity' => 'required',
            'main_catgeory_id' => 'integer',
            'cat_id' => 'integer',
            'image' => 'image'
        ];

        if($data){
//            $rules += [
//                'name' => ['required',Rule::unique('product', 'name')],
//                'a_name' => ['required',Rule::unique('product', 'a_name')],
//                'sku' => ['required',Rule::unique('product', 'sku')],
//            ];
        }else{
            $rules += [
                'name' => ['required',Rule::unique('product', 'name')],
                'a_name' => ['required',Rule::unique('product', 'a_name')],
                'sku' => ['required',Rule::unique('product', 'sku')],
            ];

        }

        if($request->type == 1){
            $rules += ['offer_price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'];
        }

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(Request $request)
    {
        $data['title'] = __('site.products');
        $data['products'] = Product::when($request->search, function ($q) use ($request) {
            Cache::put('search', $request->search, $seconds = 60*24*30);

            return $q->where('name','LIKE' ,'%' . $request->search . '%')
                ->orWhere('a_name','LIKE' ,'%' . $request->search . '%');

        })->when($request->cat_id,function ($q) use ($request){
            Cache::put('category', $request->cat_id, $seconds = 60*24*30);
            return $q->where('cat_id',$request->cat_id);
        })->when($request->q,function ($q) use ($request){
            if($request->q){
                Cache::put('quantity', $request->q, $seconds = 60*24*30);
                Cache::put('operation', $request->operation, $seconds = 60*24*30);
                if($request->operation == 2){
                    return   $q->where('quantity','<',$request->q);
                }else if($request->operation == 3){
                    return   $q->where('quantity','>',$request->q);
                }else{
                    return $q->where('quantity','=',$request->q);
                }
            }
        })->when($request->status,function ($q) use ($request){
            if($request->status == 1 or $request->status == 2){
                Cache::put('status', $request->status, $seconds = 60*24*30);

                return $q->where('available',(($request->status == 1) ? 1 : 0));
            }
        })->when($request->brand_id,function ($q) use ($request){
            Cache::put('brand', $request->brand, $seconds = 60*24*30);

            return $q->where('brand_id',$request->brand_id);
        })->when($request->available,function ($q) use ($request){
            Cache::put('available', $request->available, $seconds = 60*24*30);

            return $q->where('available',1);
        })->when($request->sku,function ($q) use ($request){
            Cache::put('sku', $request->sku, $seconds = 60*24*30);

            return $q->where('sku','LIKE' ,'%' . $request->sku . '%');
        })->when($request->var_type,function ($q) use ($request){
            Cache::put('var_type', $request->var_type, $seconds = 60*24*30);

            if($request->var_type == 1 or $request->var_type == 2)
                    return $q->where('var_type',$request->var_type);
        })
            ->orderBy('sku', "asc")
            ->paginate(20);


        foreach ($data['products'] as $product){
            $product->orders  = OrderDetails::where('product_id',$product->id)->get()->count();
            $product->favorites  = Favourite::where('product_id',$product->id)->get()->count();
        }

        Cache::put('page',$request->page);

        $data['url'] = route(env('DASH_URL') . '.products.index');
        $data['categories'] = Category::all();

        if($request->pdf){
            $view = \View::make('dashboard.products._pdf',compact('data'));
            $html_content = $view->render();
            PDF::SetTitle($data['title']);
            PDF::AddPage();
            PDF::setRTL(true);
            PDF::writeHTML($html_content, true, false, true, false, '');
            // userlist is the name of the PDF downloading
            PDF::Output(date('Y-m-d', strtotime(now())));
        }else{
            return view('dashboard.products.index', compact('data','request'));
        }
    }

    public function create()
    {
        $data['title'] = __('site.add_products');
        $data['url'] = route(env('DASH_URL') . '.products.store');
        $data['main_categories'] = MainCategory::all();
        $data['brands'] = Brand::all();
        $data['quantities'] = Quantity::all();
        return view('dashboard.products.create', compact('data'));
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
            $data['description'] = $request->description;
            $data['a_description'] = $request->a_description;
            $data['price_type'] = $request->price_type;
            $data['price'] = $request->price;
            $data['offer_price'] = ($request->offer_price) ? $request->offer_price : 0;
            $data['available'] = $request->available ? $request->available : 0;
            $data['status'] = 1;
            $data['is_belong'] = $request->is_belong ? $request->is_belong : 0;
            $data['type'] = ($request->type) ? $request->type : 0;
            $data['brand_id'] = ($request->brand_id) ? ($request->brand_id) : 0;
            $data['main_catgeory_id'] = $request->main_catgeory_id;
            $data['cat_id'] = $request->cat_id;
            $data['quantity'] = $request->quantity ;
            $data['quantity_id'] = $request->quantity_id ;
            $data['tags'] = $request->tags;
            $data['sku'] = $request->sku;
            $data['var_type'] = $request->var_type;
            if ($request->image) {

                Image::make($request->image)
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('uploads/products/' . $request->image->hashName()));

                $data['img'] = $request->image->hashName();

            }else{
                $data['img'] = "";
            }

            Product::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = Product::findOrFail($id);
        $data['title'] = __('site.edit_products');
        $data['main_categories'] = MainCategory::all();
        $data['categories'] = Category::where('main_cat_id',$form_data->main_catgeory_id)->get();
        $data['sub_categories'] = SubCategory::where('cat_id',$form_data->cat_id)->get();
        $data['brands'] = Brand::all();
        $data['quantities'] = Quantity::all();
        $data['url'] = route(env('DASH_URL') . '.products.update',$id);
        return view('dashboard.products.edit', compact('data','form_data'));
    }

    public function update(Request $request,$id)
    {
        $product = Product::find($id);
        $validator = $this->validate_page($request,$product);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['name'] = $request->name;
            $data['a_name'] = $request->a_name;
            $data['description'] = $request->description;
            $data['a_description'] = $request->a_description;
            $data['price_type'] = $request->price_type;
            $data['price'] = $request->price;
            $data['offer_price'] = ($request->offer_price) ? $request->offer_price : 0;
            $data['available'] = $request->available ? $request->available : 0;
            $data['status'] = $request->status ? $request->status : 0;
            $data['is_belong'] = $request->is_belong ? $request->is_belong : 0;
            $data['type'] = ( $request->type) ?  $request->type  : 0;
            $data['brand_id'] = $request->brand_id;
            $data['quantity_id'] = $request->quantity_id;
            $data['main_catgeory_id'] = $request->main_catgeory_id;
            $data['cat_id'] = $request->cat_id;
            $data['quantity'] = $request->quantity ;
            $data['tags'] = $request->tags;
            $data['sku'] = $request->sku;
            $data['var_type'] = $request->var_type;

            if ($request->image) {

                if ($product->img != 'default.png') {

                    Storage::disk('public_uploads')->delete('/products/' . $product->img);

                }//end of if

                Image::make($request->image)
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('uploads/products/' . $request->image->hashName()));

                $data['img'] = $request->image->hashName();

            }//end of if

            $product->update($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product->img != 'default.png') {

            Storage::disk('public_uploads')->delete('/products/' . $product->img);

        }//end of if

        $product->delete();
        return response()->json(array('success' => true), 200);

    }

    public function upload_image(Request $request){
        $image = '';
        if ($request->image) {
            $images_functions = new ImagesFunctions();
            $image = $images_functions->UploadImage($request->image, 'products', true, true);

            if($image !=''){
                echo $image;
            }
        }
    }


    public function save_excel(Request $request){
        if ($xlsx = \SimpleXLSX::parse($request->file)) {
            $i = 0;

            foreach ($xlsx->rows() as $index => $elt) {

                if ($index != 0) {
                    $data['name'] = $elt[1];
                    $data['a_name'] = $elt[2];
                    $data['description'] = $elt[3];
                    $data['a_description'] = $elt[4];
                    $data['price_type'] = 1;
                    $data['price'] = $elt[5];
                    $data['offer_price'] = 0;
                    $data['available'] = $elt[11];
                    $data['status'] = 1;
                    $data['is_belong'] =  0;
                    $data['type'] =  0;
                    $data['brand_id'] = $elt[6];
                    $data['main_catgeory_id'] = $elt[7];
                    $data['cat_id'] = $elt[8];
                    $data['quantity'] = $elt[9] ;
                    $data['quantity_id'] = 1 ;
                    $data['tags'] = "";
                    $data['sku'] = $elt[10];
                    $data['img'] = "";


                    Product::create($data);

                    //  return redirect(route(env('DASH_URL').'.products.index'));
                }
            }
            return redirect(route(env('DASH_URL').'.products.index'));
        }
    }

    public function reports(Request $request){
        $data['title'] = __('site.products');
        $data['products'] =  $data['products'] = Product::when($request->search, function ($q) use ($request) {
            Cache::put('search', $request->search, $seconds = 60*24*30);

            return $q->where('name','LIKE' ,'%' . $request->search . '%')
                ->orWhere('a_name','LIKE' ,'%' . $request->search . '%');

        })->when($request->cat_id,function ($q) use ($request){
            Cache::put('category', $request->cat_id, $seconds = 60*24*30);
            return $q->where('cat_id',$request->cat_id);
        })->when($request->q,function ($q) use ($request){
            if($request->q){
                Cache::put('quantity', $request->q, $seconds = 60*24*30);
                Cache::put('operation', $request->operation, $seconds = 60*24*30);
                if($request->operation == 2){
                    return   $q->where('quantity','<',$request->q);
                }else if($request->operation == 3){
                    return   $q->where('quantity','>',$request->q);
                }else{
                    return $q->where('quantity','=',$request->q);
                }
            }
        })->when($request->status,function ($q) use ($request){
            if($request->status == 1 or $request->status == 2){
                Cache::put('status', $request->status, $seconds = 60*24*30);

                return $q->where('available',(($request->status == 1) ? 1 : 0));
            }
        })->when($request->brand_id,function ($q) use ($request){
            Cache::put('brand', $request->brand, $seconds = 60*24*30);

            return $q->where('brand_id',$request->brand_id);
        })->when($request->available,function ($q) use ($request){
            Cache::put('available', $request->available, $seconds = 60*24*30);

            return $q->where('available',1);
        })->when($request->sku,function ($q) use ($request){
            Cache::put('sku', $request->sku, $seconds = 60*24*30);

            return $q->where('sku','LIKE' ,'%' . $request->sku . '%');
        })->when($request->var_type,function ($q) use ($request){
            Cache::put('var_type', $request->var_type, $seconds = 60*24*30);

            if($request->var_type == 1 or $request->var_type == 2)
                return $q->where('var_type',$request->var_type);
        })->orderBy('sku')
            ->where('main_catgeory_id' , '!=' ,70)
            ->where('is_belong' , '!=' ,70)
            ->latest('id')->get()->take(500);

        $data['url'] = route(env('DASH_URL') . '.products.index');
        $data['categories'] = Category::all();

        if($request->pdf){
            $view = \View::make('dashboard.products._pdf',compact('data'));
            $html_content = $view->render();
            PDF::SetTitle($data['title']);
            PDF::AddPage();
            PDF::setRTL(true);
            PDF::writeHTML($html_content, true, false, true, false, '');
            // userlist is the name of the PDF downloading
            PDF::Output(date('Y-m-d', strtotime(now())));
        }else{
            return view('dashboard.products.resports', compact('data','request'));
        }
    }

    public function getAutocompleteData(Request $request){
        if($request->has('term')){
            return Product::where('sku','like','%'.$request->input('term').'%')->get();
        }
    }


    public function show(Product $product){
        $data['title'] = __('site.products');
        $data['product'] = $product;
        $data['extras'] = ExtraImage::with('product')->where('product_id')->get();
        return view('dashboard.products.show', compact('data'));

    }
}
