<?php
	
	define("AWE_DWZ_PATH",'./');
	// echo ("<script type='text/javascript'>alert('666');</script>");

	$json_string = file_get_contents("dwzData.json");// 从文件中读取数据到PHP变量
	$_localData = json_decode($json_string,true);// 把JSON字符串转成PHP数组
	// print_r($_localData);

	if (@$_GET['action'] == 'add') {

		//获取提交的数据
		$_appId = $_POST['appid'];
		$_appKey = $_POST['appkey'];
		$_url = $_POST['url'];
		$_url_id = $_POST['url_id'];

		//设置必要参数
        $url = 'http://dwz.fghwett.com/awe-dwz/api.php';
        $post_data['appId']       = $_appId;
        $post_data['appKey']      = $_appKey;
        $post_data['action']      = 'add';
        $post_data['url']      = $_url;
        $post_data['id']      = $_url_id;

		//post数据到API
		$res = json_decode(request_post($url, $post_data)); 
		//print_r($res);

		//对各状态码进行相应回复
		if ($res->code == '-201') {	//用户名或密码未输入
			_alert_back($res->info);
		} elseif ($res->code == '-301') {	//用户名或密码错误
			_alert_back($res->info);
		} elseif ($res->code == '-501') {	//url为空
			_alert_back($res->info);
		} elseif ($res->code == '-701') {	//短网址id被占用
			_alert_back($res->info);
		} elseif ($res->code == '201') {	//获取成功
			echo "<script type='text/javascript'>alert('".$res->data."');history.back();history.go(0);</script>";
		} else {	//其他情况直接打印错误信息与代码
			_alert_back(print_r($res));
		}
		

	} elseif (@$_GET['action'] == 'fresh') {
		//获取提交的数据
		$_appId = $_POST['appid'];
		$_appKey = $_POST['appkey'];

		//设置必要参数
        $url = 'http://dwz.fghwett.com/awe-dwz/api.php';
        $post_data['appId']       = $_appId;
        $post_data['appKey']      = $_appKey;
        $post_data['action']      = 'fresh';

		//post数据到API
		$res = json_decode(request_post($url, $post_data)); 
		//print_r($res);

		//对各状态码进行相应回复
		if ($res->code == '-305') {	//无数据
			_alert_back($res->info);
		} elseif ($res->code == '-301') {	//用户名或密码错误
			_alert_back($res->info);
		}elseif ($res->code == '205') {	//获取成功
			// echo "<script type='text/javascript'>alert('".$res->data."');history.back();history.go(0);</script>";
			$_dwz_data = json_encode($res->data);
			file_put_contents("dwzData.json",$_dwz_data);
			echo "<script type='text/javascript'>alert('刷新成功！');history.back();history.go(0);</script>";
		} else {	//其他情况直接打印错误信息与代码
			_alert_back(print_r($res));
		}
	}


	/**
	 * 弹框并返回上一步
	 * @param string $_info 弹出的信息
	 * @return void
	 */
	function _alert_back($_info){
		echo "<script type='text/javascript'>alert('".$_info."');history.back();</script>";
		exit();
	}


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

<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="Author" content="awe.im">
		<meta name="Keywords" content="短网址,dwz,短网址生成">
		<meta name="Description" content="这是由awe.im发表的短网址生成网站！">
		<title>awe短网址生成</title>
		<link rel="stylesheet" href="<?php echo AWE_DWZ_PATH; ?>awe-includes/layui/css/layui.css">
		<link rel="stylesheet" href="<?php echo AWE_DWZ_PATH; ?>awe-includes/css/index.css">
	</head>
<body>
	<!-- 												header 														-->
	<div class="header layui-header">
		<div class="layui-main">
			<ul class="layui-nav" lay-filter="">
				<li class="layui-nav-item"><a href="">首页</a></li>
				<li class="layui-nav-item layui-this"><a href="">短网址</a></li>
				<li class="layui-nav-item"><a href="">大数据</a></li>
				<li class="layui-nav-item">
					<a href="javascript:;">解决方案</a>
					<dl class="layui-nav-child"> <!-- 二级菜单 -->
					<dd><a href="">移动模块</a></dd>
					<dd><a href="">后台模版</a></dd>
					<dd><a href="">电商平台</a></dd>
					</dl>
				</li>
				<li class="layui-nav-item"><a href="">反馈</a></li>
			</ul>
		</div>
	</div>
	<!-- 												header end													 -->

	<!-- 												section	one													-->
	<div class="layui-main awe-dwz-main layui-card">
		<div class="layui-card-header">短网址添加</div>
		<div class="layui-card-body">
		<form class="layui-form" action="index.php?action=add" method="post" name="aweForm">
			<div class="layui-form-item">
				<label class="layui-form-label">原网址</label>
				<div class="layui-input-inline" id="awe-dwz-main-form-text">
				<input type="text" name="url" placeholder="请输入您将要缩短的网址" autocomplete="off" class="layui-input">
				</div>
				<div class="layui-form-mid layui-word-aux">您需要缩短的网址</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">appId</label>
				<div class="layui-input-inline" id="awe-dwz-main-form-text">
				<input type="text" name="appid" required  lay-verify="required" placeholder="请输入您的appId" autocomplete="off" class="layui-input">
				</div>
				<div class="layui-form-mid layui-word-aux"><font color="red">*</font> 必填，您需要登录的appId</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">appKey</label>
				<div class="layui-input-inline" id="awe-dwz-main-form-text">
				<input type="password" name="appkey" required  lay-verify="required" placeholder="请输入您的appKey" autocomplete="off" class="layui-input">
				</div>
				<div class="layui-form-mid layui-word-aux"><font color="red">*</font> 必填，您需要登陆的appKey</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">自定义后缀</label>
				<div class="layui-input-inline">
				<input type="text" name="url_id" placeholder="请输入您自定义的后缀" autocomplete="off" class="layui-input">
				</div>
				<div class="layui-form-mid layui-word-aux">六位由数字及大小写字母组成,可不填写</div>
			</div>
			<div class="layui-form-item">
				<div class="layui-input-block">
					<button class="layui-btn awe-dwz-add" lay-submit lay-filter="formDemo">立即添加</button>
					<button type="reset" class="layui-btn layui-btn-primary">重置</button>
					<button class="layui-btn layui-btn-normal awe-dwz-fresh" lay-submit lay-filter="formDemo">刷新列表</button>
				</div>
			</div>
		</form>
		</div>
	</div>
	<!-- 												section	one end													-->

	<!-- 												section	two 													-->
	<div class="layui-main awe-dwz-main layui-card">
		<div class="layui-card-header">已保存短网址</div>
		<div class="layui-card-body">
		<table class="layui-table">
			<colgroup>
				<col width="150">
				<col width="200">
				<col>
			</colgroup>
			<thead>
				<tr>
					<th>添加时间</th>
					<th>短网址</th>
					<th>原链接</th>
				</tr> 
			</thead>
			<tbody>
				<tr>
					<td>2018-09-23 21:48:57</td>
					<td>dwz</td>
					<td>http://awe.im</td>
				</tr>
				<!-- <tr>
					<td>许闲心</td>
					<td>2016-11-28</td>
					<td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
				</tr> -->
				<?php 
				$i = 0;
				while($_localData){
					echo "<tr>";
					echo "<td>".$_localData[$i][2]."</td><td>".$_localData[$i][0]."</td><td>".$_localData[$i][1]."</td>";
					echo "</tr>";
					$i++;
					if ($i == count($_localData)) {
						break;
					}
				} ?>
			</tbody>
		</table>
		</div>
	</div>
	<!-- 												section	two end													-->



	<!-- <form method="post" name="dwz" action="dwz.php?action=result">
		<p>请输入您将要缩短的网址</p>
		<input type="url" name="url"></input> <font color='red'>*</font>
		<p>请输入您想要使用的后缀（6位英文）</p>
		<input type="text" name="dwz_id"></input>
		<input type="submit">
	</form> -->


	<?php
		
	?>

	<script src="<?php echo AWE_DWZ_PATH; ?>awe-includes/layui/layui.js"></script>
	<script>
		layui.config({
		  base: '<?php echo AWE_DWZ_PATH; ?>awe-includes/js/' 
		}).use('index');	
	</script>
	<!-- <script>layui.use('layer', function(){var layer = layui.layer;layer.alert('hello');});</script> -->

</body>
</html>
