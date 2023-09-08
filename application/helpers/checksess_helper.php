<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('session_logs')) {

    function session_logs($username, $action) {
	$CI = & get_instance();
    }

}

function financialyear($syear,$flag){

    $year  = explode('-',$syear);
    if($flag == 0){
      $getyr = $year[0].'-04-01';      ///   Code For Start Financial year     
    }elseif($flag == 1){
      $getyr   = ($year[0]+1).'-03-31';   ///   Code For End Financial year     
    }else{
      $getyr = '';
    }
    return $getyr;

 }
