<?php
// setup file

	$dbc = mysqli_connect('localhost', 'dev', 'password', 'etfs') OR die('Could not connect because: '.mysqli_connect_error());
	$site_title = 'IV and Delta Hedging';
	$page_title = 'Home Page';

	if (isset($_GET['page'])) {
		
		$page_type = $_GET['page'];
		
		switch ($page_type) {
			case 'iv':
				#echo '<h1>implied vol stuff</h1>';
				$page_type = 'iv';
				break;
				
			case 'dh':
				#echo '<h1>delta hedging stuff</h1>';
				$page_type = 'dh';
				break;
				
			default:
				break;
		}
	}


?>