@extends('layouts.app')

@section('content')
    <div class="sm:grid sm:grid-cols-3 sm:gap-10">
        <aside class="mt-4">
            {{-- ユーザ情報 --}}
            @include('users.card')
        </aside>
        <div class="sm:col-span-2 mt-4">
            {{-- タブ --}}
            @include('users.navtabs')
        
            @if(Auth::user()->id == $user->id)
                <div class="mt-4 ml-4">
                    <div class="my-3">
                        <p class="text-2xl">ユーザ名</p>
                        <p class="text-3xl ml-4 font-bold font-mono">{{ $user->name}}</p>
                    </div>
                    <div class="my-3">
                        <p class="text-2xl">年齢</p>
                        <p class="text-3xl ml-4 font-bold font-mono">{{ $user->age}}</p>
                    </div>
                    <div class="my-3">
                        <p class="text-2xl">性別</p>
                        <p class="text-3xl ml-4 font-bold font-mono">{{ $user->gender}}</p>
                    </div>
                    <a class="btn btn-info w-full text-white" href="{{ route('users.edit',$user->id) }}">プロフィール変更</a>
                </div>
                @else
                <div class="mt-4 ml-4">
                    <div class="my-3">
                        <p class="text-2xl">ユーザ名</p>
                        <p class="text-3xl ml-4 font-bold font-mono">{{ $user->name}}</p>
                    </div>
                    <div class="my-3">
                        <p class="text-2xl">年齢</p>
                        <p class="text-3xl ml-4 font-bold font-mono">{{ $user->age}}</p>
                    </div>
                    <div class="my-3">
                        <p class="text-2xl">性別</p>
                        <p class="text-3xl ml-4 font-bold font-mono">{{ $user->gender}}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
<script type="text/javascript">
window.onload = function() {
    const message = "{{ $message }}";
    console.log(message);
    if(message != "") {
        alert('プロフィールを更新しました');
    }
}

</script>
@endsection