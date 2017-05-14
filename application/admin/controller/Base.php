<?php
//  Project name Q-Buy
//  Created by window on 17/5/13.
//  Copyright © 2017年 worning. All rights reserved.

/**
 *　　　　　　　 ┏┓       ┏┓+ +
 *　　　　　　　┏┛┻━━━━━━━┛┻┓ + +
 *　　　　　　　┃　　　　　　 ┃
 *　　　　　　　┃　　　━　　　┃ ++ + + +
 *　　　　　　 █████━█████  ┃+
 *　　　　　　　┃　　　　　　 ┃ +
 *　　　　　　　┃　　　┻　　　┃
 *　　　　　　　┃　　　　　　 ┃ + +
 *　　　　　　　┗━━┓　　　 ┏━┛
 *               ┃　　  ┃
 *　　　　　　　　　┃　　  ┃ + + + +
 *　　　　　　　　　┃　　　┃　Code is far away from     bug with the animal protecting
 *　　　　　　　　　┃　　　┃ + 　　　　         神兽保佑 , 代码无bug
 *　　　　　　　　　┃　　　┃
 *　　　　　　　　　┃　　　┃　　+
 *　　　　　　　　　┃　 　 ┗━━━┓ + +
 *　　　　　　　　　┃ 　　　　　┣┓
 *　　　　　　　　　┃ 　　　　　┏┛
 *　　　　　　　　　┗┓┓┏━━━┳┓┏┛ + + + +
 *　　　　　　　　　 ┃┫┫　 ┃┫┫
 *　　　　　　　　　 ┗┻┛　 ┗┻┛+ + + +
 */

namespace app\admin\controller;
use think\Controller;
use think\Db;
use app\admin\model\Admin;
class Base extends Controller
{
	protected $allowMthod = ['admin_login','verlogin'];
	
	public function _initialize()
	{

		if(!$this->checkLogin() && !in_array(request()->action(),$this->allowMthod))
		{
			$this->error('请登录','admin_login');
		}
		$this->bindData();
	}
	protected function bindData ()
	{
		$systems = Db::name('config')->find();
		$this->assign('systems',$systems);
	}


	//检查是否登陆 后台必须要登录
	protected function checkLogin ()
	{
		if (session('?admin_uid')) {
			return true;
		}
		return false;
	}
	//登陆界面
	public function admin_login ()
	{
		session('admin_uid',null);
		return $this->fetch('user/admin_login');
	}

	//验证ajax传来的数据 然后进行判断返回
	public function verlogin ()
	{
		$user = input('post.');
		$username = $user['username'];
		$password = md5($user['password']);
		
		$result = Admin::where(['username' => $username,'password' => $password])->find();
		if (empty($result)) {
			return 0;
		}
		session('admin_uid' ,$result->admin_id);
		session('adminname' ,$result->username);
		session('role_id' ,$result->role_id);
		return 1;
		
	}
}
 
