<?php
require_once ('../classes/mdl_soapserverrest.php');

$client=new mdl_soapserverrest();
require_once ('../auth.php');
/**test code for add_group
* @param int $client
* @param string $sesskey
* @param groupDatum $datum
* @return  groupRecord[]
*/

$lr=$client->login(LOGIN,PASSWORD);
$datum= new groupDatum();
$datum->setAction('');
$datum->setCourseid(0);
$datum->setDescription('');
$datum->setEnrolmentkey('');
$datum->setHidepicture(0);
$datum->setId(0);
$datum->setName('');
$datum->setPicture(0);
$res=$client->add_group($lr->getClient(),$lr->getSessionKey(),$datum);
print_r($res);
$client->logout($lr->getClient(),$lr->getSessionKey());

?>
