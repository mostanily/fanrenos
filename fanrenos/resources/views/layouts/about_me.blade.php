    <div class="am-u-md-4 am-u-sm-12 blog-sidebar">
        <div class="blog-sidebar-widget blog-bor">
            <h2 class="blog-text-center blog-title"><span>About ME</span></h2>
            <img src="{{asset('/images/myfaceinfo.jpg')}}" alt="about me" class="blog-entry-img" >
            <p>喵星人一枚</p>
            <p>传说中可以‘拍簧片’的男人</p>
            <p>我不想成为一个庸俗的人。十年百年后，当我们死去，质疑我们的人同样死去，后人看到的是裹足不前、原地打转的你，还是一直奔跑、走到远方的我？</p>
            <p>这些年，平凡的小半身，<a href="{{url('experience')}}" target="_blank">点我o(╯□╰)o</a></p>
        </div>
        <div class="blog-sidebar-widget blog-bor">
            <h2 class="blog-text-center blog-title"><span>Contact ME</span></h2>
            <p>
                <a href="javascript:;"><span data-am-popover="{content: 'MomentD的 QQ-3484368175' ,trigger: 'hover focus'}" class="am-icon-qq am-icon-fw am-primary blog-icon"></span></a>
                <a href="https://github.com/MomentD" target="_blank"><span data-am-popover="{content: 'MomentD的 Github' ,trigger: 'hover focus'}" class="am-icon-github am-icon-fw blog-icon"></span></a>
                <a href="javascript:;"><span class="am-icon-weibo am-icon-fw blog-icon"></span></a>
                <a href="https://gitee.com/fanrenos" target="_blank"><span data-am-popover="{content: 'MomentD的 码云' ,trigger: 'hover focus'}" class="am-icon-reddit am-icon-fw blog-icon"></span></a>
                <a href="javascript:;"><span class="am-icon-weixin am-icon-fw blog-icon"></span></a>
            </p>
        </div>
        <div class="blog-clear-margin blog-sidebar-widget blog-bor am-g ">
            <h2 class="blog-title"><span>最热文章</span></h2>
            <ul class="am-list">
                @foreach($hotArticle as $article)
                    <li style="overflow: hidden;max-height: 45px;"><a href="{{url('blog')}}/{{$article->slug}}" title="{{$article->title}}" target="_blank">{{$article->title}}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="blog-clear-margin blog-sidebar-widget blog-bor am-g ">
            <h2 class="blog-title"><span>最新文章</span></h2>
            <ul class="am-list">
                @foreach($latestArticle as $article)
                    <li style="overflow: hidden;max-height: 45px;"><a href="{{url('blog')}}/{{$article->slug}}" title="{{$article->title}}" target="_blank">{{$article->title}}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="blog-clear-margin blog-sidebar-widget blog-bor am-g ">
            <h2 class="blog-title"><span>TAG cloud</span></h2>
            <div class="am-u-sm-12 blog-clear-padding">
                @foreach($allTag as $tags)
                    <a data-am-popover="{content: '标签 {{$tags->tag}}' ,trigger: 'hover focus'}" href="{{url('/blog?tag=')}}{{urlencode($tags->tag)}}" class="blog-tag">{{$tags->tag}}</a>
                @endforeach
            </div>
        </div>
        <div class="blog-sidebar-widget blog-bor">
            <h2 class="blog-title"><span>小贴墙</span></h2>
            <ul class="am-list">
                <li><a href="#">每个人都有一个死角， 自己走不出来，别人也闯不进去。</a></li>
                <li><a href="#">我把最深沉的秘密放在那里。</a></li>
                <li><a href="#">你不懂我，我不怪你。</a></li>
                <li><a href="#">每个人都有一道伤口， 或深或浅，盖上布，以为不存在。</a></li>
            </ul>
        </div>
        <div class="blog-sidebar-widget blog-bor">
            <h2 class="blog-title"><span>友链</span></h2>
            <ul class="am-list">
                @foreach($links as $link)
                    <li><a href="{{$link->link}}">{{$link->name}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>