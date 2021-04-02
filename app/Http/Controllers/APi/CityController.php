<?php

namespace App\Http\Controllers\APi;

use App\City;
use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(){
        $data['cities'] = City::all();
        foreach ($data['cities'] as $city){
            $city->name = $city->getTranslateName('ar');
        }
        $apis = new ApiHelper();
        $apis->createApiResponse(false, 200, "", $data);
        return;
    }
}
