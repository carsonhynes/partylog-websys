	<?php

		$host = 'localhost';
    $dbname = 'partylog';
    $user = 'websys';
    $pass = 'websys';

		$dbh = new PDO("mysql:host=$host", $user, $pass);

		$result = $dbh->prepare('CREATE DATABASE IF NOT EXISTS `partylog`
																DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;');

		$result->execute();

    $dbconn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

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
