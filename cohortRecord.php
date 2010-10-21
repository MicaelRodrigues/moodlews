<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class cohortRecord {
	/** 
	* @var string
	*/
	public $error;
	/** 
	* @var integer
	*/
	public $id;
	/** 
	* @var integer
	*/
	public $contextid;
	/** 
	* @var string
	*/
	public $name;
	/** 
	* @var string
	*/
	public $description;
	/** 
	* @var string
	*/
	public $idnumber;
	/** 
	* @var string
	*/
	public $component;
	/** 
	* @var integer
	*/
	public $timecreated;
	/** 
	* @var integer
	*/
	public $timemodified;
	 public function cohortRecord() {
		 $this->error='';
		 $this->id=0;
		 $this->contextid=0;
		 $this->name='';
		 $this->description='';
		 $this->idnumber='';
		 $this->component='';
		 $this->timecreated=0;
		 $this->timemodified=0;
	}
	/* get accessors */
	public function getError(){
		 return $this->error;
	}

	public function getId(){
		 return $this->id;
	}

	public function getContextid(){
		 return $this->contextid;
	}

	public function getName(){
		 return $this->name;
	}

	public function getDescription(){
		 return $this->description;
	}

	public function getIdnumber(){
		 return $this->idnumber;
	}

	public function getComponent(){
		 return $this->component;
	}

	public function getTimecreated(){
		 return $this->timecreated;
	}

	public function getTimemodified(){
		 return $this->timemodified;
	}

	/*set accessors */
	public function setError($error){
		$this->error=$error;
	}

	public function setId($id){
		$this->id=$id;
	}

	public function setContextid($contextid){
		$this->contextid=$contextid;
	}

	public function setName($name){
		$this->name=$name;
	}

	public function setDescription($description){
		$this->description=$description;
	}

	public function setIdnumber($idnumber){
		$this->idnumber=$idnumber;
	}

	public function setComponent($component){
		$this->component=$component;
	}

	public function setTimecreated($timecreated){
		$this->timecreated=$timecreated;
	}

	public function setTimemodified($timemodified){
		$this->timemodified=$timemodified;
	}

}

?>
