<?php
$configs = include('config.php');
$host = $configs['host'];
$user =  $configs['username'];
$pass = $configs['password'];
$dbname = $configs['database'];




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
								`phone` int(11) DEFAULT NULL,
								`over` varchar(10) DEFAULT \'under\',
								PRIMARY KEY (`id`));
							');

	$result->execute();
	if (isset($_POST['register']) && !isset($_SESSION['username'])){
		if(isset($_POST['username']))
		{
			$stmt = $dbh->prepare("SELECT id FROM users WHERE username = :username");
			$stmt->execute(array(':username' => $_POST['username']));
			if ($user = $stmt->fetch())
			{
				$msg = "User already exists";
			}
			else {
				if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['passwordConfirm']) || !isset($_POST['school']) || !isset($_POST['fraternity']) || !isset($_POST['phoneNumber']))
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
					$stmt = $dbh->prepare("INSERT INTO users(username, salt, password, frat, school, phone, over) VALUES (:username, :salt, :password, :frat, :school, :phone, :over);");
					$stmt->execute(array(':username' => $_POST['username'], ':password' => $s_pass,
																':salt' => $salt, ':school' => $_POST['school'],
																':frat' => $_POST['fraternity'], ':phone' => intval($_POST['phoneNumber']),
																':over' => (isset($_POST['over']) ? "over" : "under")));

					header('Location: login.php');
					exit();
				}
			}
		}
	}
	else if (isset($_SESSION['username']))
	{
		$msg = $_SESSION['username'] . ", you need to log out before creating a new account.";
	}
}
catch (Exception $e) {
  $msg =  "Error: " . $e->getMessage();
}


?>




	<html>
	<head>
		<title>Party Log - Lookup</title>
		<link rel="shortcut icon" href="resources/media/PL.ico">
		<link rel="stylesheet" type="text/css" href="resources/css/pikaday.css">
		<link rel="stylesheet" type="text/css" href="resources/css/index.css">
		<link rel="stylesheet" type="text/css" href="resources/css/register.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="resources/css/page.css">

	</head>

	<body>
		<menu>
			<?php session_start(); if(isset($_SESSION['username'])) echo "<p> Welcome " . htmlentities($_SESSION['username']) ."</p>";?>
			<ul>
				<li id="title"><strong>Party Log</strong></li>
				<li><a href="login.php"><?php echo (isset($_SESSION['username'])) ? "Logout" : "Login";?></a></li>
				<li><a href="mailto:carsonhynes@gmail.com?Subject=Party%20Log" target="_top">Contact</a></li>
				<li>Help</li>
			</ul>
		</menu>

	<form action="register.php" method="post" onsubmit="return validate_register(this);">

		<div id="wrapper">
			<h1 class="center-text">Sign Up</h1>
			<?php if (isset($msg)) echo "<p class=\"err-msg\">Error: $msg</p>"; $msg= NULL; ?>
	    <div class="ui-widget">
	        <label for="name">Username:</label>
	        <input name="username" id="name" class="skipEnter"/>
	    </div>

			<div class="ui-widget">
					<label for="password">Password:</label>
					<input type="password" name="password" id="password" class="skipEnter"/>
			</div>

			<div class="ui-widget">
	        <label for="passwordConfirm">Confirm Password:</label>
	        <input type="password" name="passwordConfirm" id="passwordConfirm" class="skipEnter"/>
	    </div>

		<div class="ui-widget">
			<label for="phoneNumber">Phone Number:</label>
			<input type="text" name="phoneNumber" id="phoneNumber" placeholder="ex: 3855550168" required pattern="^\D?(\d{3})\D?\D?(\d{3})\D?(\d{4})$"/>
		</div>

		<div class="ui-widget">
			<label for="school">School:</label>
			<select name="school" id="school">
			</select>
		</div>

		<div id="fraternityWidget" class="ui-widget">
			<label for="fraternity">Fraternity: </label>
			<select name="fraternity" id="fraternity">
			</select>
		</div>

		<div class="checkbox">
			<input type = "checkbox" id="over" name="over" />
			<label for="over">Over 21<span></span></label>
		</div>

		</div>
		<div class="submit">

			<input id="register" type="submit" name="register" value=" " />
		</div>



	</form>
	</body>
	<script src="resources/js/jquery-1.7.1.js"></script>
	<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="resources/js/pikaday.js"></script>
	<script type="text/javascript" src="resources/js/auth.js"></script>

	</html>
