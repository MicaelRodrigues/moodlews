<?php
/**
 * 
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class editWikisInput {
	/** 
	* @var  (wikiData) array of wikiDatum
	*/
	public $wikis;
	 public function editWikisInput() {
		 $this->wikis=array();
	}
	/* get accessors */
	public function getWikis(){
		 return $this->wikis;
	}

	/*set accessors */
	public function setWikis($wikis){
		$this->wikis=$wikis;
	}

}

?>
