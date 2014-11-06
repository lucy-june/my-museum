<?php
namespace TOURIST\Controller;
use Think\Controller;
class CollectionController extends Controller {
    public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>[ 您现在访问的是Home模块的Index控制器 ]</div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }

    //http://localhost:89/Museum/Home/Collection/myCollection?uid=2
    public function myCollection($uid){
    }

    //http://localhost:89/Museum/Home/Collection/myCollectionDetail?uid=2
    public function myCollectionDetail($uid){
    	//TODO:返回所有item，简介，图片
        $db = M('collection');
        $map['uid'] = $uid;
        $data = $db->where($map)->select();

        $result=array();
        foreach($data as $record){
            $path=mb_convert_encoding($record["exhibitpath"],'gb2312','utf-8');
            $arr = explode("/",$path);
//            print_r($arr);
            $pair["name"]=$arr[count($arr)-2];
            $pair["img"]=getBase().urlencode(mb_convert_encoding($path."缩略图.jpg",'gb2312','utf-8' ));
            $result[]=$pair;
        }
		
        echo(JSON($result));
    }

    //http://localhost:89/Museum/Home/Collection/addCollection?uid=2&exhibitpath=展馆展品数据资料/展品信息/
    public function addCollection($uid,$exhibitpath){
    	//TODO: get collections
    }
}