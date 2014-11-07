<?php
namespace TOURIST\Controller;
use Think\Controller;
class ActivityController extends Controller {
	public function index(){
		$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>[ 您现在访问的是Home模块的Index控制器 ]</div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
	}
	/**
	 * get activities, events
	 * localhost:8001/museum/index.php/TOURIST/Activity/getActivities?vs_id=1
	 * @param unknown $vs_id
	 * @param string $state
	 * @param string $nums
	 * 
	 */
	public function getActivities($vs_id, $state=null,$nums=null) {
		$activity_table = M('activity_event');
		$condition['AE_VS_ID_INT_FK'] = $vs_id;
 		if ($state != null ) {
			$condition['AE_STATE_TX_FX'] = $state;
 		}
		$activities = $activity_table->where($condition)->select();
		$count = count($activities);
		if ($nums != null) {
			$nums = min($nums, $count);
		} else {
			$nums = $count;
		}
 		for ($i = 0; $i < $nums; $i++) {
 			$temp["act_id"] = $activities[$i]["AE_ID_INT_PK"];
 			$temp["act_name"] = $activities[$i]["AE_NAME_TX"];
 			$temp["act_pics"] = explode("$", $activities[$i]["AE_PIC_PATH_TX"]);
 			$temp["act_base_url"] = getBase()._ACTIVITIES_.'/'.'ID_'.$temp["act_id"].'/';
 			$result[$i] = $temp;
 		}
		
		
		echo JSON($result);
	}
	
	/**
	 * get details of one activity
	 * localhost:8001/museum/index.php/TOURIST/Activity/getActivityDetails?activity_id=1
	 * @param unknown $activity_id	: the id of the activity
	 */
	public function getActivityDetails($activity_id) {
		if(IS_GET) {
			$condition['AE_ID_INT_PK'] = $activity_id;
			$result = findInTable(_TBL_ACTIVITY_, $condition);
			$data["name"] = $result["AE_NAME_TX"];
			$data["description"] = $result['AE_DESCRIPTION_TX'];
			$data["content"] = $result['AE_CONTENT_TX'];
			$data["pics"] = explode("$", $result['AE_PIC_PATH_TX']);
			$data["start_date"] = $result['AE_TIME_START_TIMESTAMP'];
			$data["end_date"] = $result['AE_TIME_FINISH_TIMESTAMP'];
			$data["status"] = $result['AE_STATE_TX_FX'];
			$data["base_url"] = getBase()._ACTIVITIES_.'/'.'ID_'.$activity_id;
			echo JSON($data);
		}
		return;
	}
	
	
	
}
?>