<?php // $Id: wsdl.php,v 1.5 2007/04/28 04:05:36 PP Exp $

/**
 * This file creates a WSDL file for the web service interfaced running on
 * this server with URL paths relative to the currently running server.
 *
 * When referring to this file, you must call it as:
 *
 * http://www.yourhost.com/ ... /wspp/wsdl_pp.php
 *
 * Where ... is the path to your Moodle root.  This is so that your web server
 * will process the PHP statemtents within the file, which returns a WSDL
 * file to the web services call (or your browser).
 *
 * @version $Id: wsdl.php,v 1.4 2007/04/24 04:05:36 jfilip Exp $
 * @author Justin Filip <jfilip@oktech.ca>
 * @author Open Knowledge Technologies - http://www.oktech.ca/
 * @author PP
 */


 require_once('../config.php');


 header('Content-Type: application/xml; charset=UTF-8');

 header('Content-Disposition: attachment; filename="moodlews.wsdl"');

$wsdl=file_get_contents("$CFG->wwwroot/wspp/moodlewsdl.xml");

$wsdl=str_replace('CFGWWWROOT',$CFG->wwwroot,$wsdl);
echo $wsdl;
?>
