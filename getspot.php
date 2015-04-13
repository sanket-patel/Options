<?php

	include('analytics/utilities.php');
	$etf = $_GET['etf'];
	$spot = get_price_as_of('20140102', $etf);
	echo '<br><h5><strong>Spot: </strong>'.$spot.'</h5>';

?>