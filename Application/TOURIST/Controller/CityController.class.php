<?php
namespace TOURIST\Controller;
use Think\Controller;
class CityController extends Controller {
	public function index(){
		$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>[ 您现在访问的是Home模块的Index控制器 ]</div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
	}
	
	
	/**
	 * 检索当前所有的省份
	 * localhost:8001/museum/index.php/TOURIST/City/getProvinces
	 * @return province_id int 省份ID，用于检索城市
	 * 		   province_name String 省份名称	
	 */
	public function getProvinces(){
		
		$city_table = M(_TBL_CITY_);
		$condition['PC_PARENT_ID_INT_FK'] = array('exp','is NULL');
		$provinces = $city_table->where($condition)->select();
		for( $i=0; $i < count($provinces); $i++) {
			$data[$i]['province_id'] = $provinces[$i]['PC_ID_INT_PK'];
			$data[$i]['province_name'] = $provinces[$i]['PC_NAME_TX'];
		}
		
		echo JSON($data);
	}
	
	/**
	 * 查找某一省份的所有城市
	 * localhost:8001/museum/index.php/TOURIST/City/getCities?province_id=1
	 * @param unknown $province_id: 省份ID
	 * @return city_id int 城市ID
	 * 		   city_name String 城市名称 
	 */
	public function getCities($province_id) {
		$city_table = M(_TBL_CITY_);
		$condition['PC_PARENT_ID_INT_FK'] = $province_id;
		$cities = $city_table->where($condition)->select();
		for( $i=0; $i < count($cities); $i++) {
			$data[$i]['city_id'] = $cities[$i]['PC_ID_INT_PK'];
			$data[$i]['city_name'] = $cities[$i]['PC_NAME_TX'];
		}
		echo JSON($data);
		
	} 
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}