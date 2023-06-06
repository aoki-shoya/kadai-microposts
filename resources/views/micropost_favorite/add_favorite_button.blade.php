    @if(Auth::user()->is_favoritings($micropost->id))
        
        {{-- お気に入りを外すボタンのフォーム --}}
        <form method="POST" action="{{ route('favorite.unfavorite',$micropost->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-gray-400 hover:bg-gray-300 text-white rounded px-4 py-2"
                onclick="return confirm('id = {{ $micropost->id }}のお気に入りを外していいですか？')">UnFavorite</button>
        </form>
    
    @else
        
        {{-- お気に入りボタンのフォーム --}}
        <form method="POST" action="{{ route('favorite.favorite',$micropost->id) }}">
            @csrf
            <button type="submit" class="bg-green-500 hover:bg-green-400 text-white rounded px-4 py-2">Favorite</button>
        </form>
        
    @endif
