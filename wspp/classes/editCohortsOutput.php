<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class editCohortsOutput {
	/** 
	* @var cohortRecord[]
	*/
	public $cohorts;

	/**
	* default constructor for class editCohortsOutput
	* @return editCohortsOutput
	*/	 public function editCohortsOutput() {
		 $this->cohorts=array();
	}
	/* get accessors */

	/**
	* @return cohortRecord[]
	*/
	public function getCohorts(){
		 return $this->cohorts;
	}

	/*set accessors */

	/**
	* @param cohortRecord[] $cohorts
	* @return void
	*/
	public function setCohorts($cohorts){
		$this->cohorts=$cohorts;
	}

}

?>
