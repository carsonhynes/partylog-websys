<?php

$filePath = "/var/www/html/partylog/resources/misc/names.csv";

if (move_uploaded_file($_FILES["list"]["tmp_name"], $filePath)) {
	exec("python ./resources/misc/Gcsv2list.py");
	header("Location: index.php");
}

else {
	echo '	<script>
				alert("File not uploaded");
			</script>';

	header( "refresh:0; url=upload.php" );
}