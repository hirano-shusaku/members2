@extends('layouts.app')
@section('content')

@if(session('message'))
<div class="alert alert-success">{{session('message')}}</div>
@endif

{{$user->name}}さん、ようこそ。<br>
{{$user->name}}さんのIDは{{$user->id}}です。

@if(count($comments) == 0)<br>
    <h3><span class="badge badge-danger">
        まだ{{$user->name}}さんはまだコメントしてません
    </span></h3>
@else
{{$user->name}}さんのコメントしてた投稿です。

@foreach($comments->unique('post_id') as $comment)
<div class="container-fluid mt-20" style="margin-left:-10px;">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="media flex-wrap w-100 align-items-center">
                        <img src="{{ asset('storage/avatar/'.($comment->user->avatar ?? 'user_default.jpg')) }}" class="rounded-circle" style="width:45px; height:40px;">
                        <div class="media-body ml-3"> 
                        <a href="{{ route('post.show', $comment->post) }}">{{$comment->post->title}}</a>
                            <div class="text-muted small">{{ $comment->post->user->name ?? '削除されユーザー'  }}</div>
                        </div>
                        <a href="{{ route('post.show',$comment->post) }}" class="btn btn-success">投稿確認</a>
                        <div class="text-muted small ml-3">
                            <div>投稿日</div>
                            <div><strong>{{ $comment->post->created_at->diffForHumans() }}</strong> </div>
                        </div>
                    </div>
                </div>
                
                @php
                $post = $comment->post;
                @endphp
                
                <div class="card-body">
                    <p>{{ Str::limit($post->body,100,'......') }}</p>
                </div>
                
                @if($post->image)
                <div class="thubnail col-lg-2 col-md-1">
		            <a href="{{ asset('storage/images/'.$post->image) }}" class="thumbnail" target="_blank">
			            <img src="{{ asset('storage/images/'.$post->image) }}" style="width:100px; ,height:100px;">
		            </a>
	            </div>
                @endif
                
                <div class="card-footer d-flex flex-wrap justify-content-between align-items-center px-0 pt-0 pb-3">
                    <div class="px-4 pt-3">
                        @if($post->comments->count())
                        <span class="badge badge-success">
                            返信{{ $post->comments->count() }}件
                        </span>
                        @else
                        <span class="badge badge-primary">
                            まだコメントはありません
                        </span>
                        @endif
                    </div>
                    <div class="px-4 pt-3">
                        <button type="button" class="btn btn-primary"><a href="{{ route('post.show', $post) }}"style="color:white">コメントする</a></button>
                        <a class="btn btn-danger" href="{{ route('post.show', $post->id) }}">コメントする</a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
@endsection