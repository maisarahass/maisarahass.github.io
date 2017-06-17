<?php

 function lang($phrase)
 {
      static $lang = array(
          
          // navbar links
      
      'HOME_ADMIN'  => 'Home',
          
      'Gategoris'   => "Section",  
          
       'ITEMS'      => 'Items',
          
       'MEMBERS'    => 'Members',
          
      'STATISTICS'  => 'Statistics',
          
       'LOGS' => 'Logs'
          
      
      );
     
     return $lang[$phrase];       
    
 }
 

