<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class eventRecord {
	/** 
	* @var string
	*/
	public $error;
	/** 
	* @var integer
	*/
	public $id;
	/** 
	* @var string
	*/
	public $name;
	/** 
	* @var string
	*/
	public $description;
	/** 
	* @var integer
	*/
	public $format;
	/** 
	* @var integer
	*/
	public $courseid;
	/** 
	* @var integer
	*/
	public $groupid;
	/** 
	* @var integer
	*/
	public $userid;
	/** 
	* @var integer
	*/
	public $repeatid;
	/** 
	* @var string
	*/
	public $modulename;
	/** 
	* @var integer
	*/
	public $instance;
	/** 
	* @var string
	*/
	public $eventtype;
	/** 
	* @var integer
	*/
	public $timestart;
	/** 
	* @var integer
	*/
	public $timeduration;
	/** 
	* @var integer
	*/
	public $visible;
	/** 
	* @var string
	*/
	public $uuid;
	/** 
	* @var integer
	*/
	public $sequence;
	/** 
	* @var integer
	*/
	public $timemodified;

	/**
	* default constructor for class eventRecord
	* @return eventRecord
	*/	 public function eventRecord() {
		 $this->error='';
		 $this->id=0;
		 $this->name='';
		 $this->description='';
		 $this->format=0;
		 $this->courseid=0;
		 $this->groupid=0;
		 $this->userid=0;
		 $this->repeatid=0;
		 $this->modulename='';
		 $this->instance=0;
		 $this->eventtype='';
		 $this->timestart=0;
		 $this->timeduration=0;
		 $this->visible=0;
		 $this->uuid='';
		 $this->sequence=0;
		 $this->timemodified=0;
	}
	/* get accessors */

	/**
	* @return string
	*/
	public function getError(){
		 return $this->error;
	}


	/**
	* @return integer
	*/
	public function getId(){
		 return $this->id;
	}


	/**
	* @return string
	*/
	public function getName(){
		 return $this->name;
	}


	/**
	* @return string
	*/
	public function getDescription(){
		 return $this->description;
	}


	/**
	* @return integer
	*/
	public function getFormat(){
		 return $this->format;
	}


	/**
	* @return integer
	*/
	public function getCourseid(){
		 return $this->courseid;
	}


	/**
	* @return integer
	*/
	public function getGroupid(){
		 return $this->groupid;
	}


	/**
	* @return integer
	*/
	public function getUserid(){
		 return $this->userid;
	}


	/**
	* @return integer
	*/
	public function getRepeatid(){
		 return $this->repeatid;
	}


	/**
	* @return string
	*/
	public function getModulename(){
		 return $this->modulename;
	}


	/**
	* @return integer
	*/
	public function getInstance(){
		 return $this->instance;
	}


	/**
	* @return string
	*/
	public function getEventtype(){
		 return $this->eventtype;
	}


	/**
	* @return integer
	*/
	public function getTimestart(){
		 return $this->timestart;
	}


	/**
	* @return integer
	*/
	public function getTimeduration(){
		 return $this->timeduration;
	}


	/**
	* @return integer
	*/
	public function getVisible(){
		 return $this->visible;
	}


	/**
	* @return string
	*/
	public function getUuid(){
		 return $this->uuid;
	}


	/**
	* @return integer
	*/
	public function getSequence(){
		 return $this->sequence;
	}


	/**
	* @return integer
	*/
	public function getTimemodified(){
		 return $this->timemodified;
	}

	/*set accessors */

	/**
	* @param string $error
	* @return void
	*/
	public function setError($error){
		$this->error=$error;
	}


	/**
	* @param integer $id
	* @return void
	*/
	public function setId($id){
		$this->id=$id;
	}


	/**
	* @param string $name
	* @return void
	*/
	public function setName($name){
		$this->name=$name;
	}


	/**
	* @param string $description
	* @return void
	*/
	public function setDescription($description){
		$this->description=$description;
	}


	/**
	* @param integer $format
	* @return void
	*/
	public function setFormat($format){
		$this->format=$format;
	}


	/**
	* @param integer $courseid
	* @return void
	*/
	public function setCourseid($courseid){
		$this->courseid=$courseid;
	}


	/**
	* @param integer $groupid
	* @return void
	*/
	public function setGroupid($groupid){
		$this->groupid=$groupid;
	}


	/**
	* @param integer $userid
	* @return void
	*/
	public function setUserid($userid){
		$this->userid=$userid;
	}


	/**
	* @param integer $repeatid
	* @return void
	*/
	public function setRepeatid($repeatid){
		$this->repeatid=$repeatid;
	}


	/**
	* @param string $modulename
	* @return void
	*/
	public function setModulename($modulename){
		$this->modulename=$modulename;
	}


	/**
	* @param integer $instance
	* @return void
	*/
	public function setInstance($instance){
		$this->instance=$instance;
	}


	/**
	* @param string $eventtype
	* @return void
	*/
	public function setEventtype($eventtype){
		$this->eventtype=$eventtype;
	}


	/**
	* @param integer $timestart
	* @return void
	*/
	public function setTimestart($timestart){
		$this->timestart=$timestart;
	}


	/**
	* @param integer $timeduration
	* @return void
	*/
	public function setTimeduration($timeduration){
		$this->timeduration=$timeduration;
	}


	/**
	* @param integer $visible
	* @return void
	*/
	public function setVisible($visible){
		$this->visible=$visible;
	}


	/**
	* @param string $uuid
	* @return void
	*/
	public function setUuid($uuid){
		$this->uuid=$uuid;
	}


	/**
	* @param integer $sequence
	* @return void
	*/
	public function setSequence($sequence){
		$this->sequence=$sequence;
	}


	/**
	* @param integer $timemodified
	* @return void
	*/
	public function setTimemodified($timemodified){
		$this->timemodified=$timemodified;
	}

}

?>
