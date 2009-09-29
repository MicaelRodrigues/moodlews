<?php // $Id: mdl_soapserver.class.php,v 1.5.4  2007/05/08 22:04:25 pp Exp $

/**
 * class for SOAP protocol-specific server layer. PHP 5 ONLY (may throw an exception !)
 *
 * @package Web Services
 * @version $Id: mdl_soapserver.class.php,v 1.5 2007/04/26 22:04:25 pp Exp $
 * @author Open Knowledge Technologies - http://www.oktech.ca/
 * @author Justin Filip <jfilip@oktech.ca>  v 1.4
 * @author Patrick Pollet <patrick.pollet@insa-lyon.fr> v 1.5
 */

/* rev history
*  1.5.4: made public the API calls to try the wshelper utility (www.jool.nl/webservicehelper/)
*  1.5.6 : swapped parameters of to_soap($r,$className)  for consistency with
           to_soap_array($res,$keyName,$className,$emptyMsg)
*/

    // acces to all Moodle API
    // require_once('../config.php');  NOT ANYMORE NEEDED rev 1.5.4

    // base class that performs data extraction/injection
    require_once('server.class.php');

    // list of required classes for input/output data
    require_once('MoodleWS.php');

    //define('DEBUG',true);

    if (DEBUG) ini_set('soap.wsdl_cache_enabled', '0');  // no caching by php in debug mode)


    class mdl_soapserver extends server {

    /**
     * Constructor method.
     *
     * @param none
     * @return none
     */
        function mdl_soapserver() {
        /// Necessary for processing any DB upgrades.
            parent::server();

            if (DEBUG) $this->debug_output('    Version: ' . $this->version);
            if (DEBUG) $this->debug_output('    Session Timeout: ' . $this->sessiontimeout);
        }

	/** since SOAP requires all attributes fields to be filled, even in case of error
	* this function return a "blank array", with error attribute set to $errMsg
	* className is the name of the returned class built with our wsdl2php utility against our WSDL file
        */

	function blank_array($className){
		if (class_exists($className)) {
			$res= new $className();
			return get_object_vars($res);// convert to array
		} else
			// throw a fatal exception SoapFault
			$this->error("internal error :class $className not found !");
	}


        function error_record ($className,$errMsg) {
		$res= $this->blank_array($className);
		$res['error']=$errMsg;
		return $res;
	}

	/**
	* return a SOAP ready array with filled in attributes from a Moodle object
	* or a blank array with attribute error set
	*/
        function to_soap ($res,$className) {

          //Lille : in case to_soap is made from to_soap_array
            if(!is_array($res) && !is_object($res))
            {
                $this->debug_output("LilleDebug  _mdl_soapserver.class/to_soap_ =>  Not Object and not array");
                return $this->error_record($className,$res);
            }
          //end Lille


		if (!isset($res->error) || empty($res->error)) {
			//in case server class missed some attributes ...
			$soap_res=$this->blank_array($className);
			foreach ($res as $key=>$value)
				$soap_res[$key]=$value;
			$soap_res['error']='';
			return $soap_res;
		} else
			return $this->error_record($className,$res->error);
	}


	/**
	* Convert an array of objects returned by server class to the appropriate format
	* This function should be called for all data returned to client
        * @param array of object $res , may be null
	* @param string $keyName the name used for the array key , eg 'users','groups' ... as
	*    defined in the wsdl

	* @param string $className. The PHP class of the returned  item(s). this class must exist
	* in server's working directory . To generate it, use wsdl2php utility (or mkclasses.sh script)
	* @param string $errMsg the error message to be sent if  no results found.
	* Note that every returned object should have an error attribute set by server class in case
	* it is invalid
	* In case of "fatal errors" (invalid client, not enough rights ..., $res will contains only one
	*  record with error set.
	* In case of not "fatal errrors" (such as one course among a list of course is invalid...),
	*  all "good records" should have error attribute to blank and all bads should have error
	*  attribut set to the cause of the failure.
	* @return an array of arrays
	*/

	function to_soap_array($res,$keyName,$className,$emptyMsg) {
		$return=array();
		if (!$res || ! is_array($res) || (count($res)==0))
			$return[$keyName][]=$this->error_record($className,$emptyMsg);
		else {
			foreach($res as $r) {
				$return[$keyName][] = $this->to_soap($r,$className);
			}
		}
		return $return;

	}

/**  =====  OVERRIDE SERVER METHODS NEEDING SOAP-SPECIFIC HANDLING  ======  **/


    /**
     * Edit user records (add/update/delete).
     * UNTESTED PP
     * @param int $client The client session ID.
     * @param string $sesskey The client session key.
     * @param array $users An array of user records (objects or arrays) for editing
     *                     (including opertaion to perform).
     * @return array An array of user objects.
     */
      public function edit_users($client, $sesskey, $users) {
           	$return = array();
		if ($res = parent::edit_users($client, $sesskey,$users))
                    foreach ($res as $r)
                        $return['users'][] = $this->to_soap($r,'userRecord');
                 else
                        $return['users'][]=$this->error_record('userRecord','no users');
                 return $return;
        }


    /**
     * Find and return a list of user records.
     * OK PP tested with php5 5 and python clients
     * @param int $client The client session ID.
     * @param string $sesskey The client session key.
     * @param array $userids An array of input user id values. If empty, all users are returned
     * @param string $idfield : the id field to use for searching users ('id', 'idnumber' ...)
     *    not necessarly unique ...
     * examples in Python :
     *       proxy.get_users(a,b,['astrid','pguy','toto'],'username')
     *       proxy.get_users(a,b,['alexis'],'firstname')
     *       proxy.get_users(a,b,['alexis','astrid'],'firstname')
     *       proxy.get_users(a,b,[1],'deleted')
     * @return array An array of user records.
     */
     public function get_users($client, $sesskey, $userids, $idfield = 'idnumber') {
		return $this->to_soap_array(
			parent::get_users($client, $sesskey,$userids,$idfield),
			'users',
			'userRecord',
			'no users found');
        }


    /**
     * Find Edit course records (add/update/delete).
     * UNTESTED PP
     * @param int $client The client session ID.
     * @param string $sesskey The client session key.
     * @param array $courseids An array of course records (objects or arrays) for
     *                         editing (including operation to perform).
     * @return array An array of course records.
     */
     public function edit_courses($client, $sesskey, $courses) {
            $return = array();
            if ($res = parent::edit_courses($client, $sesskey, $courses))
                    foreach ($res as $r)
                        $return['courses'][] = $this->to_soap($r,'courseRecord');
                 else
                        $return['courses'][]=$this->error_record('courseRecord','no courses');
                 return $return;
        }


    /**
     * Find and return a list of course records.
     * OK PP tested with php5 5 and python clients
     * @param int $client The client session ID.
     * @param string $sesskey The client session key.
     * @param array $courseids An array of input course id values to search for. If empty return all courses
     * @param string $idfield : the field used to identify courses
     * @return array An array of resource records.
     */
     public function get_courses($client, $sesskey, $courseids,$idfield='idnumber') {
		return $this->to_soap_array(
                        parent::get_courses($client, $sesskey,$courseids,$idfield),
                        'courses',
                        'courseRecord',
                        'no courses found');
        }



     /**
     * Find and return a list of resources within one or several courses.
     * TODO cast returned data to more specific types
     * currently return only a "generic description"
     * @param int $client The client session ID.
     * @param string $sesskey The client session key.
     * @param array $courseids An array of input course id values to search for. If empty return all ressources
     * @param string $idfield : the field used to identify courses
     * @param string $type : resource type i.e. forum, wiki, assignment ...
     * @return array An array of type records.
     */
     public function get_instances_bytype($client, $sesskey, $courseids,$idfield='idnumber',$type='resource') {
                return $this->to_soap_array(
                        parent::get_instances_bytype($client, $sesskey,$courseids,$idfield,$type),
                        'resources',
                        'resourceRecord',
                        'no resources of type '.$type.' found');
        }

     /**
     * Find and return a list of activities within one or several courses.
     * OK PP tested with php5 5 and python clients
     * @param int $client The client session ID.
     * @param string $sesskey The client session key.
     * @param array $courseids An array of input course id values to search for. If empty return all ressources
     * @param string $idfield : the field used to identify courses
     * @return array An array of resource records.
     */
     public function get_resources($client, $sesskey, $courseids,$idfield='idnumber') {
                return $this->to_soap_array(
                        parent::get_resources($client, $sesskey,$courseids,$idfield),
                        'resources',
                        'resourceRecord',
                        'no resources found');
        }

 /**
     * Find and return a list of sections within one or several courses.
     * OK PP tested with php5 5 and python clients
     * @param int $client The client session ID.
     * @param string $sesskey The client session key.
     * @param array $courseids An array of input courses id values to search for. If empty return all sections
     * @param string $idfield : the field used to identify courses
     * @return array An array of section records.
     */
     public function get_sections($client, $sesskey, $courseids,$idfield='idnumber') {
                return $this->to_soap_array(
                        parent::get_sections($client, $sesskey,$courseids,$idfield),
                        'sections',
                        'sectionRecord',
                        'no sections found');
        }
    /**
     * Find and return a list of student grade values.
     * OK PP tested with php5 5 and python clients
     * @param int $client The client session ID.
     * @param string $sesskey The client session key.
     * @param string $userid The user ID number of the student.
     * @param array $courseids An array of input course id values.
     * @param string $idfield course's field (default = idnumber)
     * @return array An array of grade records.
     */
     public function get_grades($client, $sesskey, $userid, $courseids,$idfield = 'idnumber') {
            $rgrades = array();

            if ($grades = parent::get_grades($client, $sesskey, $userid, $courseids,$idfield)) {
                foreach ($grades as $grade) {
                    if (!empty($grade->error)) {
                        $rgrade             = array();
                        $rgrade['error']    = $grade->error;
                        $rgrade['courseid'] = $grade->courseid;
                        $rgrade['stats']    = $this->blank_array('gradeStatsRecord');
                        $rgrade['grades']   = $this->blank_array('gradeRecord');

                    } else {
                        $rgrade             = array();
                        $rgrade['error']    = '';
                        $rgrade['courseid'] = $grade->courseid;
                        $stats              = array();
                        $mygrades           = array();

                        if (!empty($grade->grades)) {
                            while ($mygrade = current($grade->grades)) {
                                if (key($grade->grades) == 'stats') {
                                    $stats = array(
                                        'gradeItems'  => (int)$mygrade['grade_items'],
                                        'allgrades'   => $mygrade['allgrades'],
                                        'points'      => (int)$mygrade['points'],
                                        'totalpoints' => (int)$mygrade['totalpoints'],
                                        'percent'     => (float)$mygrade['percent'],
                                        'weight'      => (float)$mygrade['weight'],
                                        'weighted'    => (float)$mygrade['weighted'],
                                    );

                                } else {
                                    $graded = array(
                                        'name'      => key($grade->grades),
                                        'maxgrade'  => (int)$mygrade['maxgrade'],
                                        'grade'     => $mygrade['grade'],
                                        'percent'   => (float)$mygrade['percent'],
                                        'weight'    => (float)$mygrade['weight'],
                                        'weighted'  => (float)$mygrade['weighted'],
                                        'sortOrder' => (int)$mygrade['sort_order']
                                    );

                                    $mygrades[] = $graded;
                                }

                                next($grade->grades);
                            }
                        }

                        $rgrade['stats']  = $stats;
                        $rgrade['grades'] = $mygrades;
                    }

                    $rgrades['grades'][] = $rgrade;
                }
            }

            return $rgrades;
        }


    /**
     * Enrol users as a student in the given course.
     * prerequisite : corresponding students records MUST exist in Moodle
     * OK PP tested with php5 5 and python clients
     * @param int $client The client session ID.
     * @param string $sesskey The client session key.
     * @param string $courseid The course ID number to enrol students in. (caution idnumber, not Moodle id)
     * @param array $userids An array of input user idnumber values for enrolment.
     * @param string $idfield student identifier, default idnumber
     * @return array Return data (user_student records) to be converted into a
     *               specific data format for sending to the client.
     */
     public function enrol_students($client, $sesskey, $courseid, $userids,$idfield='idnumber') {
            $rstudents = array();

            if ($students = parent::enrol_students($client, $sesskey, $courseid, $userids,$idfield)) {
                    $rstudents['error']    = $students->error;
                    $rstudents['students'] = array();
 		    foreach ($students-> students as $r)
                        $rstudents['students'][] = $this->to_soap($r,'studentRecord');

            } else {
               $rstudents['error']    = '??????';
               $rstudents['students'] = array();
            }
            return $rstudents;
        }


    /**
     * Sends an fatal error response back to the client.
     *
     * @param string $msg The error message to return.
     * @return An error message string.
     */
       private function error($msg) {
  	    parent::error($msg); //log in error msg
            throw new SoapFault("Server", $msg);
        }


/*ATI added function see */

    /**
     * Assigns instructors in the given course. (ATI Function)
     * prerequisite : corresponding instructors records MUST exist in Moodle
     * @param int $client The client session ID.
     * @param string $sesskey The client session key.
     * @param string $courseid The course ID number to enrol students in. (caution idnumber, not Moodle id)
     * @param array $userids An array of input user idnumber values for assignment.
     * @param string $idfield instructor identifier, default idnumber
     * @param string $lmsrole role for the instructor, default instructor
     * @param string $enrol operation is enrol or unenrol, default enrol
     * @return array Return data (user_student records) to be converted into a
     *               specific data format for sending to the client.
     */
     public function assign_instructors($client, $sesskey, $courseid, $userids, $idfield='idnumber', $lmsrole = 3, $enrol = true) {
            $rstudents = array();

            if ($students = parent::assign_instructors($client, $sesskey, $courseid, $userids, $idfield, $lmsrole, $enrol)) {
                    $rstudents['error']    = $students->error;
                    $rstudents['students'] = array();
            foreach ($students-> students as $r)
                        $rstudents['students'][] = $this->to_soap($r,'studentRecord');

            } else {
               $rstudents['error']    = '??????';
               $rstudents['students'] = array();
            }
            return $rstudents;
        }


/**
*   Assigns/Unassigns a user to/from a group in a course    (ATI Function)
     * @param int $client The client session ID.
     * @param string $sesskey The client session key.
     * @param string $courseid The course ID number that the group exists in
     * @param string $userid input user
     * @param string $idfield instructor identifier, default idnumber
     * @param string $atigroup group to enrol in, default 0 (no group)
     * @param boolean $assign operation is assign or unassign, default assign
     * @return boolean true = successful
*/

   public function set_group_member($client, $sesskey, $courseid, $userid, $atigroup, $assign = true) {

        $breturn = true;

            if ($breturn = parent::set_group_member($client, $sesskey, $courseid, $userid, $atigroup, $assign)) {
                return true;
            }else{
                return false;
            }

        }

/**
     * Find and return student grade value for a course (ATI Function)
     *
     * @uses $CFG
     * @param int $client The client session ID.
     * @param string $sesskey The client session key.
     * @param string $userid The ATIStudentID number of the student.
     * @param string $courseid The short coursename
     * @return float $freturn The student grade
     *
*/

   public function get_grade($client, $sesskey, $userid, $courseid) {

        $freturn = 0.0; // can be removed when error handling is properly implemented (tbd...)

        $freturn = parent::get_grade($client, $sesskey, $userid, $courseid);

        return $freturn;

        }


/**
     * Find and return student grades for currently enrolled courses    (ATI Function)
     *
     * @uses $CFG
     * @param int $client The client session ID.
     * @param string $sesskey The client session key.
     * @param string $userid The ATIStudentID number of the student.
     * @param string $courseids Array of short coursenames
     * @return userGrade [] $ugareturn The student grades
     *
*/

   public function get_user_grades($client, $sesskey, $userid, $courseids) {

        $ugareturn = parent::get_user_grades($client, $sesskey, $userid, $courseids);

        return $ugareturn;

        }


/**
*   Resets a course (ATI Function)
     * @param int $client The client session ID.
     * @param string $sesskey The client session key.
     * @param string $courseid The course ID number that the group exists in
     * @param string $newstartdate The new course start date
     * @param boolean $allincat All courses in the same category will be reset if true
     * @param boolean $stuonly Only the students will be unenrolled, not the instructors if true
     * @return boolean true = successful
*/

   public function reset_course($client, $sesskey, $courseid, $newstartdate = 0, $allincat = true, $stuonly = false) {

        $breturn = true;

            if ($breturn = parent::reset_course($client, $sesskey, $courseid, $newstartdate, $allincat, $stuonly)) {
                return true;
            }else{
                return false;
            }

        }




/*end ATI */



/**
*   get one user record with idfield=userinfo.
*   may return several users records if idfield is not a key
*   eg. proxy.get_user(a,b,'alexis','firstname')
*/

   public function get_user($client,$sesskey,$userinfo,$idfield) {
                return $this->get_users($client,$sesskey,array($userinfo),$idfield);
        }

/**
*  internal, not published (yet) in wsdl.
*  return an array of groups
*  @see get_group_byid, get_groups_byname
*/
       function get_groups($client,$sesskey,$groups,$idfield,$courseid=0) {
		return $this->to_soap_array(
                	parent::get_groups($client, $sesskey,$groups,$idfield,$courseid),
                       'groups',
			'groupRecord',
                        'no groups in course '.$courseid);
        }


     /**
     * Find and return a list of courses that a user is a member of.
     *
     * @param int $client The client session ID.
     * @param string $sesskey The client session key.
     * @param int $uid (optional) Moodle's id of user. If absent, uses current session user id
     * @param string $sort (optional). If absent use parent's default (by fullname)
     * @return array Return data (course record) to be converted into a specific
     *               data format for sending to the client.
     */

     private function _get_mycourses_by ($client,$sesskey,$uinfo,$idfield,$sort) {
	return $this->to_soap_array(
                        parent::get_my_courses($client, $sesskey,$uinfo,$idfield,$sort),
                        'courses',
                        'courseRecord',
                        'no courses');

     }


     public  function get_my_courses($client, $sesskey, $uid='',$sort='') {
		return $this->_get_mycourses_by($client,$sesskey,$uid,'id',$sort);
       }

    public  function get_my_courses_byusername($client, $sesskey, $uid='',$sort='') {
		 return $this->_get_mycourses_by($client,$sesskey,$uid,'username',$sort);
       }

    public  function get_my_courses_byidnumber($client, $sesskey, $uid='',$sort='') {
             return $this->_get_mycourses_by($client,$sesskey,$uid,'idnumber',$sort);
       }


	/**
	* Get an user record from it's login name
	* @param int $client The client session ID.
	* @param string $sesskey The client session key.
	* @param int $userinfo  Moodle's login of user.
 	* @return array Return data (user  record) to be converted into a specific
	*               data format for sending to the client.
	*/
      public function get_user_byusername($client,$sesskey,$userinfo) {
		return $this->get_user($client,$sesskey,$userinfo,'username');
	}

        /**
        * Get an user record from it's id number (an optional info in Moodle)
        * @param int $client The client session ID.
        * @param string $sesskey The client session key.
        * @param int $userinfo  Moodle's id number .
        * @return array Return data (user  record) to be converted into a specific
        *               data format for sending to the client.
        */

       public function get_user_byidnumber($client,$sesskey,$userinfo) {
                return $this->get_user($client,$sesskey,$userinfo,'idnumber');
        }

       /**
        * Get an user record from it's id  (the main Moodle id key)
        * @param int $client The client session ID.
        * @param string $sesskey The client session key.
        * @param int $userinfo  Moodle's id .
        * @return array Return data (user  record) to be converted into a specific
        *               data format for sending to the client.
        */

       public function get_user_byid($client,$sesskey,$userinfo) {
                return $this->get_user($client,$sesskey,$userinfo,'id');
        }

	/**
	* return the list of groups of course identified by courseid
	* @param string $courseid the course identifier
	* @param string $idfield  the course identifier field, defaut = idnumber
	* @return array of groupRecord
	*/
	public function get_groups_bycourse($client,$sesskey,$courseid,$idfield='idnumber') {
		return $this->to_soap_array(
			parent::get_groups_bycourse($client, $sesskey,$courseid,$idfield),
			'groups',
			'groupRecord',
			'no groups in course '.$courseid);
	}

	/**
	* return one groupRecord  identified by Moodle's id
	*/
	public function get_group_byid($client,$sesskey,$groupid) {
		return $this->get_groups($client,$sesskey,array($groupid),'id',0);
        }

	/**
	* return one or several groupRecord for groups having name $name
	* and (optionally) belonging to course $courseid
	*/
	public function get_groups_byname($client,$sesskey,$groupname,$courseid=0) {
		return $this->get_groups($client,$sesskey,array($groupname),'name',$courseid);
        }

	/**
	* return members of group identified by $groupeid (Moodle id )
	*/

	public function get_group_members($client,$sesskey,$groupid) {
		$rres = array();
                if ($res = parent::get_group_members($client, $sesskey,$groupid))
                    foreach ($res as $r)
                        $rres['users'][] = $this->to_soap($r,'userRecord');
                 else
                        $rres['users'][]=$this->error_record('userRecord','no users');
                 return $rres;

	}

	/**
	* return groups to which user $uid belongs to
	* if $uid is empty, use current logged in user.
	* otherwise, current logged in user must be admin to fetch data
	*/
        public function get_my_groups($client,$sesskey,$uid=0) {
		return $this->to_soap_array(
			parent::get_my_groups($client, $sesskey,$uid),
                        'groups',
			'groupRecord',
                        'no groups');
        }

	/**
	* Return user's $uid group(s)  in course identified by $courseid
	* @param $uid . User's Moodle id. If empty, use current logged in user.
	* @param $courseid Moodle's course id
	*/

       public function get_my_group($client,$sesskey,$uid,$courseid) {
        	$rres=array();
		if( $tmp=parent::get_my_groups($client,$sesskey,$uid)) {
			$foundOne=false;
			foreach($tmp as $g) {
				if ($g->courseid == $courseid) {
					$rres['groups'][] = $this->to_soap($g,'groupRecord');
					$foundOne=true;
				}
			}
			if (! $foundOne)
				$rres['groups'][]=$this->error_record('groupRecord','no group in course '.$courseid);

		}else {
			$rres['groups'][]=$this->error_record('groupRecord','no group');
		}
		return $rres;

	}

	/**
	* return courseRecord for one course identified by Moodle's id $info
	*/

	public function get_course_byid($client,$sesskey,$info) {
                return $this->get_courses($client,$sesskey,array($info),'id');
        }

	/**
        * return courseRecord for one course identified by idnumber $info
        */
	public function get_course_byidnumber($client,$sesskey,$info) {
                return $this->get_courses($client,$sesskey,array($info),'idnumber');
        }

	/**
	* return an array of course record having $idfield=$info
	* can be used for any criteria
	*   eg: in python proxy.get_courses(a,b,'visible',0)
	*   note that is that case, only admins and courses teachers will get them
	* @see server.soap.class filter_course
	*/
        public function get_course($client,$sesskey,$info,$idfield) {
                return $this->get_courses($client,$sesskey,array($info),$idfield);
        }

	/**
	* return an array of users having role $idrole in course $idcourse identified by $idfield
 	* @param integer $idrole. Role id number in mdl_roles table. If empty, all roles are matched
	*/

	public function get_users_bycourse($client,$sesskey,$idcourse,$idfield='idnumber',$idrole=0) {
		$res=$this->to_soap_array(
			parent::get_users_bycourse($client, $sesskey,$idcourse,$idfield,$idrole),
			'users',
			'userRecord',
			'no users in course '.$idfield.'='.$idcourse.' with role '.$idrole );
                  //file_put_contents('/work/moodledata/debug_pp.log','mdl_ss:get_users_bycourse'.print_r($res,true));
                 return $res;
	}

           /**
        * return the count of  users having role $idrole in course $idcourse identified by $idfield
        * @param integer $idrole. Role id number in mdl_roles table. If empty, all roles are matched
        * could be moved in server.class since no type conversion is required (return integer)
        */

        public function count_users_bycourse($client,$sesskey,$idcourse,$idfield='idnumber',$idrole=0) {
                $res=parent::get_users_bycourse($client, $sesskey,$idcourse,$idfield,$idrole);
                if ($res->error)
			return 0;
                else
                        return count($res);

        }


	/**
	* return teachers and non editing teachers of a course $idcourse identified by $idfield
	*/
        public function get_teachers ($client,$sesskey,$idcourse,$idfield='idnumber') {
		$te=parent::get_users_bycourse($client,$sesskey,$idcourse,$idfield,3);
		if ($te->error)   // cancel any errors if no teachers found
			$te=array();
		$net=parent::get_users_bycourse($client,$sesskey,$idcourse,$idfield,4);
		if ($net->error)   // cancel any errors if no non editing teachers found
			$net=array();
		return $this->to_soap_array(
			array_merge($te,$net),
			'users',
			'userRecord',
 			'no teachers in course '.$idfield.'='.$idcourse);
	}

	/**
        * return students of a course $idcourse identified by $idfield
        */

	public function get_students ($client,$sesskey,$idcourse,$idfield='idnumber') {
                return $this->get_users_bycourse($client,$sesskey,$idcourse,$idfield,5);
        }

	/**
	* return all known roles in Moodle or an array of roleRecord having $idfield equals to $roleid
	*/
        public function get_roles($client,$sesskey,$roleid='',$idfield='') {
		return $this->to_soap_array(
                        parent::get_roles($client, $sesskey,$roleid,$idfield),
                        'roles',
                        'roleRecord',
                        'no roles found ');
        }

	/**
	* return one roleRecord identified by it's id
	*/
        public function get_role_byid($client,$sesskey,$roleid) {
		return $this->get_roles($client,$sesskey,$roleid,'id');
	}

	 /**
        * return one roleRecord identified by it's name
        */

	public function get_role_byname($client,$sesskey,$rolename) {
                return $this->get_roles($client,$sesskey,$rolename,'shortname');
        }

	public function get_categories($client,$sesskey,$catid='',$idfield='') {
		return $this->to_soap_array(
			parent::get_categories($client, $sesskey,$catid,$idfield),
			'categories',
			'categoryRecord',
			'no categories found ');
       }

	public function get_category_byid($client,$sesskey,$catid) {
                return $this->get_categories($client,$sesskey,$catid,'id');
        }

        public function get_category_byname($client,$sesskey,$catname) {
                return $this->get_categories($client,$sesskey,$catname,'name');
        }


 	public function get_courses_bycategory($client, $sesskey,$categoryid) {
                 return $this->get_courses($client,$sesskey,array($categoryid),'category');
	}

        public function get_events($client, $sesskey,$eventtype,$ownerid) {
		return $this->to_soap_array(
			parent::get_events($client,$sesskey,$eventtype,$ownerid),
			'events',
			'eventRecord',
			'no events');
        }

	public function get_last_changes($client, $sesskey,$courseid,$idfield='idnumber',$limit=10) {
		return $this->to_soap_array(
                        parent::get_last_changes($client,$sesskey,$courseid,$idfield,$limit),
                        'changes',
                        'changeRecord',
                        'nothing new');
	}

       public function get_activities($client,$sesskey,
                                      $userid,$useridfield='idnumber',
                                      $courseid=0,$courseidfield='idnumber',$limit=99) {
                $res=$this->to_soap_array(
                        //array(),  <-- test code 1 empty record return
			parent::get_activities($client,$sesskey,
                                                  $userid,$useridfield,
                                                  $courseid,$courseidfield,$limit,0),
                        'activities',
                        'activityRecord',
                        'nothing new');
               //file_put_contents('/work/moodledata/debug_pp.log',
               //  'get_act  '.print_r($res,true));
               return $res;

        }

	public function count_activities($client,$sesskey,
                                      $userid,$useridfield='idnumber',
                                      $courseid=0,$courseidfield='idnumber',$limit=0) {
			// save  a lot of memory with flag doCount=1
                      return  parent::get_activities($client,$sesskey,
                                                  $userid,$useridfield,
                                                  $courseid,$courseidfield,$limit,1);


    }


      /*
    *****************************************************************************************************************************
    *                                                                                                                           *
    *                                                 START LILLE FUNCTIONS                                                     *
    *                                                                                                                           *
    *****************************************************************************************************************************
    */

    function edit_labels($client, $sesskey, $labels)
     {
        $return = array();
        if ($res = parent::edit_labels($client, $sesskey, $labels))
        {
            foreach ($res as $r)
            {
                $return['labels'][] = $this->to_soap($r,'labelRecord');
            }
        }
        else
        {
            $return['labels'][]=$this->error_record('labelRecord','no labels');
        }
        return $return;
     }

     function edit_groups($client, $sesskey, $groups)
     {
            $return = array();
            if ($res = parent::edit_groups($client, $sesskey, $groups))
                 foreach ($res as $r)
                        $return['groups'][] = $this->to_soap($r,'groupRecord');
                 else
                        $return['groups'][]=$this->error_record('groupRecord','no group');
                 return $return;
     }

     function edit_assignments($client, $sesskey, $assignments)
     {
        $return = array();
        if ($res = parent::edit_assignments($client, $sesskey, $assignments))
             foreach ($res as $r)
                    $return['assignments'][] = $this->to_soap($r,'assignmentRecord');
             else
                    $return['assignments'][]=$this->error_record('assignmentRecord','no assignment');
             return $return;
     }

     function edit_databases($client, $sesskey, $databases)
     {
        $return = array();
        if ($res = parent::edit_databases($client, $sesskey, $databases))
             foreach ($res as $r)
                    $return['databases'][] = $this->to_soap($r,'databaseRecord');
             else
                    $return['databases'][]=$this->error_record('databaseRecord','no database');
             return $return;
     }

     function edit_categories($client, $sesskey, $categories)
     {
        $return = array();
        if ($res = parent::edit_categories($client, $sesskey, $categories))
                foreach ($res as $r)
                    $return['categories'][] = $this->to_soap($r,'categoryRecord');
        else
                    $return['categories'][]=$this->error_record('categoryRecord','no categories');
        return $return;
     }

     function edit_sections($client, $sesskey, $sections)
     {
        $return = array();
        if ($res = parent::edit_sections($client, $sesskey, $sections))
                foreach ($res as $r)
                    $return['sections'][] = $this->to_soap($r,'sectionRecord');
        else
                    $return['sections'][]=$this->error_record('sectionRecord','no sections');
        return $return;
     }

     function edit_forums($client, $sesskey, $forums)
     {
        $return = array();
        if ($res = parent::edit_forums($client, $sesskey, $forums))
                foreach ($res as $r)
                    $return['forums'][] = $this->to_soap($r,'forumRecord');
        else
                    $return['forums'][]=$this->error_record('forumRecord','no forums returned');
        return $return;
     }

     function edit_wikis($client, $sesskey, $wikis)
     {
        $return = array();
        if ($res = parent::edit_wikis($client, $sesskey, $wikis))
                foreach ($res as $r)
                    $return['wikis'][] = $this->to_soap($r,'wikiRecord');
             else
                    $return['wikis'][]=$this->error_record('wikiRecord','no wikis');
             return $return;
     }

     function edit_pagesWiki($client, $sesskey, $pagesWiki)
     {
        $return = array();
        if ($res = parent::edit_pagesWiki($client, $sesskey, $pagesWiki))
                foreach ($res as $r)
                    $return['pagesWiki'][] = $this->to_soap($r,'pageWikiRecord');
             else
                    $return['pagesWiki'][]=$this->error_record('pageWikiRecord','no pages of wiki');
             return $return;
     }

     function affect_course_to_category($client,$sesskey,$courseid,$categoryid)
     {
          return $this->to_soap(parent::affect_course_to_category($client,$sesskey,$courseid,$categoryid),"affectRecord");
     }

     function affect_label_to_section($client,$sesskey,$labelid,$sectionid)
     {
         return $this->to_soap(parent::affect_label_to_section($client,$sesskey,$labelid,$sectionid),"affectRecord");
     }

     function affect_forum_to_section($client,$sesskey,$forumid,$sectionid,$groupmode)
     {
         return $this->to_soap(parent::affect_forum_to_section($client,$sesskey,$forumid,$sectionid,$groupmode),"affectRecord");
     }

     function affect_section_to_course($client,$sesskey,$sectionid,$courseid)
     {
         return $this->to_soap(parent::affect_section_to_course($client,$sesskey,$sectionid,$courseid),"affectRecord");
     }

     function affect_user_to_group($client,$sesskey,$userid,$groupid)
     {
          return $this->to_soap(parent::affect_user_to_group($client,$sesskey,$userid,$groupid),"affectRecord");
       }

     function affect_group_to_course($client,$sesskey,$groupid,$courseid)
     {
          // return parent::affect_group_to_course($client,$sesskey,$groupid,$courseid);
             return $this->to_soap(parent::affect_group_to_course($client,$sesskey,$groupid,$courseid),"affectRecord");
     }

     function affect_wiki_to_section($client,$sesskey,$wikiid,$sectionid,$groupmode,$visible)
     {
            return $this->to_soap(parent::affect_wiki_to_section($client,$sesskey,$wikiid,$sectionid,$groupmode,$visible),"affectRecord" );
        }

     function affect_database_to_section($client,$sesskey,$databaseid,$sectionid)
     {
            return $this->to_soap(parent::affect_database_to_section($client,$sesskey,$databaseid,$sectionid),"affectRecord" );
        }

     function affect_assignment_to_section ($client,$sesskey,$assignmentid,$sectionid,$groupmode)
     {
            return $this->to_soap(parent::affect_assignment_to_section ($client,$sesskey,$assignmentid,$sectionid,$groupmode),"affectRecord" );
     }

     function affect_user_to_course($client,$sesskey,$userid,$courseid,$rolename)
     {
            $rest=parent::affect_user_to_course($client,$sesskey,$userid,$courseid, $rolename );
            return $this->to_soap($rest,'affectRecord');
     }

     function affect_pageWiki_to_wiki($client,$sesskey,$pageid,$wikiid)
     {
           $rest=parent::affect_pageWiki_to_wiki($client,$sesskey,$pageid,$wikiid)  ;
           return $this->to_soap($rest,'affectRecord');
     }

     function remove_userRole_from_course($client,$sesskey,$userid,$courseid,$rolename)
     {
            $rest=parent::remove_userRole_from_course($client,$sesskey,$userid,$courseid, $rolename );
            return $this->to_soap($rest,'affectRecord');
     }

     //------------------------------------------------------------------------------------------------------------------------


     function get_all_wikis($client,$sesskey,$fieldname,$fieldvalue)
     {
        return $this->to_soap_array(
            parent::get_all_wikis($client, $sesskey,$fieldname,$fieldvalue),
            'wikis',
            'wikiRecord',
            'no wikis found ');
     }

     function get_all_pagesWiki($client,$sesskey,$fieldname,$fieldvalue)
     {
        return $this->to_soap_array(
            parent::get_all_pagesWiki($client, $sesskey,$fieldname,$fieldvalue),
            'pageswiki',
            'pageWikiRecord',
            'no pages wiki found ');
     }

     function get_all_groups($client,$sesskey,$fieldname,$fieldvalue)
     {
        return $this->to_soap_array(
            parent::get_all_groups($client, $sesskey,$fieldname,$fieldvalue),
            'groups',
            'groupRecord',
            'no groups found ');
       }

     function get_all_forums($client,$sesskey,$fieldname,$fieldvalue)
     {
          return $this->to_soap_array(
            parent::get_all_forums($client, $sesskey,$fieldname,$fieldvalue),
            'forums',
            'forumRecord',
            'no forums found ');
     }

     function get_all_labels($client,$sesskey,$fieldname,$fieldvalue)
     {
          return $this->to_soap_array(
            parent::get_all_labels($client, $sesskey,$fieldname,$fieldvalue),
            'labels',
            'labelRecord',
            'no labels found ');
     }

     function get_all_assignments($client,$sesskey,$fieldname,$fieldvalue)
     {
          return $this->to_soap_array(
            parent::get_all_assignments($client, $sesskey,$fieldname,$fieldvalue),
            'assignments',
            'assignmentRecord',
            'no assignments found ');
     }

     function get_all_databases($client,$sesskey,$fieldname,$fieldvalue)
     {
          return $this->to_soap_array(
            parent::get_all_databases($client, $sesskey,$fieldname,$fieldvalue),
            'databases',
            'databaseRecord',
            'no databases found ');
     }


    /*
    *****************************************************************************************************************************
    *                                                                                                                           *
    *                                                 END LILLE FUNCTIONS                                                     *
    *                                                                                                                           *
    *****************************************************************************************************************************
    */


}

?>
