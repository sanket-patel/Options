<?php include('config/setup.php'); ?>

<!DOCTYPE html>
<html lang="en">
	
	<head>
		<?php
			include('config/setup.php');
			include('config/js.php');	
			include('config/css.php');
		?>	
		<title>Delta Hedging</title>
  	</head>

  <body>

	<div class="container">
  		
  		<nav class="navbar navbar-default">
			<div class="container-fluid">
  				<div class="navbar-header">
					<a class="navbar-brand" href="index.php"><i class="fa fa-bar-chart"></i></a>
  				</div> <!--- END navbar header --->
  				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
  						<li><a href="iv.php">Implied Volatility</a></li>
  						<li class="active"><a href="#">Delta Hedging</a></li>
					</ul> <!--- END links --->
  				</div>
			</div><!--- END conatiner-fluid --->
  		</nav> <!--- END navbar --->

	</div> <!--- END container --->

  </body>
  
</html>
