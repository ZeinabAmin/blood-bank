<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
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
    public function index(Request $request)
    {


        $records = Contact::where(function ($query) use($request){
            if ($request->input('client_name'))
            {
                $query->whereHas('client',function($query) use($request){
                    $query->where('name','like','%'.$request->input('client_name').'%');
                });
            }

            // $records = Contact::WhereHas('client()->city',function($query) use($request){
            //     $query->where('name','like','%'.$request->input('city_id').'%');



        })->paginate(20);
        return view('contacts.index',compact('records'));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Contact::findOrFail($id);
        $record->delete();
        flash()->success("Deleted");
         return back();
    }
}
