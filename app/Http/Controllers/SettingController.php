<?php

namespace App\Http\Controllers;

use App\Models\Setting;

use Illuminate\Http\Request;

class SettingController extends Controller
{


    function __construct()
{
$this->middleware('permission:users_lists|users-create|users-edit|users-delete', ['only' => ['index','store']]);
$this->middleware('permission:users-create', ['only' => ['create','store']]);
$this->middleware('permission:users-edit', ['only' => ['edit','update']]);
$this->middleware('permission:users-delete', ['only' => ['destroy']]);
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Setting $model)
    {

        $model = Setting::first();

        return view('settings.index', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [


            'notification_settings_text'=> 'required|string',
            'about_app'=> 'required|string',
            'intro'=> 'required|string',
            'fb_link'  => 'required|url',
            'tw_link'   => 'required|url',
            'insta_link' => 'required|url',
            'youtube_link'=> 'required|url',
            'contact_us_text'=> 'required|string',
            'mobile_app_text'=> 'required|string',
        'mobile_app_android_link'  => 'required|url',
     'mobile_app_ios_link'  => 'required|url',

        ]);


        Setting::first()->update($request->all());


        flash()->success('Edited');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
