@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
            @if(Auth::user()->id == $user->id)
            <form method="POST" action="{{ route('users.update', $user->id) }}" class="w-1/2">
                @csrf
                @method('PUT')
                <div class="mt-4">
                    <div class="form-control my-3">
                    <label for="name" class="label">
                        <span class="label-text">名前</span>
                    </label>
                    <input type="text" name="name" class="input input-bordered w-full" value="{{ $user->name }}">
                </div>
                
                <div class="form-control my-3">
                    <label class="label">
                        <span class="label-text">性別</span>
                    </label>
                    <div class="flex">
                        <div class="flex">
                            <input type="radio" name="gender" id="male" value="男性" @if(old('gender', $user->gender) == '男性') checked @endif class="ml-2 cursor-pointer">
                            <label for="male" class="ml-2 mr-2 cursor-pointer">男性</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="gender" id="female" value="女性" @if(old('gender', $user->gender) == '女性') checked @endif class="cursor-pointer">
                            <label for="female" class="ml-2 mr-2 cursor-pointer">女性</label>
                        </div>
                        <div class="flex">
                            <input type="radio" name="gender" id="oters" value="その他" @if(old('gender', $user->gender) == 'その他') checked @endif class="cursor-pointer">
                            <label for="oters" class="ml-2 cursor-pointer">その他</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-control my-3">
                    <label for="age" class="label">
                        <span class="label-text">年齢</span>
                    </label>
                    <input type="number" name="age" value="{{ $user->age }}" class="input input-bordered w-full">
                </div>
                <div class="form-control">
                    <div class="flex mt-6 justify-around">
                        <a class="btn btn-block normal-case w-5/12" href="{{ route('users.profile',$user->id) }}">戻る</a>
                        <button type="submit" class="btn btn-info btn-block text-white w-5/12"
                            onclick="return confirm('プロフィールを更新しますか？')">プロフィール更新</button>
                    </div>
                </div>
            @else
                return back();
            @endif
        </div>
@endsection

