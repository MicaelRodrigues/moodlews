<?php
require_once ('../classes/mdl_soapserver.php');

$client=new mdl_soapserver();
require_once ('../auth.php');
/**test code for get_user
* @param int $client
* @param string $sesskey
* @param string $userinfo
* @param string $idfield
* @return  userRecord[]
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->get_user($lr->getClient(),$lr->getSessionKey(),'','');
print_r($res);
$client->logout($lr->getClient(),$lr->getSessionKey());

?>
