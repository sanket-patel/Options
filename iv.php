<?php include('config/setup.php'); ?>

<!DOCTYPE html>
<html lang="en">
	
	<head>
		<?php
			include('config/setup.php');
			include('config/js.php');	
			include('config/css.php');
		?>	
		<title>Implied Volatility</title>
		
		
		
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
							<li class="active"><a href="#">Implied Volatility</a></li>
							<li><a href="dh.php">Delta Hedging</a></li>
						</ul> <!--- END links --->
					</div>
				</div><!--- END conatiner-fluid --->
			</nav> <!--- END navbar --->
			
			<div class="alert alert-warning alert-info" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Enter all the values below then press ENTER
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading"><span class="label label-default label-as-badge">1</span>&nbsp&nbspSelect an ETF</div>
					<div class="panel-body">
						<!---
						<ul class="nav nav-pills" role="tablist" id="etfs">
							<li role="presentation"><a  onclick="setEFA()">EFA</a></li>
							<li role="presentation"><a href="#">IWM</a></li>
							<li role="presentation"><a href="#">SPY</a></li>
						</ul> ---><!--- END ul --->
						<select class="selectpicker" id="myEtf">
				    		<option>EFA</option>
				    		<option>IWM</option>
					    	<option>SPY</option>
  						</select>
  						<input type='hidden' id='myhiddenEtf' value=''>
					</div> <!--- END panel-body --->
			</div> <!--- END panel for etf dropdown--->
			
			<div class="panel panel-default">
				<div class="panel-heading"><span class="label label-default label-as-badge">2</span>&nbsp&nbspSelect option expiry</div>
					<div class="panel-body">
						<div class="input-append date">
							<input type="date" id="expiry" name="expiry" />
							<span class="add-on"><i class="icon-th"></i></span>
						</div> <!--- END date input --->
					</div> <!--- END panel-body --->
			</div> <!--- END panel for expiry--->
			
			<div class="panel panel-default">
				<div class="panel-heading"><span class="label label-default label-as-badge">3</span>&nbsp&nbspEnter option premium</div>
					<div class="panel-body">
						<div class="input-append date">
							<input type="text" id="premium" name="premium">
							<span class="add-on"><i class="icon-th"></i></span>
						</div> <!--- END date input --->
					</div> <!--- END panel-body --->
			</div> <!--- END panel for premium --->
			
			<div class="panel panel-default">
				<div class="panel-heading"><span class="label label-default label-as-badge">4</span>&nbsp&nbspEnter a strike</div>
					<div class="panel-body">
						<div class="input-append date">
							<input type="text" id="strike" name="strike">
							<span class="add-on"><i class="icon-th"></i></span>
						</div> <!--- END date input --->
					</div> <!--- END panel-body --->
			</div> <!--- END panel for strike --->
			
			<div class="panel panel-info">
				<div class="panel-heading">Implied Volatility</div>
					<div class="panel-body inline-block">
						<a class="btn btn-info"><span id="etfSelected">EFA</span></a>
						<a class="btn btn-info"><span id="dateEntered">DATE</span></a>
						<a class="btn btn-info"><span id="premiumEntered">PREMIUM</span></a>
						<a class="btn btn-info"><span id="strikeEntered">STRIKE</span></a>
						<a class="btn btn-success"><span id="result">IMPLIED VOL%</span></a>
						<!--- <div id="result2"></div> --->
					</div> <!--- END panel-body --->
			</div> <!--- END panel for output --->
		
		</div> <!--- END container --->
		
		<script>
			// expiry changes
			$('#expiry').change(function() {
				jQuery('#expiryEntered').text($('#expiry').val());
				});
		</script>
		
		<script>
			// premium changes
			$('#premium').change(function() {
				jQuery('#premiumEntered').text($('#premium').val());
				});
		</script>
		
		<script>
			// strike
			$('#strike').change(function() {
				jQuery('#strikeEntered').text($('#strike').val());
				});
		</script>
		
		<script type='text/javascript'>
			// etfs changes
			$(function() {
			    $('#myEtf').change(function() {
			        var x = $(this).val();
			        $('#myhiddenEtf').val(x);
			        jQuery('#etfSelected').text($('#myEtf').val());
			    });
			});
			</script>
		
		<script>
			// call php
			$(document).ready(function() {
				$('#premium').change(function() {
					$.ajax({
						type: 'GET',
						url: 'calcimpliedvol.php',
						data: {'etf':$('#myEtf').val(), 'expiry':$('#expiry').val(), 'premium':$('#premium').val(), 'strike':$('#strike').val()},
						success: function(msg) {
							$('#result').html(msg);
						} 
					});
				});
			});
		</script>
		
		<script>
			// call php
			$(document).ready(function() {
				$('#expiry').change(function() {
					$.ajax({
						type: 'GET',
						url: 'calcimpliedvol.php',
						data: {'etf':$('#myEtf').val(), 'expiry':$('#expiry').val(), 'premium':$('#premium').val(),  'strike':$('#strike').val()},
						success: function(msg) {
							$('#result').html(msg);
						} 
					});
				});
			});
		</script>
		
		<script>
			// call php
			$(document).ready(function() {
				$('#myEtf').change(function() {
					$.ajax({
						type: 'GET',
						url: 'calcimpliedvol.php',
						data: {'etf':$('#myEtf').val(), 'expiry':$('#expiry').val(), 'premium':$('#premium').val(), 	'strike':$('#strike').val()},
						success: function(msg) {
							$('#result').html(msg);
						} 
					});
				});
			});
		</script>
		
		<script>
			// call php
			$(document).ready(function() {
				$('#strike').change(function() {
					$.ajax({
						type: 'GET',
						url: 'calcimpliedvol.php',
						data: {'etf':$('#myEtf').val(), 'expiry':$('#expiry').val(), 'premium':$('#premium').val(), 'strike':$('#strike').val()},
						success: function(msg) {
							$('#result').html(msg);						
						}
					});
				});
			});
		</script>

	</body> <!--- END BODY --->  
	
</html>
