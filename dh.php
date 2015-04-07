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
		
		<script type="txt/javascript">
			google.load('visualization', '1', {packages: ['corechart', 'line']});
	google.setOnLoadCallback(drawAxisTickColors);
	
	function drawAxisTickColors() {
	      var data = new google.visualization.DataTable();
	      data.addColumn('number', 'X');
	      data.addColumn('number', 'Dogs');
	      data.addColumn('number', 'Cats');
	
	      data.addRows([
	        [0, 0, 0],    [1, 10, 5],   [2, 23, 15],  [3, 17, 9],   [4, 18, 10],  [5, 9, 5],
	        [6, 11, 3],   [7, 27, 19],  [8, 33, 25],  [9, 40, 32],  [10, 32, 24], [11, 35, 27],
	        [12, 30, 22], [13, 40, 32], [14, 42, 34], [15, 47, 39], [16, 44, 36], [17, 48, 40],
	        [18, 52, 44], [19, 54, 46], [20, 42, 34], [21, 55, 47], [22, 56, 48], [23, 57, 49],
	        [24, 60, 52], [25, 50, 42], [26, 52, 44], [27, 51, 43], [28, 49, 41], [29, 53, 45],
	        [30, 55, 47], [31, 60, 52], [32, 61, 53], [33, 59, 51], [34, 62, 54], [35, 65, 57],
	        [36, 62, 54], [37, 58, 50], [38, 55, 47], [39, 61, 53], [40, 64, 56], [41, 65, 57],
	        [42, 63, 55], [43, 66, 58], [44, 67, 59], [45, 69, 61], [46, 69, 61], [47, 70, 62],
	        [48, 72, 64], [49, 68, 60], [50, 66, 58], [51, 65, 57], [52, 67, 59], [53, 70, 62],
	        [54, 71, 63], [55, 72, 64], [56, 73, 65], [57, 75, 67], [58, 70, 62], [59, 68, 60],
	        [60, 64, 56], [61, 60, 52], [62, 65, 57], [63, 67, 59], [64, 68, 60], [65, 69, 61],
	        [66, 70, 62], [67, 72, 64], [68, 75, 67], [69, 80, 72]
	      ]);
	
	      var options = {
	        hAxis: {
	          title: 'Time',
	          textStyle: {
	            color: '#01579b',
	            fontSize: 20,
	            fontName: 'Arial',
	            bold: true,
	            italic: true
	          },
	          titleTextStyle: {
	            color: '#01579b',
	            fontSize: 16,
	            fontName: 'Arial',
	            bold: false,
	            italic: true
	          }
	        },
	        vAxis: {
	          title: 'Popularity',
	          textStyle: {
	            color: '#1a237e',
	            fontSize: 24,
	            bold: true
	          },
	          titleTextStyle: {
	            color: '#1a237e',
	            fontSize: 24,
	            bold: true
	          }
	        },
	        colors: ['#a52714', '#097138']
	      };
	      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
	      	chart.draw(data, options);
	
		</script>
		
  	</head>

	<body>

		<div ng-app="">
			<div class="container">
				
				<nav class="navbar navbar-default">
					<div class="container-fluid">
						<div class="navbar-header">
							<a class="navbar-brand" href="index.php"><i class="fa fa-bar-chart"></i></a>
						</div> <!--- END navbar header --->
						<div id="navbar" class="navbar-collapse collapse">
							<ul class="nav navbar-nav">
								<li><a href="iv.php">Implied Volatility</a></li>
								<li  class="active"><a href="#">Delta Hedging</a></li>
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
					<div class="panel-heading"><span class="label label-default label-as-badge">3</span>&nbsp&nbspEnter implied volatility (e.g 28.3%)</div>
						<div class="panel-body">
							<div class="input-append date">
								<input type="text" id="impliedvol" name="impliedvol">
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
					<div class="panel-heading">Delta Hedging Simulation</div>
						<div class="panel-body inline-block">
							<a class="btn btn-info"><span id="etfSelected">EFA</span></a>
							<a class="btn btn-info"><span id="expiryEntered">DATE</span></a>
							<a class="btn btn-info"><span id="impliedVolEntered">PREMIUM</span></a>
							<a class="btn btn-info"><span id="strikeEntered">STRIKE</span></a>
							<!---<a class="btn btn-success"><span id="result">IMPLIED VOL%</span></a> --->
							<div i="chart_div"></div>
							<div id="result"></span>
							<!--- <div id="result2"></div> --->
						</div> <!--- END panel-body --->
						
				</div> <!--- END panel for output --->
			</div> <!--- END ngApp --->
		</div> <!--- END container --->
		
		<script>
			// expiry changes
			$('#expiry').change(function() {
				jQuery('#expiryEntered').text($('#expiry').val());
				});
		</script>
		
		<script>
			// premium changes
			$('#impliedvol').change(function() {
				jQuery('#impliedVolEntered').text($('#impliedvol').val());
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
				$('#impliedvol').change(function() {
					$.ajax({
						type: 'GET',
						url: 'deltahedginghandler.php',
						data: {'etf':$('#myEtf').val(), 'expiry':$('#expiry').val(), 'impliedvol':$('#impliedvol').val(), 'strike':$('#strike').val()},
						success: function(msg) {
							//$('#result').html('');
							$('#result').html(msg);
							//$(document).getElementById('#result').innerHTML = msg;
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
						url: 'deltahedginghandler.php',
						data: {'etf':$('#myEtf').val(), 'expiry':$('#expiry').val(), 'impliedvol':$('#impliedvol').val(),  'strike':$('#strike').val()},
						success: function(msg) {
							//$('#result').html('');
							$('#result').html(msg);
							//$(document).getElementById('#result').innerHTML = msg;
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
						url: 'deltahedginghandler.php',
						data: {'etf':$('#myEtf').val(), 'expiry':$('#expiry').val(), 'impliedvol':$('#impliedvol').val(), 	'strike':$('#strike').val()},
						success: function(msg) {
							//$('#result').html('');
							$('#result').html(msg);
							//$(document).getElementById('#result').innerHTML = msg;
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
						url: 'deltahedginghandler.php',
						data: {'etf':$('#myEtf').val(), 'expiry':$('#expiry').val(), 'impliedvol':$('#impliedvol').val(), 'strike':$('#strike').val()},
						success: function(msg) {
							//$('#result').html('');
							$('#result').html(msg);						
						}
					});
				});
			});
		</script>

	</body> <!--- END BODY --->  
	
</html>
