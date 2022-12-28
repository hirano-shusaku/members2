@extends('layouts.app')
@section('content')

<div class="card mb-4">
    <div class="card-header">
        
        <div class="text-muted small mr-3">
            <img src="{{ asset('storage/avatar/' .($post->user->avatar ?? 'user_defalut.jpg')) }}" class="rounded-circle" style="width:45px; height:40px;">
            {{ $post->user->name ?? '削除ユーザー' }}
        </div>
        <h4>{{ $post->title }}</h4>
        <div>
            @can('update',$post)
            <a href="{{route('post.edit', $post)}}"><button class="btn btn-primary">編集</button></a>
            @endcan
            @can('delete',$post)
           <form method="post" action="{{ route('post.destroy', $post) }}">
               @csrf
               @method('delete')
               <button type="submit" class="btn btn-danger" onClick="return confirm('本当に削除しますか？？O K??')">削除</button>
           </form>
           @endcan
        </div>
    </div>
    
    <div class="card-body">
        <p class="card-text">
            {!! nl2br(e($post->body)) !!}
        </p>
        @if($post->image)
        <div>（画像ファイル：{{ $post->image }}）</div>
        <img src="{{ asset('storage/images/'. $post->image) }}" style="height:300px;" >
        @endif
    </div>
    <div class="card-footer">
        <span class="mr-2 float-right">
            投稿日時：{{ $post->created_at->diffForHumans() }}
        </span>
    </div>
</div>

<hr>
@if($post->comments)
@foreach($post->comments as $comment)
<div class="card-header">
    <img src="{{ asset('storage/avatar/' .($comment->user->avatar ?? 'user_defalut.jpg')) }}" class="rounded-circle" style="width:45px; height:40px;">
    {{ $comment->user->name ?? '削除ユーザー' }}
</div>
<div class="card-body">
    {{ $comment->body }}
</div>
<div class="card-footer mb-4" >
    <span class="mr-2 float-rigth">投稿日時{{ $comment->created_at->diffForHumans() }}</span>
</div>
@endforeach
@endif

{{--バリデーションエラー--}}
@if($errors->any())
<div class="alert alert-danger">
    <u>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </u>
</div>
@endif

<div>
    <form method="post" action="{{ route('comment.store') }}">
        @csrf
        <input name="post_id" type="hidden" value="{{ $post->id }}">
        <div class="form-group">
            <textarea name="body" class="form-control" id="body" cols="30" row="5" placeholder="コメント入力してください">{{ old('body') }}</textarea>
        </div>
        <div class="form-group">
            <button class="btn btn-success float-right mb-3 mr-3">コメントする</button>
        </div>
    </form>
</div>

@endsection