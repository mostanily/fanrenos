<?php
return [
    [
        'TitleNav' => '面板',//一级菜单名称
        'model' => 'home',//当前菜单的模板（属于哪一块模块下，如文件、文章等等）
        'route' => 'dashboard.home',//路由
        'route_alias' => 'dashboard/home',//实际路由
        'isActive' => false,//用于判断是否具有active状态
        'icon' => 'fa-dashboard',//一级菜单的图标
        'subTitleNav' => []//二级菜单内容
    ],
    [
        'TitleNav' => '站长经历',
        'model' => 'experience',
        'route' => '',
        'isActive' => false,
        'icon' => 'fa-film',
        'subTitleNav' => [
            [
                'name' => '经历列表',//二级菜单的名称
                'route' => 'dashboard.experience.index',//对应点路由
                'route_alias' => 'dashboard/experience/index',
                'isActive' => false,//用于判断是否具有active状态
            ],
            [
                'name' => '添加经历',
                'route' => 'dashboard.experience.create',
                'route_alias' => 'dashboard/experience/create',
                'isActive' => false,
            ],
        ],
    ],
    [
        'TitleNav' => '用户管理',
        'model' => 'user',
        'route' => '',
        'isActive' => false,
        'icon' => 'fa-users',
        'subTitleNav' => [
            [
                'name' => '用户列表',//二级菜单的名称
                'route' => 'dashboard.user.index',//对应点路由
                'route_alias' => 'dashboard/user/index',
                'isActive' => false,//用于判断是否具有active状态
            ],
            [
                'name' => '添加用户',
                'route' => 'dashboard.user.create',
                'route_alias' => 'dashboard/user/create',
                'isActive' => false,
            ],
        ],
    ],
    [
        'TitleNav' => '文章管理',
        'model' => 'article',
        'route' => '',
        'isActive' => false,
        'icon' => 'fa-book',
        'subTitleNav' => [
            [
                'name' => '文章列表',
                'route' => 'dashboard.article.index',
                'route_alias' => 'dashboard/article/index',
                'isActive' => false,
            ],
            [
                'name' => '添加文章',
                'route' => 'dashboard.article.create',
                'route_alias' => 'dashboard/article/create',
                'isActive' => false,
            ],
        ],
    ],
    [
        'TitleNav' => '评论管理',
        'model' => 'comment',
        'route' => '',
        'isActive' => false,
        'icon' => 'fa-comment',
        'subTitleNav' => [
            [
                'name' => '评论列表',
                'route' => 'dashboard.comment.index',
                'route_alias' => 'dashboard/comment/index',
                'isActive' => false,
            ],
        ],
    ],
    [
        'TitleNav' => '文件管理',
        'model' => 'file',
        'route' => '',
        'isActive' => false,
        'icon' => 'fa-file',
        'subTitleNav' => [
            [
                'name' => '文件列表',
                'route' => 'dashboard.file.index',
                'route_alias' => 'dashboard/file/index',
                'isActive' => false,
            ],
        ],
    ],
    [
        'TitleNav' => '标签管理',
        'model' => 'tag',
        'route' => '',
        'isActive' => false,
        'icon' => 'fa-tags',
        'subTitleNav' => [
            [
                'name' => '标签列表',
                'route' => 'dashboard.tag.index',
                'route_alias' => 'dashboard/tag/index',
                'isActive' => false,
            ],
            [
                'name' => '添加标签',
                'route' => 'dashboard.tag.create',
                'route_alias' => 'dashboard/tag/create',
                'isActive' => false,
            ],
        ],
    ],
    [
        'TitleNav' => '分类管理',
        'model' => 'category',
        'route' => '',
        'isActive' => false,
        'icon' => 'fa-list',
        'subTitleNav' => [
            [
                'name' => '分类列表',
                'route' => 'dashboard.category.index',
                'route_alias' => 'dashboard/category/index',
                'isActive' => false,
            ],
            [
                'name' => '添加分类',
                'route' => 'dashboard.category.create',
                'route_alias' => 'dashboard/category/create',
                'isActive' => false,
            ],
        ],
    ],
    [
        'TitleNav' => '音乐管理',
        'model' => 'music',
        'route' => '',
        'isActive' => false,
        'icon' => 'fa-music',
        'subTitleNav' => [
            [
                'name' => '音乐列表',
                'route' => 'dashboard.music.index',
                'route_alias' => 'dashboard/music/index',
                'isActive' => false,
            ],
        ],
    ],
    [
        'TitleNav' => '相册管理',
        'model' => 'album',
        'route' => '',
        'isActive' => false,
        'icon' => 'fa-picture-o',
        'subTitleNav' => [
            [
                'name' => '相册列表',
                'route' => 'dashboard.album.index',
                'route_alias' => 'dashboard/album/index',
                'isActive' => false,
            ],
        ],
    ],
    [
        'TitleNav' => '友链管理',
        'model' => 'link',
        'route' => '',
        'isActive' => false,
        'icon' => 'fa-link',
        'subTitleNav' => [
            [
                'name' => '友链列表',
                'route' => 'dashboard.link.index',
                'route_alias' => 'dashboard/link/index',
                'isActive' => false,
            ],
            [
                'name' => '添加友链',
                'route' => 'dashboard.link.create',
                'route_alias' => 'dashboard/link/create',
                'isActive' => false,
            ],
        ],
    ],
    [
        'TitleNav' => '系统配置',
        'model' => 'system',
        'route' => 'dashboard.system',
        'route_alias' => 'dashboard/system',
        'isActive' => false,
        'icon' => 'fa-cog',
        'subTitleNav' => [],
    ],

];