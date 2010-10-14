<?php
require_once ('../MoodleWS.php');

$moodle=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Affect a group to grouping
* @param integer $client
* @param string $sesskey
* @param integer $groupid
* @param integer $groupingid
* @return affectRecord
*/

$lr=$moodle->login(LOGIN,PASSWORD);
$res=$moodle->affect_group_to_grouping($lr->getClient(),$lr->getSessionKey(),1,1);
print_r($res);
print($res->getError());
print($res->getStatus());

$moodle->logout($lr->getClient(),$lr->getSessionKey());

?>
