<?php 
class LoginController{
#登录方法
	public function login(){
		// p($_POST);
		if (IS_AJAX) {
			$data=$_POST;
			$username=$data['username'];
			$password=$data['password'];
			$old_data=M()->query_sql("SELECT * FROM user WHERE username='{$username}'");
			// p($old_data);//是一个二维数组
			$old_data=current($old_data);
			if (empty($old_data)) {
				echo ajax_return(505,'用户名不存在','');
			}else{
				$new_password = md5(md5($password).$old_data['encrypt']);
				if ($new_password==$old_data['password']) {
					session_start();
					$_SESSION['username']=$username;
					echo ajax_return(200,'登录成功',$username);
				}else{
					echo ajax_return(403,'密码错误','');
				}
			}
		}
	}
#注册
	public function reg(){
		$data=$_POST;
		$username=$data['username'];
		$password=$data['password'];
		$old_data=M()->query_sql("SELECT * FROM user WHERE username='{$username}'");
		// p($old_data);
		if(!empty($old_data)){
			echo ajax_return(505,'用户名已存在','');
			exit;//输出后退出函数
		}else{
			$data['encrypt'] = $this -> genRandomString(6);
			$data['password']= md5(md5($password).$data['encrypt']);//加密
			unset($data['c']);
			unset($data['a']);
			$result=M()->add('`user`',$data);//受影响条数
			if ($result) {
				echo ajax_return(200,'成功',$username);
			}else{
				echo ajax_return(404,'失败',$username);
			}
		}
	}
	#退出方法
	public function unset1(){
		if (IS_AJAX) {
			session_start();
			session_destroy();
			session_unset();
			echo ajax_return(200,'成功','');
		}
	}
/**加密
 * 产生一个指定长度的随机字符串,并返回给用户 
 * @param type $len 产生字符串的长度
 * @return string 随机字符串
 */
	public function genRandomString($len = 32) {
		$chars = array(
		"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
		"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
		"w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
		"H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
		"S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
		"3", "4", "5", "6", "7", "8", "9"
		);
		$charsLen = count($chars) - 1;
		// 将数组打乱 
		shuffle($chars);
		$output = "";
		for ($i = 0; $i < $len; $i++) {
			$output .= $chars[mt_rand(0, $charsLen)];
		}
		return $output;
	}
#上传图片
	public function upload(){
		if($_FILES['file']){
			$_file = $_FILES['file'];
			var_dump($_file);
			if($_file['error'] != 0){
				echo "失败";
			}else{
				$path = '../img_upd';
				if(!is_dir($path)){
					mkdir($path,'0777',true);
				}
				$filepath =$_SERVER['DOCUMENT_ROOT'].'/visitor/img_upd/'.$_file['name'];
				if(move_uploaded_file($_file['tmp_name'], $filepath)){
					echo $filepath;
				}else{
					echo "失败";
				}
			}
		}
	}
#评论方法
	public function comment(){
		// p($_POST);
		if (IS_AJAX) {
			$data=$_POST;
			$username=$data['username'];
			$old_data = M()->query_sql("SELECT * FROM user WHERE username='{$username}'");
			// p($old_data);//是一个二维数组
			unset($data['username']);
			$data['userid']=current($old_data)['userid'];
			$data['addtime']=time();
			$data['img']=split(' ', $data['img']);
			array_pop($data['img']);
			$data['img']=$this -> Array2String($data['img']);
			if (empty($data['userid'])) {
				echo ajax_return(505,'错误','');
			}else{
				$result=M()->add('share',$data);//受影响条数
				if ($result) {
					echo ajax_return(200,'成功','');
				}else{
					echo ajax_return(404,'失败','');
				}
			}
		}
	}
#进入页面，请求share表
	public function freshen(){
		$data = M() -> query_sql("SELECT * FROM share");
		foreach ($data as $key => $value) {
			$data[$key]['img'] = $this -> String2Array($value['img']);
			$id=$value['userid'];
			$data[$key]['username'] = current(M() -> query_sql("SELECT username FROM user WHERE userid='{$id}'"))['username'];
		}
		$data=json_encode($data);
		echo $data;
	}
#array2string	
	function Array2String($Array){
	    $Return='';
	    $NullValue="^^^";
	    foreach ($Array as $Key => $Value) {
	        if(is_array($Value))
	            $ReturnValue='^^array^'.Array2String($Value);
	        else
	            $ReturnValue=(strlen($Value)>0)?$Value:$NullValue;
	        $Return.=urlencode(base64_encode($Key)) . '|' . urlencode(base64_encode($ReturnValue)).'||';
	    }
	    return urlencode(substr($Return,0,-2));
	}
	function String2Array($String){
	    $Return=array();
	    $String=urldecode($String);
	    $TempArray=explode('||',$String);
	    $NullValue=urlencode(base64_encode("^^^"));
	    foreach ($TempArray as $TempValue) {
	        list($Key,$Value)=explode('|',$TempValue);
	        $DecodedKey=base64_decode(urldecode($Key));
	        if($Value!=$NullValue) {
	            $ReturnValue=base64_decode(urldecode($Value));
	            if(substr($ReturnValue,0,8)=='^^array^')
	                $ReturnValue=String2Array(substr($ReturnValue,8));
	            $Return[$DecodedKey]=$ReturnValue;
	        }
	        else
	        $Return[$DecodedKey]=NULL;
	    }
	    return $Return;
	}
}