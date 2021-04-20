# 前端密码校验算法 #


前缀
   
     var prefix='app_id_'
用户名
     
     var username

  用户输入密码

     var password

  登录密码

    login_password = md5(prefix+username+password)



# 后端密码校验算法 #
 
盐值，从配置文件中获取

    $salt
 
前端传入注册密码

    $register_password
 
入库密码

    $member_password = password_hash(md5($salt.$register_password)

前端传入登录密码

    $login_password
 
密码校验

    $check_password_status = password_verify (md5($salt.$login_password),$member_password)