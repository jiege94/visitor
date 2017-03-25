<?php 
function P($a){
	// echo "<pre>";
	print_r($a);
	// var_dump($a);
}

define("IS_POST", $_SERVER['REQUEST_METHOD']=="POST"?TRUE:FALSE);

define("IS_GET", $_SERVER['REQUEST_METHOD']=="GET"?TRUE:FALSE);

define("IS_AJAX",isset($_SERVER['HTTP_X_REQUESTED_WITH'])&&$_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest"?true:false);//判断ajax请求如果存在


function __autoload($classname){//不能改名字，只要实例化句柄，自动执行这个函数
	$calssPath='./'.$classname.'.class.php';
	if (file_exists($calssPath)) {
		include_once $calssPath;
	}else{
		echo '类不存在' ;
	}

}

function M(){//数据库操作
	$obj=new ModuleController;
	return $obj;
}


function ajax_return($code,$message,$data){
	if (!is_numeric($code)) {//判断是否是数字格式
		return '';
	}
	$new_data=array(
		'code'=>$code,
		'message'=>$message,
		'data'=>$data
	);
	return json_encode($new_data);
}


 