@extends('layouts.app')

@section('content')

    <div class="prose mx-auto text-center">
        <h2>アカウント作成</h2>
    </div>

    <div class="flex justify-center">
        <form method="POST" action="{{ route('register') }}" class="w-1/2">
            @csrf

            <div class="form-control my-3">
                <label for="name" class="label">
                    <span class="label-text">名前</span>
                </label>
                <input type="text" name="name" class="input input-bordered w-full">
            </div>

            <div class="form-control my-3">
                <label for="email" class="label">
                    <span class="label-text">メールアドレス</span>
                </label>
                <input type="email" name="email" class="input input-bordered w-full">
            </div>
            
            <div class="form-control my-3">
                <label class="label">
                    <span class="label-text">性別</span>
                </label>
                <div class="flex">
                    <div class="flex">
                        <input type="radio" name="gender" id="male" value="男性" class="ml-2 cursor-pointer">
                        <label for="male" class="ml-2 mr-2 cursor-pointer">男性</label>
                    </div>
                    <div class="flex">
                        <input type="radio" name="gender" id="female" value="女性" class="cursor-pointer">
                        <label for="female" class="ml-2 mr-2 cursor-pointer">女性</label>
                    </div>
                    <div class="flex">
                        <input type="radio" name="gender" id="oters" value="その他" class="cursor-pointer" checked>
                        <label for="oters" class="ml-2 cursor-pointer">その他</label>
                    </div>
                </div>
            </div>
            
            <div class="form-control my-3">
                <label for="age" class="label">
                    <span class="label-text">年齢</span>
                </label>
                <input type="number" name="age" class="input input-bordered w-full">
            </div>

            <div class="form-control my-3">
                <label for="password" class="label">
                    <span class="label-text">パスワード</span>
                </label>
                <input type="password" name="password" class="input input-bordered w-full">
            </div>

            <div class="form-control my-3">
                <label for="password_confirmation" class="label">
                    <span class="label-text">パスワード確認</span>
                </label>
                <input type="password" name="password_confirmation" class="input input-bordered w-full">
            </div>

            <button type="submit" class="btn btn-primary btn-block normal-case mt-6">新規登録</button>
        </form>
    </div>
@endsection