<?php include('config/setup.php'); ?>

<!DOCTYPE html>
<html lang="en">
	
	<head>
		<?php
			include('config/setup.php');
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
					<a class="navbar-brand" href="#"><i class="fa fa-bar-chart"></i></a>
  				</div> <!--- END navbar header --->
  				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
  						<li><a href="iv.php">Implied Volatility</a></li>
  						<li><a href="dh.php">Delta Hedging</a></li>
					</ul> <!--- END links --->
  				</div>
			</div><!--- END conatiner-fluid --->
  		</nav> <!--- END navbar --->

  		<div class="jumbotron">
			<h3>Implied Volatility and Delta Hedging</h3>
			Begin by selecting either Implied Volatility or Delta Hedging above
  		</div> <!--- END jumbotron --->

	</div> <!--- END container --->

  </body>
  
</html>
