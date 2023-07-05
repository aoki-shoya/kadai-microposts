@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
            @if(Auth::user()->id == $micropost->user_id)
            <form method="POST" action="{{ route('microposts.update', $micropost->id) }}" class="w-1/2">
                @csrf
                @method('PUT')
                <div class="mt-4">
                    <div class="form-control my-3">
                    <label for="name" class="label">
                        <span class="label-text">投稿内容</span>
                    </label>
                    <input type="text" name="content" class="input input-bordered w-full" value="{{ $micropost->content }}">
                </div>
                <div class="form-control">
                    <div class="flex mt-6 justify-around">
                        <a class="btn btn-block normal-case w-5/12" href="{{ route('users.show',Auth::user()->id) }}">戻る</a>
                        <button type="submit" class="btn btn-info btn-block text-white w-5/12"
                            onclick="return confirm('投稿内容を更新しますか？')">投稿更新</button>
                    </div>
                </div>
            @else
                return back();
            @endif
        </div>
@endsection

