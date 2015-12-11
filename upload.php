<html>
<head>
	<title>Party Log - Upload</title>
	<link rel="shortcut icon" href="resources/media/PL.ico">
    <link href='https://fonts.googleapis.com/css?family=Oxygen:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="resources/css/page.css">
	<link rel="stylesheet" href="resources/css/upload.css">
</head>

<body>

	<menu>
		<?php session_start(); if(isset($_SESSION['username'])) echo "<p> Welcome " . htmlentities($_SESSION['username']) ."</p>";?>
		<ul>
			<li id="title"><strong><a href="index.php">Party Log</a></strong></li>
			<li><a href="login.php"><?php echo (isset($_SESSION['username'])) ? "Logout" : "Login";?></a></li>
			<li><a href="mailto:carsonhynes@gmail.com?Subject=Party%20Log" target="_top">Contact</a></li>
			<?php if(isset($_SESSION['username'])) echo "<li><a href='upload.php'>Upload</a><li><li><a href='lookup.php'>Lookup</a><li>";?>
		</ul>
	</menu>

	<h1>Please follow the steps below to ensure proper upload</h1>

	<section id="guidelines">
	<h2>Google Invite List Guidelines <br> (Example Shown Below)</h2>

		<ul>
			<li>Top two rows are for labels/titles. Will not be parsed.</li>
			<li>Left-most column for Brothers (Inviters). Will not be parsed.</li>
		</ul>

		<a href="example.png"><img src="example.png"></a>
	</section>

	<hr>

	<section id="instructions">
	<h2>Instructions For Uploading</h2>

		<ol>
			<li>Open the invite list in Google Sheets (See guidelines above)</li>
			<li>Click "Download as -> Comma-separated Values (.csv, current sheet)</li>
			<li>Click the "Choose File" button below</li>
			<li>Select the file from your computer and click upload</li>
			<li>Visit <a href="index.php">Party Submission</a></li>
		</ol>

	</section>

	<div id="form">
		<form name="submitFile" action="submit-list.php" method="post" enctype="multipart/form-data">
			<input type="file" name="list" id="list">
			<input type="submit" name="submit" id="submit">
		</form>

		<button id="listButton" onclick="document.getElementById('list').click()"/>
		<button id="submitButton" onclick="document.getElementById('submit').click()"/>
	</div>

</body>
</html>
