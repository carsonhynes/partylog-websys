<html>
<head>
	<title>Party Log - Index</title>
	<link rel="shortcut icon" href="resources/media/PL.ico">
	<link href='https://fonts.googleapis.com/css?family=Oxygen:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="resources/css/page.css">
    <link rel="stylesheet" type="text/css" href="resources/css/index.css">
</head>

<body>

<div id="splash">
	<h2 class="welcome">Welcome to Party Log</h2>
	<img src="resources/media/logo.png">
</div>
<menu>
	<?php session_start(); if(isset($_SESSION['username'])) echo "<p> Welcome " . $_SESSION['username'] ."</p>";?>
	<ul>
		<li id="title"><strong>Party Log</strong></li>
		<li><a href="login.php"><?php echo (isset($_SESSION['username'])) ? "Logout" : "Login";?></a></li>
		<li><a href="mailto:carsonhynes@gmail.com?Subject=Party%20Log" target="_top">Contact</a></li>
		<li>Help</li>
	</ul>
</menu>
<div id="form-wrapper">

		<div id="pin-prompt">

				<div class="ui-widget">
					<label for="pin">PIN:</label>
					<input id="pin" name="pin" placeholder="ex. 8080" required pattern="[0-9]{4}"/>
					<button onclick="pinValidate()">Submit</button>
				</div>

		</div>


	<form id="submit-form"action="submit-party.php" method="post" onsubmit="return validate(this);">


		<div class='date'>
		<strong>
			<?php
				date_default_timezone_set("America/New_York");
				echo date("F jS, Y");
			?>
		</strong>
		</div>

		<div id="wrapper">
		    <div class="ui-widget">
		        <label for="name">Name:</label>
        <input name="name" id="name" class="skipEnter" required pattern="^[^\s]+(\s+[^\s]+)*$"/>
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
				<input type="checkbox" id="over" name="over" />
				<label for="over">Over 21<span></span></label>
			</div>
		</div>
		<div class="submit">
	        <button id="submit" style="margin-top: 10px" type="submit"><span>Submit</span></button>
		</div>
	</form>

</body>

<script src="resources/js/jquery-1.7.1.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="resources/js/index.js"></script>
<script type="text/javascript" src="resources/js/carhartl-jquery-cookie-92b7715/jquery.cookie.js" ></script>
<script>
	var userpin = '0000';
	var result = '-1';
	$('#over').click(function () {
		while (result != userpin) {
			result = prompt('Please show your id to the host');
		}
	});
</script>
</html>
