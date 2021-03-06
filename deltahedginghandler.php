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
		
		// make sure expiry is after 1/2/2014
		if (!is_valid_expiry($expiry)) {
			echo die('<br><br><a class="btn btn-danger">Please ensure expiry is after 01/02/2014</a>');
		}
			
		$impliedvol = ((float)str_replace('%','',$impliedvol) / 100); //convert to number
		$strike = $_GET['strike'];
		
		// make sure strike and implied vol are grater than 0
		if (!params_all_valid(array($strike, $impliedvol))) {
			echo die('<br><a class="btn btn-danger">Please ensure both the strike and implied vol are greater than 0</a>');
		}

		// set additional variables
		$spot_date = '2014-01-02';
		$dcf = get_daycount_fraction($spot_date, $expiry);
		$rate = 0.0;
		
		// if the expiry entered is on or before 12/31/2014, price the options
		// only up until day(expiry-1) because option on day(expiry) will result in
		// a dividy by 0 error because the daycount fracation  will be 0
		$cutoff = new DateTime('2014-12-31');
		$adjust = false;
		if (new DateTime($expiry) <= $cutoff) {
			$adjust = true;
		}
		
		// get data from db
		$expiry = remove_hyphen_from_date($expiry);
		$expiry = format_expiry($expiry);
		$query = "SELECT * FROM ".$etf." WHERE Str_to_date(Date, '%Y%m%d') <= Str_to_date('".$expiry."', '%Y%m%d')";
		$results = execute_query($query);
				
		// array to hold options
		$options = array();
		
		// populate options array
		if ($results->num_rows > 0) {
			
			$i = 1;
			while($row = $results->fetch_assoc()) {
				// if the expiry entered is on or before 12/31/2014, price the options
				// only up until day(expiry-1) because option on day(expiry) will result in
				// a dividy by 0 error because the daycount fracation  will be 0
				if (($adjust) && ($i == $results->num_rows)) {
					break;
				}
		    	$spot_date = $row["Date"];
		    	$spot = $row["Price"];
				$option = new EuroOptionPosition($spot, $strike, $spot_date, $expiry, $impliedvol, $rate); //create an option for each day
				$options[] = $option;
				$i += 1;
		    }
			
			// containers for simulation data
			$option_pnl = array(); //call(t) - call(t-1)
			$equity_pnl = array(); //dollardelta(t) - dollardelta(t-1)
			$cashflows = array();  //(delta(t) - delta(t-1)) * spot(t)
			$hedge_pnl = array();  //dollardelta(t) + cashflows(t)
			$daily_pnl = array();  //call(t) - hedge_pnl(t)
			
			// perform delta hedging simulation
			$pnl_array = array($option_pnl, $equity_pnl, $cashflows, $hedge_pnl, $daily_pnl);
			$pnl_array = perform_delta_hedging($options, $pnl_array);
			
			// column headers for the output
			$columns = array('Date', 'Option', 'Spot', 'Dollar Delta', 'Option PNL', 'Hedge PNL', 'Daily PNL');
			
			// start formatting the output into an html table
			$table_tag = '<table class="table table-hover table-condensed table-striped">';
			
			// table heading
			$table_head = '<thead><tr>';
			foreach($columns as $column) {
				$table_head = $table_head.'<th>'.$column.'</th>';
			}
			$table_head = $table_head.'</thead>';
			
			// table body
			$table_body = '<tbody>';
			$i = 0;
			
			// create html for each row of the table
			foreach($options as $option) {
				$tr = '<tr>';
				$tr = $tr.'<td>'.format_as_date($option->spot_date).'</td>';
				$tr = $tr.'<td>'.format_num((float)$option->price,4).'</td>';							//option price
				$tr = $tr.'<td>'.format_num((float)$option->spot,4).'</td>';							//spot
				$tr = $tr.'<td>'.format_num((float)$option->dollar_delta,4).'</td>';					//dollar delta
				$tr = $tr.'<td>'.format_num((float)$pnl_array[0][$i],4).'</td>';						//option pnl	
				$tr = $tr.'<td>'.format_num((float)$pnl_array[3][$i],4).'</td>';						//hedge pnl	
				$tr = $tr.'<td>'.format_num((float)$pnl_array[4][$i],4).'</td>';						//total pnl
				$tr = $tr.'</tr>';
				$table_body = $table_body.$tr;
				$i = $i + 1;
			}
			
			// add a final row which sums the option pnl, hedge pnl and daily pnl columns
			$table_body = $table_body.'<tr><td>-</td><td>-</td><td>-</td><td>-</td>';
			$table_body = $table_body.'<td><strong>'.format_num(array_sum($pnl_array[0]),4).'</strong></td>';	// sum of option pnl
			$table_body = $table_body.'<td><strong>'.format_num(array_sum($pnl_array[3]),4).'</strong></td>';	// sum of hedge pnl
			$table_body = $table_body.'<td><strong>'.format_num(array_sum($pnl_array[4]),4).'</strong></td>';	// sum of daily pnl
			$table_body = $table_body.'</tr>';
			
			$table_body = $table_body.'</tbody>';
			
			// combine all table elements to form full table
			$table = $table_tag.$table_head.$table_body.'</table>';
			
			// add a reload link
			echo '<br><a href="dh.php">Reload Page</a><br><br>'.$table;

		} else {
			// nothing 
		    echo die('<br><a class="btn btn-danger>Something went wrong...please try again</a>');
		}
		
	} else {
		echo die('<br><a class="btn btn-warning">Please enter all values and ensure no values are 0</a>');
	}

?>