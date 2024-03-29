<?php

//$configs = include('config.php');
include "setup.php";
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'partylog';
$mysqli = new mysqli($host, $username, $password, $database);
//$mysqli = new mysqli(configs['host'], configs['username'], configs['password'], configs['database']);

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Empty';


function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function sendMail($email, $name, $soberD){

		$mail = new PHPMailer(true);

		//Set up gmail smtp
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPAuth = true; // enable SMTP authentication
		$mail->SMTPSecure = "ssl"; // sets the prefix to the servier
		$mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
		$mail->Port = 465; // set the SMTP port for the GMAIL server
		$mail->Username = "websysgroup8@gmail.com"; // GMAIL username
		$mail->Password = "richardplotkarpi"; // GMAIL password


		//create message
		$email_from = "websysgroup8@gmail.com";
		$name_from = "PartyLog";
		//Typical mail data
		$mail->AddAddress($email, $name);
		$mail->SetFrom($email_from, $name_from);
		$mail->Subject = "Partylog notification";
		$mail->Body = "The sober driver number for this party is: ". $soberD;

		try{
			$mail->Send();
			//echo "Success!";
		} catch(Exception $e){
			//Something went bad
			//echo "Fail :(";
		}

	}


//ensure school and frat exists
$frat = "'";
$sc = "'";
$frat .= test_input($_POST["fraternity"]);
$sc .= test_input($_POST["school"]);
$frat .= "'";
$sc .= "'";



$result = $mysqli->prepare("SELECT * FROM fraternity, school WHERE fraternity.name = $frat AND school.name = $sc");

$result->execute();

$result->store_result();

if($result->num_rows > 0 ){

	$q = "('";
	$q .= test_input($_POST["name"]) . "', '";
	$q .= test_input($_POST["fraternity"]) . "', '";
	$q .= test_input($_POST["school"]) . "', '";
	$q .= test_input($_POST["phoneNumber"]) . "', '";
	$q .= $username. "', '";

	if (!isset($_POST["over"])) {
		$q .= "Under')";
	}

	else {
		$q .= "Over')";
	}

	$result = $mysqli->query("INSERT INTO party (name, fraternity, school, phone, username, over) VALUES $q");



 	//this sends out an sms to the phone number

		if (isset($_POST["phoneNumber"]))
		{


			require 'PHPMailer/PHPMailerAutoload.php';


			$number = $_POST["phoneNumber"];
			$soberD = "4444444444"; // should be loaded from database by a query


			//using carriers email to sms clients because it's the only free alternative to sms gateways
			$email = $number ."@vtext.com";
			$name = "Party Guest";
			sendMail($email, $name, $soberD);

			$email = $number ."@txt.att.net";
			$name = "Party Guest";
			sendMail($email, $name, $soberD);

			$email = $number ."@tmomail.net";
			$name = "Party Guest";
			sendMail($email, $name, $soberD);

			$email = $number ."@sprintpcs.com";
			$name = "Party Guest";
			sendMail($email, $name, $soberD);


		}


}
	header("Location: index.php");
