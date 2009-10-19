<?php
/**
 * 
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class groupRecord {
	/** 
	* @var  string
	*/
	public $error;
	/** 
	* @var  integer
	*/
	public $id;
	/** 
	* @var  integer
	*/
	public $courseid;
	/** 
	* @var  string
	*/
	public $name;
	/** 
	* @var  string
	*/
	public $description;
	/** 
	* @var  string
	*/
	public $lang;
	/** 
	* @var  string
	*/
	public $theme;
	/** 
	* @var  integer
	*/
	public $picture;
	/** 
	* @var  integer
	*/
	public $hidepicture;
	/** 
	* @var  integer
	*/
	public $timecreated;
	/** 
	* @var  integer
	*/
	public $timemodified;
	/** 
	* @var  string
	*/
	public $enrolmentkey;
	/* full constructor */
	 public function groupRecord($error='',$id=0,$courseid=0,$name='',$description='',$lang='',$theme='',$picture=0,$hidepicture=0,$timecreated=0,$timemodified=0,$enrolmentkey=''){
		 $this->error=$error   ;
		 $this->id=$id   ;
		 $this->courseid=$courseid   ;
		 $this->name=$name   ;
		 $this->description=$description   ;
		 $this->lang=$lang   ;
		 $this->theme=$theme   ;
		 $this->picture=$picture   ;
		 $this->hidepicture=$hidepicture   ;
		 $this->timecreated=$timecreated   ;
		 $this->timemodified=$timemodified   ;
		 $this->enrolmentkey=$enrolmentkey   ;
	}
	/* get accessors */
	public function getError(){
		 return $this->error;
	}

	public function getId(){
		 return $this->id;
	}

	public function getCourseid(){
		 return $this->courseid;
	}

	public function getName(){
		 return $this->name;
	}

	public function getDescription(){
		 return $this->description;
	}

	public function getLang(){
		 return $this->lang;
	}

	public function getTheme(){
		 return $this->theme;
	}

	public function getPicture(){
		 return $this->picture;
	}

	public function getHidepicture(){
		 return $this->hidepicture;
	}

	public function getTimecreated(){
		 return $this->timecreated;
	}

	public function getTimemodified(){
		 return $this->timemodified;
	}

	public function getEnrolmentkey(){
		 return $this->enrolmentkey;
	}

	/*set accessors */
	public function setError($error){
		$this->error=$error;
	}

	public function setId($id){
		$this->id=$id;
	}

	public function setCourseid($courseid){
		$this->courseid=$courseid;
	}

	public function setName($name){
		$this->name=$name;
	}

	public function setDescription($description){
		$this->description=$description;
	}

	public function setLang($lang){
		$this->lang=$lang;
	}

	public function setTheme($theme){
		$this->theme=$theme;
	}

	public function setPicture($picture){
		$this->picture=$picture;
	}

	public function setHidepicture($hidepicture){
		$this->hidepicture=$hidepicture;
	}

	public function setTimecreated($timecreated){
		$this->timecreated=$timecreated;
	}

	public function setTimemodified($timemodified){
		$this->timemodified=$timemodified;
	}

	public function setEnrolmentkey($enrolmentkey){
		$this->enrolmentkey=$enrolmentkey;
	}

}

?>
