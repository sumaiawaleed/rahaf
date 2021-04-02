<?php

namespace App\Http\Controllers\APi;

use App\Ad;
use App\AdImage;
use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $data['slider'] = Ad::select('id', 'name', 'main_image', 'price', 'discount_price', 'category_id')
            ->where('type', 3)
            ->get()
            ->take(10);
        $p = new ProductsController();
        $data['slider'] = $p->featch_products($data['slider'],$user);

        $data['latest_ads'] = Ad::select('id', 'name', 'main_image', 'price', 'discount_price', 'category_id')
            ->where('type', 2)
            ->get()
            ->take(10);
        $p = new ProductsController();
        $data['latest_ads'] = $p->featch_products($data['latest_ads'],$user);


        $data['latest_products'] = Ad::select('id', 'name', 'main_image', 'price', 'discount_price', 'category_id')
            ->where('type', 1)
            ->get()
            ->take(10);
        $p = new ProductsController();
        $data['latest_products'] = $p->featch_products($data['latest_products'],$user);

        $apis = new ApiHelper();
        $apis->createApiResponse(false, 200, "", $data);
        return;
    }
}
