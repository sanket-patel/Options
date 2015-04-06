<?php

	function compute_pnl($options, $pnl_array) {
		
		$option_pnl = $pnl_array[0];
		$equity_pnl = $pnl_array[0];
		$cashflow = $pnl_array[0];
		$hedge_pnl = $pnl_array[0];
		$daily_pnl = $pnl_array[0];
		
		// t(0) values are all 0
		$option_pnl[] = 0.0;
		$equity_pnl[] = 0.0;
		$cashflows[] = 0.0;
		$hedge_pnl[] = 0.0;
		$daily_pnl[] = 0.0;
		
		$num_options = count($options);
		for ($t = 0; $t <= $num_options; $t++) {
			
			// get options pnl
			$option_pnl[] = $options[t]->price -  $options[t-1]->price;
			// get equity pnl
			$equity_pnl[] = $options[t]->dollar_delta -  $options[t-1]->dollar_delta;
			// get cashflow from rebalancing the delta
			$cashflows[] = $options[t]->dollar_delta -  $options[t-1]->dollar_delta;	
		}
		
	}

?>