<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
//use File;


class PostController extends Controller
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
        $records = Post::paginate(20);
        return view('posts.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->toArray();
        return view('posts.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


      //  dd($request->all());
        $rules = [
            'title' => 'required',
             'content' => 'required',
             'image'=> 'required|mimes:jpeg,png,jpg,gif,svg',
             'category_id' => 'required',
        ];
            $messages = [
                'title.required' => 'Title is required',
                'content.required' => 'Content is required',
                'image.required' => 'Image is required',
                'image.mimes' => 'must be image',
                 'category_id.required' => 'category_id is required',

        ];
            $this->validate($request, $rules, $messages);

            $record = Post::create($request->all());


if ($request->hasFile('image')) {
    $image =$request->file('image');
    $filename = time() . '.' . $image->getClientOriginalExtension();
    Image::make($image)->resize(300, 300)->save( public_path('uploads/images/posts/' . $filename ) );
    $record->image = $filename;
    $record->save();

}

            flash()->success("success");
            return redirect(route('posts.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model =Post::findOrFail($id);
        return view('posts.edit',compact('model'));
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



        $rules = [
            'title' => 'required',
             'content' => 'required',
             'image'=> 'required|mimes:jpeg,png,jpg,gif,svg',
             'category_id' => 'required',
        ];
            $messages = [
                'title.required' => 'Title is required',
                'content.required' => 'Content is required',
                'image.required' => 'Image is required',
                'image.mimes' => 'must be image',
                 'category_id.required' => 'category_id is required',



        ];
            $this->validate($request, $rules, $messages);



         $record = Post::findOrFail($id);
         $record->update($request->all());

if ($request->hasFile('image')) {
    $image =$request->file('image');
    $filename = time() . '.' . $image->getClientOriginalExtension();
    Image::make($image)->resize(300, 300)->save( public_path('uploads/images/posts/' . $filename ) );
    $record->image = $filename;
    $record->save();

}

        flash()->success("Edited");
        return redirect(route('posts.index',$record->id));


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Post::findOrFail($id);

       File::delete(public_path('uploads/images/posts/' .$record->image ));

    //    if(file_exists(public_path($record->image))){
    //     unlink(public_path($record->image));
    //     }

        $record->delete();
        flash()->success("Deleted");
         return back();
    }
}












