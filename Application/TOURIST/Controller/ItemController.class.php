<?php
namespace TOURIST\Controller;
use Think\Controller;
class ItemController extends Controller {
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
    
    /**
     * 返回从某一层次开始的所有展品列表(名称,简介,缩略图)
     * tree_id为空时，搜索展馆全部展品
     * tree_id非空时，搜索tree node以下的所有展品
     * localhost:8001/museum/index.php/TOURIST/Item/getItems?site_id=1&tree_id=1
     * @param $site_id:场馆ID
     * @param $tree_id:树节点ID(层次),null表示搜索场馆全部item
     */
    public function getItems($site_id=null,$tree_id=null) {
    	//TODO:返回展品命，备注，图片
    	if($site_id == null && $tree_id == null) {
    		echo 'site_id&tree_id can\'t be both null!';
    		return;
    	}
    	if($site_id != null && $tree_id == null) {
    		$tree_table = M(_TBL_SITE_TREE_);
    		$condition['ST_VS_ID_INT_FK'] = $site_id;
	    	$condition['ST_PARENT_ID_INT_FK'] = array('exp','is NULL');
	    	$roots = $tree_table->field('ST_ID_INT_PK')->where($condition)->select();
	    	$result = array();
	    	foreach ($roots as $root) {
	    		$temp = $this->getAllNodes($root['ST_ID_INT_PK']);
	    		$result = array_merge($result, $temp);
	    	}
	    	$to_search = array_values(array_unique($result));
    	}
    	
    	if ($tree_id != null) {
    		$to_search = $this->getAllNodes($tree_id);
    	}
		
    	
    	$item_table = M(_TBL_ITEM_);
    	$condition_item['IT_ST_ID_INT_FK'] = array('IN',$to_search);
    	$items = $item_table->field(array('IT_ID_INT_PK','IT_NAME_TX','IT_DESCRIPTION_TX','IT_MPIC_PATH_TX','IT_AUDIO_PATH_TX'
    	,'IT_LYRICS_PATH_TX'))->
    		where($condition_item)->select();
    	for ($i = 0; $i < count($items); $i++) {
    		$base_url = getBase()._ITEM_.'ID_'.$items[$i]['IT_ID_INT_PK'].'/';
    		$local_url = './Ftp/'._ITEM_.'ID_'.$items[$i]['IT_ID_INT_PK'].'/';
    		$data[$i]['item_id'] = $items[$i]['IT_ID_INT_PK'];
    		$data[$i]['item_name'] = $items[$i]['IT_NAME_TX'];
    		$data[$i]['textType'] = $items[$i]['IT_DESCRIPTION_TX'];
    		$data[$i]['img_url'] = $base_url.$items[$i]['IT_MPIC_PATH_TX'];
    		$data[$i]['voice_url'] = $base_url.$items[$i]['IT_AUDIO_PATH_TX'];
    		$voice_file = new \Org\Util\mp3file($local_url.$items[$i]['IT_AUDIO_PATH_TX']);
    		$voice_info = $voice_file->get_metadata();
    		$data[$i]['voice_time'] = ($voice_info['Length'] ? $voice_info['Length']:0)*1000;
    		$data[$i]['lrc_url'] = $base_url.$items[$i]['IT_LYRICS_PATH_TX'];
    	}
    	echo JSON($data);
    	return ;
    	
    }
    /**
     * 返回展品详细信息(名称, 概述, 图片, 缩略图, 音频, 歌词, 详细信息, 补充信息=>以key_value的形式)
     * localhost:8001/Museum/index.php/TOURIST/Item/getItemDetails?item_id=1
     * @param unknown $item_id: 展品ID
     */
    public function getItemDetails($item_id) {
    	if(IS_GET) {
	    	$item_table = M(_TBL_ITEM_);
	    	$condition['IT_ID_INT_PK'] = $item_id;
	    	$item = $item_table->where($condition)->find();
	    	
	    	$base_url = getBase()._ITEM_.'ID_'.$item['IT_ID_INT_PK'].'/';
	    	$local_url = './Ftp/'._ITEM_.'ID_'.$item['IT_ID_INT_PK'].'/';
	    	$kv_table = M(_TBL_ITEM_KEY_VALUE_);
	    	$conditiion_kv[ITKV_IT_ID_INT_FK] = $item_id;
	    	$item_kvs = $kv_table->field(array('ITKV_KEY_TX_FX', 'ITKV_VALUE_TX'))->where($conditiion_kv)->select();
	    	
	    	$data['item_id'] = $item_id;
	    	$data['name'] = $item['IT_NAME_TX'];
	    	$data['textType'] = $item['IT_DESCRIPTION_TX'];
	    	$data['image_url'] = explode("$", $item['IT_PIC_PATH_TX']);
	    	arrayPreSufix($data['image_url'], $base_url, null);
	    	$data['logo_url'] = $base_url.$item['IT_MPIC_PATH_TX'];
	    	$data['voice_url'] = $base_url.$item['IT_AUDIO_PATH_TX'];
	    	$data['lrc_url'] = $base_url.$item['IT_LYRICS_PATH_TX'];
	    	$data['detail_author'] = $item['IT_AUTHOR_TX'];
	    	$data['detail_time'] = $item['IT_DECADE_TX'];
	    	$data['detail_shape'] = $item['IT_PHYSICS_INFO_TX'];
	    	$data['detail_content'] = $item['IT_DEATAILS_TX'];
	    	for ($i = 0; $i < count($item_kvs); $i++) {
	    		$data['key_'.$i] = $item_kvs[$i]['ITKV_KEY_TX_FX'];
	    		$data['value_'.$i] = $item_kvs[$i]['ITKV_VALUE_TX'];
	    	}
	    	echo JSON($data);
	    	}
    }

    
    /**
     * get all last nods
     * @param unknown $node_id
     * @return NULL
     */
    private function getAllNodes($node_id) {
    	$tree_node['level_id'] = $node_id;
    	static $result = array();
    	$this->findRecursiveChildren($tree_node, $result);
    	return $result;
    }
    
    /**
     * the recursive function, searching all last nodes
     * @param unknown $tree_node : the tree_node
     */
    private function findRecursiveChildren(& $tree_node, & $result) {
    	$tree_table = M(_TBL_SITE_TREE_);
    	$condition['ST_PARENT_ID_INT_FK'] = $tree_node['level_id'];
    	$children = $tree_table->field('ST_ID_INT_PK')->where($condition)->select();
    	if (!$children) {
    		$result[count($result)] = $tree_node['level_id'];
    		return;
    	} else {
    		for ($i = 0; $i<count($children); $i++) {
    			$data[$i]['level_id'] = $children[$i]['ST_ID_INT_PK'];
    			$data[$i]['children'] = null;
    			$this->findRecursiveChildren($data[$i], $result);
    		}
    	}
    	return;
    }
}