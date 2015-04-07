<?php

	function perform_delta_hedging($options, $pnl_array) {
		
		$option_pnl = $pnl_array[0];
		$equity_pnl = $pnl_array[1];
		$cashflow = $pnl_array[2];
		$hedge_pnl = $pnl_array[3];
		$daily_pnl = $pnl_array[4];
		
		// t(0) values are all 0
		$option_pnl[] = 0.0;
		$equity_pnl[] = 0.0;
		$cashflows[] = 0.0;
		$hedge_pnl[] = 0.0;
		$daily_pnl[] = 0.0;
		
		#echo 'IN THE HEDGING...<br>';
		$num_options = count($options);
		#echo $num_options.'<br>';
		
		echo '<br>';
		for ($t = 1; $t < $num_options; $t++) {
				
			// get options pnl
			$opt_pnl = (float)-($options[$t]->price - $options[$t-1]->price);  //we are short the call
			// get equity pnl
			$eq_pnl = $options[$t]->dollar_delta -  $options[$t-1]->dollar_delta;
			// get cashflow from rebalancing the delta
			$cashflow = $options[$t]->spot * ($options[$t]->delta -  $options[$t-1]->delta);
			// get total hedge pnl
			$hedge = -($eq_pnl + $cashflow);
			// get total pnl (option + hedge)
			$total_pnl = $opt_pnl + $hedge;

			$option_pnl[] = (float)$opt_pnl;		
			$equity_pnl[] = (float)$eq_pnl;
			$cashflows[] = (float)$cashflow;
			$hedge_pnl[] = 	(float)$hedge;
			$daily_pnl[] = (float)$total_pnl;
				
		}
		
		// collect the results
		return array($option_pnl, $equity_pnl, $cashflow, $hedge_pnl, $daily_pnl);
	}

?>

