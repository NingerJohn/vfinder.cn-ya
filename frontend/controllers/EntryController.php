<?php
/**
* 网站入口控制器
* 注册，登录，
* @author NingerJohn <ningerjohn@163.com>
* @ctime 2015年10月27日16:44:54
* @
*/
namespace frontend\controllers;


use yii\web\Controller; // 

class EntryController extends Controller
{
	public $title;
	public $layout = 'entry';
	/**
	 * 登录页面
	 * 
	 * @author NingerJohn
	 * @return NULL
	 */
	public function actionLogin()
	{
		# code...
		// 调用entry布局
		$this->title = '登录';
		$data = [];
		// 返回渲染的页面
		return $this->render('login',$data);
	}

	/**
	 * 登录操作
	 * @author Ningerjohn
	 */
	public function actionSignin()
	{
		# code...
	}


	/**
	 * 
	 * 注册页面
	 * 用户名，邮箱和密码登录
	 * @author NingerJohn
	 * 
	 */
	public function actionRegister()
	{
		# code...
		// 返回渲染的页面
		return $this->render('register');
	}

	/**
	 * 注册操作
	 * @author NingerJohn
	 */
	public function actionSignup()
	{
		# code...
	}

}




























