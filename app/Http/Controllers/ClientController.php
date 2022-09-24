<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
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
        $records = Client::where(function ($query) use($request){
            if ($request->input('keyword')) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%'.$request->keyword.'%');
                    $query->orWhere('phone', 'like', '%'.$request->keyword.'%');
                    $query->orWhere('email', 'like', '%'.$request->keyword.'%');
                    $query->orWhereHas('city',function($query) use($request){
                        $query->where('name','like','%'.$request->input('city_id').'%');
                    });
                });
            }

    if ($request->input('blood_type_id'))
    {
        $query->where('blood_type_id',$request->blood_type_id);
    }




        })->paginate(20);

return view('clients.index', compact('records'));

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

        $record = Client::findOrFail($id);
        if($record->donationRequest()->count() || $record->contact()->count() ){
       flash()->error("cant delete , this client has donation request or contact");
          return back();
        }
       $record->delete();
       flash()->success("Deleted");
        return back();

    }




    public function activate($id)
    {


        $client = Client::findOrFail($id);
        $client->update(['is_active' => 1]);
        flash()->success('activate');
        return back();
    }




    public function deactivate($id)
    {
        $client = Client::findOrFail($id);
        $client->update(['is_active' => 0]);
        flash()->success('deactivate');
        return back();
    }



}
