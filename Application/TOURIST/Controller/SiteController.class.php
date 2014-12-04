<?php
namespace TOURIST\Controller;
use Think\Controller;
class SiteController extends Controller {
    public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>[ 您现在访问的是Home模块的Index控制器 ]</div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }

    /**
     * 返回博物馆简略信息(开放时间, 门票, 地址, 简介)
     * http://localhost:8001/Museum/index.php/TOURIST/Site/siteDetails?site_id=1
     * @param int site_id: 场馆ID
     * */
    public function siteDetails($site_id){
    	if(IS_GET) {
    		$site_table = M(_TBL_VISIT_SITE_);
    		$condition['VS_ID_INT_PK'] = $site_id;
    		$site = $site_table->where($condition)->find();
    		
    		$data['site_open_time'] = $site['VS_OPEN_TIME_TX'];
    		$data['site_price'] = $site['VS_PRICE_TX'];
    		$data['site_address'] = $site['VS_ADDRESS_TX'];
    		$data['site_introduction'] = $site['VS_DESCRIPTION_TX'];
    		echo JSON($data);
    	}
    	return JSON($data);
    }
    


    /**
     * 返回博物馆简略信息+活动信息(开放时间, 门票, 地址, 简介，活动信息)
     * http://localhost:8001/Museum/index.php/TOURIST/Site/siteDetails?site_id=1
     * @param int site_id: 场馆ID
     * */
    public function siteDetailsFull($site_id){
        if(IS_GET) {
            $site_table = M(_TBL_VISIT_SITE_);
            $condition['VS_ID_INT_PK'] = $site_id;
            $site = $site_table->where($condition)->find();
            
            $data['site_open_time'] = $site['VS_OPEN_TIME_TX'];
            $data['site_price'] = $site['VS_PRICE_TX'];
            $data['site_address'] = $site['VS_ADDRESS_TX'];
            $data['site_introduction'] = $site['VS_DESCRIPTION_TX'];
            /*get activities*/
            $activity_table = M('activity_event');
            $condition_activities['AE_VS_ID_INT_FK'] = $site_id;
            $condition_activities['AE_STATE_TX_FX'] = 'NST';
            $activities = $activity_table->field($field)->where($condition_activities)->order('AE_TIME_START_TIMESTAMP desc')->select();
            for ($i = 0; $i < count($activities); $i++) {
                 
                $temp["act_id"] = $activities[$i]["AE_ID_INT_PK"];
                $temp["act_name"] = $activities[$i]["AE_NAME_TX"];
                $base_url = getBase()._ACTIVITIES_.'ID_'.$temp["act_id"].'/';
                $temp["act_pics"] = explode("$", $activities[$i]["AE_PIC_PATH_TX"]);
                arrayPreSufix($temp["act_pics"], $base_url, null);
                
                $result[$i] = $temp;
            }

            $data['site_activities'] = $result;

            echo JSON($data);
        }
        return JSON($data);
    }
    


    
    //http://localhost:8001/museum/index.php/TOURIST/Site/scrollImgs?vs_id=1
    public function scrollImgs($vs_id){
    	if(IS_GET) {
    		//TODO:返回展品图，名称，id
    		$base_url =getServer().'SITE/ID_'.$vs_id;
    		$condition['VS_ID_INT_PK'] = $vs_id;
    		$site = findInTable(_TBL_VISIT_SITE_,$condition);
    		$imgs = explode("$",$site['VS_PIC_PATH_TX']);
    		$result['base_url'] = $base_url.'/';
    		$result['imgs_array'] = $imgs;
    		echo JSON($result);
    	}
    	return JSON($result);
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