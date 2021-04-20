永红源用户微服务
================

相关配置
--------
1.  redis配置<br>
        配置在src/.env文件，内容如下：

        ; redis配置
		CACHE_DRIVER=redis
		REDIS_HOST=127.0.0.1
		REDIS_PORT=8379
		REDIS_DATABASE=8
		REDIS_PASSWORD=Pm8GojHk
        
2.  mysql配置<br>
        * 数据库结构sql文件放在src/deploy/yhy_user.sql
        * 配置在src/.env文件，内容如下： 

        ; 默认数据库配置
		DB_HOST=127.0.0.1
		DB_PORT=3306
		DB_DATABASE=yhy_user
		DB_USERNAME=root
		DB_PASSWORD=6R.2%4=3q.n#2#3j
		DB_TIMEZONE=+08:00


