<?php

$user = "websys";
$pass = "websys";
$query = "";


try {

	$dbh = new PDO('mysql:host=localhost', $user, $pass);

	$result = $dbh->prepare('CREATE DATABASE IF NOT EXISTS `partylog`
	                            DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;');

	$result->execute();

	$dbh = new PDO('mysql:host=localhost;dbname=partylog', $user, $pass);

	$result = $dbh->prepare('CREATE TABLE IF NOT EXISTS `party` (
							  `number` int(11) NOT NULL AUTO_INCREMENT,
							  `name` text NOT NULL,
							  `fraternity` text NOT NULL,
							  `school` text NOT NULL,
							  `over` text NOT NULL,
							  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
							  PRIMARY KEY (`number`)
							);');

	$result->execute();

	if (isset($_POST['date']) && $_POST['date'] != '') {
		$date = date("Y-m-d", strtotime(substr($_POST['date'], 4)));
		echo "You requested data from <strong>".date("F jS, Y", strtotime($date)).'</strong><br>';
		$result = $dbh->prepare("SELECT * FROM party WHERE INSTR(`timestamp`, '$date') > 0");
		$result->execute();

		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			echo $row['name'] . ' ' . $row['fraternity'] . '<br>';
		}
	}

	if (isset($_POST['frat']) && $_POST['frat'] != '') {
		$frat = $_POST['frat'];
		echo "You requested data about <strong>$frat</strong><br>";
		$result = $dbh->prepare("SELECT * FROM party WHERE INSTR(`fraternity`, '$frat') > 0");
		$result->execute();

		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			echo $row['name'] . ' ' . $row['fraternity'] . '<br>';
		}
	}

	if (isset($_POST['person']) && $_POST['person'] != '') {
		$person = $_POST['person'];
		echo "You requested data for <strong>$person</strong><br>";
		$result = $dbh->prepare("SELECT * FROM party WHERE INSTR(`name`, '$person') > 0");
		$result->execute();

		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			echo $row['name'] . ' ' . $row['fraternity'] . '<br>';
		}
	}


} catch (PDOException $e) {
	die("DB ERROR:" . $e->getMessage());
}

?>

<html>
<head>
	<title>Party Log - Lookup</title>
	<link rel="stylesheet" type="text/css" href="resources/css/pikaday.css">
	<script src="resources/js/modernizr-custom.js"></script>

	<style>
		#dateLabel {
			margin-right: 33px;
		}
		#personLabel {
			margin-right: 20px;
		}
		#fratInput, #personInput, #dateInput {
			width: 200px;
		}
		#dateInput {
			margin-right: 4px;
		}
		.center-text {
			text-align: center;
			width: 300px;
		}
	</style>
</head>

<body>

<h1 class="center-text">Database Lookup</h1>

<form action="lookup.php" method="post" onsubmit="return validate(this)">

	<script>
		if (Modernizr.inputtypes.date) {
			document.write('<label for="date" id="dateLabel">Date: </label><input name="date" id="dateInput" id="date" type="date"><input type="radio" name="type" value="date" id="dateRadio"><br>');
		}
		else {
			document.write('<label for="date" id="dateLabel">Date: </label><input name="date" id="dateInput" type="text"><input type="radio" name="type" value="date" id="dateRadio"><br>');
		}
	</script>

	<label for="frat" id="fratLabel">Fraternity: </label>
	<select name="frat" id="fratInput">
		<option value=""></option>
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
	<input type="radio" name="type" value="frat" id="fratRadio">
	<br>

	<label for="person" id="personLabel">Person: </label>
	<input name="person" id="personInput">
	<input type="radio" name="type" value="person" id="personRadio">
	<br>

	<button type="submit">Submit</button>
</form>
</body>

<script src="resources/js/pikaday.js"></script>
<script>
	var picker = new Pikaday({ field: document.getElementById('dateInput') });

	function validate(formObj) {
		if (formObj.date.value == "" && formObj.type.value == "date") {
			alert("You must enter a select a date");
			formObj.date.focus();
			return false;
		}

		if (formObj.frat.value == "" && formObj.type.value == "frat") {
			alert("You must enter a enter a fraternity name");
			formObj.frat.focus();
			return false;
		}

		if (formObj.person.value == "" && formObj.type.value == "person") {
			alert("You must enter a enter a person's name");
			formObj.person.focus();
			return false;
		}

		if (formObj.person.value == "" && formObj.date.value == "" && formObj.frat.value == "") {
			alert("You must select a form of lookup");
			return false;
		}

		return true;
	}

	window.onload = function() {
		document.getElementById("personInput").onfocus = function () {
			document.getElementById("personRadio").checked = true;
		};

		document.getElementById("fratInput").onfocus = function () {
			document.getElementById("fratRadio").checked = true;
		};

		document.getElementById("dateInput").onfocus = function () {
			document.getElementById("dateRadio").checked = true;
		};
	}
</script>

</html>