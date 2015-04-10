<?php include('config/setup.php'); ?>

<!DOCTYPE html>
<html lang="en">
	
	<head>
		<?php
		    # load common scripts
			include('config/setup.php');
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
			
			<!--- dissmissible banner at top of page --->
			<div class="alert alert-warning alert-info" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Enter all the values below then press ENTER
			</div> <!--- END alert panel --->
			
			<?php 
				#import html for the etf drop down
				include('templates/etfdropdown.php');
			?>
			
			<div data-toggle="tooltip" title="Enter a date as mm/dd/yyyy or pick one from the date picker">
				<div class="panel panel-default">
					<div class="panel-heading"><span class="label label-default label-as-badge">2</span>&nbsp&nbspSelect option expiry</div>
						<div class="panel-body">
							<div class="input-append date">
								<!--- type-"date" is currently not supported in firefox and ie --->
								<!--- input type="date" id="expiry" name="expiry" /> --->
								<input class="datepicker" id="expiry" name="expiry" placeholder="12/31/2014" />
								<span class="add-on"><i class="icon-th"></i></span>
							</div> <!--- END date input --->
						</div> <!--- END panel-body --->
				</div> <!--- END panel for expiry--->
			</div>
			
			<div data-toggle="tooltip" title="Enter an implied volatility, for example 20%">
				<div class="panel panel-default">
					<div class="panel-heading"><span class="label label-default label-as-badge">3</span>&nbsp&nbspEnter implied volatility (e.g 28.3%)</div>
						<div class="panel-body">
							<div class="input-append date">
								<input type="text" id="impliedvol" name="impliedvol" placeholder="20%">
								<span class="add-on"><i class="icon-th"></i></span>
							</div> <!--- END date input --->
						</div> <!--- END panel-body --->
				</div> <!--- END panel for premium --->
			</div>
			
			<div data-toggle="tooltip" title="Enter an strike, for example 50, then press TAB if you are using FireFox or IE or press ENTER if you are using Chrome">
				<div class="panel panel-default">
					<div class="panel-heading"><span class="label label-default label-as-badge">4</span>&nbsp&nbspEnter a strike</div>
						<div class="panel-body">
							<div class="input-append date">
								<input type="text" id="strike" name="strike" placeholder="50">
								<span class="add-on"><i class="icon-th"></i></span>
							</div> <!--- END date input --->
						</div> <!--- END panel-body --->
				</div> <!--- END panel for strike --->
			</div>
			
			<!--- output section --->
			<div class="panel panel-info">
				<div class="panel-heading">Delta Hedging Simulation</div>
					<div class="panel-body inline-block">
						<a class="btn btn-info"><span id="etfSelected">EFA</span></a>
						<a class="btn btn-info"><span id="expiryEntered">Select an expiry</span></a>
						<a class="btn btn-info"><span id="impliedVolEntered">Enter an implied volatility</span></a>
						<a class="btn btn-info"><span id="strikeEntered">Enter a strike</span></a>
						<!--- results will be written to this div --->
						<div id="result"></div>
					</div> <!--- END panel-body --->
			</div> <!--- END panel for output --->
		</div> <!--- END container --->
		
		<!--- jQuery to populate inputs with some initial values as examples --->
		<script>
		//	$(document).ready(function() {
		//		// set values of input elements
		//		$('#myEtf').val('IWM');
		//		$('#expiry').val('01\/04\/2014');
		//		$('#impliedvol').val('20%');
		//		$('#strike').val('110');
		//		// set values of ouptput labels
		//		$('#etfSelected').text('IWM');
		//		$('#expiryEntered').text('01\/04\/2014');
		//		$('#impliedvolEntered').text('20%');
		//		jQuery('#impliedVolEntered').text('20%');
		//		$('#strikeEntered').text('110');
		//		$.ajax({
		//				type: 'GET',
		//				url: 'deltahedginghandler.php',
		//				data: {'etf':$('#myEtf').val(), 'expiry':$('#expiry').val(), 'impliedvol':$('#impliedvol').val(), 'strike':$('#strike').val()},
		//				success: function(msg) {
		//					$('#result').html(msg); // write output to the #result div
		//				} 
		//			});
		//	});
		//
		</script>

		<!--- dynamically update the EXPIRY label in the output section when the input is changed --->
		<script>
			// expiry
			$('#expiry').change(function() {
				jQuery('#expiryEntered').text($('#expiry').val());
			});
		</script>
		
		<!--- dynamically update the IMPLIED VOL label in the output section when the input is changed --->
		<script>
			// implied vol
			$('#impliedvol').change(function() {
				jQuery('#impliedVolEntered').text($('#impliedvol').val());
			});
		</script>
		
		<!--- dynamically update the STRIKE label in the output section when the input is changed --->
		<script>
			// strike
			$('#strike').change(function() {
				jQuery('#strikeEntered').text(Math.abs($('#strike').val()));
			});
		</script>
		
		<!--- dynamically update the ETF label in the output section when drop down changes --->
		<script type='text/javascript'>
			// etfs changes
			$(function() {
			    $('#myEtf').change(function() {
			        var x = $(this).val();
			        $('#hiddenEtf').val(x);
			        jQuery('#etfSelected').text($('#myEtf').val());
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
						$('#impliedVolEntered').text('20%');
					} else {
						//alert('we are ok');
						jQuery('#impliedVolEntered').text($('#impliedvol').val());
						// here
						$.ajax({
							type: 'GET',
							url: 'deltahedginghandler.php',
							data: {'etf':$('#myEtf').val(), 'expiry':$('#expiry').val(), 'impliedvol':$('#impliedvol').val(), 'strike':$('#strike').val()},
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
						data: {'etf':$('#myEtf').val(), 'expiry':$('#expiry').val(), 'impliedvol':$('#impliedvol').val(),  'strike':$('#strike').val()},
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
				$('#myEtf').change(function() {
					$.ajax({
						type: 'GET',
						url: 'deltahedginghandler.php',
						data: {'etf':$('#myEtf').val(), 'expiry':$('#expiry').val(), 'impliedvol':$('#impliedvol').val(), 	'strike':$('#strike').val()},
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
						data: {'etf':$('#myEtf').val(), 'expiry':$('#expiry').val(), 'impliedvol':$('#impliedvol').val(), 'strike':$('#strike').val()},
						success: function(msg) {
							$('#result').html(msg); // write output to the #result div				
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
			
			
			$('#popup_static').tooltip({
			    'show': true,
			        'placement': 'bottom',
			        'title': "Please remember to..."
			});
			
			$('#popup_static').tooltip('show');
		</script>

	</body> <!--- END BODY --->  
	
</html>
