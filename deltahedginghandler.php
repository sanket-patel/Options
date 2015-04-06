<?php

	include('analytics/utilities.php');
	include('analytics/blackscholes.php');
	include('analytics/eurooption.php');
	
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
			
		} else {
		    echo "0 results";
		}

	} else {
		echo '<br>'.'please enter all values';
	}

?>