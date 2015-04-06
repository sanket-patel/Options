<?php

	include('analytics/utilities.php');
	include('analytics/blackscholes.php');
	
	if (!empty($_GET['etf']) && !empty($_GET['expiry']) && !empty($_GET['premium']) && !empty($_GET['strike'])) {
				
		// set variables
		$etf = $_GET['etf'];
		$expiry = $_GET['expiry'];
		$premium = $_GET['premium'];
		$strike = $_GET['strike'];
		
		// set additional variables
		$spot_date = '2014-01-02';
		$spot = get_price_as_of($spot_date, $etf);
		$dcf = get_daycount_fraction($spot_date, $expiry);
		$sigma_initial = 0.25;
		$rate = 0.0;
		
		// calculate option price and implied vol
		$option_price = bs_price($spot, $strike, $rate, $sigma_initial, $dcf);
		$implied_vol = newton_raphson($premium, $strike, $spot, $dcf, $rate);
		
		if ($implied_vol < 0) {
			echo '<a class="btn btn-warning">unable to solve for implied volatility with the given inputs</a>';
		} else {
			echo '<a class="btn btn-success">Implied Volatility: '.($implied_vol*100).'%'.'</a>';
		}
		
	} else {
		echo '<br>'.'please enter all values';
	}

?>