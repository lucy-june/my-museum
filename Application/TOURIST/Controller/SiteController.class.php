<?php
namespace TOURIST\Controller;
use Think\Controller;
class MuseumController extends Controller {
    public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>[ 您现在访问的是Home模块的Index控制器 ]</div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }

    /**
     * return museum information page needs
     * */
    //http://localhost:8001/Museum/index.php/TOURIST/Home/museumIntroduction?vs_id=1
    public function museumIntroduction($vs_id){
    	if(IS_GET) {
    		$site_table = M('visit_site');
    		$condition['VS_ID_INT_PK'] = $vs_id;
    		$site = $site_table->where($condition)->find();
    		 
    		$result['introduction'] = $site['VS_DESCRIPTION_TX'];
    		$result['open_time'] = $site['VS_OPEN_TIME_TX'];
    		$result['price'] = $site['VS_PRICE_TX'];
    		echo JSON($result);
    	}
    	return JSON($result);
    }
    
    public function museumEvent($vs_id,$state) {
    	 
    }
    
    
    
    //http://localhost:8001/museum/index.php/TOURIST/Home/scrollImgs?vs_id=1
    public function scrollImgs($vs_id){
    	if(IS_GET) {
    		$base_url =getServer().'SITE/ID_'.$vs_id;
    		$condition['VS_ID_INT_PK'] = $vs_id;
    		$site = selectAll('visit_site',$condition);
    		$imgs = explode("$",$site['VS_PIC_PATH_TX']);
    		$i = 0;
    		foreach ($imgs as $img) {
    			$result['img'.$i] = $base_url.'/'.$img;
    			$i++;
    		}
    		echo JSON($result);
    	}
    	return JSON($result);
    }
    
    //http://localhost:8001/museum/index.php/TOURIST/Home/getStarted
    public function getStarted(){
    	$base_url =getServer().'SITE/start.mp3';
    	echo $base_url;
    }
    
    public function test() {
    
    	//     	header("content-Type: text/html; charset=Utf-8");
    	//     	$path='展馆展品数据资料/首页信息/';
    	//     	$file='展馆详情.txt';
    	//     	$result = mb_convert_encoding($path.$file,'gb2312','utf-8');
    	// //     	echo mb_convert_encoding($result,'utf-8','gb2312');
    	// 		echo $path.$file;
    	// 		echo '<br>';
    	// 		echo $result;
    	$str = array("曹操");
    	echo JSON($str);
    }
}