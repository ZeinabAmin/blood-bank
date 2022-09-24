<?php

namespace App\Http\Controllers\Front;

use App\Models\Post;
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
        $client = Client::first();
        auth('client-web')->login($client);
        // dd($request->user());
        // $posts = Post::take(9)->get();
        $posts = Post::where('publish_date', '<', Carbon::now()->toDateString())->get();

        $donationRequests = DonationRequest::take(4)->get();

        return view('front.home', compact('posts', 'donationRequests'));
    }
    public function about()
    {
        return view('front.about');
    }



    public function articles(Request $request)
    {
        $posts = Post::where('publish_date', '<', Carbon::now()->toDateString())->get();

        return view('front.article-details', compact('posts'));
    }


    // public function articleDetails(Request $request ,$id)
    // {
    //     $post = Post::findOrFail($id);
    //     $posts = Post::take(6)->get();
    //      return view('front.article-details',compact('post','posts'));
    // }
    public function toggleFavourite(Request $request)
    {
        // $toggle = $request->user()->favourites()->toggle($request->post_id);
        $toggle = auth('client-web')->user()->favourites()->toggle($request->post_id);

        return responseJson(1, 'success', $toggle);
    }






    public function donationRequests()
    {
        return view('front.donation-requests');
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
            'message' => 'required',
        ];

        $messages = [
            'name.required' => 'يجب كتابة الاسم',
            'email.required' => 'يجب كتابة البريد الإلكتروني',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'phone.required' => 'يجب كتابة رقم الهاتف',
            'phone.digits' => 'رقم الهاتف غير صحيح',
            'subject.required' => 'يجب كتابة عنوان للرسالة',
            'message.required' => 'يجب كتابة موضوع للرسالة',
        ];

        $this->validate($request, $rules, $messages);

        $contact = Contact::create([


            'subject' => $request->subject,
            'message' => $request->message,
            'client_id' => $request->id
        ]);

        flash()->success('تم الارسال');

        return back();
    }
}
