<?php

	function cdf($x) {
		// approximation of cumulative density function
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
	
	function get_daycount_fraction($dateFrom, $dateTo) {
		// calculate day count fraction between two dates
		$dateFrom = new DateTime($dateFrom);
		$dateTo = new DateTime($dateTo);
		$interval = $dateFrom->diff($dateTo);
		$dcfAct360 = ($interval->days) / 360;
		
		return (float)$dcfAct360;
	}
	
	function pdf($x) {
		return 1 / (sqrt(2 * pi()) * exp(-(pow($x, 2) / 2)));
	}
	
	function remove_hyphen_from_date($date) {
		// remove - from date 
		$date = str_replace('-', '', $date);
		return $date;	
	}
	
	function execute_query($query) {
		include('config/setup.php');
		$result = mysqli_query($dbc, $query);
		return $result;
	}
	
	function get_price_as_of($date, $etf){
		// get price as of a date
		include('config/setup.php');
		$query = "SELECT Price FROM ".$etf." WHERE Date = '".remove_hyphen_from_date($date)."'";
		#echo $query;
		$result = execute_query($query);
		$price = mysqli_fetch_assoc($result);
		return $price['Price'];
	}

?>