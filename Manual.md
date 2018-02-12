# 命令行手册
http://docs.phpcomposer.com/03-cli.html                                                                                 # composer 命令行手册
https://docs.golaravel.com/docs/5.1/artisan/                                                                            # artisan 命令行手册

# composer 命令
composer config -g repo.packagist composer https://packagist.phpcomposer.com                                            # 命令行切换 composer 源
composer install                                                                                                        # 安装 composer 组件


# artisan 教程
http://laravelacademy.org/post/1374.html

# artisan 命令行帮助
php artisan help make:controller                                                                                        # 创建控制器
php artisan help make:model

# composer 命令行创建控制器
php artisan make:controller IndexController                                                                             # restful 模式
php artisan make:controller --plain IndexController                                                                     # 无模式创建全空控制器
php artisan make:controller App\\Admin\\Http\\Controllers\\DashboardController                                          # 指定生成控制器的路径

# composer 命令行创建数据模型
php artisan make:model XXX
php artisan make:model Models\\XXX                                                                                      # 制定生成模型层路径