<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Inertia\Inertia;
use App\Mail\OTPMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    // login page && user login
    public function LoginPage(Request $request){
        return Inertia::render('LoginPage');
    }//end method
    public function userLogin(Request $request){
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        if($user && Hash::check($request->input('password'), $user->password)){
            $request->session()->put('email', $email);
            $request->session()->put('user_id', $user->id);

            $data = ['message'=>'User login successfully','status'=>true,'error'=>''];
            return redirect('/dashboard')->with($data);
        }else{
            $data = ['message'=>'Invalid credentials','status'=>false,'error'=>''];
            return redirect('/login')->with($data);
        }
    }//end method


    // register page && user register
    public function registerPage(Request $request){
        return Inertia::render('registerPage');
    }//end method
    public function userRegister(Request $request){
        try{
            $data = [
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ];

            if($request->hasFile('image')){
                $image = $request->file('image');
    
                $fileName = time().'.'.$image->getClientOriginalExtension();
                $filePath = 'uploads/avatar/'.$fileName;
    
                $image->move(public_path('uploads/avatar'), $fileName);
                $data['image'] = $filePath;
            }
            
            User::create($data);

            $data = ['message'=>'User created successfully','status'=>true,'error'=>''];
            return redirect('/login')->with($data);
        }catch(Exception $e){
            $data = [
                'message' => 'User registration failed',
                'status' => false,
                'error' => ''
            ];
            return redirect('/register')->with($data);
        }
    }//end method


    // forgot password page && forget password
    public function forgotPasswordPage(Request $request){
        return Inertia::render('forgotPasswordPage');
    }//end method
    public function forgetPassword(Request $request){
        $email = $request->input('email');
        $otp = rand(100000,999999);

        $count = User::where('email',$email)->count();

        if($count == 1){
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email', $email)->update(['otp' => $otp]);
            $request->session()->put('email', $email);
            $data = ["message"=>"6 Digit { $otp } OTP send successfully","status"=>true,"error"=>''];
            return redirect('/verify-otp')->with($data);
        }else{
            $data = ['message'=>'unauthorized','status'=>false,'error'=>''];
            return redirect('/register')->with($data);
        }
    }//end method


    // verify otp page && verify otp
    public function verifyOTPPage(Request $request){
        return Inertia::render('VerifyOTPPage');
    }//end method
    public function verifyOTP(Request $request){
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);
        $email = $request->session()->get('email');
        $otp = $request->input('otp');

        $count = User::where('email', $email)->where('otp', $otp)->count();

        if($count == 1){
            User::where('email', $email)->update(['otp' => 0]);

            $request->session()->put('otp_verify','yes');

            $data = ["message"=>"OTP verification successfully","status"=>true,"error"=>''];
            return redirect('/reset-password')->with($data);
        }else{
            $data = ['message'=> 'unauthorized','status'=>false, 'error'=>''];
            return redirect('/login')->with($data);
        }
    }//end method


    // reset password page && reset password
    public function ResetPasswordPage(Request $request){
        return Inertia::render('ResetPasswordPage');
    }//end method
    public function resetPassword(Request $request){
        try{
            $email = $request->session()->get('email','default');
            $password = $request->input('password');

            $otp_verify = $request->session()->get('otp_verify','default');
            if($otp_verify === 'yes'){
                User::where('email', $email)->update(['password' => $password]);
                $request->session()->flush();

                $data = ['message'=> 'Password reset successfully','status'=>true, 'error'=>'' ];
                return redirect('/login')->with($data);
            }else{
                $data = ['message'=> 'Request fail','status'=>false, 'error'=>'' ];
                return redirect('/reset-password')->with($data);
            }

        }catch(Exception $e){
            $data = ['message'=> $e->getMessage(),'status'=>false, 'error'=>'' ];
            return redirect('/reset-password')->with($data);
        }
    }//end method


    // user profile page && user update
    public function profilePage(Request $request){
        $email = request()->header('email');

        $user = User::where('email', $email)->first();
        return Inertia::render('ProfilePage',['user'=>$user]);
    }//end method
    public function userUpdate(Request $request){
        $email = request()->header('email');

        $user = User::where('email', $email)->first();
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        
        if($request->hasFile('image')){
            if($user->image && file_exists(public_path($user->image))){
                unlink(public_path($user->image));
            }

            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $image = $request->file('image');
            $fileName = time().'.'.$image->getClientOriginalExtension();
            $filePath = 'uploads/avatar/'.$fileName;
            $image->move(public_path('uploads/avatar'), $fileName);
            $user->image = $filePath;
        }

        $user->save();
        $data = ['message'=> 'Profile update successfully','status'=>true, 'error'=>'' ];
        return back()->with($data);
    }


    // changePasswordPage && changePassword
    public function changePasswordPage(Request $request){
        $email = request()->header('email');

        $user = User::where('email', $email)->first();
        return Inertia::render('ChangePassword',['user'=>$user]);
    }
    public function changePassword(Request $request){
        try{
            $email = request()->header('email');

            $request->validate([
                'password' => 'required|min:5',
                'confirm_password' => 'required|same:password',
            ]);

            $user = User::where('email', $email)->first();
            $user->password = Hash::make($request->input('password'));
            $user->save();

            $data = ['message'=> 'Password change successfully','status'=>true, 'error'=>'' ];
            return back()->with($data);
        }catch(Exception $e){
            $data = ['message'=> $e->getMessage(),'status'=>false, 'error'=>'' ];
            return back()->with($data);
        }
    }
    

    public function userLogout(Request $request){
        $request->session()->forget('email');
        $request->session()->forget('user_id');
        $data = ['message'=>'User logout successfully','status'=>true,'error'=>''];
        return redirect('/login')->with($data);
    }//end method
}

