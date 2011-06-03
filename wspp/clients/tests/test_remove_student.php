<?php
require_once ('../classes/mdl_soapserver.php');

$client=new mdl_soapserver();
require_once ('../auth.php');
/**test code for remove_student
* @param int $client
* @param string $sesskey
* @param string $courseid
* @param string $courseidfield
* @param string $userid
* @param string $useridfield
* @return  affectRecord
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->remove_student($lr->getClient(),$lr->getSessionKey(),'','','','');
print_r($res);
print($res->getError());
print($res->getStatus());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
