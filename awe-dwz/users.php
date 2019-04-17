<?php

//防止恶意调用
if(!defined('awe-dwz')) {
    exit('Access Denied!');
}

$_USERS = array (
    0 => 
    array (
        'name' => 'username',
        'pass' => '5f4dcc3b5aa765d61d8327deb882cf99',   //md5加密   password
    ),
    1 => 
    array (
        'name' => 'admin',
        'pass' => '21232f297a57a5a743894a0e4a801fc3',   //md5加密   admin
    ),
);