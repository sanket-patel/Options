<?php

	// etfselected
	// dateEntered
	// premiumEntered

	// make sure variables have been set
	
	//1 get price as of jan2 2014 ->
	//2 bs pricer
	
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
		$dateTo = new DateTIme($dateTo);
		$interval = $dateFrom->diff($dateTo);
		$dcfAct360 = ($interval->days) / 360;
		
		return (float)$dcfAct360;
	}
	
	function pdf($x) {
		return 1 / (sqrt(2 * pi()) * exp(-(pow($x, 2) / 2)));
	}
		
	function get_d1($spot, $strike, $rate, $sigma, $dcf) {
    	return (log($spot / $strike) + ($rate + (pow($sigma, 2)) / 2) * $dcf) / ($sigma * sqrt($dcf));
	}
		
	function bs_vega($spot, $d1, $dcf) {
    	return $spot * pdf($d1) * sqrt($dcf);
	}
			
	function bs_price($spot, $strike, $rate, $sigma, $dcf) {
    	$d1 = get_d1($spot, $strike, $rate, $sigma, $dcf);
    	$d2 = $d1 - $sigma * sqrt($dcf);
    	$nd1 = cdf($d1);
    	$nd2 = cdf($d2);
		
    	return $nd1 * $spot - $nd2 * $strike * exp(-$rate * $dcf);
	}
	
	function newton_raphson($market_price, $strike, $spot, $dcf, $rate) {
    		
    	$tolerance = 0.000000001;
    	$sigma = 0.25;	// initial guess
    	$model_price = 0;

	    $max_iters = 10000;
		$iters = 0;
	    while (abs($market_price - $model_price) > $tolerance) {
	    	
	    	if($iters >= $max_iters) {
	    		break;
			}
			
	        $d1 = get_d1($spot, $strike, $rate, $sigma, $dcf);
	        $vega = bs_vega($spot, $d1, $dcf);
	        $model_price = bs_price($spot, $strike, $rate, $sigma, $dcf);
	        $sigma = $sigma - ($model_price - $market_price) / $vega;
	        //echo '<br>'.$iters.'----->.'.$market_price.'------'.$model_price.'------'.$sigma;
			$iters = $iters + 1;
		}
		
    
    	return $sigma;
	}
		
	function remove_hyphen_from_date($date) {
		// remove - from date 
		$date = str_replace('-', '', $date);
		return $date;	
	}
	
	function get_price_as_of($date, $etf){
		// get price as of a date
		include('config/setup.php');
		$query = "SELECT Price FROM ".$etf." WHERE Date = '".remove_hyphen_from_date($date)."'";
		#echo $query;
		$result = mysqli_query($dbc, $query);
		$price = mysqli_fetch_assoc($result);
		return $price['Price'];
	}
	
	if (!empty($_GET['etf']) && !empty($_GET['expiry']) && !empty($_GET['premium']) && !empty($_GET['strike'])) {
		// everthing has been set
		$etf = $_GET['etf'];
		$expiry = $_GET['expiry'];
		$premium = $_GET['premium'];
		$strike = $_GET['strike'];
		
		// make call to db
		$spot_date = '2014-01-02';
		$spot = get_price_as_of($spot_date, $etf);
		$dcf = get_daycount_fraction($spot_date, $expiry);
		$sigma_initial = 0.25;
		$rate = 0.0;
		//echo $spot
		
		$option_price = bs_price($spot, $strike, $rate, $sigma_initial, $dcf);
		//echo $spot.'----'.$strike.'----'.$dcf.'----'; 
		//echo '<br>bs price'.$option_price;
		//echo '<br>entered premium>'.$premium;
		$implied_vol = newton_raphson($premium, $strike, $spot, $dcf, $rate);
		echo ($implied_vol*100).'%';
		
	} else {
		echo 'please enter all values';
	}


	
	
?>