# 安装说明
1.配置数据库
````
打开.env文件，配置下面类容
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=brotherblog
DB_USERNAME=root
DB_PASSWORD=root

````
2.数据迁移
````
php artisan migrate
````
3.数据填充
```
php artisan db:seed
```