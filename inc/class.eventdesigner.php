<?php
/**
*  event designer main class
*  @author Nick Korbut
*  @name eventdesigner
*  @version 0.0.0.1
*/

class eventDesigner {
    
    /**
    * Version of service
    * 
    * @var mixed
    */
    var $version = "Event Designer version 0.0.0.2";
 
    
    
    /**
    * Constructor
    * 
    */
    function eventDesigner(){
       $this->version = "Event Designer version 0.0.0.3";
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
                           'location'    => array( 'locationname' => 'Gidropark', 'latitude'     => '0010', 'longitude'   => '0020')
                    );
               
        return $retValue;
    }
    
    
}
?>
