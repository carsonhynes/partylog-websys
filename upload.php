<html>
<head>
	<style>
		h1, h2, div {
			text-align: center;
		}

		h1 {
			margin: 25px auto;
		}

		.guidelines {
			width: 500px;
			text-align: left;
			margin: 0 auto 25px auto;
		}

		.instructions {
			width: 500px;
			text-align: left;
			margin: 0 auto;
		}

		body {
			width: 800px;
			margin: 0 auto;
		}

		.example-image {
			text-align: center;
		}

		form {
			margin-top: 100px;
		}
	</style>
</head>

<body>
	<h1>Please follow the steps below to ensure proper upload</h1>

	<h2>Google Invite List Guidelines (Example Shown Below)</h2>

	<div class="guidelines">
		<ul>
			<li>Top two rows are for labels/titles. Will not be parsed.</li>
			<li>Left-most column for Brothers (Inviters). Will not be parsed.</li>
		</ul>
		<div class="example-image">
			<a href="example.png">Example Image</a>
		</div>
		<hr>
	</div>


	<h2>Instructions For Uploading</h2>

	<div class="instructions">
		<ol>
			<li>Open the invite list in Google Sheets (See guidelines above)</li>
			<li>Click "Download as -> Comma-separated Values (.csv, current sheet)</li>
			<li>Click the "Choose File" button below</li>
			<li>Select the file from your computer and click upload</li>
			<li>Visit <a href="index.php">Party Submission</a></li>
		</ol>
	</div>

	<form action="submit-list.php" method="post" enctype="multipart/form-data">
		<input style="float: left" type="file" name="list" id="list">
		<input style="float: right;" type="submit">
	</form>
</body>

</html>