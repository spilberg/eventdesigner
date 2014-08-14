<?php
/**
*  event designer main class
*  @author Nick Korbut
*  @name eventdesigner
*  @version 0.0.0.4
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
    * 
    */
    function eventDesigner($db = null){
       $this->db = $db;
       $this->today = date("Y-m-d H:i:s"); 
       $this->version = "Event Designer version 0.0.0.4";
    }
    
    /**
    * Return version o service
    * 
    * @return string
    */
    function getVersion(){
        return $this->version;   
    }
    
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
    
    function setLocation($locationname, $description = '', $latitude= '', $longitude = ''){
        
         $locationid = null;
         $data = array('locationname' => $locationname, 'description' => $description, 'latitude' => $latitude, 'longitude' => $longitude);
         
         if($this->db->Insert($data, "locations")){
            $locationid = $this->db->LastInsertID();    
         }
         
         return $locationid;
    }

    
    
}
?>
