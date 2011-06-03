<?php
require_once ('../classes/mdl_soapserver.php');

$client=new mdl_soapserver();
require_once ('../auth.php');
/**test code for get_users_bycourse
* @param int $client
* @param string $sesskey
* @param string $idcourse
* @param string $idfield
* @param int $idrole
* @return  userRecord[]
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->get_users_bycourse($lr->getClient(),$lr->getSessionKey(),'','',0);
print_r($res);
$client->logout($lr->getClient(),$lr->getSessionKey());

?>
