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

$server->soap_defencoding = 'UTF-8';
//$server->soap_defencoding = 'cp1251';

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
    'complexType', 'struct', 'all', '',
    array(
        'errorcode' => array('name' => 'errorcode', 'type' => 'xsd:int'),
        'errorname' => array('name' => 'errorname', 'type' => 'xsd:string')
    )
);

/**
* @desc Franchisee structure defenition
*/
 $server->wsdl->addComplexType(
     'Client',
     'complexType', 'struct', 'all', '',
     array( 'clientname' => array('name' => 'clientname', 'type' => 'xsd:string'),
            'clientcode' => array('name' => 'clientcode', 'type' => 'xsd:string')
     )
); 

/**
* @desc Location struvture defenition
*/
$server->wsdl->addComplexType(
    'Location',
    'complexType', 'struct', 'all', '',
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
    'complexType', 'array', '', 'SOAP-ENC:Array',
    array( 'location' => array('name' => 'location', 'type' => 'tns:Location') ),
    array( array( "ref" => "SOAP-ENC:arrayType", "wsdl:arrayType" => "tns:Location[]") ),
    "tns:Location"
);

$server->wsdl->addComplexType(
    'Equipment',
    'complexType', 'struct', 'all', '',
    array(
        'id'            => array('name' => 'id', 'type' => 'xsd:string'),
        'equipmentname' => array('name' => 'locationname', 'type' => 'xsd:string'),
        'description'   => array('name' => 'description', 'type' => 'xsd:string'),
        'owner'         => array('name' => 'latitude', 'type' => 'xsd:string'),
        'costofrent'    => array('name' => 'longitude', 'type' => 'xsd:string')
    )
); 

$server->wsdl->addComplexType(
    'Equipmentlist',
    'complexType', 'array', '', 'SOAP-ENC:Array',
    array( 'equipment' => array('name' => 'equipment', 'type' => 'tns:Equipment') ),
    array( array( "ref" => "SOAP-ENC:arrayType", "wsdl:arrayType" => "tns:Equipment[]") ),
    "tns:Equipment"
);


// ---------------- actor ------------------
$server->wsdl->addComplexType(
    'Actor',
    'complexType', 'struct', 'all', '',
    array(
        'id'        => array('name' => 'id', 'type' => 'xsd:string'),
        'firstname' => array('name' => 'firstname', 'type' => 'xsd:string'),
        'lastname'  => array('name' => 'lastname', 'type' => 'xsd:string')
    )
); 

$server->wsdl->addComplexType(
    'Actorlist',
    'complexType', 'array', '', 'SOAP-ENC:Array',
    array( 'actor' => array('name' => 'actor', 'type' => 'tns:Actor') ),
    array( array( "ref" => "SOAP-ENC:arrayType", "wsdl:arrayType" => "tns:Actor[]") ),
    "tns:Actor"
);

// ---------------- character ------------------
$server->wsdl->addComplexType(
    'Character',
    'complexType', 'struct', 'all', '',
    array(
        'id'            => array('name' => 'id', 'type' => 'xsd:string'),
        'charactername' => array('name' => 'charactername', 'type' => 'xsd:string'),
        'description'   => array('name' => 'description', 'type' => 'xsd:string'),
        'notes'         => array('name' => 'notes', 'type' => 'xsd:string'), 
        'actorid'       => array('name' => 'actorid', 'type' => 'xsd:string')
    )
); 

$server->wsdl->addComplexType(
    'Characterlist',
    'complexType', 'array', '', 'SOAP-ENC:Array',
    array( 'character' => array('name' => 'character', 'type' => 'tns:Character') ),
    array( array( "ref" => "SOAP-ENC:arrayType", "wsdl:arrayType" => "tns:Character[]") ),
    "tns:Character"
);

/**
* @desc Task ComplexType defenition
*/
$server->wsdl->addComplexType(
    'Task',
    'complexType', 'struct', 'all', '',
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
    'complexType', 'array', '', 'SOAP-ENC:Array',
    array( 'task' => array('name' => 'task', 'type' => 'tns:Task') ),
    array( array( "ref" => "SOAP-ENC:arrayType", "wsdl:arrayType" => "tns:Task[]") ),
    "tns:Task"
);

// ----------- eventlist -----------------

// Eventitem ComplexType defenition
$server->wsdl->addComplexType(
    'Eventitem',
    'complexType', 'struct', 'all', '',
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

// Eventlist ComplexType defenition
$server->wsdl->addComplexType(
    'Eventlist',
    'complexType', 'array', '', 'SOAP-ENC:Array',
    array( 'eventitem' => array('name' => 'eventitem', 'type' => 'tns:Eventitem') ),
    array( array( "ref" => "SOAP-ENC:arrayType", "wsdl:arrayType" => "tns:Eventitem[]") ),
    "tns:Eventitem"
);

// ------------ end eventlist ------------



// Event ComplexType defenition
$server->wsdl->addComplexType(
    'Event',
    'complexType', 'struct', 'all', '',
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
// 'franchisee' => 'tns:Franchisee'
$server->register('getVersion',                                              // method name
                   array('client' => 'tns:Client'),                                                  // input parameters
                   array('version' => 'xsd:string'), // output parameters
                   'urn:eventDesigner',                                      // namespace
                   'urn:eventDesigner#getVersion',                           // soapaction
                   'rpc',                                                    // style
                   'encoded',                                                // use
                   'Return version of service'                               // documentation
                   );
                   
// ------------------ Event ----------------
$server->register('getEvent',
                   array('client' => 'tns:Client', 'eventid' => 'xsd:string'),
                   array('event' => 'tns:Event'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#getEvent',
                   'rpc', 'encoded', 'Return event object');

// Return list of events
$server->register('getEventList',
                   array('client' => 'tns:Client'),
                   array('eventlist' => 'tns:Eventlist'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#getEventList',
                   'rpc', 'encoded', 'Return list of events');  
                                      
// ------------------ location -------------                   
$server->register('setLocation', 
                   array('client' => 'tns:Client', 'id' => 'xsd:string', 'locationname' => 'xsd:string', 'description' => 'xsd:string', 'latitude' => 'xsd:string', 'longitude' => 'xsd:string'),
                   array('locationid' => 'xsd:string'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#setLocation',
                   'rpc', 'encoded', 'Insert location');
                   
$server->register('getLocation',
                   array('client' => 'tns:Client', 'id' => 'xsd:string'),
                   array('location' => 'tns:Location'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#getLocation',
                   'rpc', 'encoded', 'Return Location');
                   
$server->register('delLocation', 
                   array('client' => 'tns:Client', 'id' => 'xsd:string'),
                   array('locationid' => 'xsd:string'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#delLocation',
                   'rpc', 'encoded', 'Delete location');                                      
                  
$server->register('getLocationList',
                   array('client' => 'tns:Client'),
                   array('location' => 'tns:Locationlist'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#getLocationList',
                   'rpc', 'encoded', 'Return Location list');  

// -------------- equipment ----------------
$server->register('setEquipment', 
                   array('client' => 'tns:Client', 'id' => 'xsd:string', 'equipmentname' => 'xsd:string', 'description' => 'xsd:string', 'owner' => 'xsd:string', 'costofrent' => 'xsd:string'),
                   array('equipmentid' => 'xsd:string'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#setEquipment',
                   'rpc', 'encoded', 'Insert equipment');                                                     
                   
$server->register('getEquipment',
                   array('client' => 'tns:Client', 'id' => 'xsd:string'),
                   array('equipment' => 'tns:Equipment'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#getEquipment',
                   'rpc', 'encoded', 'Return Equipment');  

$server->register('delEquipment', 
                   array('id' => 'xsd:string'),
                   array('equipmentid' => 'xsd:string', 'error' => 'tns:Error'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#delEquipment',
                   'rpc', 'encoded', 'Delete equipment');                                                         

$server->register('getEquipmentList',
                   array(),
                   array('equipments' => 'tns:Equipmentlist', 'error' => 'tns:Error'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#getEquipmentList',
                   'rpc', 'encoded', 'Return Equipment list');                     

// --------------------- actor ---------------------
$server->register('setActor', 
                   array('id' => 'xsd:string', 'firstname' => 'xsd:string', 'lastname' => 'xsd:string'),
                   array('actorid' => 'xsd:string', 'error' => 'tns:Error'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#setActor',
                   'rpc', 'encoded', 'Insert actor');                                                     
                   
$server->register('getActor',
                   array('id' => 'xsd:string'),
                   array('actor' => 'tns:Actor', 'error' => 'tns:Error'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#getActor',
                   'rpc', 'encoded', 'Return Actor');                                      

$server->register('delActor', 
                   array('id' => 'xsd:string'),
                   array('actorid' => 'xsd:string', 'error' => 'tns:Error'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#delActor',
                   'rpc', 'encoded', 'Delete actor');  
                                      
$server->register('getActorList',
                   array(),
                   array('actors' => 'tns:Actorlist', 'error' => 'tns:Error'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#getActorList',
                   'rpc', 'encoded', 'Return Actor list');  
                   
// --------------------- character ---------------------
$server->register('setCharacter', 
                   array('id' => 'xsd:string', 'charactername' => 'xsd:string', 'description' => 'xsd:string', 'notes' => 'xsd:string', 'actorid' => 'xsd:string'),
                   array('characterid' => 'xsd:string'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#setCharacter',
                   'rpc', 'encoded', 'Insert Character');                                                     
                   
$server->register('getCharacter',
                   array('id' => 'xsd:string'),
                   array('character' => 'tns:Character'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#getCharacter',
                   'rpc', 'encoded', 'Return Character'); 
                   
$server->register('delCharacter',
                   array('id' => 'xsd:string'),
                   array('characterid' => 'xsd:string', 'error' => 'tns:Error'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#delCharacter',
                   'rpc', 'encoded', 'Delete Character');                                                        

$server->register('getCharacterList',
                   array(),
                   array('characters' => 'tns:Characterlist'),
                   'urn:eventDesigner',
                   'urn:eventDesigner#getCharacterList',
                   'rpc', 'encoded', 'Return Character list');                                        
 
 // --------------- DEFINE THE METHOD AS A PHP FUNCTION ----------------------
 
 /**
 * Return version of service
 * @param array
 */
 function getVersion($client){
    global $ed;
        $retValue = '';
        $retValue = $ed->getVersion($client); //array('version' => $ed->getVersion());
    return $retValue;
}

// defenition  Location function
/**
* @desc Insert record in Data Base of Location
* 
* @param array $client
* @param string $id
* @param string location name
* @param string description
* @param string latitude
* @param string longitude
* @return array
*/
function setLocation($client, $id, $locationname, $description, $latitude, $longitude){
    global $ed;
    return $ed->setLocation($client, $id, $locationname, $description, $latitude, $longitude);
}

function delLocation($client, $id){
    global $ed;
    return $ed->delLocation($client, $id);
}

/**
* @desc Get location 
* 
* @param string id
* @return array
*/
function getLocation($client, $id){
    global $ed;
    return $ed->getLocation($client, $id);
}

/**
* Get location list
* 
* @return array
*/
function getLocationList($client){
    global $ed;
    return $ed->getLocationList($client);
    
    //$retValue = array('location' => $locationlist, 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
}


// defenition equipment function
/**
* Insert equipment in Database
* 
* @param mixed $equipmentname
* @param mixed $description
* @param mixed $owner
* @param mixed $costofrent
* 
* @return array
*/
function setEquipment($client, $id = null, $equipmentname, $description, $owner, $costofrent){
    global $ed;
    return $ed->setEquipment($client, $id, $equipmentname, $description, $owner, $costofrent);
}

/**
* Get equipment
* 
* @param mixed $id
* @return array
*/
function getEquipment($client, $id){
    global $ed;
    return $ed->getEquipment($client, $id);
}

function delEquipment($id){
    global $ed;
    $retValue = '';
    $retValue = array('equipmentid' => $ed->delEquipment($id),
                      'error' => array('errorcode' => 0, 'errorname' => 'ok')
                      );
    return $retValue;
}
/**
* Get location list
* 
* @return array
*/
function getEquipmentList(){
    global $ed;
    $retVatue = '';
    
    $equipmentlist = $ed->getEquipmentList();
    
    $retValue = array('equipments' => $equipmentlist, 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
    
    return  $retValue; 
}

// defenition actors function
/**
* put your comment there...
* 
* @param mixed $firstname
* @param mixed $lastname
*/
function setActor($id = null, $firstname, $lastname = ''){
    global $ed;
    $retValue = '';
    $retValue = array('actorid' => $ed->setActor($id, $firstname, $lastname),
                      'error' => array('errorcode' => 0, 'errorname' => 'ok')
                      );
    return $retValue;
}

/**
* Get actor
* 
* @param mixed $id
* @return array
*/
function getActor($id){
    global $ed;
    $retValue = '';
    
    $retValue = array('actor' => $ed->getActor($id), 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
    
    return $retValue;
}

function delActor($id){
    global $ed;
    $retValue = '';
    
    $retValue = array('actorid' => $ed->delActor($id), 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
    
    return $retValue;    
}

/**
* Get actors list
* 
* @return array
*/
function getActorList(){
    global $ed;
    $retVatue = '';
    
    $actorlist = $ed->getActorList();
    
    $retValue = array('actors' => $actorlist, 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
    
    return  $retValue; 
}

// define charactor function

/**
* Insert or update cyaracter
* 
* @param mixed $firstname
* @param mixed $lastname
*/
function setCharacter($id = null, $charactername, $description = '' , $notes = '', $actorid = ''){
    global $ed;
    $retValue = $ed->setCharacter($id, $charactername, $description, $notes, $actorid); //array('characterid' => $ed->setCharacter($id, $charactername, $description, $notes, $actorid));
    return $retValue;
}


/**
* Get Character
* 
* @param mixed $id
* @return array
*/
function getCharacter($id){
    global $ed;
    return $ed->getCharacter($id); // array('character' => $ed->getCharacter($id));
}

function delCharacter($id){
    global $ed;
    
    return array('charecterid' => $ed->delCharacter($id), 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
}

/**
* Get Character list
* 
* @return array
*/
function getCharacterList(){
    global $ed;
    //$rrr = $ed->getCharacterList(); // array('characters' => $ed->getCharacterList(), 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
    return $ed->getCharacterList();
}

// defenition Event function
/**
* @desc Get event
* 
* @param string
* @return array
*/
function getEvent($client, $eventid){
    global $ed;
    $retValue = '';
    
    if($eventid){
       //$retValue = array('event' => $ed->getEvent($client, $eventid), 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
       $retValue = $ed->getEvent($client, $eventid);
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
function getEventList($client){
    global $ed;
    
       $retValue = '';
       //$retValue = array('eventlist' => $ed->getEventList($client), 'error' => array('errorcode' => 0, 'errorname' => 'ok'));
       $retValue = $ed->getEventList($client);
    
    return $retValue; 
}



// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>