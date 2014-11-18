<?php
namespace TOURIST\Controller;
use Think\Controller;
class HomeController extends Controller {
    public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>[ 您现在访问的是Home模块的Index控制器 ]</div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
	/**
	 * 返回场馆搜索结果列表(ID,场馆名称,场馆图片)
	 * http://localhost:8001/Museum/index.php/TOURIST/Home/searchSites?province=上海市&city=上海市
	 * @param string $province:	省份
	 * @param string $city:	城市（两者不能同时为空）
	 * @return 返回场馆列表，场馆图片，简介
	 */
    public function searchSites($province=null,$city=null)  {
    	if(IS_GET){
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
	    	for ($i = 0; $i < $count; $i++) {
	    		$temp["site_id"] = $sites[$i]["VS_ID_INT_PK"];
	    		$base_url = getBase()._SITE_.'/'.'ID_'.$temp["site_id"].'/';
	    		$temp["site_name"] = $sites[$i]["VS_NAME_TX"];
	    		$temp["site_pics"] = explode("$", $sites[$i]["VS_PIC_PATH_TX"]);
	    		arrayPreSufix($temp["site_pics"], $base_url, null);
	    		$temp["site_logo"] = $base_url.$sites[$i]["VS_LOGO_PATH_TX"];
	    		$result[$i] = $temp;
	    	}
	    	echo JSON($result);
    	}
    }
    
}