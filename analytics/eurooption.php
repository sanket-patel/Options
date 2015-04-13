<?php

	require_once 'analytics/utilities.php';
	require_once 'analytics/blackscholes.php';
	
	/*
	 * European option class (assumes option is a call)
	 */
	class EuroOptionPosition {
		
		public $delta;
		public $price;
		public $expiry;
		public $spot;
		public $strike;
		public $rate;
		public $sigma;
		public $spot_date;
		public $dcf;
		public $dollar_delta;
		//public $vega;
		private $d1;
		
		/*
		 * constructor
		 */
		function __construct($spot, $strike, $spot_date, $expiry, $sigma, $rate) {
			$this->spot_date = $spot_date;
			$this->expiry = $expiry;
			$this->spot = $spot;
			$this->strike = $strike;
			$this->rate = $rate;
			$this->sigma = $sigma;
			
			// automatically call price_option() method 
			$this->price_option();
		}
			
		/*
		 * prices the option and computes delta and dollar delta
		 */
		private function price_option() {
			$this->dcf = (float)get_daycount_fraction($this->spot_date, $this->expiry);
			$this->price = (float)bs_price($this->spot, $this->strike, $this->rate, $this->sigma, $this->dcf);
			$this->d1 = (float)get_d1($this->spot, $this->strike, $this->rate, $this->sigma, $this->dcf);
			//$this->delta = (float)bs_delta($this->spot, $this->strike, $this->rate, $this->sigma, $this->dcf);
			$this->delta = (float)bs_delta_from_d1($this->d1);
			//$this->vega = (float)bs_vega($this->spot, $this->d1, $this->dcf);
			$this->dollar_delta = $this->delta * $this->spot;
		}
	}
	
?>