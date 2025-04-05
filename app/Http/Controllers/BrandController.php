<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function BrandPage(Request $request){
        $user_id = $request->header('id');
        $brands = Brand::where('user_id', $user_id)->get();
        return Inertia::render('BrandPage',['brands'=>$brands]);
    }//end method

    public function BrandSavePage(Request $request){
        $brand_id = $request->query('id');
        $user_id = $request->header('id');
        $brand = Brand::where('id', $brand_id)->where('user_id', $user_id)->first();
        return Inertia::render('BrandSavePage',['brand'=>$brand]);
    }
    public function CreateBrand(Request $request){
        $user_id = $request->header('id');

        Brand::create([
            'name' => $request->name,
            'user_id' => $user_id
        ]);
        $data = ['message'=>'Brand created successfully','status'=>true,'error'=>''];
        return redirect('/BrandPage')->with($data);
    }//end method

    public function BrandList(Request $request){
        $user_id = $request->header('id');
        $brands = Brand::where('user_id', $user_id)->get();
        return $brands;
    }//end method

    public function BrandById(Request $request){
        $user_id = $request->header('id');
        $brand =Brand::where('id', $request->id)->where('user_id', $user_id)->first();
        return $brand;
    }//end method

    public function BrandUpdate(Request $request){
        $user_id = $request->header('id');
        $id = $request->input('id');
        Brand::where('id', $id)->where('user_id', $user_id)->update([
            'name' => $request->input('name')
        ]);
        $data = ['message'=>'Brand Updaetd successfully','status'=>true,'error'=>''];
        return redirect('/BrandPage')->with($data);
    }//end method

    public function BrandDelete(Request $request,$id){
        $user_id = $request->header('id');
        Brand::where('user_id', $user_id)->where('id', $id)->delete();
        $data = ['message'=>'Brand Deleted successfully','status'=>true,'error'=>''];
        return redirect('/BrandPage')->with($data);
    }//end method
}
