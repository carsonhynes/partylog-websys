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
	<div id="title"><strong>Party Log</strong></div>
	<div>Login</div>
	<div><a href="mailto:carsonhynes@gmail.com?Subject=Party%20Log" target="_top">Contact</a></div>
	<div>Help</div>
</menu>

<form action="submit-party.php" method="post" onsubmit="return validate(this);">

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
        <input name="name" id="name" class="skipEnter" required pattern="([A-z])\w+"/>
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
        <button style="margin-top: 10px" type="submit"><span>Submit</span></button>
	</div>
</form>

<!-- <footer>
	<div>
		<?php
			date_default_timezone_set("America/New_York");
			$year = date('Y');
			echo "Copyright &copy; $year Party Log";
		?>
	</div>
</footer> -->

</body>

<script src="resources/js/jquery-1.7.1.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!-- <script src="list.js"></script>
 --><script type="text/javascript" src="resources/js/index.js"></script>
 <script type="text/javascript" src="resources/js/carhartl-jquery-cookie-92b7715/jquery.cookie.js" ></script>
</html>