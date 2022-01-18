<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use InterventionImage;
use Illuminate\Support\facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title'=>'required |max:255',
            'body' =>'required |max:255',
            'image'=>'image |max:3072',
            ]);
        
        $post = new post();
        $post->title = $validate['title'];
        $post->body = $validate['body'];
        $post->user_id = auth()->user()->id;
        
        // if($request('image'))
        // {
        //     $original = $request()->file('image')->getClientOriginalName();
        //     $name = date('ymd_His').'_'. $original;
        //     request()->file('image')->move('storage/images' , $name);
        //     $post->image = $name;
        // }
        
        $imageFile = $request->image;
        if(request('image'))
        {
            $uniqname = uniqid(rand().'_'); //ランダムでユニークな名前を作成
            $extention = $imageFile->extension(); //拡張子を取得
            $NameToStore = $uniqname.'.'.$extention; //名前と拡張子をつけたファイル名作成
            $resizeFile = InterventionImage::make($imageFile)->fit(500,400,null,'center')->encode(); //リサイズした画像を作成
            Storage::put('public/images/'. $NameToStore , $resizeFile); //DBにファイルを保存
            $post->image = $NameToStore; //laravelにファイル名を保存
        }
        
        $post->save();
        
        return back()->with('message','投稿が保存されました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //policy適用
        $this->authorize('update', $post);
        
        return view('post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //policy適用
        $this->authorize('update',$post);
        
        $validate = $request->validate([
            'title'=>'required |max:255',
            'body' =>'required |max:255',
            'image'=>'image |max:3072',
            ]);
        
        $post->title = $validate['title'];
        $post->body = $validate['body'];
        $post->user_id = auth()->user()->id;
        
        $imageFile = $request->image;
        if(request('image'))
        {
            $uniqname = uniqid(rand().'_'); //ランダムでユニークな名前を作成
            $extention = $imageFile->extension(); //拡張子を取得
            $NameToStore = $uniqname.'.'.$extention; //名前と拡張子をつけたファイル名作成
            $resizeFile = InterventionImage::make($imageFile)->fit(500,400,null,'center')->encode(); //リサイズした画像を作成
            Storage::put('public/images/'. $NameToStore , $resizeFile); //DBにファイルを保存
            $post->image = $NameToStore; //laravelにファイル名を保存
        }
        
        $post->save();
        
        return back()->with('message','投稿が更新されました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //policy適用
        $this->authorize('delete',$post);
        
        $post->comments()->delete();
        
        Storage::delete('public/images/'.$post->image);
        
        $post->delete();
        return redirect()->route('home')->with('message', '投稿を削除しました');
    }
}
