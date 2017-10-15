<ul class="am-comments-list am-comments-list-flip">
    @forelse($comments as $comment)
        <li class="list-group-item">
            @if($comment->commentable_type == 'articles')
                <a href="{{ url('blog/'.$comment->article->slug) }}" target="_blank">{{ $comment->article->title }}</a>
            @else
                <a href="{{ url('discussion', ['id' => $comment->commentable_id]) }}" target="_blank">{{ $comment->article->title }}</a>
            @endif
            <span class="meta">
                in <span class="timeago">{{ $comment->created_at->diffForHumans() }}</span>
            </span>
            <div class="comment_content">
                <p>{!! json_decode($comment->content)->html !!}</p>
            </div>
        </li>
    @empty
        <li class="nothing">{{ lang('Nothing') }}</li>
    @endforelse
</ul>