<?php

	/*
	 * computes and returns d1
	 */
	function get_d1($spot, $strike, $rate, $sigma, $dcf) {
    	return (log($spot / $strike) + ($rate + (pow($sigma, 2)) / 2) * $dcf) / ($sigma * sqrt($dcf));
	}
	
	/*
	 * computes and returns vega
	 */	
	function bs_vega($spot, $d1, $dcf) {
    	return $spot * pdf($d1) * sqrt($dcf);
	}
			
	/*
	 * black scholes analytical pricer
	 * only calls have been implemented
	 */ 	
	function bs_price($spot, $strike, $rate, $sigma, $dcf) {
    	$d1 = get_d1($spot, $strike, $rate, $sigma, $dcf);
    	$d2 = $d1 - $sigma * sqrt($dcf);
    	$nd1 = cdf($d1);
    	$nd2 = cdf($d2);
		
    	return $nd1 * $spot - $nd2 * $strike * exp(-$rate * $dcf);
	}
	
	/*
	 * computes and returns delta
	 */ 
	function bs_delta($spot, $strike, $rate, $sigma, $dcf) {
    	$d1 = get_d1($spot, $strike, $rate, $sigma, $dcf);
    	$nd1 = cdf($d1);
    	return $nd1;
	}
	
	/*
	 * implements simple version of newton-raphson solver
	 * converges quickly but has trouble dealing with deep ITM and OTM options
	 * a lower bound of 00001 has been set on vega so it doesn't cause the update of
	 * the implied vol estimate to blow up
	 */ 
	function newton_raphson($market_price, $strike, $spot, $dcf, $rate) {
				
    	$tolerance = 0.000000000001;
    	$sigma = 1.0;	// initial guess
    	$model_price = 0;
		$bound_1 = 0.00001;
		$bound_2 = 0.000000001;

	    $max_iters = 100;
		$iters = 0;
		
		// if option is too deep OTM, solver will fail
		// return error message 
		if ($market_price < 0.001) {
			return die('<a class="btn btn-warning">Premium is too low to effectively compute implied volatility</a>');	
		}
		
	    while (abs($market_price - $model_price) > $tolerance) {
	    	
	    	// kick out of loop if max iterations is hit
	    	// genreally speaking, newton raphson shouldn't require 100 iterations for solving implied vol
	    	if($iters >= $max_iters) {
	    		// since we exited solver before finding a solution, display the result as a warning
	    		return die('<a class="btn btn-danger>Solver failed to converge because max iterations reached</a>');
			}
			
			// we need d1 and vega because the objective function needs f'(x)
			// which in this case is d(price)/d(vol)
	        $d1 = get_d1($spot, $strike, $rate, $sigma, $dcf);
	        $vega = bs_vega($spot, $d1, $dcf);
			$model_price = bs_price($spot, $strike, $rate, $sigma, $dcf);
						
			// kick out of loop if vega gets too small
			// vega close to 0 will cause f(x)/f'(x) to blow up and sovler to fail
			if ($vega < $bound_2) {
				// since we exited solver before finding a solution, display the result as a warning
				return die('<a class="btn btn-danger">Solver failed to converge because the inputs provided lead to a Vega of '.$vega.'</a>');
			}
			
	       	// update estimate
	       	$sigma = $sigma - (($model_price - $market_price) / $vega);			
			$iters = $iters + 1;
		}
		
		// format from decimal to percentage
		$sigma = format_num($sigma*100.0, 6).'%';
		
		if (($vega <= $bound_1) && ($vega >= $bound_2)) {
			// display warning if solution was found but vega is small
			return '<a class="btn btn-warning">'.$sigma.' (unreliable due to magnitude of Vega)</a>';
		} elseif ($vega < $bound_2) {
			// return failure if vega is too small
			return '<a class="btn btn-danger">Solver failed to converge because the inputs provided lead to a Vega of '.$vega.'</a>';
		} else {
			// successfully converged
			return '<a class="btn btn-success">'.$sigma.'</a>';	
		}
	
	}
		
?>