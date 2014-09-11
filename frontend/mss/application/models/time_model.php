<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Time_model extends CI_Model {

	function __construct() {

		// 呼叫模型(Model)的建構函數
		parent::__construct();
	}
	

    function ebaytimeleft($endtime)
    {

        $year = substr($endtime, 0, 4);
        $month = substr($endtime, 5, 2);
        $day = substr($endtime, 8, 2);
        $hour = substr($endtime, 11, 2);
        $minute = substr($endtime, 14, 2);
        $second = substr($endtime, 17, 2);

        $endtime_timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        $seconds_left = $endtime_timestamp - time();


        $time_left = getdate($seconds_left);
        return $time_left_string = $time_left['yday'].'D '.$time_left['hours'].'H '.$time_left['minutes'].'M '.$time_left['seconds'].'S';

    } // function


    function ebaytimeleftsec($endtime)
    {

        $year = substr($endtime, 0, 4);
        $month = substr($endtime, 5, 2);
        $day = substr($endtime, 8, 2);
        $hour = substr($endtime, 11, 2);
        $minute = substr($endtime, 14, 2);
        $second = substr($endtime, 17, 2);

        $endtime_timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        $seconds_left = $endtime_timestamp - time();

        return $seconds_left;

    } // function





 }