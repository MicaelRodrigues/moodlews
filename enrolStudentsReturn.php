<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class enrolStudentsReturn {
	/** 
	* @var  (enrolRecords) array of enrolRecord
	*/
	public $students;
	 public function enrolStudentsReturn() {
		 $this->students=array();
	}
	/* get accessors */
	public function getStudents(){
		 return $this->students;
	}

	/*set accessors */
	public function setStudents($students){
		$this->students=$students;
	}

}

?>
