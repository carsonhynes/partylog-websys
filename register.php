<?php
$configs = include('config.php');
$host = configs['host'];
$user =  configs['username'];
$pass = configs['password'];
$dbname = configs['database'];

$username = "Iota Tau";


try {

	$dbh = new PDO("mysql:host=$host", $user, $pass);

	$result = $dbh->prepare('CREATE DATABASE IF NOT EXISTS `partylog`
	                            DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;');

	$result->execute();

	$dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

	$result = $dbh->prepare('CREATE TABLE IF NOT EXISTS `users` (
								`id` int(11) NOT NULL AUTO_INCREMENT,
								`username` varchar(50) NOT NULL,
								`salt` varchar(100) NOT NULL,
								`password` varchar(100) NOT NULL,
								`frat` varchar(50) NOT NULL,
								`school` varchar(50) NOT NULL,
								PRIMARY KEY (`id`));
							');

	$result->execute();
	if (isset($_POST['register'])){
		if(isset($_POST['username']))
		{
			$stmt = $dbh->prepare("SELECT id FROM users WHERE username = :username");
			$stmt->execute(array(':username' => $_POST['username']));
			if ($user = $stmt->fetch())
			{
				$msg = "User already exists";
			}
			else {
				if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['passwordConfirm']) || !isset($_POST['school']) || !isset($_POST['frat']))
				{
		      $msg = "Please fill in all form fields.";
		    }
		    else if ($_POST['password'] !== $_POST['passwordConfirm'])
				{
		      $msg = "Passwords must match.";
		    }
				else
				{
					$salt = hash('sha256', uniqid(mt_rand(),true));
					$raw_pass = $_POST['password'];
					$s_pass = hash('sha256', $salt . $raw_pass);
					$stmt = $dbh->prepare("INSERT INTO users(username, salt, password, frat, school) VALUES (:username, :salt, :password, :frat, :school);");
					$stmt->execute(array(':username' => $_POST['username'], ':password' => $s_pass, ':salt' => $salt, ':school' => $_POST['school'], ':frat' => $_POST['frat']));
					header('Location: login.php');
					exit();
				}
			}
		}
	}
}
catch (Exception $e) {
  echo "Error: " . $e->getMessage();
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
	<?php if (isset($msg)) echo "<p>$msg</p>" ?>
	<form action="login.php" method="post">
		<label for="username">Username: </label>
		<input name="username" >
		<br>

		<label for="pasword" >Password: </label>
		<input name="password" >
		<br>

		<input type="submit" name="login" value="Login" />
	</form>
	<form action="register.php" method="post" onsubmit="return validate(this)">

		<label for="username" >Username: </label>
		<input name="username" >
		<br>

		<label for="pasword" >Password: </label>
		<input name="password" >
		<br>

		<label for="paswordConfirm" >Password: </label>
		<input name="passwordConfirm" >
		<br>

		<label for="school">School:</label>
		<select name="school" id="school">
			<option value=""></option>
			<option value="RPI">RPI</option>
			<option value="Sage">Sage</option>
			<option value="UAlbany">UAlbany</option>
			<option value="Siena">Siena</option>
			<option value="Hudson Valley">Hudson Valley</option>
			<option value="Other">Other</option>
		</select>


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
		<br>


		<input type="submit" name="register" value="Register" />
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


	</script>

	</html>
