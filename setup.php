	<?php

		$host = 'localhost';
    $dbname = 'partylog';
    $user = 'root';
    $pass = 'root';

		$dbh = new PDO("mysql:host=$host", $user, $pass);
		//creates the partylog database
		$result = $dbh->prepare('CREATE DATABASE IF NOT EXISTS `partylog`
																DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;');

		$result->execute();

    $dbconn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		//creates the table for user info
		$result = $dbconn->prepare('CREATE TABLE IF NOT EXISTS `users` (
									`id` int(11) NOT NULL AUTO_INCREMENT,
									`username` varchar(50) NOT NULL,
									`salt` varchar(100) NOT NULL,
									`password` varchar(100) NOT NULL,
									`frat` varchar(50) NOT NULL,
									`school` varchar(50) NOT NULL,
									`phone` int(11) DEFAULT NULL,
									`over` varchar(10) DEFAULT \'under\',
									PRIMARY KEY (`id`));
								');

		$result->execute();

		//creates the main table for logging guests at the party
		$result = $dbconn->prepare('CREATE TABLE IF NOT EXISTS `party` (
								  `number` int(11) NOT NULL AUTO_INCREMENT,
								  `name` text NOT NULL,
								  `fraternity` text NOT NULL,
								  `school` text NOT NULL,
								  `over` text NOT NULL,
								  `phone` int(11) DEFAULT NULL,
									  `username` text NOT NULL,
								  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
								  PRIMARY KEY (`number`)
								);');


		$result->execute();

		//creates the ip-ban table where the banned ips are stored
    $banned = $dbconn->prepare('CREATE TABLE IF NOT EXISTS `banned` (
                  `ip` varchar(45 ) NOT NULL,
                  PRIMARY KEY (`ip`));
                ');
    $banned->execute();

    $result = $dbconn->prepare('CREATE TABLE IF NOT EXISTS `fraternity` (

                  `name` varchar(50) NOT NULL,
                  PRIMARY KEY (`name`));
                ');
    $result->execute();


     $result = $dbconn->prepare('CREATE TABLE IF NOT EXISTS `school` (

                  `name` varchar(50) NOT NULL,
                  PRIMARY KEY (`name`));');
    $result->execute();

		$schools = array("RPI", "Sage","UAlbany","Siena","Hudson Valley","Other");


		//populates the fraternity table with all the the different frats and the school table with the different schools
		$greeks =array("None","Acacia", "Alpha Chi Rho","Alpha Epsilon Pi", "Alpha Phi Alpha", "Alpha Sigma Phi","Chi Phi","Delta Kappa Epsilon","Delta Phi","Delta Tau Delta","Lambda Chi Alpha","Lambda Upsilon Lambda","Phi Gamma Delta", "Phi Iota Alpha", "Phi Kappa Tau", "Phi Kappa Theta", "Phi Mu Delta", "Phi Sigma Kappa", "Pi Delta Psi", "Pi Kappa Alpha", "Pi Kappa Phi", "Pi Lambda Phi", "Psi Upsilon", "RSE", "Sigma Alpha Epsilon", "Sigma Chi", "Sigma Alpha Epsilon", "Sigma Phi Epsilon", "Tau Epsilon Phi", "Theta Chi", "Theta Xi", "Zeta Psi");
		foreach($schools as $school){

			$result =$dbconn->prepare('INSERT INTO school (name) VALUES (:school)');
			$result->execute(array(':school' => $school));


		}
		foreach($greeks as $greek){
			$nextresult = $dbconn->prepare('INSERT INTO fraternity (name) VALUES (:greek)');
			$nextresult->execute(array(':greek' => $greek));
		}

		header("Location: index.php");


	?>
