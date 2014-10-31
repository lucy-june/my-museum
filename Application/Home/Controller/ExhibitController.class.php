<?php
namespace Home\Controller;
use Think\Controller;
class ExhibitController extends Controller {
    public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>[ 您现在访问的是Home模块的Index控制器 ]</div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }

    //http://localhost:89/Museum/Home/Exhibit/exhibitBrief?path=展馆展品数据资料/展品信息/第一层/第一展厅/明清木具/明朝藤椅/
    public function exhibitBrief($path){
        $arr = explode("/",mb_convert_encoding($path,'gb2312','utf-8' ));
        $data["name"]=$arr[count($arr)-2];
        $data["img"]=getBase().urlencode(mb_convert_encoding($path."缩略图.jpg",'gb2312','utf-8' ));
        echo(JSON($data));
    }

    //http://localhost:89/Museum/Home/Exhibit/exhibitParams?path=展馆展品数据资料/展品信息/第一层/第一展厅/明清木具/明朝藤椅/
    public function exhibitParams($path){
        $content=urlContent(getBase(),$path,'展品基本信息.csv');
        $arr = explode("\n",$content);
        $data="{";
        foreach($arr as $str){
            $kv=explode(",",$str);
            if($kv[0]!=""){
                $data=$data.'"'.$kv[0].'":"'.$kv[1].'",';
            }
        }
        $data=substr($data,0,strlen($data)-1);
        $data=$data."}";
        echo $data;
    }


    //http://localhost:89/Museum/Home/Exhibit/exhibitDetail?path=展馆展品数据资料/展品信息/第一层/第一展厅/明清木具/明朝藤椅/
    public function exhibitDetail($path){
        echo urlContent(getBase(),$path,'详细资料.txt');
    }

    //http://localhost:89/Museum/Home/Exhibit/exhibitImgs?path=展馆展品数据资料/展品信息/第一层/第一展厅/明清木具/明朝藤椅/
    public function exhibitImgs($path){
        $data[0]=getBase().urlencode(mb_convert_encoding($path."缩略图.jpg",'gb2312','utf-8' ));
        $data[1]=getBase().urlencode(mb_convert_encoding($path."原图1.jpg",'gb2312','utf-8' ));
        $data[2]=getBase().urlencode(mb_convert_encoding($path."原图2.jpg",'gb2312','utf-8' ));
        echo JSON($data);
    }

    //http://localhost:89/Museum/Home/Exhibit/exhibitNarrate?path=展馆展品数据资料/展品信息/第一层/第一展厅/明清木具/明朝藤椅/
    public function exhibitNarrate($path){
        echo getBase().urlencode(mb_convert_encoding($path."解说音频.mp3",'gb2312','utf-8' ));
    }

    //http://localhost:89/Museum/Home/Exhibit/exhibitComment?path=展馆展品数据资料/展品信息/第一层/第一展厅/明清木具/明朝藤椅/
    public function exhibitComment($path){
        echo getBase().urlencode(mb_convert_encoding($path."解说词.txt",'gb2312','utf-8' ));
    }
}