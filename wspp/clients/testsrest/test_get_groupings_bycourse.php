<?php
require_once ('../classes/mdl_soapserverrest.php');

$client=new mdl_soapserverrest();
require_once ('../auth.php');
/**test code for get_groupings_bycourse
* @param int $client
* @param string $sesskey
* @param string $courseid
* @param string $idfield
* @return  groupingRecord[]
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->get_groupings_bycourse($lr->getClient(),$lr->getSessionKey(),'','');
print_r($res);
$client->logout($lr->getClient(),$lr->getSessionKey());

?>
