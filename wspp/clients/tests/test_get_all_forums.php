<?php
require_once ('../classes/mdl_soapserver.php');

$client=new mdl_soapserver();
require_once ('../auth.php');
/**test code for get_all_forums
* @param int $client
* @param string $sesskey
* @param string $fieldname
* @param string $fieldvalue
* @return  forumRecord[]
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->get_all_forums($lr->getClient(),$lr->getSessionKey(),'course','122');
print_r($res);
$client->logout($lr->getClient(),$lr->getSessionKey());

?>
