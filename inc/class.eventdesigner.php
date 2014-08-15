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
 
    
    
    /**
    * Constructor
    */
    function eventDesigner($db = null){
       $this->db = $db;
       $this->today = date("Y-m-d H:i:s"); 
       $this->version = "Event Designer version 0.0.0.5";
    }
    
    // ---------------- Version -----------------
    /**
    * Return version o service
    * 
    * @return string
    */
    function getVersion(){
        return $this->version;   
    }
    
    // ---------------- Event ------------------
    /**
    * Return Event object
    * 
    * @param mixed $eventId
    * @return mixed
    */
    function getEvent($eventid){
        
        $retValue = array ('eventid'     => $eventid,
                           'eventname'   => 'Birthday',
                           'starttime'   => '06.08.2014 12:00',
                           'endtime'     => '09.08.2014 20:00',
                           'description' => 'Vasia`s birthday',
                           'notes'       => 'Event notes',
                           'responsible' => 'Vyacheslav Korbut',
                           'estimate'    => '1000',
                           'location'    => $this->getLocation('1'),
                           'taskline'    => $this->getTaskline($eventid)
                    );
               
        return $retValue;
    }
    
    /**
    * @desc return Event without taskline and location
    */
    function getEventItem($userid){
        
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
    function getEventList($userid){
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
       // $retValue = array($this->getTask('1'), $this->getTask('2'), $this->getTask('3'));
       // return $this->getTask('1'); //$retValue;
       $retarray = array();
       
       array_push($retarray, new soapval('Taskline', 'tns:Task', $this->getTask('1')));
       array_push($retarray, new soapval('Taskline', 'tns:Task', $this->getTask('2')));
       array_push($retarray, new soapval('Taskline', 'tns:Task', $this->getTask('3')));
       
       return $retarray;
    }
    
    
    // -------------- Location --------------------
    function setLocation($id, $locationname, $description = '', $latitude= '', $longitude = ''){
        
         
         $data = array('locationname' => $locationname, 'description' => $description, 'latitude' => $latitude, 'longitude' => $longitude);
         
         if($id == null){
             if($this->db->Insert($data, "locations")){
               $id = $this->db->LastInsertID();    
             } 
         } else {
             $where =  array( 'id' => $id);
            $this->db->Update("locations", $data, $where);    
         }
         
         return $id;
    }
    
    /**
    * @desc Get location or list location
    * 
    * @param string id
    */
    function getLocation($id =  null){
      $item = null;
        
      $id ? $where = array('id'=>$id) : '';
      
      $res = $this->db->Select("locations", $where);
      
      if($this->db->lastError == null){
         $item = $res;
      }else{
         $item = $this->db->lastError; //new soap_fault('Server', '', $this->db->lastError);
      }
      
      return $item;
    }
    
    function getLocationList(){
        $retValue = null;
        $ret = $this->getLocation();
        
        /* 
        if(!is_array($ret[0])){
            $retValue = array(0 => $ret);
        }else{
            $retValue = $ret;
        }  */
           
        return (!is_array($ret[0])) ? array(0 => $ret) : $ret; //$retValue;
    }
    
    
    // -------------- Equipments -------------------
    function setEquipment($id, $equipmentname, $description = '', $owner = '', $costofrent = ''){
        
         $id = null;
         $data = array('equipmentname' => $equipmentname,
                       'description' => $description,
                       'owner' => $owner,
                       'costofrent' => $costofrent
                       );
         
         if($id == null){
            if($this->db->Insert($data, "equipments")){
               $id = $this->db->LastInsertID();    
            }    
         } else {
            $where =  array( 'id' => $id);
            $this->db->Update("equipments", $data, $where);                          
         }
         
         return $id;
    }
    
    function getEquipment($id =  null){
      global $server;
      $item = null;   
        
      $id ? $where = array('id'=>$id) : '';
      
      $res = $this->db->Select("equipments", $where);
      
      if($this->db->lastError == null && $this->db->records !== 0){
         $item = $res;
      }else{
          $server->fault('Server', 'Not found', 'getEquipment', 'details');
         //$item = new soap_fault('Server', '', $this->db->lastError);   
      }
      
      return $item;
    }
    
    function getEquipmentList(){
        
        $retValue = null;
        $ret = $this->getEquipment();
        
        return (!is_array($ret[0])) ? array(0 => $ret) : $ret;
      
    }
    
    // -------------- Actors ------------------------
    function setActor($id, $firstname, $lastname = ''){
        
        $data = array('firstname' => $firstname,
                      'lastname' => $lastname
                      ); 
        if($id == null){
             if($this->db->Insert($data, "actors")){
                $id = $this->db->LastInsertID();    
             }                 
        } else {
            $where =  array( 'id' => $id);
            $this->db->Update("actors", $data, $where);                          
        } 
        
        return $id;
    }
    
    function getActor($id =  null){
      global $server;
      $item = null;   
        
      $id ? $where = array('id'=>$id) : '';
      
      $res = $this->db->Select("actors", $where);
      
      if($this->db->lastError == null && $this->db->records !== 0){
         $item = $res;
      }else{
         $item = $server->fault('Server', 'Not found', 'getEquipment', 'details');  //$this->db->lastError; //new soap_fault('Server', '', $this->db->lastError);   
      }
      
      return $item;
    }
    
    function getActorList(){
        
        $retValue = null;
        $ret = $this->getActor();
        
        return (!is_array($ret[0])) ? array(0 => $ret) : $ret;
    }
    
    // -----------  Character ---------------------
    function setCharacter($id, $charactername, $description = '', $notes = '', $actorid = ''){
        
        $data = array('charactername' => $charactername,
                      'description' => $description,
                      'notes' => $notes,
                      'actorid' => $actorid
                      ); 
        if($id == null){
             if($this->db->Insert($data, "characters")){
                $id = $this->db->LastInsertID();    
             }                 
        } else {
            $where =  array( 'id' => $id);
            $this->db->Update("characters", $data, $where);                          
        } 
        
        return $id;
    }
    
    function getCharacter($id =  null){
      $item = null;   
        
      $id ? $where = array('id'=>$id) : '';
      
      $res = $this->db->Select("characters", $where);
      
      if($this->db->lastError == null){
         $item = $res;
      }else{
         $item = $this->db->lastError; //new soap_fault('Server', '', $this->db->lastError);   
      }
      
      return $item;
    }
    
    function getCharacterList(){
        $ret = $this->getCharacter();
        return (!is_array($ret[0])) ? array(0 => $ret) : $ret;
    }
}
?>
