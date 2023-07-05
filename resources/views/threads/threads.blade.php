@extends('layouts.app')

@section('content')
    <div class="w-1/2 mx-auto">
        {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
        <ul class="list-none mt-8 border-b-2">
            <li class="flex items-start gap-x-2 mb-4">
                <div class="avatar">
                    <div class="w-12 rounded">
                        <img src="{{ Gravatar::get($micropost->user->email) }}" alt="" />
                    </div>
                </div>
                <div>
                    {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                    <a class="link link-hover text-info" href="{{ route('users.show', $micropost->user->id) }}">{{ $micropost->user->name }}</a>
                    <span class="text-muted text-gray-500">posted at {{ $micropost->created_at }}</span>
                    <p class="mb-0">{!! nl2br(e($micropost->content)) !!}</p>
                </div>
            </li>
        </ul>
        
        <!--返信フォーム-->
        @include('threads.form')

        <ul class="list-none mt-4">
            @foreach ($threads as $thread)
                <li class="flex items-start gap-x-2 mb-4">
                    {{-- 投稿の所有者のメールアドレスをもとにGravatarを取得して表示 --}}
                    <div class="avatar">
                        <div class="w-12 rounded">
                            <img src="{{ Gravatar::get($thread->user->email) }}" alt="" />
                        </div>
                    </div>
                    <div>
                        <div>
                            {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                            <a class="link link-hover text-info" href="{{ route('users.show', $thread->user_id) }}">{{ $thread->user->name }}</a>
                            <span class="text-muted text-gray-500">posted at {{ $thread->created_at }}</span>
                        </div>
                        <div>
                            {{-- 投稿内容 --}}
                            <p class="mb-0">{!! nl2br(e($thread->content)) !!}</p>
                        </div>
                        <div class="flex mt-1 gap-3 items-center">
                        @if(Auth::id() == $thread->user_id)
                            <form method="POST" action="{{ route('threads.destroy',$thread->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('”{{ $thread->content }}” を削除しますか？')">
                                    <i class="fas fa-trash-alt" style="color:red"></i></button>
                            </form>
                            <a href="{{ route('threads.edit',$thread->id) }}" class="fas fa-pen" style="color:#64a1ff"></i></a>
                        @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        <a class="btn btn-block normal-case" href="{{ route('dashboard') }}">戻る</a>
    </div>
@endsection