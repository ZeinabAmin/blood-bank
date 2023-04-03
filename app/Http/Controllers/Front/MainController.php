<?php

namespace App\Http\Controllers\Front;

use App\Models\Post;
use App\Models\Token;
use App\Models\Client;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\DonationRequest;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function home(Request $request)
    {
        // $client = Client::first();
        // auth('client-web')->login($client);


        // dd($request->user());
        // $posts = Post::take(9)->get();
        $posts = Post::where('publish_date', '<', Carbon::now()->toDateString())->get();


        $donationRequests = DonationRequest::where(function ($query) use ($request) {
            if ($request->input('blood_type_id')) {
                $query->Where('blood_type_id', $request->blood_type_id);
            }

            if ($request->input('city_id')) {
                $query->Where('city_id', $request->city_id);
            }
        })->paginate(4);


        // $donationRequests = DonationRequest::take(4)->get();

        return view('front.home', compact('posts', 'donationRequests'));
    }





    public function articles(Request $request)
    {
        $posts = Post::where('publish_date', '<', Carbon::now()->toDateString())->paginate(5);

        return view('front.articles', compact('posts'));
    }


    public function articleDetails(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $posts = Post::where('id', '!=', $post->id)->get();
        return view('front.article-details', compact('post', 'posts'));
    }
    public function toggleFavourite(Request $request)
    {
        // $toggle = $request->user()->favourites()->toggle($request->post_id);
        $toggle = auth('client-web')->user()->favourites()->toggle($request->post_id);

        return responseJson(1, 'success', $toggle);
    }


    public  function  articlesFavourite()
    {

        $posts = auth('client-web')->user()->favourites()->paginate(5);
        return view('front.articles-favourite', compact('posts'));
    }




    public function donationRequests(Request $request)
    {

        $donationRequests = DonationRequest::where(function ($query) use ($request) {
            if ($request->input('blood_type_id')) {
                $query->Where('blood_type_id', $request->blood_type_id);
            }

            if ($request->input('city_id')) {
                $query->Where('city_id', $request->city_id);
            }
        })->orderBy("id", "desc")->paginate(4);

        return view('front.donation-requests', compact('donationRequests'));
    }


    public function insideRequest(Request $request, $id)
    {
        $donationRequest = DonationRequest::findOrFail($id);
        return view('front.inside-request', compact('donationRequest'));
    }
    public function formCreateDonation(Request $request)
    {
        return view('front.create-donation-request');
    }

    public function createDonation(Request $request)
    {
        $rules = [

            'patient_name' => 'required',
            'patient_age' => 'required|numeric',
            'blood_type_id' => 'required|exists:blood_types,id',
            'bags_num' => 'required|numeric',
            'hospital_name' => 'required',
            'city_id' => 'required|exists:cities,id',
            // 'client_id' => 'required|exists:clients,id',
            'patient_phone' => 'required|min:11',
            'hospital_address' => 'required',
            'details' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];

        //  dd($request->all());

        $validation = validator()->make($request->all(), $rules);

        if ($validation->fails()) {
            flash()->error('حدث خطأ برجاء اجراء طلب مره اخري');
            return back();
          //  $data = $validation->errors();
          //   dd($data);
          //  return responseJson(0, $validation->errors()->first(), $data);
        }



        //create donation request

        $donationRequest = $request->user()->donationRequest()->create($request->all());
        // dd($donationRequest);

        //  find clients suitable for this donation request
        //blood_types
        $clientsIds = $donationRequest->city->governorate->clients()->whereHas('clientBloodTypes', function ($query) use ($request, $donationRequest) {
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

            $tokens = Token::whereIn('client_id', $clientsIds)->where('token', '!=', null)->pluck('token')->toArray();
         //dd($tokens);

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

        if ($donationRequest) {

            flash()->success('تم اضافة طلب التبرع بنجاح');
            return back();
            // return redirect(url('/'));
        } else {
            flash()->error('حدث خطأ برجاء اجراء طلب مره اخري');
            return back();
        }
        //   return responseJson(1, 'تم الاضافة بنجاح', compact('donationRequest'));

    }


    public function notificationsSettings()
    {
        return view('front.notifications-settings');
    }


    // public function notificationsSettingsSave()
    // {
    //     $loginUser = auth()->guard('client-web')->user();

    //     $loginUser->clientGovernorates()->sync($loginUser->city->governorate_id);
    //     $loginUser->clientBloodTypes()->sync($loginUser->blood_type_id);


    //     flash()->success('تم تحديث البيانات');

    //     return back();
    // }





    public function notificationsSettingsSave(Request $request)
    {


        if ($request->has('governorate_id')) {
            $request->user()->clientGovernorates()->sync($request->user()->city->governorate_id);
        }
         else {
            $request->user()->clientGovernorates()->sync([]);

        }
        if ($request->has('blood_type_id')) {
            $request->user()->clientBloodTypes()->sync($request->user()->blood_type_id);
        }
         else {
            $request->user()->clientBloodTypes()->sync([]);

        }


   flash()->success('تم تحديث البيانات');

        return back();
    }























    public function myNotifications(Request $request)
    {

        $loginUser = auth()->guard('client-web')->user();
        // $donationRequest = DonationRequest::findOrFail($id);
        $notificationsOfUser = auth()->guard('client-web')->user()->notifications()->latest()->paginate(20);
        return view('front.my-notifications', compact('notificationsOfUser'));
    }




    public function whoAreUs()
    {
        return view('front.who-are-us');
    }

    public function contactUs()
    {
        return view('front.contact-us');
    }

    public function contactSend(Request $request)
    {

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|digits:11',
            'subject' => 'required',
            'msg' => 'required',
        ];

        $messages = [
            'name.required' => 'يجب كتابة الاسم',
            'email.required' => 'يجب كتابة البريد الإلكتروني',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'phone.required' => 'يجب كتابة رقم الهاتف',
            'phone.digits' => 'رقم الهاتف غير صحيح',
            'subject.required' => 'يجب كتابة عنوان للرسالة',
            'msg.required' => 'يجب كتابة موضوع للرسالة',
        ];

        $this->validate($request, $rules, $messages);

        $contact = Contact::create([


            'subject' => $request->subject,
            'msg' => $request->msg,
            'client_id' => $request->id
        ]);

        flash()->success('تم الارسال');

        return back();
    }
}
