<?php
/**
*  event designer main class
*  @author Nick Korbut
*  @name eventdesigner
*  @version 0.0.0.5
*/

class eventDesigner {
    
    /**
    * Version of service
    * 
    * @var mixed
    */
    var $version = "";
    
    var $db = null;
    
    var $today = null; 
    
    var $dbpref = '';
 
    
    
    /**
    * Constructor
    */
    function eventDesigner($db = null){
       $this->db = $db;
       $this->today = date("Y-m-d H:i:s"); 
       $this->version = "Event Designer version 0.0.0.5";
       //$this->dbpref = "jos_event_";
       $this->dbpref = "";
    }
    
    /**
    * Check client
    * 
    * @param mixed $client
    * @return string $id
    */
    function checkClient($client){
       
      $retValue = null;
        
      $where = array('clientname' => $client['clientname'], 'clientcode' => $client['clientcode']);
      
      $res = $this->db->Select($this->dbpref."clients", $where);
      
      if($this->db->lastError == null && $this->db->records !== 0){
         $retValue = $res['id'];
      }
      
      return $retValue; 
    }
    
    // ---------------- Version -----------------
    /**
    * Return version o service
    * 
    * @return string
    */
    function getVersion($client){
        global $server;
        
        if($this->checkClient($client) == null) $server->fault('Server', 'client not found', 'setVersion', 'details: '.$this->today);
        
        return $this->version;   
    }
    
    // ---------------- Event ------------------
    /**
    * Return Event object
    * 
    * @param mixed $eventId
    * @return mixed
    */
    function getEvent($client, $eventid){
        global $server;
        $retValue = array ('eventid'     => $eventid,
                           'eventname'   => 'Birthday',
                           'starttime'   => '06.08.2014 12:00',
                           'endtime'     => '09.08.2014 20:00',
                           'description' => 'Vasia`s birthday',
                           'notes'       => 'Event notes',
                           'responsible' => 'Vyacheslav Korbut',
                           'estimate'    => '1000',
                           'location'    => $this->getLocation($client, '1'),
                           'taskline'    => $this->getTaskline($eventid)
                    );
               
        return $retValue;
    }
    
    /**
    * @desc return Event without taskline and location
    */
    function getEventItem($userid){
        global $server;
         $retValue = array ('eventid'     => $userid,
                           'eventname'   => 'ivent etem for userid:' . $userid,
                           'starttime'   => '06.08.2014 12:00',
                           'endtime'     => '09.08.2014 20:00',
                           'description' => 'Vasia`s birthday',
                           'notes'       => 'Event notes',
                           'responsible' => 'Vyacheslav Korbut',
                           'estimate'    => '1000'
                           );
       
        return $retValue;
    }
    
    /**
    * @desc  return Event list
    */
    function getEventList($client){
        global $server;
        
       $retarray = array();
       
       array_push($retarray, new soapval('Eventlist', 'tns:Eventitem', $this->getEventItem('1')));
       array_push($retarray, new soapval('Eventlist', 'tns:Eventitem', $this->getEventItem('2')));
       array_push($retarray, new soapval('Eventlist', 'tns:Eventitem', $this->getEventItem('3')));
    
       return $retarray; 
    }
    
    
    // ---------------- Task --------------------
    /**
    * @desc Return task
    * @param string
    * @return array
    */
    function getTask($id){
        global $server;
        
        $retValue = array ('taskname'    => 'Task '.$id,
                           'starttime'   => '09.08.2014 8:00',
                           'endtime '    => '09.08.2014 9:00',
                           'description' => 'Transfer equipments to location',
                           'responsible' => 'Vyacheslav Korbut',
                           'activity'    => 'run to location',
                           'cost'        => '15'
                          );
                    
        return $retValue;
    }
    
    function getTaskline($id){
        global $server;
       // $retValue = array($this->getTask('1'), $this->getTask('2'), $this->getTask('3'));
       // return $this->getTask('1'); //$retValue;
       $retarray = array();
       
       array_push($retarray, new soapval('Taskline', 'tns:Task', $this->getTask('1')));
       array_push($retarray, new soapval('Taskline', 'tns:Task', $this->getTask('2')));
       array_push($retarray, new soapval('Taskline', 'tns:Task', $this->getTask('3')));
       
       return $retarray;
    }
    
    
    // -------------- Location --------------------
    
    /**
    * Insert or update location
    * 
    * @param array $client
    * @param string $id
    * @param string $locationname
    * @param string $description
    * @param string $latitude
    * @param string $longitude
    * @return string inserted or updated $id
    */
    function setLocation($client, $id, $locationname, $description = '', $latitude= '', $longitude = ''){
        global $server;
        
        $cl = $this->checkClient($client);
        if($cl !== null){
            $data = array('clientid' => $cl, 'locationname' => $locationname, 'description' => $description, 'latitude' => $latitude, 'longitude' => $longitude);
                 
             if($id == null){
                 
                 if($this->db->Insert($data, $this->dbpref."locations")){
                   $id = $this->db->LastInsertID();    
                 } 
                 
             } else {
                 $where =  array( 'id' => $id, 'clientid' => $cl);
                 $this->db->Update($this->dbpref."locations", $data, $where);    
             }    
             
        } else {
           $server->fault('Server', 'client not found', 'setLocation', 'details: '.$this->today);   
        }
        
         return $id;
    }
    
    /**
    * @desc Get location or list location
    * 
    * @param array $client
    * @param string $id
    * @return array
    */
    function getLocation($client, $id =  null){
        global $server;
        $item = null;

        $cl = $this->checkClient($client);
        if($cl !== null){

            ($id && $cl) ? $where = array('id'=>$id, 'clientid' => $cl) : $where = array('clientid' => $cl);
            $res = $this->db->Select($this->dbpref."locations", $where);

            if($this->db->lastError == null && $this->db->records !== 0){
                $item = $res;
            } else {
                $server->fault('Server', 'id: '. $id .' not found', 'getLocation', 'details: '.$this->today);
            }

        }else{
            $server->fault('Server', 'client not found', 'getLocation', 'details: '.$this->today);     
        }

        return $item;
    }
    
    /**
    * Get list of location
    * 
    * @param array $client
    * @return array 
    */
    function getLocationList($client){
        global $server;
        
        $ret = $this->getLocation($client);
        
        return (!is_array($ret[0])) ? array(0 => $ret) : $ret; 
    }
    
    /**
    * @desc Delete location
    * 
    * @param array $client
    * @param string $id
    * @return string deleted id
    */
    function delLocation($client, $id){
        global $server;
        $item = null;

        $cl = $this->checkClient($client);
        if($cl !== null){

            $where = array('id'=>$id, 'clientid' => $cl);

            $res = $this->db->Delete($this->dbpref."locations", $where);

            if($this->db->lastError == null && $this->db->affected !== 0){
                $item = $id;
            } else {
                $server->fault('Server', 'id: '.$id.' not found', 'delLocation', 'details: '.$this->today); 
            }
            
        } else {
            $server->fault('Server', 'client not found', 'delLocation', 'details: '.$this->today);         
        }
        
        return $item; 
    }
    
    
    // -------------- Equipments -------------------
    
    /**
    * Insert or updated Equipment
    * 
    * @param array $client
    * @param string $id
    * @param string $equipmentname
    * @param string $description
    * @param string $owner
    * @param string $costofrent
    * @return string inserted or updated id
    */
    function setEquipment($client, $id, $equipmentname, $description = '', $owner = '', $costofrent = ''){
        global $server;

        $cl = $this->checkClient($client);
        if($cl !== null){

            $data = array('clientid' => $cl, 'equipmentname' => $equipmentname, 'description' => $description, 'owner' => $owner, 'costofrent' => $costofrent );

            if($id == null){
                if($this->db->Insert($data, $this->dbpref."equipments")){
                    $id = $this->db->LastInsertID();    
                }    
            } else {
                $where =  array( 'id' => $id, 'clientid' => $cl);
                $this->db->Update($this->dbpref."equipments", $data, $where);                          
            }

        } else {
            $server->fault('Server', 'client not found', 'setEquipment', 'details: '.$this->today);   
        }

        return $id;
    }
    
    function getEquipment($client, $id =  null){
        global $server;
        $item = null;   

        $cl = $this->checkClient($client);
        if($cl !== null){

            ($id && $cl) ? $where = array('id'=>$id, 'clientid' => $cl ) : $where = array('clientid' => $cl);

            $res = $this->db->Select($this->dbpref."equipments", $where);

            if($this->db->lastError == null && $this->db->records !== 0){
                $item = $res;
            }else{
                $server->fault('Server', 'id: '.$id.' not found', 'getEquipment', 'details: '.$this->today);
            }
            
        } else {
            $server->fault('Server', 'client not found', 'getEquipment', 'details: '.$this->today);      
        }

        return $item;
    }
    
    function getEquipmentList($client){
        global $server;
        
        $retValue = null;
        $ret = $this->getEquipment($client);
        
        return (!is_array($ret[0])) ? array(0 => $ret) : $ret;
      
    }
    
    function delEquipment($client, $id){
        global $server;
        $item = null;   

        $cl = $this->checkClient($client);
        if($cl !== null){

            $where = array('id'=>$id);

            $res = $this->db->Delete($this->dbpref."equipments", $where);

            if($this->db->lastError == null && $this->db->affected !== 0){
                $item = $id;
            }else{
                $server->fault('Server', 'id: '.$id.' not found', 'delEquipment', 'details: '.$this->today); 
            }
            
        } else {
            $server->fault('Server', 'client not found', 'delEquipment', 'details: '.$this->today);         
        }

        return $item;  
    }
    
    // -------------- Actors ------------------------
    /**
    * Insert or update actor
    * 
    * @param array $client
    * @param string $id
    * @param string $firstname
    * @param string $lastname
    * @return string inserted or updated id
    */
    function setActor($client, $id, $firstname, $lastname = ''){
        global $server;
        
        $cl = $this->checkClient($client);
        if($cl !== null){
                
            $data = array('clientid' => $cl, 'firstname' => $firstname, 'lastname' => $lastname ); 
            
            if($id == null){
                 if($this->db->Insert($data, $this->dbpref."actors")){
                    $id = $this->db->LastInsertID();    
                 }                 
            } else {
                $where =  array( 'id' => $id, 'clientid' => $cl);
                $this->db->Update($this->dbpref."actors", $data, $where);                          
            } 
            
        } else {
           $server->fault('Server', 'client not found', 'setActor', 'details: '.$this->today);    
        }
        
        return $id;
    }
    
    function getActor($client, $id =  null){
        global $server;
        $item = null; 

        $cl = $this->checkClient($client);
        if($cl !== null){

            ($id && $cl) ? $where = array('id'=>$id, 'clientid' => $cl ) : $where = array('clientid' => $cl);

            $res = $this->db->Select($this->dbpref."actors", $where);

            if($this->db->lastError == null && $this->db->records !== 0){
                $item = $res;
            }else{
                $item = $server->fault('Server', 'id: '.$id .' not found', 'getActor', 'details: '.$this->today);  //$this->db->lastError; //new soap_fault('Server', '', $this->db->lastError);   
            }
        } else {
            $server->fault('Server', 'client not found', 'getEquipment', 'details: '.$this->today);         
        }
        
        return $item;
    }
    
    function getActorList($client){
        global $server;
        
        $retValue = null;
        $ret = $this->getActor($client);
        
        return (!is_array($ret[0])) ? array(0 => $ret) : $ret;
    }
    
    function delActor($client, $id){
        global $server;
        $item = null;   
        $cl = $this->checkClient($client);
        if($cl !== null){

            $where = array('id'=>$id);

            $res = $this->db->Delete($this->dbpref."actors", $where);

            if($this->db->lastError == null && $this->db->affected !== 0){
                $item = $id;
            }else{
                $item = $server->fault('Server', 'id: '.$id.' not found', 'delActor', 'details: '.$this->today);  //$this->db->lastError; //new soap_fault('Server', '', $this->db->lastError);   
            } 
        }else{
            $server->fault('Server', 'client not found', 'delActor', 'details: '.$this->today);         
        }  

        return $item;
    }
    
    // -----------  Character ---------------------
    function setCharacter($client, $id, $charactername, $description = '', $notes = '', $actorid = ''){
        global $server;

        $cl = $this->checkClient($client);
        if($cl !== null){

            $data = array('clientid' => $cl, 'charactername' => $charactername, 'description' => $description, 'notes' => $notes, 'actorid' => $actorid); 
            
            if($id == null){
                if($this->db->Insert($data, $this->dbpref."characters")){
                    $id = $this->db->LastInsertID();    
                }                 
            } else {
                $where =  array( 'id' => $id, 'clientid' => $cl);
                $this->db->Update($this->dbpref."characters", $data, $where);                          
            } 
        } else {
            $server->fault('Server', 'client not found', 'setCharacter', 'details: '.$this->today);     
        }
        
        return $id;
    }
    
    function getCharacter($client, $id =  null){
        global $server;
        $item = null;   

        $cl = $this->checkClient($client);
        if($cl !== null){

            ($id && $cl) ? $where = array('id'=>$id, 'clientid' => $cl ) : $where = array('clientid' => $cl);

            $res = $this->db->Select($this->dbpref."characters", $where);

            if($this->db->lastError == null && $this->db->records != 0){
                $item = $res;
            }else{
                $server->fault('Server', 'id: '.$id.' not found', 'getCharacter', 'details: '.$this->today); 
            }
            
        } else {
            $server->fault('Server', 'client not found', 'getCharacter', 'details: '.$this->today);         
        }
        
        return $item;
    }
    
    function getCharacterList($client){
        global $server;
        $ret = $this->getCharacter($client);
        return (!is_array($ret[0])) ? array(0 => $ret) : $ret;
    }
    
    function delCharacter($client, $id){
        global $server;  
        $item = null;   

        $cl = $this->checkClient($client);
        if($cl !== null){ 

            $where = array('id'=>$id);

            $res = $this->db->Delete($this->dbpref."characters", $where);  

            if($this->db->lastError == null && $this->db->affected !== 0){
                $item = $id;
            }else{
                $server->fault('Server', 'id: '.$id.' not found', 'delCharacter', 'details: '.$this->today); 
            }
        } else {
            $server->fault('Server', 'client not found', 'delCharacter', 'details: '.$this->today);          
        }

        return $item;
      
    }
    
    
    // -----------  Action ---------------------
    function setAction($client, $id, $duration='', $timelag ='', $actionname, $description = '', $equipments = '', $roles = ''){
        global $server;

        $cl = $this->checkClient($client);
        if($cl !== null){

            $data = array('clientid' => $cl, 'duration' => $duration, 'timelag' => $timelag, 'actionname' => $actionname, 'description' => $description, 'equipments' =>  $equipments, 'roles' => $roles); 
            
            if($id == null){
                if($this->db->Insert($data, $this->dbpref."actions")){
                    $id = $this->db->LastInsertID();    
                }                 
            } else {
                $where =  array( 'id' => $id, 'clientid' => $cl);
                $this->db->Update($this->dbpref."actions", $data, $where);                          
            } 
        } else {
            $server->fault('Server', 'client not found', 'setAction', 'details: '.$this->today);     
        }
        
        return $id;
    }
    
    function getAction($client, $id =  null){
        global $server;
        $item = null;   

        $cl = $this->checkClient($client);
        if($cl !== null){

            ($id && $cl) ? $where = array('id'=>$id, 'clientid' => $cl ) : $where = array('clientid' => $cl);

            $res = $this->db->Select($this->dbpref."actionss", $where);

            if($this->db->lastError == null && $this->db->records != 0){
                $item = $res;
            }else{
                $server->fault('Server', 'id: '.$id.' not found', 'getAction', 'details: '.$this->today); 
            }
            
        } else {
            $server->fault('Server', 'client not found', 'getAction', 'details: '.$this->today);         
        }
        
        return $item;
    }
    
    function getActionList($client){
        global $server;
        $ret = $this->getAction($client);
        return (!is_array($ret[0])) ? array(0 => $ret) : $ret;
    }
    
    function delAction($client, $id){
        global $server;  
        $item = null;   

        $cl = $this->checkClient($client);
        if($cl !== null){ 

            $where = array('id'=>$id);

            $res = $this->db->Delete($this->dbpref."actions", $where);  

            if($this->db->lastError == null && $this->db->affected !== 0){
                $item = $id;
            }else{
                $server->fault('Server', 'id: '.$id.' not found', 'delAction', 'details: '.$this->today); 
            }
        } else {
            $server->fault('Server', 'client not found', 'delAction', 'details: '.$this->today);          
        }

        return $item;
      
    }    
    
}
?>