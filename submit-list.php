<?php

$filePath = "/var/www/html/PKP/party/names.csv";

if (move_uploaded_file($_FILES["list"]["tmp_name"], $filePath)) {
	exec("python Gcsv2list.py");
	header("Location: index.php");
}

else {
	echo '	<script>
				alert("File not uploaded");
			</script>';
}