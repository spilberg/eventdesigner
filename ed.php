<?php 

   // error_reporting(0);
    
    include_once("config.php");
    include_once("inc/KLogger.php");
    include_once("inc/class.MySQL.php");
    require_once('inc/class.eventdesigner.php');  
    require_once('lib/nusoap.php');
    
    $log = new KLogger("errorlog", KLogger::INFO);
    $db = new MySQL($ed_db, $ed_db_user, $ed_db_pass, $ed_db_host);
   // $today = date("Y-m-d H:i:s");
   
    
// Create event Designer instance
$ed = new eventDesigner($db);

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
        'id'           => array('name' => 'id', 'type' => 'xsd:string'),
        'locationname' => array('name' => 'locationname', 'type' => 'xsd:string'),
        'description'  => array('name' => 'description', 'type' => 'xsd:string'),
        'latitude'     => array('name' => 'latitude', 'type' => 'xsd:string'),
        'longitude'    => array('name' => 'longitude', 'type' => 'xsd:string')
    )
); 

$server->wsdl->addComplexType(
    'Locationlist',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    array( 'location' => array('name' => 'location', 'type' => 'tns:Location') ),
    array( array( "ref" => "SOAP-ENC:arrayType", "wsdl:arrayType" => "tns:Location[]") ),
    "tns:Location"
);

/**
* @desc Task ComplexType defenition
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

/**
* @desc Taskline ComplexType defenition
*/
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

// ----------- eventlist -----------------
/**
* @desc Eventitem ComplexType defenition
*/
$server->wsdl->addComplexType(
    'Eventitem',
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
        'estimate'    => array('name' => 'estimate', 'type' => 'xsd:string')
    )
);

/**
* @desc Eventlist ComplexType defenition
*/
$server->wsdl->addComplexType(
    'Eventlist',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    array( 'eventitem' => array('name' => 'eventitem', 'type' => 'tns:Eventitem') ),
    array( array( "ref" => "SOAP-ENC:arrayType", "wsdl:arrayType" => "tns:Eventitem[]") ),
    "tns:Eventitem"
    
);

// ------------ end eventlist ------------



/**
* @desc Event ComplexType defenition
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

$server->register('getVersion',                                              // method name
                   array(),                                                  // input parameters
                   array('version' => 'xsd:string', 'error' => 'tns:Error'), // output parameters
                   'urn:eventDesigner',                                      // namespace
                   'urn:eventDesigner#getVersion',                           // soapaction
                   'rpc',                                                    // style
                   'encoded',                                                // use
                   'Return version of service'                               // documentation
                   );
                   
$server->register('getEvent',
                   array('eventid' => 'xsd:string'),
                   array('event' => 'tns:Event', 'error' => 'tns:Error'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#getEvent',
                   'rpc',
                   'encoded',
                   'Return event object');

/**
* @desc Return list of events
*/
$server->register('getEventList',
                   array('userid' => 'xsd:string'),
                   array('eventlist' => 'tns:Eventlist', 'error' => 'tns:Error'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#getEventList',
                   'rpc',
                   'encoded',
                   'Return list of events');  
                                      
                   
$server->register('setLocation', 
                   array('locationname' => 'xsd:string', 'description' => 'xsd:string', 'latitude' => 'xsd:string', 'longitude' => 'xsd:string'),
                   array('locationid' => 'xsd:string', 'error' => 'tns:Error'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#setLocation',
                   'rpc',
                   'encoded',
                   'Return version of service');
                   
$server->register('getLocation',
                  array('id' => 'xsd:string'),
                  array('location' => 'tns:Location', 'error' => 'tns:Error'),
                  'urn:eventDesigner',
                  'urn:eventDesigner#getLocation',
                  'rpc',
                  'encoded',
                  'Return Location');                   
                  
$server->register('getLocationList',
                  array(),
                  array('location' => 'tns:Locationlist', 'error' => 'tns:Error'),
                  'urn:eventDesigner',
                  'urn:eventDesigner#getLocationList',
                  'rpc',
                  'encoded',
                  'Return Location list');                                     
                   

 
 // --------------- DEFINE THE METHOD AS A PHP FUNCTION ----------------------
 
 /**
 * Return version of service
 */
 function getVersion(){
    global $ed;
        $retValue = '';
        $retValue = array('version' => $ed->getVersion(), 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
    return $retValue;
}

/**
* @desc Insert record in Data Base of Location
* 
* @param string location name
* @param string description
* @param string latitude
* @param string longitude
* @return array
*/
function setLocation($locationname, $description, $latitude, $longitude){
    global $ed;
        $retValue = '';
        $retValue = array('locationid' => $ed->setLocation($locationname, $description, $latitude, $longitude), 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
    return $retValue;
}

/**
* @desc Get location 
* 
* @param string id
* @return array
*/
function getLocation($id){
    global $ed;
        $retValue = '';
        $location = $ed->getLocation($id);
        if(is_array($location)){
            $retValue = array('location' => $location, 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
        }else{
            $retValue = array('location' => $location, 'error' => array('errorcode' => 20, 'errorname' => 'Query result error '));
        }
        //$retValue = array('location' => $ed->getLocation($id), 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
        //$retValue = array('location' => array( 'id' => '1', 'locationname' => 'Gidropark', 'description' => 'Bla Bla Bla', 'latitude'   => '50.50198526955379', 'longitude' => '30.5474853515625'), 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
    return $retValue;
}

function getLocationList(){
    global $ed;
    $retVatue = '';
    
    $locationlist = $ed->getLocation();
    
    $retValue = array('location' => $locationlist, 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
    
    return  $retValue; 
}



/**
* @desc Get event
* 
* @param string
* @return array
*/
function getEvent($eventid){
    global $ed;
    $retValue = '';
    
    if($eventid){
       $retValue = array('event' => $ed->getEvent($eventid), 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
    }else{
       $retValue = array('event' => '', 'error' => array('errorcode' => 10, 'errorname' => 'param mismatch'));
    }
        
    return $retValue; 
}

/**
* @desc return list of events for user with $userid
* 
* @param string
* @return array
*/
function getEventList($userid){
    global $ed;
    
       $retValue = '';
       $retValue = array('eventlist' => $ed->getEventList($userid), 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
    
    return $retValue; 
}



// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>