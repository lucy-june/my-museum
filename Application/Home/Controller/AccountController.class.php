<?php
namespace Home\Controller;
use Think\Controller;
class AccountController extends Controller {
    public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>[ 您现在访问的是Home模块的Index控制器 ]</div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }

    //http://localhost:89/Museum/Home/Account/signin?username=test5&password=2&tel=13839333898
    public function signin($username,$password,$tel,$sex=null,$email=null,$nickname=null){
        if(IS_GET){
            $db = M('user');
            $data = array(
                'username'              => $username,
                'password'              => md5($password),
                'tel'                    => $tel,
                'email'                  => $email,
                'sex'                    => $sex,
                'nickname'              => $nickname,
                'status'                =>1,
            );
//            foreach( $data as $key=>$value)
//            {
//                echo $key."=>".$value;
//                echo '<br />';
//            }
            $ret=$db->add($data);
            echo $ret;
        }
        else{
            $this->error('请求方式错误！');
        }
    }

    //http://localhost:89/Museum/Home/Account/login?username=test5&password=2
    public function login($username = null, $password = null){
        if(IS_GET){
            $db = M('user');
            $map['username'] = $username;
            $map['status'] = 1;
            $map['type'] = 1;
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
            $this->success($user['uid']);
        }
        else{
            $this->error('请求方式错误！');
        }
    }

    //http://localhost:89/Museum/Home/Account/logout
    public function logout(){
        if(is_login()){
            session('user', null);
            session('[destroy]');
            $this->success('退出成功！', U('login'));
        } else {
            $this->redirect('login');
        }
    }
}