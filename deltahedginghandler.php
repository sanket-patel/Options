<?php

	include('analytics/utilities.php');
	include('analytics/blackscholes.php');
	include('analytics/eurooption.php');
	include('analytics/deltahedging.php');
	
	if (!empty($_GET['etf']) && !empty($_GET['expiry']) && !empty($_GET['impliedvol']) && !empty($_GET['strike'])) {
			
		// set variables
		$etf = $_GET['etf'];
		$expiry = $_GET['expiry'];
		$impliedvol = $_GET['impliedvol'];
		$strike = $_GET['strike'];
		
		// set additional variables
		$spot_date = '2014-01-02';
		//$spot = get_price_as_of($spot_date, $etf);
		$dcf = get_daycount_fraction($spot_date, $expiry);
		$rate = 0.0;
		
		// get data from db
		$expiry = remove_hyphen_from_date($expiry);
		#$expiry = '20140111';
		$query = "SELECT * FROM ".$etf." WHERE Str_to_date(Date, '%Y%m%d') <= Str_to_date('".$expiry."', '%Y%m%d')";
		$results = execute_query($query);
		
		// array to hold options
		$options = array();
		
		// populate options array
		if ($results->num_rows > 0) {
		    
			while($row = $results->fetch_assoc()) {
				
		    	$spot_date = $row["Date"];
		    	$spot = $row["Price"];
				$option = new EuroOptionPosition($spot, $strike, $spot_date, $expiry, $impliedvol, $rate);
				$options[] = $option;
		    }
			
			// options have been set, now perform delta hedging
			$option_pnl = array(); //call(t) - call(t-1)
			$equity_pnl = array(); //dollardelta(t) - dollardelta(t-1)
			$cashflows = array();  //(delta(t) - delta(t-1)) * spot(t)
			$hedge_pnl = array();  //dollardelta(t) + cashflows(t)
			$daily_pnl = array();  //call(t) - hedge_pnl(t)
			
			// perform delta hedging simulation
			$pnl_array = array($option_pnl, $equity_pnl, $cashflows, $hedge_pnl, $daily_pnl, $options);
			$pnl_array = perform_delta_hedging($options, $pnl_array);
			
			// format output into html table
			$formatted_output = convert_to_table($options, $pnl_array);
			
		} else {
		    echo "0 results";
		}
		
		

	} else {
		echo '<br>'.'please enter all values';
	}

?>