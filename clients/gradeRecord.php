<?php
/**
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
	public $itemid;
	/** 
	* @var  float
	*/
	public $grade;
	/** 
	* @var  string
	*/
	public $str_grade;
	/** 
	* @var  string
	*/
	public $feedback;
	/* full constructor */
	 public function gradeRecord($error='',$itemid='',$grade=0.0,$str_grade='',$feedback=''){
		 $this->error=$error   ;
		 $this->itemid=$itemid   ;
		 $this->grade=$grade   ;
		 $this->str_grade=$str_grade   ;
		 $this->feedback=$feedback   ;
	}
	/* get accessors */
	public function getError(){
		 return $this->error;
	}

	public function getItemid(){
		 return $this->itemid;
	}

	public function getGrade(){
		 return $this->grade;
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

	public function setItemid($itemid){
		$this->itemid=$itemid;
	}

	public function setGrade($grade){
		$this->grade=$grade;
	}

	public function setStr_grade($str_grade){
		$this->str_grade=$str_grade;
	}

	public function setFeedback($feedback){
		$this->feedback=$feedback;
	}

}

?>
