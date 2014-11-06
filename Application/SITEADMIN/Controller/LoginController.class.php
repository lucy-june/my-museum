<?php
namespace SITEADMIN\Controller;
use Think\Controller;

/**
 * 后台公共控制器
 */
class LoginController extends Controller {
	/**
     * 管理员用户登录
     */
    public function login($username = null, $password = null, $verify = null){
        if(IS_POST){
            /* 检测验证码 TODO: */
            if(!check_verify($verify)){
                $this->error('验证码输入错误');
            }
            $tbl_admin = M('site_admin');
			$condition['SA_NAME_TX'] = 'test_admin';
 			$condition['SA_STATE_TX_FX'] = 'ACT';
			$user = $tbl_admin->where($condition)->find();

			if(!$user){
				$this->error('帐号不存在或被禁用');
			}
			if($user['SA_PASSWORD_TX'] != md5($password)){
				$this->error('密码错误');
			}
			
			$data = array(
				'SA_ID_INT_PK'    => $user['SA_ID_INT_PK'],
				'login'           => array('exp', '`login`+1'),
				'last_login_time' => NOW_TIME,
				'last_login_ip'   => get_client_ip(),
			);
			
// 			/* 记录登录SESSION和COOKIES */
			$auth = array(
				'uid'             => $user['SA_ID_INT_PK'],
				'username'        => $user['SA_NAME_TX'],
				'last_login_time' => $data['last_login_time'],
			);
			session('user', $auth);
			$this->success('登录成功！', U('Index/index'));

        } else {
            if(is_login()){
                $this->redirect('Index/index');
            }else{
                $this->display();
//                 echo 'nothing';
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
            //$this->redirect('login');
            echo 'nothing';
        }
    }

    public function verify(){
		ob_end_clean();
        $verify = new \Think\Verify();
        $verify->entry();
    }
}
?>