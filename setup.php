	<?php


    $dbname = 'partylog';
    $user = 'root';
    $pass = '';
    $dbconn = new PDO('mysql:host=localhost;dbname='.$dbname, $user, $pass);


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

	

		$greeks =array("Non-Greek","Acacia", "Alpha Chi Rho","Alpha Epsilon Pi", "Alpha Phi Alpha", "Alpha Sigma Phi","Chi Phi","Delta Kappa Epsilon","Delta Phi","Delta Tau Delta","Lambda Chi Alpha","Lambda Upsilon Lambda","Phi Gamma Delta", "Phi Iota Alpha", "Phi Kappa Tau", "Phi Kappa Theta", "Phi Mu Delta", "Phi Sigma Kappa", "Pi Delta Psi", "Pi Kappa Alpha", "Pi Kappa Phi", "Pi Lambda Phi", "Psi Upsilon", "RSE", "Sigma Alpha Epsilon", "Sigma Chi", "Sigma Alpha Epsilon", "Sigma Phi Epsilon", "Tau Epsilon Phi", "Theta Chi", "Theta Xi", "Zeta Psi");
		foreach($schools as $school){
			
			$result =$dbconn->prepare('INSERT INTO school (name) VALUES (:school)');
			$result->execute(array(':school' => $school));

	
		}
		foreach($greeks as $greek){
			$nextresult = $dbconn->prepare('INSERT INTO fraternity (name) VALUES (:greek)');
			$nextresult->execute(array(':greek' => $greek));
		}


    

	?>