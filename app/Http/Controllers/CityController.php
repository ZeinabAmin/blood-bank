<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
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



    public function index()
    {
        $records = City::paginate(20);
        return view('cities.index', compact('records'));
        //   return view('cities.index')->with('records');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());


        $rules = [
        'name' => 'required'
    ];
        $messages = [
        'name.required' => 'Name is required',
    ];
        $this->validate($request, $rules, $messages);

//        $record = new City;
//        $record->name = $request->input('name');
//        $record->save();

        $record = City::create($request->all());

        flash()->success("success");
        return redirect(route('cities.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = City::findOrFail($id);
        return view('cities.edit', compact('model'));
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
        $record = City::findOrFail($id);
        $record->update($request->all());
        flash()->success("Edited");
        return redirect(route('cities.index', $record->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = City::findOrFail($id);

if ($record->donationRequests()->count()) {
    flash()->error("cant delete,this city has donation requests");
    return back();
}
            $record->delete();
            flash()->success("Deleted");
            return back();

    }
}
