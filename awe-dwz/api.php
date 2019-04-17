<?php 
    //定义一个常量，用来授权调用includes里面的文件
	define('awe-dwz',true);
	//引入公共文件
    require dirname(__FILE__)."/common.inc.php";//转换成硬路径，速度更快

    //获取get数据
    $_action = @$_POST['action'];    //add增加   delete删除  update更改  query查询
    $_url = @$_POST['url'];  //表单提交的url
    $_id = @$_POST['id'];  //表单提交的网址对应的id
    $_appId = @$_POST['appId'];  //验证id
    $_appKey = @$_POST['appKey'];  //验证key

    $_passFlag = false; //密码验证表示
    $_dwz_id = "";  //生成的短网址id


    //验证appId,appKey
    if (empty($_appId) || empty($_appKey)) {
        $output = array('data'=>NULL, 'info'=>'请输入用户名或密码!', 'code'=>-201);
        exit(json_encode($output));
    }else {
        for ($i=0; $i < count($_USERS); $i++) { 
            if ($_appId == $_USERS[$i]['name'] && md5($_appKey) == $_USERS[$i]['pass']) {
                $_passFlag = true;
            }
        }
    }

    //密码正确操作
    if($_passFlag == false){
        $output = array('data'=>NULL, 'info'=>'用户名或密码错误!', 'code'=>-301);
        exit(json_encode($output));
    }else{
        if ($_action == "") {   //如果操作为空
            $output = array('data'=>NULL, 'info'=>'请输入action!', 'code'=>-401);
            exit(json_encode($output));
        } elseif ($_action == "add") {                                                          //如果操作是add增加
            if ($_url != '') {  //如果url不是空的
                if ($_id != "") {   //如果id不是空的
                    //连接数据库
                    if(!($_conn = @mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME))){
                        exit("数据库连接失败");
                    }
                    if(!@mysqli_select_db($_conn,DB_NAME)){
                        exit("找不到指定数据库");
                    }

                    //检查ID是否重复
                    if(_fetch_array("SELECT dwz_id FROM awe_dwz WHERE dwz_id = '{$_id}' LIMIT 1"
                    )){
                        //关闭数据库
                        _close();

                        $output = array('data'=>NULL, 'info'=>'短网址id已被占用!', 'code'=>-701);
                        exit(json_encode($output));
                    }else { //如果id不重复
                        $_dwz_id = _add_url($_url,$_id);
                        $output = array('data'=>AWE_DOMAIN.$_dwz_id, 'info'=>'增加成功!', 'code'=>201);
                        exit(json_encode($output));
                    }
                }else { //如果id是空的
                    $_dwz_id = _add_url($_url,$_id);
                    $output = array('data'=>AWE_DOMAIN.$_dwz_id, 'info'=>'增加成功!', 'code'=>201);
                    exit(json_encode($output));
                }
            }else { //如果url为空
                $output = array('data'=>NULL, 'info'=>'url不能为空!', 'code'=>-501);
                exit(json_encode($output));
            }
        } elseif ($_action == "delete") {                                                           //如果操作是delete删除
            $output = array('data'=>NULL, 'info'=>'no operation!', 'code'=>-202);
            exit(json_encode($output));
        } elseif ($_action == "update") {                                                           //如果操作是update修改
            $output = array('data'=>NULL, 'info'=>'no operation!', 'code'=>-203);
            exit(json_encode($output));
        } elseif ($_action == "query") {                                                            //如果操作是query查询
            if ($_id == "") {   //如果查询id为空
                $output = array('data'=>NULL, 'info'=>'查询id不能为空!', 'code'=>-204);
                exit(json_encode($output));
            }else { //如果查询id不为空
                //连接数据库
                if(!($_conn = @mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME))){
                    exit("数据库连接失败");
                }
                if(!@mysqli_select_db($_conn,DB_NAME)){
                    exit("找不到指定数据库");
                }

                //执行查询操作
                $sql = "select dwz_id,dwz_url from `awe_dwz` where dwz_id='$_id'";
                $result = mysqli_query($_conn,$sql);
            
                #关联数组
                if($row=mysqli_fetch_assoc($result)) {  //查询到有数据，输出查询到的url
                    //关闭数据库
                    _close();

                    $output = array('data'=>$row['dwz_url'], 'info'=>'获取原url成功!', 'code'=>204);
                    exit(json_encode($output));
                }else { //查询到无数据 输出-304错误 未查询到
                    //关闭数据库
                    _close();

                    $output = array('data'=>NULL, 'info'=>'暂未查询到url!', 'code'=>-304);
                    exit(json_encode($output));
                }
            }
        } elseif ($_action == "fresh") {                                                                //如果操作是fresh刷新数据
            //连接数据库
            if(!($_conn = @mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME))){
                exit("数据库连接失败");
            }
            if(!@mysqli_select_db($_conn,DB_NAME)){
                exit("找不到指定数据库");
            }

            //执行查询操作
            $sql = "select dwz_id,dwz_url,dwz_addTime from `awe_dwz`";
            $result = mysqli_query($_conn,$sql);
        
            #关联数组
            if($row=mysqli_fetch_assoc($result)) {  //查询到有数据，输出id、url、addTime

                //获取最新数据
                $result = mysqli_query($_conn,$sql);
                //关闭数据库
                _close();

                $data = [];
                $i = 0;
                while($row = mysqli_fetch_assoc($result)) {
                    $data[$i] = [$row['dwz_id'],$row['dwz_url'],$row['dwz_addTime']];
                    $i++;
                }

                $output = array('data'=>$data, 'info'=>'获取数据成功!', 'code'=>205);
                exit(json_encode($output));
            }else { //查询到无数据 输出-305错误 没有数据
                //关闭数据库
                _close();

                $output = array('data'=>NULL, 'info'=>'暂无查询到数据!', 'code'=>-305);
                exit(json_encode($output));
            }
        }else {                                                                                         //如果操作是其他
            $output = array('data'=>NULL, 'info'=>'action错误!', 'code'=>-601);
            exit(json_encode($output));
        }
    }


    /** 存入数据库并返回短网址id
     * @param String
     * @return String
     */
    function _add_url($_url,$_id = "") {
        //创建空数组容纳数据
        $_clean = array();
        $_clean['url'] = $_url;
        $_clean['addtime'] = _nowtime();
        $_clean['ip'] = $_SERVER['REMOTE_ADDR'];
        
        
        if ($_id == "") {
            $_clean['id'] = toShortUrl($_url);
        }else {
            $_clean['id'] = $_id;
        }

        //连接数据库
        if(!($_conn = @mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME))){
            exit("数据库连接失败");
        }
        if(!@mysqli_select_db($_conn,DB_NAME)){
            exit("找不到指定数据库");
        }

        //存入数据库
        if(!_fetch_array("SELECT dwz_id FROM awe_dwz WHERE dwz_id = '{$_clean['id']}' LIMIT 1"
        )){
            //数据写入数据库
            _query(
                "INSERT INTO awe_dwz (
                    dwz_id,
                    dwz_url,
                    dwz_addTime,
                    dwz_ip
                ) VALUES (
                    '{$_clean['id']}',
                    '{$_clean['url']}',
                    '{$_clean['addtime']}',
                    '{$_clean['ip']}'
                )"
            );
            // $sql = "INSERT INTO `awe_dwz` (`dwz_id`, `dwz_url`, `dwz_addTime`, `dwz_ip`) VALUES (\'niucc\', \'http://zqcnc.cn/ncong\', \'2019-04-11 09:45:53\', \'127.0.0.1\')";
        }

        //关闭数据库
        _close();

        //返回生成的短网址
        return $_clean['id'];

    }




    
    /** 生成短网址
     * @param String $url 原网址
     * @return String
     */
    function toShortUrl($url) {
        $code = floatval(sprintf('%u', crc32($url)));
        $surl = '';
        while ($code) {
            $mod = fmod($code, 62);
            if ($mod > 9 && $mod <= 35) {
                $mod = chr($mod + 55);
            } elseif ($mod > 35) {
                $mod = chr($mod + 61);
            }
            $surl .= $mod;
            $code = floor($code / 62);
        }
        return $surl;
    }

    //生成现在时间
	function _nowtime(){
		return date("Y-m-d H:i:s");
	}

    //弹出信息，并返回
	function _alert_back($_info){
		echo "<script type='text/javascript'>alert('".$_info."');history.back();</script>";
		exit();
	}

  

?>