<?php
require_once ('../classes/mdl_soapserver.php');

$client=new mdl_soapserver();
require_once ('../auth.php');
/**test code for get_user_byid
* @param int $client
* @param string $sesskey
* @param int $userinfo
* @return  userRecord[]
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->get_user_byid($lr->getClient(),$lr->getSessionKey(),0);
print_r($res);
$client->logout($lr->getClient(),$lr->getSessionKey());

?>
