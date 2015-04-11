<?php include('config/database.php'); ?>

<!DOCTYPE html>
<html lang="en">
	
	<head>
		<?php
		    # load common scripts
			include('config/database.php');
			include('config/js.php');	
			include('config/css.php');
		?>	
		<title>Delta Hedging</title>	
		
		<!--- using the jQuery datepicker element because <input type="date"> is an HTML5 element that is
			currently only supported in Chrome and Safari --->
		<script type="text/javascript">
			$(function(){
				$('.datepicker').datepicker({
					showAnim: "fadeIn",
					changeMonth: true,
            		changeYear: true
        		}).datepicker("setDate", "0");
			})
		</script>
			
  	</head>

	<body>
		
		<div class="container">
			
			<!--- navigation panel --->
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="index.php" title="Home"><i class="fa fa-bar-chart" style="color:black"></i></a>
					</div> <!--- END navbar header --->
					<div id="navbar" class="navbar-collapse collapse">
						<ul class="nav navbar-nav">
							<li><a href="iv.php">Implied Volatility</a></li>
							<li class="active"><a href="#">Delta Hedging</a></li>
						</ul> <!--- END links --->
					</div>
				</div><!--- END conatiner-fluid --->
			</nav> <!--- END navbar --->
			
			<!--- dissmissible banner at top of page --->
			<div class="alert alert-warning alert-info" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Enter all the values below then press ENTER
			</div> <!--- END alert panel --->
			
			<?php 
				#import html for the etf drop down
				include('templates/etfdropdown.php');
			?>
			
			<?php
				#import html for date picker for expiry
				include('templates/expirydatepicker.php');
			?>
			
			<div data-toggle="tooltip" title="Enter an implied volatility, for example 20%">
				<div class="panel panel-default">
					<div class="panel-heading"><span class="label label-default label-as-badge">3</span>&nbsp&nbspEnter implied volatility (e.g 20%)</div>
						<div class="panel-body">
							<div class="input-append date">
								<input type="text" id="impliedvol" name="impliedvol">
								<span class="add-on"><i class="icon-th"></i></span>
							</div> <!--- END date input --->
						</div> <!--- END panel-body --->
				</div> <!--- END panel for premium --->
			</div>
			
			<div data-toggle="tooltip" title="Enter an strike, for example 50, then press TAB">
				<div class="panel panel-default">
					<div class="panel-heading"><span class="label label-default label-as-badge">4</span>&nbsp&nbspEnter a strike (e.g. 50)</div>
						<div class="panel-body">
							<div class="input-append date">
								<input type="text" id="strike" name="strike">
								<span class="add-on"><i class="icon-th"></i></span>
							</div> <!--- END date input --->
						</div> <!--- END panel-body --->
				</div> <!--- END panel for strike --->
			</div>
			
			<!--- output section --->
			<div class="panel panel-info">
				<div class="panel-heading">Delta Hedging Simulation</div>
					<div class="panel-body inline-block">
						<a class="btn btn-info"><span id="etf_selected">EFA</span></a>
						<a class="btn btn-info"><span id="expiry_entered">Enter an expiry</span></a> 
						<a class="btn btn-info"><span id="implied_vol_entered">Enter an implied volatility</span></a>
						<a class="btn btn-info"><span id="strike_entered">Enter a strike</span></a>
						<!--- results will be written to this div --->
						<div id="result"></div>
					</div> <!--- END panel-body --->
			</div> <!--- END panel for output --->
		</div> <!--- END container --->
		
		<!--- set default of expiry labal in output section today's date --->
		<script>
			$(document).ready(function() {
				jQuery('#expiry_entered').text($('#expiry').val());
			});
		</script>	
		
		<!--- dynamically update the EXPIRY label in the output section when the input is changed --->
		<script>
			// expiry
			$('#expiry').change(function() {
				jQuery('#expiry_entered').text($('#expiry').val());
			});
		</script>
		
		<!--- dynamically update the IMPLIED VOL label in the output section when the input is changed --->
		<script>
			// implied vol
			$('#impliedvol').change(function() {
				jQuery('#implied_vol_entered').text($('#impliedvol').val());
			});
		</script>
		
		<!--- dynamically update the STRIKE label in the output section when the input is changed --->
		<script>
			// strike
			$('#strike').change(function() {
				jQuery('#strike_entered').text(Math.abs($('#strike').val()));
			});
		</script>
		
		<!--- dynamically update the ETF label in the output section when drop down changes --->
		<script type='text/javascript'>
			// etfs changes
			$(function() {
			    $('#my_etf').change(function() {
			        var x = $(this).val();
			        $('#hidden_etf').val(x);
			        jQuery('#etf_selected').text($('#my_etf').val());
			    });
			});
		</script>
		
		<!--- ajax call to 'deltahedginghandler.php' to generate delta hedging output without reloading the page --->
		<!--- updates delta hedging output as user changes implied vol --->
		<script>
			// call php
			$(document).ready(function() {
				$('#impliedvol').change(function() {
					
					var v = $('#impliedvol').val().replace('%','');
					if (v < 0) {
						alert('Volatility must be positive.  Defaulting to 20%.');
						//$('#impliedVol').val('20%');
						$('#implied_vol_entered').text('20%');
					} else {
						//alert('we are ok');
						jQuery('#implied_vol_entered').text($('#impliedvol').val());
						// here
						$.ajax({
							type: 'GET',
							url: 'deltahedginghandler.php',
							data: {'etf':$('#my_etf').val(), 'expiry':$('#expiry').val(), 'impliedvol':$('#impliedvol').val(), 'strike':$('#strike').val()},
							success: function(msg) {
								$('#result').html(msg); // write output to the #result div
							} 
						});
					}
				});
			});
		</script>
		
		<!--- ajax call to 'deltahedginghandler.php' to generate delta hedging output without reloading the page --->
		<!--- updates delta hedging output as user changes option expiry --->
		<script>
			// call php
			$(document).ready(function() {
				$('#expiry').change(function() {
					$.ajax({
						type: 'GET',
						url: 'deltahedginghandler.php',
						data: {'etf':$('#my_etf').val(), 'expiry':$('#expiry').val(), 'impliedvol':$('#impliedvol').val(),  'strike':$('#strike').val()},
						success: function(msg) {
							$('#result').html(msg); // write output to the #result div
						} 
					});
				});
			});
		</script>
		
		<!--- ajax call to 'deltahedginghandler.php' to generate delta hedging output without reloading the page --->
		<!--- updates delta hedging output as user changes the etf --->
		<script>
			// call php
			$(document).ready(function() {
				$('#my_etf').change(function() {
					$.ajax({
						type: 'GET',
						url: 'deltahedginghandler.php',
						data: {'etf':$('#my_etf').val(), 'expiry':$('#expiry').val(), 'impliedvol':$('#impliedvol').val(), 	'strike':$('#strike').val()},
						success: function(msg) {
							$('#result').html(msg); // write output to the #result div
						} 
					});
				});
			});
		</script>
		
		<!--- ajax call to 'deltahedginghandler.php' to generate delta hedging output without reloading the page --->
		<!--- updates delta hedging output as user changes strike --->
		<script>
			// call php
			$(document).ready(function() {
				$('#strike').change(function() {
					$.ajax({
						type: 'GET',
						url: 'deltahedginghandler.php',
						data: {'etf':$('#my_etf').val(), 'expiry':$('#expiry').val(), 'impliedvol':$('#impliedvol').val(), 'strike':$('#strike').val()},
						success: function(msg) {
							$('#result').html(msg); // write output to the #result div				
						}
					});
				});
			});
		</script>

	</body> <!--- END BODY --->  
	
</html>
