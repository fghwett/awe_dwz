<?php
	//防止恶意调用
	if(!defined('awe-dwz')) {
		exit('Access Denied!');
	}
	
	/**
	*_connect() 连接mysql数据库
	*@access public
	*@return void
	*/
	function _connect(){
		//global表示全局变量，意图是此变量可以在函数外可以访问
		global $_conn;
		if(!($_conn = @mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME))){
			exit("数据库连接失败");
		}
	}

	/**
	*_select_db() 选择一款指定数据库
	*@access public
	*@return void
	*/
	function _select_db(){
		//global表示全局变量，意图是此变量可以在函数外可以访问
		global $_conn;
		if(!@mysqli_select_db($_conn,DB_NAME)){
			exit("找不到指定数据库");
		}
	}

	/**
	*_set_names() 设置字符集
	*@access public
	*@return void
	*/
	function _set_names(){
		//global表示全局变量，意图是此变量可以在函数外可以访问
		global $_conn;
		if(!@mysqli_query($_conn,"SET NAMES UTF8")){
			exit("字符集设置错误");
		}
	}

	function _query($_sqli){
		//global表示全局变量，意图是此变量可以在函数外可以访问
		global $_conn;
		if(!$_result = mysqli_query($_conn,$_sqli)){
			global $_conn;
			exit("sql执行失败".mysqli_error($_conn));
		}
		return $_result;
	}

	/**
	*_fetch_array 只能获取数据组
	*
	*/

	function _fetch_array($_sqli){
		//global表示全局变量，意图是此变量可以在函数外可以访问
		global $_conn;
		return mysqli_fetch_array(_query($_sqli),MYSQLI_ASSOC);
	}

	/**
	*_fetch_array_list 可以返回指定数据集的所有数据
	*
	*/

	function _fetch_array_list($_result) {
		return mysqli_fetch_array($_result,MYSQLI_ASSOC);
	}

	/**
	*_num_rows 获取记录的总条数
	*
	*/

	function _num_rows($_result) {
		return mysqli_num_rows($_result);
	}

	/**
	*_real_escape_string 转义字符
	*
	*/
	function _real_escape_string($_string) {
		global $_conn;
		return mysqli_real_escape_string($_conn,$_string);
	}

	/**
	*_affected_rows 表示影响到的记录数
	*
	*/

	function _affected_rows() {
		//global表示全局变量，意图是此变量可以在函数外可以访问
		global $_conn;
		return mysqli_affected_rows($_conn);
	}

	/**
	*_free_result 表示销毁结果集
	*
	*/

	function _free_result($_result){
		mysqli_free_result($_result);
	}

	/**
	*_insert_id() 获取上一部产生的id
	*
	*
	*/
	function _insert_id(){
		global $_conn;
		return mysqli_insert_id($_conn);
	}

	function _is_repeat($_sqli,$_info){
		if(_fetch_array($_sqli)){
			_alert_back($_info);
		}
	}

	function _close(){
		//global表示全局变量，意图是此变量可以在函数外可以访问
		global $_conn;
		mysqli_close($_conn);
	}
?>