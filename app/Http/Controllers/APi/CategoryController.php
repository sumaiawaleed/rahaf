<?php

namespace App\Http\Controllers\APi;

use App\Ad;
use App\Category;
use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private function get_category($p){


        $data = Category::select('id','name','icon')
            ->where('is_deleted',0)
            ->where('parent_id',$p)
            ->orderBy('order_id')
            ->get();

       return $data;

    }
    public function index(Request $request){
        $result = array();
        $i = 0;
        $data['data'] = $this->get_category(0);

        foreach ($data['data'] as $c){
            $result[$i]['id'] = $c->id;
            $result[$i]['name'] = $c->getTranslateName('ar');
            $result[$i]['icon_path'] = $c->icon_path;
            $l1 = $this->get_category($c->id);

            $level1 = array();
            $ids = array();
            $j = 0;
            foreach ($l1 as $l){
                $ids[] = $l->id;
                $level1[$j]['id'] = $l->id;
                $level1[$j]['name'] = $l->getTranslateName('ar');
                $level1[$j]['icon_path'] = $l->icon_path;
                $j++;
            }

            $result[$i]['level1'] = $level1;
            $result[$i]['total_products'] = Ad::whereIn('category_id',$ids)->get()->count();
            $i++;
        }

        $apis = new ApiHelper();
        $apis->createApiResponse(false,200,"",$result);
        return;
    }
}
