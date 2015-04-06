<?php

	require_once 'analytics/utilities.php';
	require_once 'analytics/blackscholes.php';

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
		
		function __construct($spot, $strike, $spot_date, $expiry, $sigma, $rate) {
				
			$this->spot_date = $spot_date;
			$this->expiry = $expiry;
			$this->spot = $spot;
			$this->strike = $strike;
			$this->rate = $rate;
			$this->sigma = $sigma;
			
			$this->price_option();
			
		}
			
		private function price_option() {
			
			$this->dcf = get_daycount_fraction($this->spot_date, $this->expiry);
			$this->price = bs_price($this->spot, $this->strike, $this->rate, $this->sigma, $this->dcf);
			$this->delta = bs_delta($this->spot, $this->strike, $this->rate, $this->sigma, $this->dcf);
			
		}
		
	}
	
		

?>