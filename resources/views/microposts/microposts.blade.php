<div class="mt-4">
    @if (isset($microposts))
        <ul class="list-none">
            @foreach ($microposts as $micropost)
                <li class="flex items-start gap-x-2 mb-4">
                    {{-- 投稿の所有者のメールアドレスをもとにGravatarを取得して表示 --}}
                    <div class="avatar">
                        <div class="w-12 rounded">
                            <img src="{{ Gravatar::get($micropost->user->email) }}" alt="" />
                        </div>
                    </div>
                    <div>
                        <div>
                            {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                            <a class="link link-hover text-info" href="{{ route('users.show', $micropost->user->id) }}">{{ $micropost->user->name }}</a>
                            <span class="text-muted text-gray-500">posted at {{ $micropost->created_at }}</span>
                        </div>
                        <div class="flex">
                            {{-- 投稿内容 --}}
                            <p class="mb-0">{!! nl2br(e($micropost->content)) !!}</p>
                        </div>
                        <div>
                            <div class="flex mt-1 gap-3 items-center">
                                <button onclick="location.href='{{ route('threads',$micropost->id) }}'" class="bg-blue-400 hover:bg-blue-300 text-white rounded px-2 py-1 text-xs">リプライ</button>
                                {{-- $micropost->threads_count() --}}
                                @if(Auth::id() == $micropost->user_id)
                                    <form method="POST" action="{{ route('microposts.destroy',$micropost->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('”{{ $micropost->content }}” を削除しますか？')">
                                            <i class="fas fa-trash-alt" style="color:red"></i></button>
                                    </form>
                                    {{-- 編集ボタンのフォーム --}}
                                    <a href="{{ route('microposts.edit',$micropost->id) }}" class="fas fa-pen" style="color:#64a1ff"></i></a>
                                    @include('micropost_favorite.add_favorite_button')
                                @else 
                                    @include('micropost_favorite.add_favorite_button')
                                @endif
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        {{-- ページネーションのリンク --}}
        {{ $microposts->links() }}
    @endif
</div>