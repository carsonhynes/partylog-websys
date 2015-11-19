<?php

//mysqli('servername', 'username', 'password', 'database')
$mysqli = new mysqli("localhost", "websys", "websys", "partylog");


$q = "('";

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$q .= test_input($_POST["name"]) . "', '";
$q .= test_input($_POST["fraternity"]) . "', '";
$q .= test_input($_POST["school"]) . "', '";

if (test_input($_POST["over"] == NULL)) {
	$q .= "Under', '";
}

else {
	$q .= "Over')";
}

//echo $q;

$result = $mysqli->query("INSERT INTO party (name, fraternity, school, over) VALUES $q");

header("Location: index.php");
