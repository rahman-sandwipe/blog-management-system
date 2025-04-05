<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function CustomerPage(Request $request){
        $user_id = $request->header('id');
        $customers = Customer::where('user_id', $user_id)->get();
        return Inertia::render('CustomerPage',['customers'=>$customers]);
    }//end method

    public function CustomerSavePage(Request $request){
        $customer_id = $request->query('id');
        $user_id = $request->header('id');
        $customer = Customer::where('id', $customer_id)->where('user_id', $user_id)->first();
        return Inertia::render('CustomerSavePage',['customer'=>$customer]);
    }
    public function CreateCustomer(Request $request){
        $user_id = $request->header('id');
        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'user_id' => $user_id
        ]);
        $data = ['message'=>'Customer created successfully','status'=>true,'error'=>''];
        return redirect('/CustomerPage')->with($data);
    }//end method

    public function CustomerList(Request $request){
        $user_id = $request->header('id');
        $customers = Customer::where('user_id', $user_id)->get();
        return $customers;
    }//end method

    public function CustomerById(Request $request){
        $user_id = $request->header('id');
        if($request->id){
            $customer = Customer::where('id', $request->id)->where('user_id', $user_id)->first();
            return $customer;
        }else{
            return ['message'=>'Customer not found','status'=>false,'error'=>'Customer not found'];
        }
    }//end method

    public function CustomerUpdate(Request $request){
        $user_id = $request->header('id');
        $id = $request->input('id');
        Customer::where('id', $id)->where('user_id', $user_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ]);
        $data = ['message'=>'Customer Updaetd successfully','status'=>true,'error'=>''];
        return redirect('/CustomerPage')->with($data);
    }//end method

    public function CustomerDelete(Request $request,$id){
        $user_id = $request->header('id');
        Customer::where('user_id', $user_id)->where('id', $id)->delete();
        $data = ['message'=>'Customer Deleted successfully','status'=>true,'error'=>''];
        return redirect('/CustomerPage')->with($data);
    }//end method
}
