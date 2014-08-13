<?php 

   // error_reporting(0);
    
    include_once("config.php");
   // include_once("inc/KLogger.php");
  //  include_once("inc/class.MySQL.php");
    require_once('inc/class.eventdesigner.php');  
    require_once('lib/nusoap.php');
    
   //$log = new KLogger("errorlog", KLogger::INFO);
   // $db = new MySQL($gps_db, $gps_db_user, $gps_db_pass, $gps_db_host);
   // $today = date("Y-m-d H:i:s");
    
//$server = new soap_server('ws.wsdl');
$ed = new eventDesigner();

// Create the server instance
$server = new soap_server();

// Initialize WSDL support
$server->configureWSDL('eventDesigner', 'urn:eventDesigner');

// ------------------------- REGISTER THE DATA STRUCTURES USED BY THE SERVICE --------------------------
/* $server->wsdl->addComplexType(
    'Person',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'firstname' => array('name' => 'firstname', 'type' => 'xsd:string'),
        'age' => array('name' => 'age', 'type' => 'xsd:int'),
        'gender' => array('name' => 'gender', 'type' => 'xsd:string')
    )
);
$server->wsdl->addComplexType(
    'SweepstakesGreeting',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'greeting' => array('name' => 'greeting', 'type' => 'xsd:string'),
        'winner' => array('name' => 'winner', 'type' => 'xsd:boolean')
    )
); */

/**
* @desc Error structure defenition
*/
$server->wsdl->addComplexType(
    'Error',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'errorcode' => array('name' => 'errorcode', 'type' => 'xsd:int'),
        'errorname' => array('name' => 'errorname', 'type' => 'xsd:string')
    )
);

/**
* @desc Location struvture defenition
*/
$server->wsdl->addComplexType(
    'Location',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'locationname' => array('name' => 'locationname', 'type' => 'xsd:string'),
        'description' => array('name' => 'description', 'type' => 'xsd:string'),
        'latitude'     => array('name' => 'latitude', 'type' => 'xsd:string'),
        'longitude'     => array('name' => 'longitude', 'type' => 'xsd:string')
    )
); 

/**
* @desc Task defenition
*/
$server->wsdl->addComplexType(
    'Task',
    'complexType',
    'struct',
    'all',
    '',
    array(
         'taskname' => array('name' => 'taskname', 'type' => 'xsd:string'),
         'starttime' => array('name' => 'starttime', 'type' => 'xsd:string'),
         'endtime ' => array('name' => 'endtime', 'type' => 'xsd:string'),
         'description' => array('name' => 'description', 'type' => 'xsd:string'),
         'responsible' => array('name' => 'responsible', 'type' => 'xsd:string'),
         'activity' => array('name' => 'activity', 'type' => 'xsd:string'),
         'cost' => array('name' => 'cost', 'type' => 'xsd:string')
    )
);

$server->wsdl->addComplexType(
    'Taskline',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    array( 'task' => array('name' => 'task', 'type' => 'tns:Task') ),
    array( array( "ref" => "SOAP-ENC:arrayType", "wsdl:arrayType" => "tns:Task[]") ),
    "tns:Task"
    
);



/**
* @desc Event defenition
*/
$server->wsdl->addComplexType(
    'Event',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'eventid'     => array('name' => 'eventid', 'type' => 'xsd:int'),
        'eventname'   => array('name' => 'eventname', 'type' => 'xsd:string'),
        'starttime'   => array('name' => 'starttime', 'type' => 'xsd:string'),
        'endtime'     => array('name' => 'endtime', 'type' => 'xsd:string'),
        'description' => array('name' => 'description', 'type' => 'xsd:string'),
        'notes'       => array('name' => 'notes', 'type' => 'xsd:string'),
        'responsible' => array('name' => 'responsible', 'type' => 'xsd:string'),
        'estimate'    => array('name' => 'estimate', 'type' => 'xsd:string'),
        'location'    => array('name' => 'location', 'type' => 'tns:Location'),
        'taskline'    => array('name' => 'taskline', 'type' => 'tns:Taskline')
    )
);





// ----------------- REGISTER THE METHOD TO EXPOSE --------------------------
/* $server->register('hello',                    // method name
    array('person' => 'tns:Person'),        // input parameters
    array('return' => 'tns:SweepstakesGreeting'),    // output parameters
    'urn:hellowsdl2',                        // namespace
    'urn:hellowsdl2#hello',                    // soapaction
    'rpc',                                    // style
    'encoded',                                // use
    'Greet a person entering the sweepstakes'        // documentation
);
*/

//register web method
$server->register('getVersion', 
                   array(),
                   array('version' => 'xsd:string'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#getVersion',
                   'rpc',
                   'encoded',
                   'Return version of service');
                   
$server->register('getEvent',
                   array('eventid' => 'xsd:string'),
                   array('event' => 'tns:Event', 'error' => 'tns:Error'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#getEvent',
                   'rpc',
                   'encoded',
                   'Return event object');
 
 
 // --------------- DEFINE THE METHOD AS A PHP FUNCTION ----------------------
 
 /**
 * Return version of service
 */
 function getVersion(){
    global $ed;
    return $ed->getVersion();
}

function getEvent($eventid){
    global $ed;
    $retValue = '';
    
    if($eventid){
            $retValue = array('event' => $ed->getEvent($eventid), 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
    }else{
            $retValue = array('event' => '', 'error' => array('errorcode' => 10, 'errorname' => 'param mismatch'));
    }
        
    return $retValue; //$ed->getEvent($eventid);
}


// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>