<?php

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
		
?>