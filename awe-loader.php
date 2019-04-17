<?php

	//判断是 http 还是 https
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	
	# 获取短网址的后6位随机码
	$get_url = '';
	if (isset($_SERVER['PATH_INFO'])) {
	    $get_url = $_SERVER['PATH_INFO'];
	}else if (isset($_SERVER['REDIRECT_PATH_INFO'])) {
	    $get_url = $_SERVER['REDIRECT_PATH_INFO'];
	}else if (isset($_SERVER['REDIRECT_URL'])) {
	    $get_url = $_SERVER['REDIRECT_URL'];
	}
	#处理字符，因含有 '/'
	$get_url = ltrim($get_url,'/');//获得url地址栏额外参数
	// echo $get_url;

	#得到额外参数，进行判断
	if(isset($get_url) && !empty($get_url)){//针对 0 null '' 都是empty
	    
		//设置必要参数
        $url = 'http://dwz.fghwett.com/awe-dwz/api.php';
        $post_data['appId']       = 'admin';
        $post_data['appKey']      = 'password';
        $post_data['action']      = 'query';
        $post_data['id']      = $get_url;

    	$res = json_decode(request_post($url, $post_data)); 
	 
	    # 判断状态码
	    if($res->code == "204") {
	    	//print_r($row);
	        $real_url = $res->data;
	        header('Location: ' . $real_url);
	        exit();
	        //这里根据6位随机码对应取出原网址，就是重定向
	    }else {
	        // header('HTTP/1.0 404 Not Found');
			// echo 'Unknown link.';
			$uri .= $_SERVER['HTTP_HOST'];
			header('Location: '.$uri.'/index.php');
			exit;
	    }
	 
	}

	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/index.php');
	exit;

	/**
     * 模拟post进行url请求
     * @param string $url
     * @param array $post_data
     */
    function request_post($url = '', $post_data = array()) {
        if (empty($url) || empty($post_data)) {
            return false;
        }
        
        $o = "";
        foreach ( $post_data as $k => $v ) 
        { 
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);

        $postUrl = $url;
        $curlPost = $post_data;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        
        return $data;
    }
?>