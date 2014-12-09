<?php
namespace TOURIST\Controller;
use Think\Controller;
class CollectionController extends Controller {
    public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>[ 您现在访问的是Home模块的Index控制器 ]</div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }


    /**
     * 返回某个用户当前的收藏
     * http://localhost:8001/museum/TOURIST/Collection/getMyCollections?uid=1
     * @param unknown $uid
     * @param int $num 需要的个数
     * @return 	item_id 展品id
     * 			item_name 展品名
     * 			img_url logo文件
     * 			voice_url 音频文件
     * 			voice_time 音频时长
     * 			added_time 收藏时间
     */
    public function getMyCollections($uid, $num=null){
    	if(IS_GET) {
			$item_table = M(_TBL_ITEM_);
			$condition['rename_rel_nv_it.NV_ID_INT_FK'] = $uid;
			$condition['rename_rel_nv_it.RNI_STATE_TX_FX'] = _STATE_ACT_;
			$fields = array('IT_ID_INT_PK', 'IT_NAME_TX', 'IT_DESCRIPTION_TX', 'IT_AUDIO_PATH_TX', 'IT_MPIC_PATH_TX', 
							'RNI_CREATION_TIMESTAMP'	);
			$items = $item_table->field($fields)->join('left join rename_rel_nv_it on rename_rel_nv_it.IT_ID_INT_FK = rename_item.IT_ID_INT_PK')->
						join('left join rename_normal_visiter on rename_normal_visiter.NV_ID_INT_PK = rename_rel_nv_it.NV_ID_INT_FK')->
						where($condition)->order('RNI_CREATION_TIMESTAMP desc')->select();
			for ($i = 0; $i < count($items); $i++) {
				$base_url = getBase()._ITEM_.'ID_'.$items[$i]['IT_ID_INT_PK'].'/';
				$local_url = './Ftp/'._ITEM_.'ID_'.$items[$i]['IT_ID_INT_PK'].'/';
				$data[$i]['item_id'] = $items[$i]['IT_ID_INT_PK'];
				$data[$i]['item_name'] = $items[$i]['IT_NAME_TX'];
				$data[$i]['img_url'] = $base_url.$items[$i]['IT_MPIC_PATH_TX'];
				$data[$i]['voice_url'] = $base_url.$items[$i]['IT_AUDIO_PATH_TX'];
				$voice_file = new \Org\Util\mp3file($local_url.$items[$i]['IT_AUDIO_PATH_TX']);
				$voice_info = $voice_file->get_metadata();
				$data[$i]['voice_time'] = ($voice_info['Length'] ? $voice_info['Length']:0)*1000;
				$data[$i]['added_time'] = $items[$i]['RNI_CREATION_TIMESTAMP'];
			}
	        echo JSON($data);
    	}
    	return $data;
    }

    /**
     * 收藏一个展品
     * http://localhost:8001/museum/TOURIST/Collection/addCollection?uid=1&col_id=1
     * @param int $uid 用户ID
     * @param int $col_id 展品ID
     * @return 	1.item already in the collection list! 若已经收藏
     * 			2.item added!	若未收藏或收藏后删除
     */
    public function addCollection($uid, $col_id) {
		if(IS_GET) {
			$rel_table = M(_TBL_REL_ITEM_VISITER);
			$condition['NV_ID_INT_FK'] = $uid;
			$condition['IT_ID_INT_FK'] = $col_id;
			$condition['RNI_STATE_TX_FX'] = _STATE_ACT_;
			$exist = $rel_table->where($condition)->find();
			if ($exist != false) {
				echo 'item already in the collection list!';
				return;
			} else {
				$data = array (
						NV_ID_INT_FK => $uid,
						IT_ID_INT_FK => $col_id,
						RNI_CREATION_TIMESTAMP => date('Y-m-d H:i:s',NOW_TIME),
						RNI_STATE_TX_FX => _STATE_ACT_,
				);
				/*if the status is DEL*/
				$condition['RNI_STATE_TX_FX'] = _STATE_DEL_;
				$exist = $rel_table->where($condition)->find();
				if ($exist != false) {
					$return = $rel_table->save($data);
					if ($return == 1) {
						echo 'item added!';
						return;
					}
					
				}
				
				$return = $rel_table->add($data);
				if ($return != false) {
					echo 'item added!';
					return;
				}
				
			}
			
		}
		return $data;
    }
    
    /**
     * 删除一个收藏
     * http://localhost:8001/museum/TOURIST/Collection/removeCollection?uid=1&col_id=1
     * @param int $uid 用户ID
     * @param int $col_id 展品ID
     * @return 	1.item removed! 成功删除
     * 			2.item already removed!已经删除
     * 			3.null.从未收藏过该展品
     */
    public function removeCollection($uid, $col_id) {
    	if(IS_GET) {
    		$rel_table = M(_TBL_REL_ITEM_VISITER);
    		$condition['NV_ID_INT_FK'] = $uid;
    		$condition['IT_ID_INT_FK'] = $col_id;
    		$condition['RNI_STATE_TX_FX'] = _STATE_ACT_;
    		$exist = $rel_table->where($condition)->find();
    		if ($exist != false) {
    			$data = array (
						NV_ID_INT_FK => $uid,
						IT_ID_INT_FK => $col_id,
						RNI_CREATION_TIMESTAMP => date('Y-m-d H:i:s',NOW_TIME),
						RNI_STATE_TX_FX => _STATE_DEL_,
				);
    			$data = $rel_table->save($data);
    			if ($data == 1) {
    				echo 'item removed!';
    				return;
    			}
    		} else {
    			$condition['RNI_STATE_TX_FX'] = _STATE_DEL_;
    			$exist = $rel_table->where($condition)->find();
    			if ($exist != false) {
    				echo 'item already removed!';
    				return;
    			}
    			echo JSON($exist);
    		}
    			
    	}
    	return $data;
    }
}