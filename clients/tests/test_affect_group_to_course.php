<?php
require_once ('../MoodleWS_NS.php');

$moodle=new MoodleWS_NS();
require_once ('../auth.php');
/**test code for MoodleWS: Affect a group to course
* @param integer $client
* @param string $sesskey
* @param integer $groupid
* @param integer $coursid
* @return affectRecord
*/

$lr=$moodle->login(LOGIN,PASSWORD);
$res=$moodle->affect_group_to_course($lr->getClient(),$lr->getSessionKey(),0,0);
print_r($res);
print($res->getError());
print($res->getStatus());

$moodle->logout($lr->getClient(),$lr->getSessionKey());

?>
