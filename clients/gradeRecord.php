<?php
/**
 * 
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class gradeRecord {
	/** 
	* @var  string
	*/
	public $error;
	/** 
	* @var  string
	*/
	public $courseid;
	/** 
	* @var  float
	*/
	public $usergrade;
	/** 
	* @var  string
	*/
	public $str_grade;
	/** 
	* @var  string
	*/
	public $feedback;
	/* full constructor */
	 public function gradeRecord($error='',$courseid='',$usergrade=0.0,$str_grade='',$feedback=''){
		 $this->error=$error   ;
		 $this->courseid=$courseid   ;
		 $this->usergrade=$usergrade   ;
		 $this->str_grade=$str_grade   ;
		 $this->feedback=$feedback   ;
	}
	/* get accessors */
	public function getError(){
		 return $this->error;
	}

	public function getCourseid(){
		 return $this->courseid;
	}

	public function getUsergrade(){
		 return $this->usergrade;
	}

	public function getStr_grade(){
		 return $this->str_grade;
	}

	public function getFeedback(){
		 return $this->feedback;
	}

	/*set accessors */
	public function setError($error){
		$this->error=$error;
	}

	public function setCourseid($courseid){
		$this->courseid=$courseid;
	}

	public function setUsergrade($usergrade){
		$this->usergrade=$usergrade;
	}

	public function setStr_grade($str_grade){
		$this->str_grade=$str_grade;
	}

	public function setFeedback($feedback){
		$this->feedback=$feedback;
	}

}

?>
