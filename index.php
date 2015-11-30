<html>
<head>
	<title>Party Log - Index</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="resources/css/index.css">
</head>

<body>

<form action="submit-party.php" method="post" onsubmit="return validate(this);">

	<div class='date'>
		<?php
			echo date("F jS, Y");
		?>
	</div>

    <div class="ui-widget" style="margin-top: 10px;">
        <label for="name">Name: </label>
        <input name="name" id="name" class="skipEnter" style="width: 300px;">
    </div>

	<div class="ui-widget" style="margin-top: 10px;">
		<label for="school">School:</label>
		<select name="school" class="school" style="width: 294px;">
			<option vslue="-">-</option>
			<option value="RPI">RPI</option>
			<option value="Sage">Sage</option>
			<option value="UAlbany">UAlbany</option>
			<option value="Siena">Siena</option>
			<option value="Hudson Valley">Hudson Valley</option>
			<option value="Other">Other</option>
		</select>
	</div>

	<div id="fraternity" class="ui-widget" style="margin-top: 10px;">
		<label for="fraternity">Fraternity: </label>
		<select name="fraternity" style="width: 266px;">
			<option value="None">Non-Greek</option>
			<option value="Acacia">Acacia</option>
			<option value="Alpha Chi Rho">Alpha Chi Rho</option>
			<option value="Alpha Epsilon Pi">Alpha Epsilon Pi</option>
			<option value="Alpha Phi Alpha">Alpha Phi Alpha</option>
			<option value="Alpha Sigma Phi">Alpha Sigma Phi</option>
			<option value="Chi Phi">Chi Phi</option>
			<option value="Delta Kappa Epsilon">Delta Kappa Epsilon</option>
			<option value="Delta Phi">Delta Phi</option>
			<option value="Delta Tau Delta">Delta Tau Delta</option>
			<option value="Lambda Chi Alpha">Lambda Chi Alpha</option>
			<option value="Lambda Upsilon Lambda">Lambda Upsilon Lambda</option>
			<option value="Phi Gamma Delta">Phi Gamma Delta</option>
			<option value="Phi Iota Alpha">Phi Iota Alpha</option>
			<option value="Phi Kappa Tau">Phi Kappa Tau</option>
			<option value="Phi Kappa Theta">Phi Kappa Theta</option>
			<option value="Phi Mu Delta">Phi Mu Delta</option>
			<option value="Phi Sigma Kappa">Phi Sigma Kappa</option>
			<option value="Pi Delta Psi">Pi Delta Psi</option>
			<option value="Pi Kappa Alpha">Pi Kappa Alpha</option>
			<option value="Pi Kappa Phi">Pi Kappa Phi</option>
			<option value="Pi Lambda Phi">Pi Lambda Phi</option>
			<option value="Psi Upsilon">Psi Upsilon</option>
			<option value="RSE">RSE</option>
			<option value="Sigma Alpha Epsilon">Sigma Alpha Epsilon</option>
			<option value="Sigma Chi">Sigma Chi</option>
			<option value="Sigma Phi Epsilon">Sigma Phi Epsilon</option>
			<option value="Tau Epsilon Phi">Tau Epsilon Phi</option>
			<option value="Theta Chi">Theta Chi</option>
			<option value="Theta Xi">Theta Xi</option>
			<option value="Zeta Psi">Zeta Psi</option>
		</select>
	</div>

	<div class="roundedOne">
		<input type="checkbox" value="Over" id="roundedOne" name="over" />
		<label for="roundedOne"></label>
	</div>

	<div class="submit">
        <button style="margin-top: 10px" type="submit">Submit</button>
	</div>
</form>

</body>

<script src="resources/js/jquery-1.7.1.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!-- <script src="list.js"></script>
 --><script type="text/javascript" src="resources/js/index.js"></script>
</html>