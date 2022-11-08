<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Hash;
use Session;

use App\Models\User;
use App\Models\PaymentMethod as PR;
use App\Models\UserPaymentMethod as UPR;

use Laravel\Cashier\PaymentMethod;

use Illuminate\Support\Facades\Auth;

class UserRepository 
{
    //
    public function add($data){
        
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
          ]);

    }

    public function register(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->add($data);
        
        $user = User::where('email', $data['email'])->first();

        //create stripe customer account
        $user->createAsStripeCustomer();
        // $user->createSetupIntent();
         
        return redirect("dashboard")->withSuccess('You have signed-in');

    }

    //login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return redirect()->intended('dashboard')->withSuccess('Signed in');

        }
  
        return redirect("login")->withSuccess('Login details are not valid');
        
    }

    public function validateUser(Request $request){

        
        if(Auth::check()){

            $user = Auth::user();
            $userPaymentMethod = UPR::where('user_id', $user->id)->get();
            $getPaymentMethod = $this->getPaymentMethod();
            $intent = $user->createSetupIntent();

            return view('dashboard', compact('user', 'getPaymentMethod', 'userPaymentMethod', 'intent'));

        }
  
        return redirect("login")->withSuccess('You are not allowed to access');

    }

    public function getPaymentMethod(){

        return PR::all();

    }

    public function allUserPaymentMethod(){

        return UPR::where('user_id', Auth::user()->id)->get();

    }

    public function addPayments($data){

        $user = Auth::user();

        if(!Auth::check()){
            return redirect("login")->withSuccess('You are not allowed to access');
        }

        $checkPaymentMethod = $this->checkPaymentMethod($data);


        if($checkPaymentMethod){

            return redirect("dashboard")->withSuccess('Payment method already added');

        }

        // dd($data);
        $check = UPR::create([
            'user_id' => $user->id,
            'payment_method' => $data
        ]);

        $user->addPaymentMethod($data);

        return redirect("dashboard")->withSuccess('Payment method added successfully');

    }

    public function checkPaymentMethod($data){

        $check = UPR::where('user_id', Auth::user()->id)->where('payment_method', $data)->first();

        if($check){

            return true;

        }

        return false;

    }

    public function removePayments($data){

        if(!Auth::check()){
            return redirect("login")->withSuccess('You are not allowed to access');
        }

        $checkPaymentMethod = $this->checkPaymentMethod($data);

        if(!$checkPaymentMethod){

            return redirect("dashboard")->withSuccess('Payment method not found');

        }

        $check = UPR::where('user_id', Auth::user()->id)->where('payment_method', $data)->delete();

        return redirect("dashboard")->withSuccess('Payment method removed successfully');

    }

    public function checkPaymentMethods(){

        $user = Auth::user();
        
        dd($user->createSetupIntent());
    }



    //create customer
    public function createStripe()
    {
        $user = Auth::user();
        dd($user);
        $customer = $user->createAsStripeCustomer();
        return $customer;
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }

    
}
