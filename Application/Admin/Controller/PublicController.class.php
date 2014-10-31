<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 后台公共控制器
 */
class PublicController extends Controller {
	/**
     * 后台用户登录
     */
    public function login($username = null, $password = null, $verify = null){
        if(IS_POST){
            /* 检测验证码 TODO: */
            if(!check_verify($verify)){
                $this->error('验证码输入错误！');
            }

            $db = M('user');
			$map['username'] = $username;
			$map['status'] = 1;
            $map['type'] = 0;
			$user = $db->where($map)->find();
			if(!$user){
				$this->error('帐号不存在或被禁用');
			}
			if($user['password'] != md5($password)){
				$this->error('密码错误');
			}

			$data = array(
				'uid'              => $user['uid'],
				'login'           => array('exp', '`login`+1'),
				'last_login_time' => NOW_TIME,
				'last_login_ip'   => get_client_ip(),
			);
			$db->save($data);

			/* 记录登录SESSION和COOKIES */
			$auth = array(
				'uid'             => $user['uid'],
				'username'        => $user['nickname'],
				'last_login_time' => $data['last_login_time'],
			);
			session('user', $auth);
			$this->success('登录成功！', U('Index/index'));

        } else {
            if(is_login()){
                $this->redirect('Index/index');
            }else{
                $this->display();
            }
        }
    }
	/* 退出登录 */
    public function logout(){
        if(is_login()){
			session('user', null);
            session('[destroy]');
            $this->success('退出成功！', U('login'));
        } else {
            $this->redirect('login');
        }
    }

    public function verify(){
		ob_end_clean();
        $verify = new \Think\Verify();
        $verify->entry();
    }
}
?>