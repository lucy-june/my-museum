<?php
namespace TOURIST\Controller;
use Think\Controller;
class RegionController extends Controller {
    public function index(){
        $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>[ 您现在访问的是Home模块的Index控制器 ]</div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
    
	/**
	 * 返回场馆结构分布 , children为空表示为其为最底层
	 * 返回的是一棵树
	 * 节点(名称, 第几层, 节点ID, 子节点)
	 * http://localhost:8001/Museum/index.php/TOURIST/Region/regionTree?site_id=1
	 * @param int $site_id the site id
	 */
    public function regionTree($site_id) {
    	if(IS_GET) {
	    	$tree_table = M(_TBL_SITE_TREE_);
	    	$condition['ST_VS_ID_INT_FK'] = $site_id;
	    	$condition['ST_PARENT_ID_INT_FK'] = array('exp','is NULL');
	    	$roots = $tree_table->where($condition)->select();
	    	for ($i = 0; $i<count($roots); $i++) {
	    		$data[$i]['level_name'] = $roots[$i]['ST_TYPE_TX_FX'];
	    		$data[$i]['level_count'] = 0;
	    		$data[$i]['level_id'] = $roots[$i]['ST_ID_INT_PK'];
	    		$data[$i]['children'] = null;
	    		$this->findRecursiveChildren($data[$i]);
	    	}
	    	echo JSON($data);
    	}
    }
    
    /**
     * 返回某一节点全部信息(名称, 父节点ID, 子节点ID)
     * http://localhost:8001/Museum/index.php/TOURIST/Region/regionDetails?region_id=4
     * @param unknown $region_id:	节点ID
     * @return string
     */
    public function regionDetails($region_id) {
    	if(IS_GET) {
	    	$tree_table = M(_TBL_SITE_TREE_);
	    	$condition['ST_ID_INT_PK'] = $region_id; 
	    	$node = $tree_table->where($condition)->find();
	    	$condition_children['ST_PARENT_ID_INT_FK'] = $region_id;
	    	$children = $tree_table->field('ST_ID_INT_PK')->where($condition_children)->select();
	    	$data['node_name'] = $node['ST_TYPE_TX_FX'];
	    	$data['node_parent_id'] = $node['ST_PARENT_ID_INT_FK'];
	    	$children_id = array();
	    	foreach ($children as $child) {
	    		$children_id[count($children_id)] = $child['ST_ID_INT_PK'];
	    	}
	    	$data['children'] = $children_id;
	    	echo JSON($data);
    	}
    	
    }
    /**
     * the recursive function for completing the structure tree
     * @param unknown $tree_node : the tree_node
     */
    private function findRecursiveChildren(& $tree_node) {
    	$tree_table = M(_TBL_SITE_TREE_);
    	$condition['ST_PARENT_ID_INT_FK'] = $tree_node['level_id'];
    	$children = $tree_table->where($condition)->select();
    	if (!$children) {
    		return;
    	} else {
    		for ($i = 0; $i<count($children); $i++) {
    			$data[$i]['level_name'] = $children[$i]['ST_TYPE_TX_FX'];
    			$data[$i]['level_count'] = $tree_node['level_count'] + 1;
    			$data[$i]['level_id'] = $children[$i]['ST_ID_INT_PK'];
    			$data[$i]['children'] = null;
    			$this->findRecursiveChildren($data[$i]);
    		}
    	}
    	$tree_node['children'] = $data;
    	return;
    }
    
    
    

}