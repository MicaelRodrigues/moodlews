<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class wikiDatum {
	/** 
	* @var string
	*/
	public $action;
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
	public $summary;
	/** 
	* @var string
	*/
	public $wtype;
	/** 
	* @var integer
	*/
	public $ewikiacceptbinary;
	/** 
	* @var integer
	*/
	public $course;
	/** 
	* @var string
	*/
	public $pagename;
	/** 
	* @var integer
	*/
	public $ewikiprinttitle;
	/** 
	* @var integer
	*/
	public $htmlmode;
	/** 
	* @var integer
	*/
	public $disablecamelcase;
	/** 
	* @var integer
	*/
	public $setpageflags;
	/** 
	* @var integer
	*/
	public $strippages;
	/** 
	* @var integer
	*/
	public $removepages;
	/** 
	* @var integer
	*/
	public $revertchanges;
	/** 
	* @var string
	*/
	public $initialcontent;
	/** 
	* @var integer
	*/
	public $timemodified;

	/**
	* default constructor for class wikiDatum
	* @return wikiDatum
	*/	 public function wikiDatum() {
		 $this->action='';
		 $this->id=0;
		 $this->name='';
		 $this->summary='';
		 $this->wtype='';
		 $this->ewikiacceptbinary=0;
		 $this->course=0;
		 $this->pagename='';
		 $this->ewikiprinttitle=0;
		 $this->htmlmode=0;
		 $this->disablecamelcase=0;
		 $this->setpageflags=0;
		 $this->strippages=0;
		 $this->removepages=0;
		 $this->revertchanges=0;
		 $this->initialcontent='';
		 $this->timemodified=0;
	}
	/* get accessors */

	/**
	* @return string
	*/
	public function getAction(){
		 return $this->action;
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
	public function getSummary(){
		 return $this->summary;
	}


	/**
	* @return string
	*/
	public function getWtype(){
		 return $this->wtype;
	}


	/**
	* @return integer
	*/
	public function getEwikiacceptbinary(){
		 return $this->ewikiacceptbinary;
	}


	/**
	* @return integer
	*/
	public function getCourse(){
		 return $this->course;
	}


	/**
	* @return string
	*/
	public function getPagename(){
		 return $this->pagename;
	}


	/**
	* @return integer
	*/
	public function getEwikiprinttitle(){
		 return $this->ewikiprinttitle;
	}


	/**
	* @return integer
	*/
	public function getHtmlmode(){
		 return $this->htmlmode;
	}


	/**
	* @return integer
	*/
	public function getDisablecamelcase(){
		 return $this->disablecamelcase;
	}


	/**
	* @return integer
	*/
	public function getSetpageflags(){
		 return $this->setpageflags;
	}


	/**
	* @return integer
	*/
	public function getStrippages(){
		 return $this->strippages;
	}


	/**
	* @return integer
	*/
	public function getRemovepages(){
		 return $this->removepages;
	}


	/**
	* @return integer
	*/
	public function getRevertchanges(){
		 return $this->revertchanges;
	}


	/**
	* @return string
	*/
	public function getInitialcontent(){
		 return $this->initialcontent;
	}


	/**
	* @return integer
	*/
	public function getTimemodified(){
		 return $this->timemodified;
	}

	/*set accessors */

	/**
	* @param string $action
	* @return void
	*/
	public function setAction($action){
		$this->action=$action;
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
	* @param string $summary
	* @return void
	*/
	public function setSummary($summary){
		$this->summary=$summary;
	}


	/**
	* @param string $wtype
	* @return void
	*/
	public function setWtype($wtype){
		$this->wtype=$wtype;
	}


	/**
	* @param integer $ewikiacceptbinary
	* @return void
	*/
	public function setEwikiacceptbinary($ewikiacceptbinary){
		$this->ewikiacceptbinary=$ewikiacceptbinary;
	}


	/**
	* @param integer $course
	* @return void
	*/
	public function setCourse($course){
		$this->course=$course;
	}


	/**
	* @param string $pagename
	* @return void
	*/
	public function setPagename($pagename){
		$this->pagename=$pagename;
	}


	/**
	* @param integer $ewikiprinttitle
	* @return void
	*/
	public function setEwikiprinttitle($ewikiprinttitle){
		$this->ewikiprinttitle=$ewikiprinttitle;
	}


	/**
	* @param integer $htmlmode
	* @return void
	*/
	public function setHtmlmode($htmlmode){
		$this->htmlmode=$htmlmode;
	}


	/**
	* @param integer $disablecamelcase
	* @return void
	*/
	public function setDisablecamelcase($disablecamelcase){
		$this->disablecamelcase=$disablecamelcase;
	}


	/**
	* @param integer $setpageflags
	* @return void
	*/
	public function setSetpageflags($setpageflags){
		$this->setpageflags=$setpageflags;
	}


	/**
	* @param integer $strippages
	* @return void
	*/
	public function setStrippages($strippages){
		$this->strippages=$strippages;
	}


	/**
	* @param integer $removepages
	* @return void
	*/
	public function setRemovepages($removepages){
		$this->removepages=$removepages;
	}


	/**
	* @param integer $revertchanges
	* @return void
	*/
	public function setRevertchanges($revertchanges){
		$this->revertchanges=$revertchanges;
	}


	/**
	* @param string $initialcontent
	* @return void
	*/
	public function setInitialcontent($initialcontent){
		$this->initialcontent=$initialcontent;
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
