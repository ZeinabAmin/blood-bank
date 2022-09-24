<?php

namespace App\Http\Controllers\Front;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register()
    {

        return view('front.register');
    }

    public function registerSave(Request $request)
    {

    }
    public function signIn(Request $request)
    {

        return view('front.signin-account');
    }


    public function signInSave(Request $request)
    {
        $rules = [
            'phone' => 'required|digits:11',
            'password' => 'required'
        ];
        $messages = [
            'phone.required' => 'يجب كتابه رقم الهاتف',
            'phone.digits' => 'رقم الهاتف غير صحيح',
            'password.required' => 'يجب كتابه كلمة السر'
        ];

        $this->validate($request, $rules, $messages);

        // $client = Client::where('phone', $request->phone)->first();
        // if ($client) {
        //     if (Hash::check($request->password, $client->password)) {
                Auth::guard('client-web')->attempt(['phone' => $request->phone, 'password' => $request->password]);
                return redirect(url('/'));
            }
        } else {
            flash()->error('يرجي التأكد من صحة البيانات.');
            return back();
        }
    }



public function logout() {
    auth('client-web')->logout();
    return back();
}
}
