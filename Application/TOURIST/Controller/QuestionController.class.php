<?php
namespace TOURIST\Controller;
use Think\Controller;
class QuestionController extends Controller {
	public function index(){
		$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>[ 您现在访问的是Home模块的Index控制器 ]</div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
	}
	
	/**
	 * 返回所有场馆问题
	 * http://localhost:8001/Museum/index.php/TOURIST/question/getSiteQuestions?site_id=1
	 * @param unknown $site_id int, 场馆ID 
	 * @param string $num
	 * @return 	q_content String 问题内容
	 * 		   	q_choiceA String 选项A
	 *		   	q_choiceB String 选项B
	 * 			q_choiceC String 选项C
	 * 			q_choiceD String 选项D
	 * 			q_answer  String 正确答案
	 * 			q_point   int    分数
	 */
	public function getSiteQuestions($site_id, $num=null) {
		/*当前先写死*/
		$num = 5;
		if(IS_GET) {
			$site_question_table = M(_TBL_SITE_QUESTION_);
			$condition['SQ_VS_ID_INT_FK'] = $site_id;
			$questions = $site_question_table->where($condition)->limit($num)->select();
			for ($i = 0; $i < count($questions); $i++) {
				$data[$i]['q_content'] = $questions[$i]['SQ_QUESTION_CONTENT_TX'];
				$data[$i]['q_choiceA'] = $questions[$i]['SQ_CHOICE_A_TX'];
				$data[$i]['q_choiceB'] = $questions[$i]['SQ_CHOICE_B_TX'];
				$data[$i]['q_choiceC'] = $questions[$i]['SQ_CHOICE_C_TX'];
				$data[$i]['q_choiceD'] = $questions[$i]['SQ_CHOICE_D_TX'];
				$data[$i]['q_answer'] = $questions[$i]['SQ_ANSWER_TX'];
				$data[$i]['q_point'] = $questions[$i]['SQ_POINT_INT'];
			}
			echo JSON($data);
			
		}
		return $data;
		
	}
	/**
	 * 返回反馈问题列表
	 * http://localhost:8001/Museum/index.php/TOURIST/question/getFeedbackQuesetions
	 * @param unknown $num int 问题个数
	 * @return 	q_content String 问题内容
	 * 		   	q_choiceA String 选项A
	 *		   	q_choiceB String 选项B
	 * 			q_choiceC String 选项C
	 * 			q_choiceD String 选项D
	 * 			q_point   int    分数
	 */
	public function getFeedbackQuesetions($num=null) {
		$num = 3;
		if(IS_GET) {
			$site_question_table = M(_TBL_FEEDBACK_QUESTION_);
			$questions = $site_question_table->limit($num)->select();
			for ($i = 0; $i < count($questions); $i++) {
				$data[$i]['q_content'] = $questions[$i]['FQ_QUESTION_CONTENT_TX'];
				$data[$i]['q_choiceA'] = $questions[$i]['FQ_CHOICE_A_TX'];
				$data[$i]['q_choiceB'] = $questions[$i]['FQ_CHOICE_B_TX'];
				$data[$i]['q_choiceC'] = $questions[$i]['FQ_CHOICE_C_TX'];
				$data[$i]['q_choiceD'] = $questions[$i]['FQ_CHOICE_D_TX'];
				$data[$i]['q_point'] = $questions[$i]['FQ_POINT_INT'];
			}
			echo JSON($data);
			
		}
		return $data;
	}
}