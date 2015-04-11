<?php include('config/database.php'); ?>

<!DOCTYPE html>
<html lang="en">
	
	<head>
		<?php
			include('config/js.php');	
			include('config/css.php');
		?>	
		<title>Implied Volatility</title>
		
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
							<li class="active"><a href="#">Implied Volatility</a></li>
							<li><a href="dh.php">Delta Hedging</a></li>
						</ul> <!--- END links --->
					</div>
				</div><!--- END conatiner-fluid --->
			</nav> <!--- END navbar --->
			
			<!--- dissmissible banner at top of page --->
			<div class="alert alert-warning alert-info" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Enter all the values below then press ENTER
			</div>
			
			<?php 
				#import html for the etf drop down
				include('templates/etfdropdown.php');
			?>
			
			<?php
				#import html for date picker for expiry
				include('templates/expirydatepicker.php');
			?>
			
			<div data-toggle="tooltip" title="Enter an option premium, for example 20">
				<div class="panel panel-default">
					<div class="panel-heading"><span class="label label-default label-as-badge">3</span>&nbsp&nbspEnter option premium (e.g. 20)</div>
						<div class="panel-body">
							<div class="input-append date">
								<input type="text" id="premium" name="premium">
								<span class="add-on"><i class="icon-th"></i></span>
							</div> <!--- END date input --->
						</div> <!--- END panel-body --->
				</div> <!--- END panel for premium --->
			</div>
			
			<div data-toggle="tooltip" title="Enter an strike, for example 60, then press TAB">
				<div class="panel panel-default">
					<div class="panel-heading"><span class="label label-default label-as-badge">4</span>&nbsp&nbspEnter a strike (e.g. 60)</div>
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
				<div class="panel-heading">Implied Volatility</div>
					<div class="panel-body inline-block">
						<a class="btn btn-info"><span id="etf_selected">EFA</span></a>
						<a class="btn btn-info"><span id="expiry_entered">Enter an expiry</span></a>
						<a class="btn btn-info"><span id="premium_entered">Enter a premium</span></a>
						<a class="btn btn-info"><span id="strike_entered">Enter a strike</span></a>
						<!--- results will be written here --->
						<span id="result"><a class="btn btn-success">Implied Volatility</a></span>
					</div> <!--- END panel-body --->
			</div> <!--- END panel for output --->
		
		</div> <!--- END container --->
						 
		<!--- dynamically update the EXPIRY label in the output section when the input is changed --->
		<script>
			// expiry changes
			$('#expiry').change(function() {
				jQuery('#expiry_entered').text($('#expiry').val());
				});
		</script>
		
		<!--- dynamically update the PREMIUM label in the output section when the input is changed --->
		<script>
			// premium changes
			$('#premium').change(function() {
				jQuery('#premium_entered').text($('#premium').val());
				});
		</script>
		
		<!--- dynamically update the STRIKE label in the output section when the input is changed --->
		<script>
			// strike
			$('#strike').change(function() {
				// make display strike as positive
				// convert negative strike into postive in php script
				jQuery('#strike_entered').text($('#strike').val());
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
			
		<!--- set default of expiry labal in output section today's date --->
		<script>
			$(document).ready(function() {
				jQuery('#expiry_entered').text($('#expiry').val());
			});
		</script>		
		
		<!--- ajax call to 'impliedvolatilityhandler.php' calculate implied volatility without reloading the page --->
		<!--- updates implied volatility as user changes strike --->
		<script>
			// call php
			$(document).ready(function() {
				$('#premium').change(function() {
					$.ajax({
						type: 'GET',
						url: 'impliedvolatilityhandler.php',
						data: {'etf':$('#my_etf').val(), 'expiry':$('#expiry').val(), 'premium':$('#premium').val(), 'strike':$('#strike').val()},
						success: function(msg) {
							$('#result').html(msg); // write output to the #result div
						} 
					});
				});
			});
		</script>
		
		<!--- ajax call to 'impliedvolatilityhandler.php' calculate implied volatility without reloading the page --->
		<!--- updates implied volatility as user changes strike --->
		<script>
			// call php
			$(document).ready(function() {
				$('#expiry').change(function() {
					$.ajax({
						type: 'GET',
						url: 'impliedvolatilityhandler.php',
						data: {'etf':$('#my_etf').val(), 'expiry':$('#expiry').val(), 'premium':$('#premium').val(),  'strike':$('#strike').val()},
						success: function(msg) {
							$('#result').html(msg); // write output to the #result div
						} 
					});
				});
			});
		</script>
		
		<!--- ajax call to 'impliedvolatilityhandler.php' calculate implied volatility without reloading the page --->
		<!--- updates implied volatility as user changes strike --->
		<script>
			// call php
			$(document).ready(function() {
				$('#my_etf').change(function() {
					$.ajax({
						type: 'GET',
						url: 'impliedvolatilityhandler.php',
						data: {'etf':$('#my_etf').val(), 'expiry':$('#expiry').val(), 'premium':$('#premium').val(), 	'strike':$('#strike').val()},
						success: function(msg) {
							$('#result').html(msg); // write output to the #result div
						} 
					});
				});		
			});
		</script>
		
		<!--- ajax call to 'impliedvolatilityhandler.php' calculate implied volatility without reloading the page --->
		<!--- updates implied volatility as user changes strike --->
		<script>
			// call php
			$(document).ready(function() {
				$('#strike').change(function() {
					$('#strike').val();
					$.ajax({
						type: 'GET',
						url: 'impliedvolatilityhandler.php',
						data: {'etf':$('#my_etf').val(), 'expiry':$('#expiry').val(), 'premium':$('#premium').val(), 'strike':$('#strike').val()},
						success: function(msg) {
							$('#result').html(msg);	// write output to the #result div					
						}
					});
				});
			});
		</script>
		
		<!--- makes informational pop-up appear when user mouses over each section of the page --->
		<script>
			$('[data-toggle="tooltip"]').tooltip({
			    'placement': 'left'
			});
			
			$('[data-toggle="popover"]').popover({
			    trigger: 'hover',
			        'placement': 'left'
			});
		</script>

	</body> <!--- END BODY --->  
	
</html>
