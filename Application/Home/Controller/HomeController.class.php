<?php
namespace Home\Controller;
use Think\Controller;
class HomeController extends Controller {
    public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>[ 您现在访问的是Home模块的Index控制器 ]</div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }

    //http://localhost:89/Museum/Home/Home/museumIntroduction
    public function museumIntroduction(){
        $path='展馆展品数据资料/首页信息/';
        $file='展馆详情.txt';
        echo urlContent(getBase(),$path,$file);
    }

    //http://localhost:89/Museum/Home/Home/scrollImgs
    public function scrollImgs(){
        $path='展馆展品数据资料/首页信息/';

        $data[0]=getBase().urlencode(mb_convert_encoding($path."滚动图1.jpg",'gb2312','utf-8' ));
        $data[1]=getBase().urlencode(mb_convert_encoding($path."滚动图2.jpg",'gb2312','utf-8' ));
        $data[2]=getBase().urlencode(mb_convert_encoding($path."滚动图3.jpg",'gb2312','utf-8' ));

        echo JSON($data);
    }

    //http://localhost:89/Museum/Home/Home/getStarted
    public function getStarted(){
        $path='展馆展品数据资料/首页信息/';
        $file='操作入门.mp3';
        echo getBase().urlencode(mb_convert_encoding($path.$file,'gb2312','utf-8' ));
    }
}