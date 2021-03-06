# 项目和部署说明

## 依赖组件: 
- PHP 7.1.23 (不低于7.1.3)
- Mysql 5.7
- Nginx
- Redis
- php composer
- Laravel 5.7
- _[广告]_ 建议docker,参见 `Docker_WebServer` 项目

## 安装步骤
1. git检出项目  
2. 使用命令 composer install 来安装依赖组件。
3. 开发环境，将.env.example复制为.env，并配置内容。   
注：需要开放哪些模块，请在ALLOW_MODULE项中启用，逗号分隔。  
4. 请把storage的目录权限改为可写。 
> chmod -R 777 ./storage
5. nginx的根目录指向到项目的public下，并添加配置 
```
location / {
 try_files $uri $uri/ /index.php?$query_string;
}
``` 
6. php.ini 中需要在 disable_functions  中删除  symlink、proc_open   
7. 挂载上传目录   
> php artisan storage:link
8. 生成APP_KEY: 
> php artisan key:generate 
9. 迁移默认表:  
> php artisan migrate 
10. 安装PassPort:  
> php artisan passport:install
11. 如需要，可调用表填充:   
> 全部数据：   
> php artisan db:seed    
> 部分数据：    
> php artisan db:seed --class=***Seeder    

如果填充出现问题，可用composer dump-autoload 重置



## 继续研发和问题: 
1. 开发文档:    
部署完成以后，http://域名/docs/ 可打开『接口开发文档』
2. 返回码:    
在config/returncode.php中定义返回码，同时在lang各语言包内定义语句    
以下方法返回码值:   
> ResponseHelper::ReturnCode("UPGRADE_REQUIRED")  

以下方法返回文本:    
> ResponseHelper::ReturnInfo("UPGRADE_REQUIRED")


## 说明

![index接口](https://raw.githubusercontent.com/WiconWang/daisy_platform/master/public/readme/index.png) 
![Admin接口](https://raw.githubusercontent.com/WiconWang/daisy_platform/master/public/readme/admin.png) 

        
      
 