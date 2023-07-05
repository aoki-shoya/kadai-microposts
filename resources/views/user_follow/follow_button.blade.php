@if(Auth::id() != $user->id)
    @if(Auth::user()->is_following($user->id))
        
        <form method="POST" action="{{ route('user.unfollow',$user->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-error btn-block normal-case"
                onclick="return confirm('id = {{ $user->id }} のフォローを外してもいいですか？')">フォローを外す</button>
        </form>
        
    @else
        
        <form method="POST" action=" {{ route('user.follow',$user->id) }}">
            @csrf
            <button type="submit" class="btn btn-primary btn-block normal-case">フォロー</button>
        </form>
        
    @endif
@endif