<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\Post;
use App\Models\Token;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\Category;
use App\Models\BloodType;
use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Models\DonationRequest;
use App\Http\Controllers\Controller;


class MainController extends Controller
{
    public function governorates()
    {
        $governorates = Governorate::all();
        return responseJson(1, 'sucsess', $governorates);
    }


    public function cities(Request $request)
    {
        $cities = City::where(function ($query) use ($request) {
            if ($request->has('governorate_id')){
                $query->where('governorate_id', $request->governorate_id);
            }

        })->get();

        return responseJson(1, 'sucsess', $cities);
    }


    public function categories(Request $request)
    {
        $categories = Category::all();
        return responseJson(1, 'sucsess', $categories);
    }






    public function posts(Request $request)
    {
        // select * form posts where (category_id = 1 and (title like '' or content like '')) limit 10
        $posts = Post::with('category')->where(function ($query) use ($request) {
            if ($request->category_id) {
                $query->where('category_id', $request->category_id);
            }

            if ($request->keyword) {
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->keyword . '%');
                    $query->orWhere('content', 'like', '%' . $request->keyword . '%');
                });
            }
        })->paginate(10);
        return responseJson(1, 'sucsess', $posts);
    }

    public function post(Request $request)
    {
        $posts = Post::find($request->id);
        if ($posts) {
            return responseJson(1, 'sucsess', $posts);
        }
        return responseJson(1, 'no data found', $posts);
    }


    public function bloodTypes(Request $request)
    {
        $blood_types = BloodType::all();
        return responseJson(1, 'sucsess', $blood_types);
    }

    public function settings(Request $request)
    {
        $settings = Setting::first();
        return responseJson(1, 'sucsess', $settings);
    }
    public function contact(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'subject' => 'required',
            'msg' => 'required'

        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $contacts = Contact::create($request->all());
        return responseJson(1, 'sucsess', $contacts);
    }



    public function postFavourite(Request $request)
    {
        $rules = [
            'post_id' => 'required|exists:posts,id',
        ];
        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $toggle = $request->user()->favourites()->toggle($request->post_id);
        return responseJson(1, 'sucsess', $toggle);
    }


    public function myFavourites(Request $request)
    {
        $posts = $request->user()->favourites()->latest()->paginate(20);
        return responseJson(1, 'loaded...', $posts);
    }


    public function donations(Request $request)
    {
        $donations = DonationRequest::paginate(10);
        return responseJson(1, 'sucsess', $donations);
    }


    public function notifications(Request $request)
    {
        $notiOfUser = $request->user()->notifications()->latest()->paginate(20);
        return responseJson(1, 'Loaded...', $notiOfUser);
    }






    public function donationRequestCreate(Request $request)
    {
        $rules = [

            'patient_name' => 'required',
            'patient_age' => 'required|digits:2',
            'blood_type_id' => 'required|exists:blood_types,id',
            'bags_num' => 'required|digits:1',
            'hospital_name' => 'required',
            'city_id' => 'required|exists:cities,id',
            'patient_phone' => 'required|digits:11',
        ];

        //  dd($request->all());

        $validation = validator()->make($request->all(), $rules);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
        //create donation request

        $donationRequest = $request->user()->donationRequest()->create($request->all());
        //dd($donationRequest);


        //  find clients suitable for this donation request
        //blood_types

        // $clientsIds = Client::whereHas('governorates',function ($query) use($donationRequest){
        //     $query->where('governorates.id',$donationRequest->city->governorate_id);

        // })->whereHas('clientBloodTypes',function ($query) use($donationRequest){
        //     $query->where('blood_types.id',$donationRequest->blood_type_id);

        // })->pluck('clients.id')->toArray();

        $clientsIds = $donationRequest->city->governorate->clients()->whereHas('clientBloodTypes', function ($query) use ($request,$donationRequest) {
            $query->where('blood_types.id', $request->blood_type_id);
        })->pluck('clients.id')->toArray();

        //dd($clientsIds);



        $send = "";

        if (count($clientsIds)) {
            // create a notification on database
            $notification = $donationRequest->notifications()->create([
                'title' => 'يوجد حالة تبرع قريبة منك',
                'content' => $donationRequest->blood_type_id . 'احتاج متبرع لفصيلة',
            ]);


            //attach clients to this notification
            $notification->clients()->attach($clientsIds);

            //get tokens for fcm (push notification using firebase cloud)

            // $tokens = Token::where('token', '!=', null)->whereHas('client',function($client)use($donationRequest){
            //     $client->whereHas('governorates',function($query)use($donationRequest){
            //         $query->where('governorates.id',$donationRequest->city->governorate_id);
            //     })->whereHas('clientBloodTypes',function ($query) use($donationRequest){
            //   $query->where('blood_types.id',$donationRequest->blood_type_id);
            //     });
            // })->pluck('token')->toArray();


            $tokens = Token::whereIn('client_id', $clientsIds)->where('token', '!=', null)->pluck('token')->toArray();
            // dd($tokens);

            if (count($tokens)) {
                $title = $notification->title;
                $body = $notification->content;
                $data = [
                    'donation_request_id' => $donationRequest->id
                ];

                $send = notifyByFirebase($title, $body, $tokens, $data);

                info("firebase result:" . $send);
                info("data:" . json_encode($data));
            }
        }
        return responseJson(1, 'تم الاضافة بنجاح', compact('donationRequest'));
    }
}
