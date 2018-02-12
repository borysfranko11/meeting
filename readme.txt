---------------会议采购管理系统-----------

1、该项目采用H+模板系统，代码冗余较多，但因为已经开发了一段时间再换时间成本较高。
2、所采用的iframe嵌套方式，控制页面的跳转，有一定的弊端；
3、没有原型图与ui图，交互逻辑基本靠猜。
4、文档没有，新手接入较为麻烦；

--------------关于会议采购系统的一些简要说明（主要是一些页面对应模块的说明）-------------

1、页面资源都在 resources-->views 文件夹下，静态资源在 public-->assets 文件夹下；
2、views-->master-->main.blade.php 是页面整体的模块组装，类似于 index;
3、views-->master-->navs.blade.php 是页面的左侧模块，类似于 left;
4、views-->master-->content.blade.php 是页面右侧内容;主要分为上中下三块；
5、views-->index-->index.blade.php 是iframe(iframe在content的下部)里面放的内容，目前只有一个跳转路径；
6、views-->dashboard-->index.blade.php 是页面首页的内容；
7、views-->user-->index.blade.php 是权限管理模块下的用户管理内容；
8、views-->logs-->index.blade.php 是日志管理模块下的日志列表；
9、views-->rpf-->index.blade.php 是我的询单模块下的主页内容；
