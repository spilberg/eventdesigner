<?php

error_reporting(ALL);
    include_once('config.php');
    include_once('inc/class.MySQL.php');
    
    $db = new MySQL($ed_db, $ed_db_user, $ed_db_pass, $ed_db_host);   
    
    // var_dump($db->Select("locations", array('id'=>'1')));
    
   $d =   $db->ExecuteSQL("Select * from locations");
        //   $s = $db->ArrayResult();
        
        var_dump($db->arrayedResult);
    
    /* if($db->Select("locations", array('id'=>'1'))){
        $d = $db->ArrayResult();
        echo $d;
    }  */
?>
