<?php

/**
* 短信发送类
* @author NingerJohn <ningerjohn@163.com>
* @ctime 创建时间：2015年10月28日13:37:01
*
* 使用方法
* $config['mobile'] = 18651718003; 			// 接收短信的手机号码
* $config['text'] = '短信验证码是123456'; 	// 短信内容
* $config['tpl_id'] = 124;					// 设置模板id时，会对应模板格式发送；不设置时，默认智能匹配模板
* $SMS = new SMS;
* $res = $SMS->send($config); 				// 发送短信
* echo $res; 								// 返回json结果，{"code":-1,"msg":"非法的apikey","detail":"请检查的apikey是否正确，或者账户已经失效"}
*
*
* 
*/

class SMS
{
	/**
	 * 基本成员属性
	 * @var $apikey 云片apikey
	 * @var $url 云片默认发送url的地址
	 * 
	 */
	public $apikey = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'; // 云片apikey
	public $url = 'http://yunpian.com/v1/sms/send.json'; // 云片请求url地址
	/**
	 * 构造函数
	 * 初始化基本信息
	 */
	function __construct()
	{
		# code...
		# $this->paramArr = ['mobile'=>$config['mobile'],'text'=>$config['text'], 'tpl_id'=>$config['tpl_id']];
		// $this->apikey = $apikey; // 云片apikey
	}

	/**
	 * 发送短信函数
	 * @param  array $paramArray 数组
	 * @return json data         json结果
	 */
	public function send($paramArray)
	{
		# code...
		if (!@$paramArray['tpl_id']) {
			// 传递模板id时
			return $this->automatch_send($paramArray);
		}else{
			// 不传递时，默认智能匹配发送
			return $this->tpl_send($paramArray);
		}
	}


	/**
	 * 模板方式发送
	 * @param  array $paramArray 参数数组，包含手机号码，短信内容，模板id eg：$paramArray = ['mobile'=>18651718003, 'text'=>'短信内容']
	 * @return json data 发送请求返回的json结果
	 */
	private function automatch_send($paramArray)
	{ // 智能匹配发送
		# code...
		// $apikey = $this->apikey;
		$encoded_text = urlencode($paramArray['text']);
		$mobile = urlencode($paramArray['mobile']);
		$post_string="apikey=$this->apikey&text=$encoded_text&mobile=$mobile";
		// var_dump($post_string);
		return $this->sock_post($this->url, $post_string);
	}


	/**
	 * 模板方式发送
	 * @param  array $paramArray 参数数组，包含手机号码，短信内容，模板id eg：$paramArray = ['mobile'=>18651718003, 'text'=>'短信内容','tpl_id'=>123]
	 * @return json data 发送请求返回的json结果
	 */
	private function tpl_send($paramArray)
	{
		# $paramArr = ['mobile'=>18651718003,'text'=>'短信内容','tpl_id'=>1]
		// $apikey = $this->apikey;
		$encoded_tpl_value = urlencode($paramArray['text']);  //tpl_value需整体转义
		$mobile = urlencode($paramArray['mobile']);
		$post_string="apikey=$this->apikey&tpl_id=".$paramArray['tpl_id']."&tpl_value=$encoded_tpl_value&mobile=$mobile";
		// var_dump($post_string);
		return $this->sock_post($this->url, $post_string);
	}

	/**
	 * 远程请求方法，短信发送时调用
	 * @param  string $url   请求的url地址
	 * @param  string $post_string 请求的字符串
	 * @return json        请求后的结果json数据
	 */
	private function sock_post($url,$post_string){
		$data = "";
		$info=parse_url($url);
		$fp=fsockopen($info["host"],80,$errno,$errstr,30);
		if(!$fp){
		    return $data;
		}
		$head="POST ".$info['path']." HTTP/1.0\r\n";
		$head.="Host: ".$info['host']."\r\n";
		$head.="Referer: http://".$info['host'].$info['path']."\r\n";
		$head.="Content-type: application/x-www-form-urlencoded\r\n";
		$head.="Content-Length: ".strlen(trim($post_string))."\r\n";
		$head.="\r\n";
		$head.=trim($post_string);
		$write=fputs($fp,$head);
		$header = "";
		while ($str = trim(fgets($fp,4096))) {
		    $header.=$str;
		}
		while (!feof($fp)) {
		    $data .= fgets($fp,4096);
		}
		return $data;
	}

}




$config['mobile'] = 18651718003;
$config['text'] = "你的验证码是123456";

$sms = new SMS();
// var_dump($sms->send($config));
$res = json_decode($sms->send($config), true);
// var_dump($res);
if ($res['code']===0) {
	echo '发送成功';
} else {
	echo '发送失败<br>';
	echo $res['msg'].'<br>';
	echo $res['detail'];
}
























