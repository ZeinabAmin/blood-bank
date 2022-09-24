<?php

namespace App\Http\Controllers\Api;

use App\Models\Token;
use App\Models\Client;
use App\Models\BloodType;
use App\Mail\ResetPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\BloodTypeClient;
use App\Models\DonationRequest;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'name' => 'required',
            'city_id' => 'required|exists:cities,id',
            'phone' => 'required|unique:clients',
            'last_donation_date' => 'required|date|before_or_equal:' . Carbon::now()->toDateString(),
            'blood_type_id' => 'required|exists:blood_types,id',
            'password' => 'required|confirmed',
            'email' => 'required|unique:clients',
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $request->merge(['password' => bcrypt($request->password)]);
        $client = Client::create($request->all());
        $client->api_token = Str::random(60);
        $client->save();
        $client->clientGovernorates()->attach($request->governorate_id);
        $bloodType = BloodType::where('id', $request->blood_type_id)->first();
        $client->clientBloodTypes()->attach($bloodType->id);

        return responseJson(1, 'تم الاضافة بنجاح', [
            'api_token' => $client->api_token,
            'client' => $client

        ]);
    }

    public function login(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'phone' => 'required',
            'password' => 'required',

        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        //return auth()->guard('api')->validate($request->all());
        $client = Client::where('phone', $request->phone)->first();
        if ($client) {
            if (Hash::check($request->password, $client->password)) {
                return responseJson(1, 'تم تسجيل الدخول', [
                    'api_token' => $client->api_token,
                    'client' => $client
                ]);
            } else {
                return responseJson(0, 'بيانات الدخول غير صحيحة');
            }
        } else {
            return responseJson(0, 'بيانات الدخول غير صحيحة');
        }
    }

    public function profile(Request $request)
    {
        $validation = validator()->make($request->all(), [

            'password' => 'confirmed',
            'email' => Rule::unique('clients')->ignore($request->user()->id),
            'phone' => Rule::unique('clients')->ignore($request->user()->id),

        ]);

        if ($validation->fails()) {
            $data = $validation->errors;
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $loginUser = $request->user();
        $loginUser->update($request->all());

        if ($request->has('password')) {
            $loginUser->password = bcrypt($request->password);
        }

        $loginUser->save();
        return responseJson(1, 'تم تحديث البيانات', $loginUser);
    }


    public function notificationsSettings(Request $request)
    {
        //return $request->all();
        $validation = validator()->make($request->all(), [

            'governorate_id.*' => 'exists:governorates,id',
            'blood_types.*' => 'exists:blood_types,id',

        ]);

        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $validation->errors());
        }

        if ($request->has('governorate_id')) {
            $request->user()->clientGovernorates()->sync($request->governorate_id);
        }

        if ($request->has('blood_types')) {
            $request->user()->clientBloodTypes()->sync($request->blood_types);
        }

        $data = [
            'governorate_id' => $request->user()->governorates()->pluck('governorates.id')->toArray(),
            'blood_type_id' => $request->user()->clientBloodTypes()->pluck('blood_types.id')->toArray(),
        ];
        return responseJson(1, 'done', $data);
    }





    public function resetPassword(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'phone' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors;
            return responseJson(0, $validation->errors()->first(), $data);
        }

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
                return responseJson(1, 'برجاء فحص هاتفك', [
                    'pin_code_for_test' => $code,
                    'mail_fails' => Mail::failures(),
                    'email' => $user->email
                ]);
            } else {
                return responseJson(0, 'حدث خطأ حاول مرة أخرى');
            }
        } else {
            return responseJson(0, 'لا يوجد اي حساب مرتبط بهذا الهاتف');
        }
    }


    public function newPassword(Request $request)
    {
        $validation = validator()->make($request->all(), [

            'pin_code' => 'required',
            'phone' => 'required',
            'password' => 'required|confirmed'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }

        $user = Client::where('pin_code', $request->pin_code)->where('pin_code', '!=', 0)->where('phone', $request->phone)->first();
        if ($user) {

            $user->password = bcrypt($request->password);
            $user->pin_code = null;

            if ($user->save()) {
                return responseJson(1, 'تم تغيير كلمة المرور بنجاح');
            } else {
                return responseJson(0, 'حدث خطأ حاول مرة أخرى');
            }
        } else {
            return responseJson(0, 'هذا الكود غير صالح');
        }
    }


    public function registerToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required',
            'platform' => 'required|in:android,ios'
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
        Token::where('token', $request->token)->delete();
        $request->user()->tokens()->create($request->all());
        return responseJson(1, 'تم التسجيل بنجاح');
    }



    public function removeToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
        Token::where('token', $request->token)->delete();
        $request->user()->tokens()->create($request->all());
        return responseJson(1, 'تم الحذف بنجاح');
    }
}
