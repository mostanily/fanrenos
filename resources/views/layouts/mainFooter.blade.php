<footer class="blog-footer">
    <div class="am-g am-g-fixed blog-fixed am-u-sm-centered blog-footer-padding">
        <div class="am-u-sm-12 am-u-md-4- am-u-lg-4">
            <h3>网站简介</h3>
            <p class="am-text-sm">{!!config('blog.des')!!}</p>
        </div>
        <div class="am-u-sm-12 am-u-md-4- am-u-lg-4">
            <h3>社交账号</h3>
            <p>
                <a href=""><span class="am-icon-qq am-icon-fw am-primary blog-icon blog-icon"></span></a>
                <a href=""><span class="am-icon-github am-icon-fw blog-icon blog-icon"></span></a>
                <a href=""><span class="am-icon-weibo am-icon-fw blog-icon blog-icon"></span></a>
                <a href=""><span class="am-icon-reddit am-icon-fw blog-icon blog-icon"></span></a>
                <a href=""><span class="am-icon-weixin am-icon-fw blog-icon blog-icon"></span></a>
            </p>
            <h3>坚信</h3>
            <p>{!!config('blog.credits')!!}</p>          
        </div>
        <div class="am-u-sm-12 am-u-md-4- am-u-lg-4">
              <h1>站在巨人的肩膀上就是爽</h1>
             <h3>Heroes</h3>
            <p>
                <ul>
                    <li>Laravel</li>
                    <li>PHP</li>
                    <li>jQuery</li>
                    <li>MySql</li>
                    <li>...</li>
                </ul>
            </p>
        </div>
    </div>    
    <div class="blog-text-center">Copyright © {{ config('blog.author') }} 2017. Made with love <a href="{{url('/')}}">{{config('blog.name')}}</a></div>    
  </footer>