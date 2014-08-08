<?php 

   // error_reporting(0);
    
    include_once("config.php");
   // include_once("inc/KLogger.php");
  //  include_once("inc/class.MySQL.php");
    require_once('lib/nusoap.php');
    
    //$log = new KLogger("errorlog", KLogger::INFO);
    
   // $db = new MySQL($gps_db, $gps_db_user, $gps_db_pass, $gps_db_host);
    
   // $today = date("Y-m-d H:i:s");
    
    
    
//$server = new soap_server('ws.wsdl');
$server = new soap_server();

$server->configureWSDL('eventDesigner', 'urn:eventDesigner');
 
$server->register('getVersion', array(), array('version' => 'xsd:string'), 'xsd:eventDesigner');
 
function getVersion(){
    global $ed_version;
    return $ed_version;
}

function reverse($in){
    return strrev($in);
}

function ping() {
    return time();
}

function sum($a, $b) {
    return ($a + $b);
}

$server->service($HTTP_RAW_POST_DATA); 
    
?>