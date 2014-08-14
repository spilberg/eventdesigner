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
    function setLocation($locationname, $description = '', $latitude= '', $longitude = ''){
        
         $id = null;
         $data = array('locationname' => $locationname, 'description' => $description, 'latitude' => $latitude, 'longitude' => $longitude);
         
         if($this->db->Insert($data, "locations")){
            $id = $this->db->LastInsertID();    
         }
         
         return $id;
    }
    
    /**
    * @desc Get location or list location
    * 
    * @param string id
    */
    function getLocation($id =  null){
      $location = null;
        
      $id ? $where = array('id'=>$id) : '';
      
      $res = $this->db->Select("locations", $where);
      
      if($this->db->lastError == null){
         $location = $res;
      }else{
         $location = $this->db->lastError;
      }
      
      return $location; //$this->db->Select("locations", $where);
         //return array( 'id' => '1', 'locationname' => 'Gidropark', 'description' => 'Bla Bla Bla', 'latitude'   => '50.50198526955379', 'longitude' => '30.5474853515625');
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
    function setEquipment($equipmentname, $description = '', $owner = '', $costofrent = ''){
        
         $id = null;
         $data = array('equipmentname' => $equipmentname,
                       'description' => $description,
                       'owner' => $owner,
                       'costofrent' => $costofrent
                       );
         
         if($this->db->Insert($data, "equipments")){
            $id = $this->db->LastInsertID();    
         }
         
         return $id;
    }
    
    function getEquipment($id =  null){
      $equipment = null;   
        
      $id ? $where = array('id'=>$id) : '';
      
      $res = $this->db->Select("equipments", $where);
      
      if($this->db->lastError == null){
         $equipment = $res;
      }else{
         $equipment = $this->db->lastError;
      }
      
      return $equipment;
    }
    
    function getEquipmentList(){
        
        $retValue = null;
        $ret = $this->getEquipment();
        
        /* if(!is_array($ret[0])){
            $retValue = array(0 => $ret);
        }else{
            $retValue = $ret;
        }  */
           
        return (!is_array($ret[0])) ? array(0 => $ret) : $ret;
      
    }
    
    // -------------- Actors ------------------------
    function setActor($id, $firstname, $lastname = ''){
        
        if($id == null){
             $data = array('firstname' => $firstname,
                           'lastname' => $lastname
                          );    
             if($this->db->Insert($data, "actors")){
                $id = $this->db->LastInsertID();    
             }                 
        } else {
            $where =  array( 'id' => $id);
            $data = array( 'firstname' => $firstname,
                           'lastname' => $lastname
                          );
            $this->db->Update("actors", $data, $where);                          
        } 
        
        return $id;
    }
    
    function getActor($id =  null){
      $actor = null;   
        
      $id ? $where = array('id'=>$id) : '';
      
      $res = $this->db->Select("actors", $where);
      
      if($this->db->lastError == null){
         $actor = $res;
      }else{
         $actor = $this->db->lastError;
      }
      
      return $actor;
    }
    
    function getActorList(){
        
        $retValue = null;
        $ret = $this->getActor();
        
        return (!is_array($ret[0])) ? array(0 => $ret) : $ret;
    }
    
    
}
?>
