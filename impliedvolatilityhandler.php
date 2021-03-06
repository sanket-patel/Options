<?php

	include('analytics/utilities.php');
	include('analytics/blackscholes.php');
	
	// make sure all inputs have were specified by user
	if (!empty($_GET['etf']) && !empty($_GET['expiry']) && !empty($_GET['premium']) && !empty($_GET['strike'])) {
			
		// assign variables to values from the GET request
		$etf = $_GET['etf'];
		$expiry = $_GET['expiry'];
		
		// make sure expiry isn't in the past or on 1/2/2014
		if (!is_valid_expiry($expiry)) {
			echo die('<br><br><a class="btn btn-danger">Please ensure expiry is after 01/02/2014</a>');
		}
		
		// get premium and strike from GET request
		$premium = $_GET['premium'];
		$strike = $_GET['strike'];

		// make sure strike and premium are grater than 0
		if (!params_all_valid(array($strike, $premium))) {
			echo die('<br><br><a class="btn btn-danger">Please ensure both the strike and premium are greater than 0</a>');
		}
		
		// set additional variables
		$spot_date = '2014-01-02';		// implied vol is being calculated as of 1/2/2014
		$spot = get_price_as_of($spot_date, $etf);
		$dcf = get_daycount_fraction($spot_date, $expiry);
		$rate = 0.0;
		
		// calculate implied vol
		$implied_vol = newton_raphson($premium, $strike, $spot, $dcf, $rate);
	
		// return output of implied vol solver to webpage
		echo $implied_vol;	
		 
	} else {
		// not all values were entered on the webpage
		echo die('<br><br><a class="btn btn-warning">Please enter all values and ensure no values are 0</a>');
	}

?>