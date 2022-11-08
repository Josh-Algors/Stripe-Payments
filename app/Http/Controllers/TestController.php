<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;

use Hash;
use Session;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        ini_set('memory_limit', '2048M');
        return view('auth.login');
    }  
      
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('Signed in');
        }
  
        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function registration()
    {
        return view('auth.registration');
    }
      
    public function customRegistration(Request $request)
    {  
        
        $registerUser = $this->userRepository->register($request);

        return $registerUser;

    }

    public function create(array $data)
    {

      $createUser = $this->userRepository->add($data);

      return $createUser;
    }    
    
    public function dashboard()
    {
        
        $validateUser = $this->userRepository->validateUser();

        return $validateUser;

    }

    public function addPayment(Request $request)
    {
        $input = $request->input('payment_method');

        if(!$input)
        {
            return redirect()->back()->with('error', 'Please select a payment method');
        }

        switch ($request->input('action')) {
            case 'add':
                $addPay = $this->userRepository->addPayments($input);
                return $addPay; 
    
            case 'remove':
                $removePay = $this->userRepository->removePayments($input);
                return $removePay;
            
            case 'pay':
                $pay = $this->userRepository->checkout($input);
                return $pay;
        }
        
    }

    public function checkm(){
        //checkPaymentMethods
        $checkPaymentMethods = $this->userRepository->checkPaymentMethods();

        return $checkPaymentMethods;
    }

    public function createStripeAccount()
    {
        $createCustomer = $this->userRepository->createStripe();

        return $createCustomer;
    }

    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}
