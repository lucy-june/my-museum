<?php
namespace TOURIST\Controller;
use Think\Controller;
class HomeController extends Controller {
    public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>[ 您现在访问的是Home模块的Index控制器 ]</div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
	/**
	 * return all the sites found as a list
	 * @param string $province
	 * @param string $city
	 */
    public function searchSites($province=null,$city=null)  {
    	//TODO: 返回博物馆名，简介
    	$site_table = M(_TBL_VISIT_SITE_);
    	if ($province == null && $city == null) {
    		echo "error, province&city can't be both null";
    		return;
    	}
    	if ($province != null) {
    		$condition['VS_PROVINCE_TX'] = $province;
    	}
    	if ($city != null) {
    		$condition['VS_CITY_TX'] = $city;
    	}
    	$sites = $site_table->where($condition)->select();
    	$count = count($sites);
    	for ($i = 0; $i < $nums; $i++) {
    		$temp["site_id"] = $sites[$i]["VS_ID_INT_PK"];
    		$temp["site_name"] = $sites[$i]["VS_NAME_TX"];
    		$temp["site_pics"] = explode("$", $sites[$i]["VS_PIC_PATH_TX"]);
    		$temp["base_url"] = getBase()._ACTIVITIES_.'/'.'ID_'.$temp["act_id"].'/';
    		$result[$i] = $temp;
    	}
    }
    
}