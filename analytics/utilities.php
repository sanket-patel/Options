<?php

	/*
	 * approximate cumulative density
	 */
	function cdf($x) {
		$b1 = 0.31938153;
    	$b2 = -0.356563782;
    	$b3 = 1.781477937;
    	$b4 = -1.821255978;
    	$b5 = 1.330274429;
    	$p = 0.2316419;
    	$c2 = 0.3989423;
		
    	$a = abs($x);
    	$t = 1 / (1 + $a * $p);
    	$b = $c2 * exp((-$x) * ($x / 2));
    	$v = (((($b5 * $t + $b4) * $t + $b3) * $t + $b2) * $t + $b1) * $t;
    
    	if ($x > 0) {
        	return 1 - $b * $v;
    	} else {			
        	return 1 - (1 - $b * $v);
		}
	}
	
	/*
	 * calculate the daycount fraction between two date assuming an ACT/360 basis
	 */
	function get_daycount_fraction($dateFrom, $dateTo) {
		$dateFrom = new DateTime($dateFrom);
		$dateTo = new DateTime($dateTo);
		$interval = $dateFrom->diff($dateTo);
		$dcfAct360 = ($interval->days) / 360;
		
		return (float)$dcfAct360;
	}
	
	/*
	 * checks whether expiry entered by user is on or before 1/2/2014
	 */
	function is_valid_expiry($expiry) {
		$spot_date = '2014-01-02';
		if (strtotime($expiry) <= strtotime($spot_date)) {
			return false;
		} else {
			return true;
		}
	}
	
	
	/*
	 * converts a date from "mm/dd/yyyy" into yyyymmdd
	 */
	function format_expiry($expiry) {
		list($month, $day, $year) = explode('/', $expiry);
		return $year.$month.$day;
	}
	
	/*
	 * converts a string into a date
	 */
	function format_as_date($dt) {
		$dt = new DateTime($dt);
		return $dt->format('m/d/Y');
	}
	
	/*
	 * calculates probability density funtion
	 */	
	function pdf($x) {
		return  (1.0 / sqrt(2.0 * pi())) * exp(-pow($x, 2.0) * 0.5);
	}
	
	/*
	 * converts a double formatted to display the desired number of digits 
	 */
	function format_num($num, $digits) {
		return number_format($num, $digits);
	}
	
	/*
	 * conversts a date string from yyyy-mm-dd into yyyymmdd
	 */
	function remove_hyphen_from_date($date) {
		// remove - from date 
		$date = str_replace('-', '', $date);
		return $date;	
	}
	
	/* 
	 * executes query and returns results
	 */
	function execute_query($query) {
		include('config/database.php');
		$result = mysqli_query($dbc, $query);
		return $result;
	}
	
	/*
	 * returns etf price of on a given day
	 */
	function get_price_as_of($date, $etf){
		include('config/database.php');
		$query = "SELECT Price FROM ".$etf." WHERE Date = '".remove_hyphen_from_date($date)."'";
		$result = execute_query($query);		// there should only be 1 row in the result
		$price = mysqli_fetch_assoc($result);	//convert results into an associative array
		return $price['Price'];
	}
	
	/*
	 * returns an alert if the expiry entered (for implied vol calcultion) equal the valuaion day
	 */
	function display_expiry_alert() {
		echo "<script>alert('Expiry must be at least 1 day after 1/2/2014')</script>";
	}


?>