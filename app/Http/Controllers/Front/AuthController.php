<?php

namespace App\Http\Controllers\Front;

use App\Models\City;
use App\Models\Client;
use App\Models\BloodType;
use App\Mail\ResetPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register()
    {

        return view('front.register');
    }

    public function registerSave(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:clients',
            'date_of_birth' => 'required',
            'blood_type_id' => 'required|exists:blood_types,id',
            'governorate_id' => 'required',
            'city_id' => 'required',
            'phone' => 'required|unique:clients|digits:11',
            'last_donation_date' => 'required',
            'password' => 'required|confirmed|min:6',
        ];
        $messages = [
            'name.required' => 'يجب كتابه الاسم',
            'email.required' => 'يجب كتابه البريد الإلكتروني',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'email.unique' => 'البريد الإلكتروني مسجل مسبقا',
            'date_of_birth.required' => 'يجب كتابه تاريخ الميلاد',
            'blood_type_id.required' => 'يجب اختيار فصيله الدم',
            'blood_type_id.exists' => 'فصيله الدم غير موجوده',
            'governorate_id.required' => 'يجب اختيار المحافظة',
            'city_id.required' => 'يجب اختيار المدينة',
            'phone.required' => 'يجب كتابه رقم الهاتف',
            'phone.unique' => 'رقم الهاتف مسجل مسبقا',
            'phone.digits' => 'رقم الهاتف غير صحيح',
            'last_donation_date.required' => 'يجب كتابه تاريخ اخر عمليه تبرع بالدم',
            'password.required' => 'يجب كتابه كلمه المرور',
            'password.confirmed' => 'كلمه المرور لا تطابق تأكيد كلمه المرور',
            'password.min' => 'يجب ان تكون كلمه المرور اكثر من 6 احرف',

        ];

        $this->validate($request, $rules, $messages);


        $request->merge(['password' => bcrypt($request->password)]);
        $client = Client::create($request->all());
        $client->api_token = Str::random(60);
        $client->save();

        $client->clientGovernorates()->attach($request->governorate_id);

        $client->clientBloodTypes()->attach($request->blood_type_id);

        flash()->success('تم التسجيل بنجاح.');

        return redirect(url('signin-account'));
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


        if (Auth::guard('client-web')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
            return redirect(url('/'));
        } else {

             flash()->error('يرجي التأكد من صحة البيانات.');
            return back();
        }
    }


    public function forgetPassword(Request $request)
    {

        return view('front.forget-password');
    }

    public function resetPassword(Request $request)
    {


        $rules = [
            'phone' => 'required|exists:clients|min:11',
        ];
        $messages = [
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.exists' => 'الهاتف الذي ادخلته غير صحيح',
            'phone.min' => 'رقم الهاتف يجب ان يكون علي الاقل 11 رقم',
        ];

        $this->validate($request, $rules, $messages);


        $user = Client::where('phone', $request->phone)->first();

        if ($user) {
            $code = rand(1111, 9999);
            $user->pin_code = $code;
            //$update=$user->update(['pin_code'=>$code]);
            if ($user->save()) {
                //  send email
                Mail::to($user->email)
                    ->bcc("zeinabamin00@gmail.com")
                    ->send(new ResetPassword($user));
              
                flash()->success('برجاء فحص بريدك الالكتروني');
                return redirect(url(route('new-password')));
            } else {
                flash()->error('حدث خطأ برجاء المحاوله مره اخري');
            return back();

            }
        } else {
            flash()->error('لا يوجد حسابات مرتبطه بهذا الهاتف');
            return back();
        }
    }

    public function newPassword(Request $request)
    {

        return view('front.new-password');
    }


    public function newPasswordConfirm(Request $request)
    {
        $rules = [
            'pin_code' => 'required',
            'new_password' => 'required|confirmed'
        ];
        $messages = [
            'pin_code.required' => 'رمز الاسترجاع مطلوب',
            'new_password.required' => 'كلمة المرور مطلوبه',
            'new_password.confirmed' => 'كلمة المرور يجب ان تكون متطابقه',

        ];

        $this->validate($request, $rules, $messages);
        $user = Client::where('pin_code', $request->pin_code)->where('pin_code', '!=', 0)->where('phone', $request->phone)->first();
        if ($user) {

            $user->password = bcrypt($request->password);
            $user->pin_code = null;

            if ($user->save()) {
                flash()->success('تم تغيير كلمة المرور بنجاح');
                return redirect(route('signin-account'));
            } else {
                flash()->error('حدث خطأ برجاء المحاوله مره أخري');
                return back();
            }
        } else {
            flash()->error('هذا الكود غير صالح');
            return back();
        }
    }




    public function profile(Request $request)
    {
        $client = auth()->guard('client-web')->user();
        $blood_types = BloodType::all();
        $cities = City::all();
        return view('front.edit-profile', compact('client', 'blood_types', 'cities'));
    }

    public function editProfile(Request $request)
    {

        $rules = [
            'name' => 'required',
            // 'email' => Rule::unique('clients')->ignore($request->user()->id),
            'email' => Rule::unique('clients')->ignore(auth()->guard('client-web')->user()),

            'date_of_birth' => 'required',
            'blood_type_id' => 'required|exists:blood_types,id',
            'governorate_id' => 'required',
            'city_id' => 'required',
            //    'phone' => Rule::unique('clients')->ignore($request->user()->id),
            'phone' => Rule::unique('clients')->ignore(auth()->guard('client-web')->user()),

            'last_donation_date' => 'required',
            'password' => 'required|confirmed',
        ];
        $messages = [
            'name.required' => 'يجب كتابه الاسم',
            'email.unique' => 'البريد الإلكتروني مسجل مسبقا',
            'date_of_birth.required' => 'يجب كتابه تاريخ الميلاد',
            'blood_type_id.required' => 'يجب اختيار فصيله الدم',
            'blood_type_id.exists' => 'فصيله الدم غير موجوده',
            'governorate_id.required' => 'يجب اختيار المحافظة',
            'city_id.required' => 'يجب اختيار المدينة',
            'phone.unique' => 'رقم الهاتف مسجل مسبقا',
            'last_donation_date.required' => 'يجب كتابه تاريخ اخر عمليه تبرع بالدم',
            'password.required' => 'يجب كتابه كلمه المرور',
            'password.confirmed' => 'كلمه المرور لا تطابق تأكيد كلمه المرور',

        ];

        $this->validate($request, $rules, $messages);

        //  $loginUser = $request->user();
        $loginUser = auth()->guard('client-web')->user();

        $loginUser->update($request->all());

        if ($request->has('password')) {
            $loginUser->password = bcrypt($request->password);
        }

        $loginUser->save();
        //    $loginUser->clientGovernorates()->sync($loginUser->city)->governorate_id;
        //     $loginUser->clientBloodTypes()->sync($loginUser->blood_type_id);
        flash()->success('تم تحديث البيانات');

        return back();
    }



    public function logout()
    {
        auth('client-web')->logout();
        return redirect(url('/'));
    }
}
