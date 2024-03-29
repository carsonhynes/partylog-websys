<?php
$configs = include('config.php');
$host = $configs['host'];
$user =  $configs['username'];
$pass = $configs['password'];
$dbname = $configs['database'];
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

//the ban system, it logs the number of attempts the user has made
//once they read 5 failed attempts in 90 seconds, they're locked out for 30 seconds
//if there are an additional 30 tries in those 30 seconds, their IP is logged in the db and they're banned
function attempt()
{
	 $configs = include('config.php');
	$host = $configs['host'];
	$user =  $configs['username'];
	$pass = $configs['password'];
	$dbname = $configs['database'];
	$dbconn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
	 $notAllowed = $dbconn->prepare('SELECT ip FROM banned WHERE ip = :ip');
	 $notAllowed->execute(array(':ip' =>$_SERVER['REMOTE_ADDR']));

	 //checks to see if the user is already locked out or banned
	if (!isset($_SESSION['lockout']) && $notAllowed->rowCount() ==0){
		if (isset($_SESSION['attempt-time']) && (time() - intval($_SESSION['attempt-time']) > 90))
		{
			//after 90 seconds since last attempt, reset attemp counter
			$_SESSION['attempt-time'] = time();
			$_SESSION['attempts'] = 0;
		}
		if(!isset($_SESSION['attempts']))
		{
			$_SESSION['attempts'] = 0;
		}
		else {
			$_SESSION['attempts']++;
		}
		if(isset($_SESSION['attempts']) && $_SESSION['attempts'] > 5)
		{
			$_SESSION['lockout'] = time();
		}
}
else {
	//checks to see if the user isn't banned and to see if the lockout time has expired
	if ($notAllowed->rowCount() == 0 && time() - intval($_SESSION['lockout']) > 30 ){
		unset($_SESSION['lockout']);
		//checks number of total attempts the user had made since first attempt
		//if they're greater than 35, the user's ip is logged and banned
		if(isset($_SESSION['attempts']) && $_SESSION['attempts'] > 35)
		{

			$banned = $dbconn->prepare('INSERT INTO banned (ip) VALUES (:ip)');
			$banned->execute(array(':ip'=> $_SERVER['REMOTE_ADDR']));
			$msg = 'Your ip has been recorded and banned';

		}
		unset($_SESSION['attempts']);
	}
	else if (isset($_SESSION['lockout']) && time() - intval($_SESSION['lockout']) <= 30){
		$_SESSION['attempts']++;
	}
}
$_SESSION['attempt-time'] = time();
}


try {
	$dbh = new PDO("mysql:host=$host", $user, $pass);

	$result = $dbh->prepare('CREATE DATABASE IF NOT EXISTS `partylog`
	                            DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;');

	$result->execute();

	$dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

	//create the user table if it doesn't already exist
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
		attempt();
		if(isset($_SESSION['lockout']))
		{
			if(time() - $_SESSION['lockout'] > 30){
        $_SESSION['attempts'] --;
				unset($_SESSION['lockout']);
			}
		}
		$notAllowed = $dbh->prepare('SELECT ip FROM banned WHERE ip = :ip');
		$notAllowed->execute(array(':ip' =>$_SERVER['REMOTE_ADDR']));
		if($notAllowed->rowCount() >0){
			$msg = "You are banned and cannot attempt login";
		}
		else if(isset($_POST['username']) && !isset($_SESSION['lockout']))
		{
			//checks to see if the username already exists in the DB
			$stmt = $dbh->prepare("SELECT id FROM users WHERE username = :username");
			$stmt->execute(array(':username' => $_POST['username']));
			if ($user = $stmt->fetch())
			{
				$msg = "User already exists";
			}
			else {
				//checks to make certain all the fields were filled out
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
					//generates a random salt
					$salt = hash('sha256', uniqid(mt_rand(),true));
					$raw_pass = $_POST['password'];
					//generates the salted password
					$s_pass = hash('sha256', $salt . $raw_pass);
					//logs the new user into the db
					$stmt = $dbh->prepare("INSERT INTO users(username, salt, password, frat, school, phone, over) VALUES (:username, :salt, :password, :frat, :school, :phone, :over);");
					$stmt->execute(array(':username' => $_POST['username'], ':password' => $s_pass,
																':salt' => $salt, ':school' => $_POST['school'],
																':frat' => $_POST['fraternity'], ':phone' => intval($_POST['phoneNumber']),
																':over' => (isset($_POST['over']) ? "over" : "under")));
					//clears the cookies for the banning system
					unset($_SESSION['attempts']);
					unset($_SESSION['attempt-time']);
					unset($_SESSION['lockout']);
					//sends the visitor to the login page
					header('Location: login.php');
					exit();
				}
			}
		}
		else if(isset($_SESSION['lockout'])){
			$msg = "Locked out. Please wait " . (30 - (time() - intval($_SESSION['lockout']))) . " seconds and try again.";
		}
	}
	else if (isset($_SESSION['username']))//checks to see if the user is already logged in or not
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
		<title>Party Log - Register</title>
		<link rel="shortcut icon" href="resources/media/PL.ico">
		<link rel="stylesheet" type="text/css" href="resources/css/pikaday.css">
		<link rel="stylesheet" type="text/css" href="resources/css/register.css">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="resources/css/page.css">

	</head>

	<body>
		<menu>
			<?php if(isset($_SESSION['username'])) echo "<p> Welcome " . htmlentities($_SESSION['username']) ."</p>";?>
			<ul>
				<li id="title"><strong>Party Log</strong></li>
				<li><a href="login.php"><?php echo (isset($_SESSION['username'])) ? "Logout" : "Login";?></a></li>
				<li><a href="mailto:carsonhynes@gmail.com?Subject=Party%20Log" target="_top">Contact</a></li>
				<li>Help</li>
			</ul>
		</menu>

	<form action="register.php" method="post" onsubmit="return validate_register(this);">

		<section id="wrapper">
			<h1 class="center-text">Sign Up</h1>
			<!-- displays error messages to the user, such as that the username they chose already exists or if they have been banned -->
			<?php if (isset($msg)) echo "<p class=\"err-msg\">Error: $msg</p>"; $msg= NULL; ?>
	    <section class="ui-widget">
	        <label for="name">Username:</label>
	        <input name="username" id="name" class="skipEnter"/>
	    </section>

			<section class="ui-widget">
					<label for="password">Password:</label>
					<input type="password" name="password" id="password" class="skipEnter"/>
			</section>

			<section class="ui-widget">
	        <label for="passwordConfirm">Confirm Password:</label>
	        <input type="password" name="passwordConfirm" id="passwordConfirm" class="skipEnter"/>
	    </section>

		<section class="ui-widget">
			<label for="phoneNumber">Phone Number:</label>
			<input type="text" name="phoneNumber" id="phoneNumber" placeholder="ex: 3855550168" required pattern="^\D?(\d{3})\D?\D?(\d{3})\D?(\d{4})$"/>
		</section>

		<section class="ui-widget">
			<label for="school">School:</label>
			<select name="school" id="school">
			</select>
		</section>

		<section id="fraternityWidget" class="ui-widget">
			<label for="fraternity">Fraternity: </label>
			<select name="fraternity" id="fraternity">
			</select>
		</section>

		<section class="checkbox">
			<input type = "checkbox" id="over" name="over" />
			<label for="over">Over 21<span></span></label>
		</section>

		<section class="submit">

			<input id="register" type="submit" name="register" value=" " />
		</section>
		</section>



	</form>
	</body>
	<script src="resources/js/jquery-1.7.1.js"></script>
	<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="resources/js/pikaday.js"></script>
	<script type="text/javascript" src="resources/js/auth.js"></script>

	</html>
