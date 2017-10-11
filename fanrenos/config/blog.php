<?php
return [
    'name' => "不惹人嫌的废喵",
    'title' => "凡喵",
    'subtitle' => 'http://fanrenos.com',
    'description' => '凡人境喵喵欣赏交流资源学区，专爱PHP，会思念人的喵',
    'keywords' => 'Laravel，Mostanily，博客，Blog，喜欢喵星人，PHP，个人分享，古典，IT民工',
    'author' => 'Mostanily',
    'page_image' => 'home-bg.jpg',
    'index_banner_def_image' => 'b1.jpg',
    'index_post_def_image' => 'no_default.jpg',
    'music_def_logo' => 'def_music.png',
    'posts_per_page' => 20,
    'cache_time' => [
        'default' => 60,
        'extra' => 30,
    ],//页面缓存时间，单位，分钟
    'uploads' => [
        'storage' => 'local',
        'webpath' => '/uploads',
    ],
    'base_size_path'   => '/home/mostanily/public_html/uploads/',
    'contact_email' => '229885381@qq.com',
    'des' => '这是一个注定不会更新频繁的个人小站o(╥﹏╥)o。<br><br>博客这些太高大上了，不晓得能玩上多久╮(╯▽╰)╭； <br><br> 想啥写啥，想放啥就放啥，说不定还会写小说o(╯□╰)o；<br><br>嗯嗯，不知道说啥，外面的世界真精彩ヾ(@^▽^@)ノ；<br><br>字数凑的差不多了\(^o^)/。',

    'credits' => '“何为缘？”；<br>“青山，绿水，月升潮起”；<br>“可否具体？”；<br>“在天，在地，比翼连理”；<br>“可否再具体？”；<br>“不期而遇。”',
    //敏感词文件路径
    'mgc' => storage_path('app/public').'/mgck',
    'mgc_txt' => [
        '/key.txt',
        '/key1.txt',
        '/key2.txt',
        '/key3.txt',
        '/key4.txt',
        '/key5.txt',
        '/key6.txt',
        '/key7.txt',
        '/key8.txt',
        '/key9.txt',
        '/seqing.txt',
    ],
];