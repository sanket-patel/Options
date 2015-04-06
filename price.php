<?php

	include('config/setup.php');
	include('config/js.php');
	
	
	if ($_GET['etf']) {
		$d = str_replace('-','', (string)$_GET['dt']);
		
		$q = 'SELECT * FROM '.$_GET['etf'];
		#$q = 'SELECT * FROM '.$_GET['etf'].' WHERE Date = "'.$d.'"';
		echo $q.'<br>';
		#$q = 'SELECT Date, Price FROM '.$_GET['etf'];
		$r = mysqli_query($dbc, $q);
		
		#$prices = mysqli_fetch_assoc($r);
		echo $d.'<br>';	
		
		while(mysqli_fetch_assoc($r)) {
			$values = mysqli_fetch_assoc($r);
			$price = $values['Price'];
			$datestr = $values['Date'];
			echo ($datestr==$d) ? $datestr.'$$$$'.$price.'<br>' : $datestr.'---'.$price.'<br>';
		}
	}		
?>
