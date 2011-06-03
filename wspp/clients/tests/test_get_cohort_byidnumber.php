<?php
require_once ('../classes/mdl_soapserver.php');

$client=new mdl_soapserver();
require_once ('../auth.php');
/**test code for get_cohort_byidnumber
* @param int $client
* @param string $sesskey
* @param string $cohortidnumber
* @return  cohortRecord[]
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->get_cohort_byidnumber($lr->getClient(),$lr->getSessionKey(),'');
print_r($res);
$client->logout($lr->getClient(),$lr->getSessionKey());

?>
