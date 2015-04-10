<?php

	include('analytics/utilities.php');
	include('analytics/blackscholes.php');
	
	// make sure all inputs have were specified by user
	if (!empty($_GET['etf']) && !empty($_GET['expiry']) && !empty($_GET['premium']) && !empty($_GET['strike'])) {
			
		// assign variables to values from the GET request
		$etf = $_GET['etf'];
		
		$expiry = $_GET['expiry'];
		if ($expiry == '01/02/2014') {
			display_expiry_alert();
			$expiry = '01/03/2014';
		}
		
		
		$premium = $_GET['premium'];
		$strike = abs($_GET['strike']);
		
		// set additional variables
		$spot_date = '2014-01-02';		// implied vol is being calculated as of 1/2/2014
		$spot = get_price_as_of($spot_date, $etf);
		$dcf = get_daycount_fraction($spot_date, $expiry);
		//$sigma_initial = 0.25;
		$rate = 0.0;
		
		// calculate option price and implied vol
		//$option_price = bs_price($spot, $strike, $rate, $sigma_initial, $dcf);
		$implied_vol = newton_raphson($premium, $strike, $spot, $dcf, $rate);
	
		// return output of implied vol solver to webpage
		echo $implied_vol;	
		 
	} else {
		// not all values were entered on the webpage
		echo '<br>'.'please enter all values';
	}

?>