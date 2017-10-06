# 凡喵/blog，个人网站

![前端预览](http://www.fanrenos.com/images/blog_home.jpg)

![后端预览](http://www.fanrenos.com/images/blog_front.jpg)

项目是用的Laravel5.3版本，前端是基于Amaze UI框架做的模板，后端是基于AdminLTE做的；本来想统一的，但是后端是从以前的项目中抽出来的，已经写好的，就懒的再去换了；而前端是最近刚看到的一个基于Amaze UI做的一个模板，挺喜欢的，就拿来用了，最终就导致前后端出现了两个不一样的风格(((;꒪ꈊ꒪;)))。

> 移动端有自适应，感觉看起来还不丑，还算看的过去！

项目中的一堆css及js文件，看看就行，实在是插件用的多了，昏乱的不行，还有一堆重复的；不过实在没办法，没法去整理，只能这样了，反正也没调用，就当不存在好了ε(┬┬﹏┬┬)3

项目中还有些模块还没弄完，等闲下来在慢慢去弄了 o(TωT)o ！

项目中参考其他项目的地方还是蛮多的，只是有的时间长了，也忘了，反正感谢每位前辈的无私奉献了！

ヽ(￣ω￣(￣ω￣〃)ゝ义气

先说下数据库的问题，我这边就没有用laravel自带的数据库迁移功能，直接打包了个sql文件，在项目根目录
database目录下的`test.sql`文件（￣︶￣）↗。

数据库数据都被我情空掉了，后端管理员账号，因为关了注册功能，所以想要登陆的，可以找到`app\Http\Controllers\Admin\Auth\AuthController`文件，里面有个被我注释掉的注册方法，取消注释，再添加个注册路由，就可以注册成功了。或者你用前端注册功能，注册一个账号，然后把账号信息复制到数据库admins表中也行(^し^)。

目前存在的问题，后端的 分类管理及文件管理 因为还没想好怎么弄，所以这两个模块还没开发。

###更新

相册模块完成（进行页面添加或通过ftp上传并更新时，尽量别一次性操作太多文件）。（2017-10-6）

更新下音乐模块部分

[网页音乐播放教程之getid3类音频解析](http://www.fanrenos.com/blog/wang-ye-yin-le-bo-fang-jiao-cheng-zhi-getid3-lei-yin-pin-jie-xi)。

[网页音乐播放教程之获取指定音频文件](http://www.fanrenos.com/blog/wang-ye-yin-le-bo-fang-jiao-cheng-zhi-huo-qu-zhi-ding-yin-pin-wen-jian)

[网页音乐播放教程之音频文件批量处理](http://www.fanrenos.com/blog/wang-ye-yin-le-bo-fang-jiao-cheng-zhi-yin-pin-wen-jian-pi-liang-chu-li)

## License

[MIT license](http://opensource.org/licenses/MIT).
