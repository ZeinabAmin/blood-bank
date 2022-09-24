<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:categories-list|categories-create|categories-edit|categories-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:categories-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:categories-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:categories-delete', ['only' => ['destroy']]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $records = Category::paginate(10);
        return view('categories.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required'
        ];
        $messages = [
            'name.required' => 'Name is required'
        ];
        $this->validate($request, $rules, $messages);
        /*$record = new Category;
        $record->name = $request->input('name');
        $record->save();*/
        $record = Category::create($request->all());
        flash()->success('success');
        return redirect(route('categories.index'));
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
        $model = Category::findOrFail($id);
        return view('categories.edit', compact('model'));
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
        //         $rules = [
        //             'name' => 'required'
        //    ];
        //    $message = [
        //              'name.required' => 'Name is required'
        //    ];
        //    $this->validate($request,$rules,$message);
        $record = Category::findOrFail($id);
        $record->update($request->all());
        flash()->success('success');
        return redirect(route('categories.index', $record->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Category::findOrFail($id);
        if ($record->posts()->count()) {
            flash()->error("cant delete,this category has posts");
            return back();
        }
        $record->delete();
        flash()->success("Deleted");
        return back();
    }
}
