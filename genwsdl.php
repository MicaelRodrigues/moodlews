<?php // $Id: service.php 857 2009-06-07 16:36:53Z ppollet $

/**
 * PHP5 only SOAP server for Moodle
 * @package Web Services
 * @author Patrick Pollet <patrick.pollet@insa-lyon.fr>
 */

 set_time_limit(0);

define ('LIB_PATH','clients/lib/');
require_once(LIB_PATH.'wshelper/WSDLStruct.class.php');
require_once(LIB_PATH.'wshelper/WSDLException.class.php');
require_once(LIB_PATH.'wshelper/WSException.class.php');
require_once(LIB_PATH.'wshelper/IPXMLSchema.class.php');
require_once(LIB_PATH.'wshelper/IPPhpDoc.class.php');
require_once(LIB_PATH.'wshelper/IPReflectionClass.class.php');
require_once(LIB_PATH.'wshelper/IPReflectionCommentParser.class.php');
require_once(LIB_PATH.'wshelper/IPReflectionMethod.class.php');
require_once(LIB_PATH.'wshelper/IPReflectionProperty.class.php');


// SOAP service class
require('mdl_soapserver.class.php');


  $serviceNameSpace = $CFG->wwwroot.'/wspp/wsdl';
  $serviceURL = $CFG->wwwroot.'/wspp/service_pp.php';

        $wsdl = new WSDLStruct($serviceNameSpace, $serviceURL, SOAP_RPC, SOAP_ENCODED);
        $wsdl->setService(new IPReflectionClass('mdl_soapserver'));
        $wsdl->_debug=true;

        try {
            $gendoc = $wsdl->generateDocument();
            //print ($gendoc);
        } catch (WSDLException $exception) {
            print ($exception->msg);
            print_r ($exception->getTrace());

        }


?>
