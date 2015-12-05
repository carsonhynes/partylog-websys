<html>
<head>
	<link rel="shortcut icon" href="resources/media/PL.ico">
    <link href='https://fonts.googleapis.com/css?family=Oxygen:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="resources/media/PL.ico">
    <link rel="stylesheet" href="resources/css/page.css">
	<link rel="stylesheet" href="resources/css/upload.css">
</head>

<body>

<menu>
	<div id="title"><strong>Party Log</strong></div>
	<div>Login</div>
	<div>Contact</div>
	<div>Help</div>
</menu>

<div id="content">


	<h1>Please follow the steps below to ensure proper upload</h1>

	<div id="guidelines">
	<h2>Google Invite List Guidelines <br> (Example Shown Below)</h2>

		<ul>
			<li>Top two rows are for labels/titles. Will not be parsed.</li>
			<li>Left-most column for Brothers (Inviters). Will not be parsed.</li>
		</ul>
		<a href="example.png"><img src="example.png"></a>
	</div>

	<hr>
	<div id="instructions">
	<h2>Instructions For Uploading</h2>

	
		<ol>
			<li>Open the invite list in Google Sheets (See guidelines above)</li>
			<li>Click "Download as -> Comma-separated Values (.csv, current sheet)</li>
			<li>Click the "Choose File" button below</li>
			<li>Select the file from your computer and click upload</li>
			<li>Visit <a href="index.php">Party Submission</a></li>
		</ol>
	</div>
	<form name="submitFile" action="submit-list.php" method="post" enctype="multipart/form-data">
		<input type="file" name="list" id="list">
		<button id="listButton" onclick="document.getElementById('list').click()"/>
		<input type="submit" name="submit" id="submit">
		<button id="submitButton" onclick="document.submitFile.submit()"/>
	</form>
</div>
</body>
</html>