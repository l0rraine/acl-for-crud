# Qla\DepCRUD
Qla crud里的单位编辑模块，需要 laravel 5.x。

## 安装

```
composer require qla/depcrud
php artisan vendor:publish
select the Provider and tag with qla
```

## 使用

1. 首先`php artisan migrate`
2. 在config/qla/base.php中可以配置后台路由前缀
3. 可以在网站里直接调用`route('Crud.Dep.index')`

