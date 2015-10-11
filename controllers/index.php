<?php

Class Controller_Index Extends Controller_Base {

   
    
    function index() {
        
         $api = new Dota();
         $arr = $api->start();
         
         $match_id = 1854959431;
         $match = $api->get_match_by_id($match_id);

         $this->des->set('arr',$arr['result']);
         $this->des->set('match',$match['result']);
      
        $this->des->display('index');
    }

}

?>