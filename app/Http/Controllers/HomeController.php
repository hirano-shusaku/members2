<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->get();
        $user = auth()->user();
        
        return view('home',compact('posts','user'));
    }
    
    public function mypost()
    {
        $userId = auth()->user()->id;
        $user = auth()->user();
        $posts = Post::where('user_id',$userId)->orderBy('created_at','desc')->get();
        
        return view ('mypost',compact('posts','user'));
    }
    
    public function mycomment()
    {
        $user = auth()->user();
        $userId = auth()->user()->id;
        $comments = Comment::where('user_id',$userId)->orderBy('created_at','desc')->get();
        
        return view('mycomment',compact('comments','user'));
    }
}
