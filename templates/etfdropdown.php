<!--- this is a reusable element so we can keep it in a separate file
	  and just reference it from other pages --->
<div data-toggle="tooltip" title="Select an ETF from the dropdown">
	<div class="panel panel-default">
		<div class="panel-heading"><span class="label label-default label-as-badge">1</span>&nbsp&nbspSelect an ETF</div>
			<div class="panel-body">
				<select class="selectpicker" id="my_etf">
		    		<option>EFA</option>
		    		<option>IWM</option>
			    	<option>SPY</option>
				</select>
				<input type='hidden' id='hidden_etf' value=''>
			</div> <!--- END panel-body --->
	</div> <!--- END panel for etf dropdown--->
</div>