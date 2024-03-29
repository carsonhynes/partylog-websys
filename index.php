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

<section id="splash">
	<h2 class="welcome">Welcome to Party Log</h2>
	<img src="resources/media/logo.png">
</section>
<menu>
	<?php session_start(); if(isset($_SESSION['username'])) echo "<p> Welcome " . $_SESSION['username'] ."</p>";?>
	<ul>
		<li id="title"><strong><a href="index.php">Party Log</a></strong></li>
		<li><a href="login.php"><?php echo (isset($_SESSION['username'])) ? "Logout" : "Login";?></a></li>
		<li><a href="mailto:carsonhynes@gmail.com?Subject=Party%20Log" target="_top">Contact</a></li>
		<?php if(isset($_SESSION['username'])) echo "<li><a href='upload.php'>Upload</a><li><li><a href='lookup.php'>Lookup</a><li>";?>
	</ul>
</menu>



	<form id="submit-form"action="submit-party.php" method="post" onsubmit="return validate(this);">


		<section class='date'>
		<strong>
			<?php
				date_default_timezone_set("America/New_York");
				echo date("F jS, Y");
			?>
		</strong>
		</section>

		<section id="wrapper">
		    <section class="ui-widget">
		        <label for="name">Name:</label>
        <input name="name" id="name" class="skipEnter" required pattern="^[^\s]+(\s+[^\s]+)*$"/>
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
				<input type="checkbox" id="over" name="over" />
				<label for="over" id="over-label">Over 21<span></span></label>
			</section>
			<section class="submit">
	    	<button id="submit" type="submit"><span>Submit</span></button>
			</section>
		</section>
	</form>

</body>

<script src="resources/js/jquery-1.7.1.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="resources/misc/list.js"></script>
<script src="resources/js/index.js"></script>
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
