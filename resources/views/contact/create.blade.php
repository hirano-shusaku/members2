@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-10 col-md-8 col-lg-6 mx-auto mt-6">
        <div class="card-body">
            <h1 class="mt-4 mb-3">お問合せ</h1>
            <form method="post" action="{{ route('contact.store') }}">
                @csrf
                <div class="form-group">
                    <label for="title">件名</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{old('title')}}" placeholder="件名を入力">
                </div>
                
                <div class="form-group">
                    <label for="body">本文</label>
                    <textarea name="body" class="form-control" id="body" cols="30" rows="10">{{ old('body') }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input name="email" type="email" class="form-control" id="email" value="{{ old('emai') }}" placeholder="メールアドレスを入力">
                </div>
                
                <button type="submit" class="btn btn-success">送信する</button>
                <a type="submit" class="btn brn-success">送信する</a>
            </form>
        </div>
    </div>
</div>


@endsection