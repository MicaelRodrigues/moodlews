<?php
/**
 * 
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class getGradesReturn {
	/** 
	* @var  (gradeRecords) array of gradeRecord
	*/
	public $grades;
	/* full constructor */
	 public function getGradesReturn($grades=array()){
		 $this->grades=$grades   ;
	}
	/* get accessors */
	public function getGrades(){
		 return $this->grades;
	}

	/*set accessors */
	public function setGrades($grades){
		$this->grades=$grades;
	}

}

?>
