<?php
	//公共文件

	//设置时区为中国
	date_default_timezone_set('PRC');

	//防止恶意调用
	if(!defined('awe-dwz')) {
		exit('Access Denied!');
	}

	//设置字符集编码
	header('Content-Type:text/html;charset=utf-8');

	//转换成硬路径，速度更快
	// define("ROOT_PATH",substr(dirname(__FILE__),0,-8));
	define("ROOT_PATH",dirname(__FILE__).'/');

	//创建一个自动转义状态的常量
	define('GPC',get_magic_quotes_gpc());

	//拒绝PHP低版本
	if(PHP_VERSION<'5.2.0') {
		exit("PHP is to low.");
	}

	//引入函数库
	require ROOT_PATH.'mysqli.func.php';
	//引入用户库
	require ROOT_PATH.'users.php';


	//数据库连接
	define('DB_HOST','127.0.0.1:3306');
	define('DB_USER','dwz_fghwett_com');
	define('DB_PWD','dwz_fghwett_com');
	define('DB_NAME','dwz_fghwett_com');
	define('AWE_DOMAIN','http://dwz.fghwett.com/');
	
	//初始化数据库
	_connect();
	//_select_db();
	_set_names();


?>