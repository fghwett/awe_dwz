# AWE短网址系统

[TOC]

## 更新

### 2019.4.11

1. 可添加查看数据。

## 一、安装

### 1. 上传文件到服务器或虚拟空间主目录

### 2. 上传`install` -> `awe_dwz.sql`数据库

### 3. 修改`awe-dwz` -> `common.inc.php`中相关信息

![common.inc.php](https://ws3.sinaimg.cn/large/005BYqpgly1g1z1tsfn4oj30fi03aaad.jpg)

### 4. 修改`awe-dwz` -> `index.php` 中API地址

![修改index中API地址](https://ws3.sinaimg.cn/large/005BYqpgly1g1z1xxohcij30ns0hntbv.jpg)

### 5. 修改`awe-dwz` -> `users.php` 中用户名及密码

![修改用户名及密码](https://ws3.sinaimg.cn/large/005BYqpgly1g1z2251lmcj30oh0dmdh6.jpg)

### 6. 修改`awe-loader.php`中api地址以及用户名和密码

![修改awe-loader.php](https://ws3.sinaimg.cn/large/005BYqpgly1g1z25s33ofj30s70djq5e.jpg)

### 7.配置伪静态

apache开启伪静态上传`.htaccess`即可，nginx需手动配置伪静态,以下仅供参考

```
location / {
  if (!-e $request_filename){
    rewrite ^(.*)$ /awe-loader.php/$1;
  }
}
```

> 以上配置完即可使用

## 二、使用

输入你的域名+“/awe-dwz”即可访问，输入url、appId、appKey即可添加短网址，url_id可选，但是不超过六位。

刷新列表会将数据库数据放入服务器json文件中，但是网页有缓存，所以页面数据不会立即刷新。