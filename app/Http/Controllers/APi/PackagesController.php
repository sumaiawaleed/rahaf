<?php

namespace App\Http\Controllers\Api;

use App\AdPackage;
use App\Http\Controllers\Controller;
use App\UserType;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    public function index()
    {
        $data['status'] = "success";
        $data['data'] = UserType::all();

        foreach ($data['data'] as $d) {
            $d->packages = AdPackage::where('user_type', $d->id)
                ->where('is_deleted', 0)
                ->get();

            foreach ($d->packages as $p) {
                $features = explode(',', $p->features);
                $p->features = json_encode($features);
            }
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        return;
    }


}
