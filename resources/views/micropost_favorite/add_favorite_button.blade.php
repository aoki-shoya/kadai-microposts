@if(Auth::user()->is_favoritings($micropost->id))
    
    {{-- お気に入りを外すボタンのフォーム --}}
    <form method="POST" action="{{ route('favorite.unfavorite',$micropost->id) }}">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('id = {{ $micropost->id }}のお気に入りを外していいですか？')">
            <i class="fas fa-heart" style="color:pink"></i></button>
    </form>

@else
    
    {{-- お気に入りボタンのフォーム --}}
    <form method="POST" action="{{ route('favorite.favorite',$micropost->id) }}">
        @csrf
        <button type="submit"><i class="far fa-heart" style="color:pink"></i></button>
    </form>
    
@endif
