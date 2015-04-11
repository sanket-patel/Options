<!DOCTYPE html>
<html lang="en">
	
	<head>
		<?php
			//include('config/setup.php');
			include('config/js.php');	
			include('config/css.php');
		?>	
		<title>IV and Delta Hedging</title>
  	</head>

  <body>

	<div class="container">
  		
  		<nav class="navbar navbar-default">
			<div class="container-fluid">
  				<div class="navbar-header">
					<a class="navbar-brand" href="#" title="Home"><i class="fa fa-bar-chart" style="color:black	"></i></a>
  				</div> <!--- END navbar header --->
  				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
  						<li><a href="iv.php">Implied Volatility</a></li>
  						<li><a href="dh.php">Delta Hedging</a></li>
					</ul> <!--- END links --->
  				</div>
			</div><!--- END conatiner-fluid --->
  		</nav> <!--- END navbar --->
  		
		<div class="text-muted">
	  		<div class="jumbotron">
	  			
				<h2 class="text-info">Implied Volatility and Delta Hedging</h2>
				
				<br>
				<a href="iv.php"><h4 class="text-warning">Implied Volatility</h4></a>
				
				This page will compute implied volatility for a call with a given expiry and premium
				as of Jan 2, 2014.  Note, not all combinations of inputs will result in a solution for implied volatility.  
				The implied volatility solver uses the Newton-Raphson method for estimating implied volatility.
				
				<br><br><br>
				<a href="dh.php"><h4  class="text-warning">Delta Hedging</h4></a>
				This page will a perform delta hedging simulation until expiry for a call option on an ETF with a given strike,
				implied volatility, and maturity.  The calculation assumes implied volatility remains constant
				through the life of the option..
			</div> <!--- END jumbotron --->
		</div>  <!--- END muted text --->

	</div> <!--- END container --->

  </body>
  
</html>
