<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  function attempt()
  {
     $configs = include('config.php');
    $host = $configs['host'];
    $user =  $configs['username'];
    $pass = $configs['password'];
    $dbname = $configs['database'];

    $dbconn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
     $notAllowed = $dbconn->prepare('SELECT ip FROM banned WHERE ip = :ip');
     $notAllowed->execute(array(':ip' =>$_SERVER['REMOTE_ADDR']));

      if (!isset($_SESSION['lockout']) && $notAllowed->rowCount() ==0){
      if (isset($_SESSION['attempt-time']) && (time() - intval($_SESSION['attempt-time']) > 90))
  	  {
  		  $_SESSION['attempt-time'] = time();
  	  }
  	  if(!isset($_SESSION['attempts']))
  	  {
  		  $_SESSION['attempts'] = 0;
  	  }
  	  else {
  		  $_SESSION['attempts']++;
  	  }
  	  if(isset($_SESSION['attempts']) && $_SESSION['attempts'] > 5)
      {
  	    $_SESSION['lockout'] = time();
  	  }
  }
  else {
    if ($notAllowed->rowCount() == 0 &&time() - intval($_SESSION['lockout']) > 30 ){
      unset($_SESSION['lockout']);
      if(isset($_SESSION['attempts']) && $_SESSION['attempts'] > 5)
      {
        if($_SESSION['attempts'] > 8){
        $banned = $dbconn->prepare('INSERT INTO banned (ip) VALUES (:ip)');
        $banned->execute(array(':ip'=> $_SERVER['REMOTE_ADDR']));
        $msg = 'Your ip has been recorded and banned';
        }
      }
    }
  }
  $_SESSION['attempt-time'] = time();
}

  $configs = include('config.php');
  try
  {
    $host = $configs['host'];
    $user =  $configs['username'];
    $pass = $configs['password'];
    $dbname = $configs['database'];

    $dbh = new PDO('mysql:host=localhost', $user, $pass);

  	$result = $dbh->prepare('CREATE DATABASE IF NOT EXISTS `partylog`
  	                            DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;');

  	$result->execute();


    $dbconn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
     $banned = $dbconn->prepare('CREATE TABLE IF NOT EXISTS `banned` (
                  `ip` varchar(45 ) NOT NULL,
                  PRIMARY KEY (`ip`));
                ');
    $banned->execute();

    $result = $dbconn->prepare('CREATE TABLE IF NOT EXISTS `users` (
  								`id` int(11) NOT NULL AUTO_INCREMENT,
  								`username` varchar(50) NOT NULL,
  								`salt` varchar(100) NOT NULL,
  								`password` varchar(100) NOT NULL,
  								`frat` varchar(50) NOT NULL,
  								`school` varchar(50) NOT NULL,
  								`phone` int(11) DEFAULT NULL,
  								PRIMARY KEY (`id`));
                ');

    $result->execute();
  }
  catch (Exception $e)
  {
    echo "Error: " . $e->getMessage();
  }


  if (isset($_POST['login']) && isset($_POST['password']))
  {
    attempt();
    if(isset($_SESSION['lockout']))
		{
			if(time() - $_SESSION['lockout'] > 30){
        $_SESSION['attempts']--;
				unset($_SESSION['lockout']);
			}
		}
    $select_salt = $dbconn->prepare('SELECT salt FROM users WHERE username = :username');
    $select_salt->execute(array(':username' => $_POST['username']));
    $res = $select_salt->fetch();
    $salt = ($res) ? $res['salt'] : '';
    $raw_pass = $_POST['password'];

    $hashed_salt = hash('sha256', $salt . $raw_pass);

    $stmt = $dbconn->prepare('SELECT * FROM users WHERE username=:username AND password = :password');
    $stmt->execute(array(':username' => $_POST['username'], ':password' => $hashed_salt));
    $notAllowed = $dbconn->prepare('SELECT ip FROM banned WHERE ip = :ip');
    $notAllowed->execute(array(':ip' =>$_SERVER['REMOTE_ADDR']));
    if($notAllowed->rowCount() >0){
      $msg = "You are banned and cannot attempt login";
    }
    else if (!isset($_SESSION['lockout'])){
      if ($user = $stmt->fetch())
      {
        $_SESSION['username'] = $user['username'];
        $_SESSION['uid'] = $user['id'];
        $_SESSION['frat'] = $user['frat'];
        //add in session data for social organization
        $msg = 'Succesfully Logged in';
        unset($_SESSION['attempts']);
        unset($_SESSION['attempt-time']);
        unset($_SESSION['lockout']);
        header('Location: index.php');
        exit();
      }
      else
      {
        $msg = 'Wrong username or password';
      }
    }
    else{
      $msg = "Locked out. Please wait " . (30 - (time() - intval($_SESSION['lockout']))) . " seconds and try again.";
    }
  }
  if(isset($_POST['logout']) && isset($_SESSION['username']))
  {
    unset($_SESSION['username']);
    unset($_SESSION['uuid']);
    $msg = "You have been logged out.";
  }
 ?>

 <html>
 <head>
   <title>Party Log - Login</title>
   <link rel="shortcut icon" href="resources/media/PL.ico">
   <link rel="stylesheet" type="text/css" href="resources/css/pikaday.css">
   <link rel="stylesheet" type="text/css" href="resources/css/login.css">
   <link rel="stylesheet" type="text/css" href="resources/css/page.css">
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
   <script src="resources/js/modernizr-custom.js"></script>


 </head>

 <body>
  <menu>
    <?php if(isset($_SESSION['username'])) echo "<p> Welcome " . htmlentities($_SESSION['username']) ."</p>";?>
    <ul>
      <li id="title"><strong><a href="index.php">Party Log</a></strong></li>
      <li><a href="login.php"><?php echo (isset($_SESSION['username'])) ? "Logout" : "Login";?></a></li>
      <li><a href="mailto:carsonhynes@gmail.com?Subject=Party%20Log" target="_top">Contact</a></li>
      <?php if(isset($_SESSION['username'])) echo "<li><a href='upload.php'>Upload</a><li><li><a href='lookup.php'>Lookup</a><li>";?>
    </ul>
  </menu>

 <?php if (isset($_SESSION['username'])):?>
    <form action="login.php" method="post" id="logout-form">
      <h1 class="title">Log Out</h1>
      <?php if (isset($msg)) echo "<p class=\"err-msg\">$msg</p>"; $msg = NULL; ?>
      <input id="submit" type = "submit" name="logout" value=" "/>
    </form>

 <?php else: ?>
 <form action="login.php" method="post" id="login-form" onsubmit="return validate_login(this);">
   <h1 class="title">Log In</h1>
   <?php if (isset($msg)) echo "<p class=\"err-msg\">$msg</p>"; $msg = NULL;?>
   <section class="ui-widget">
       <label for="name">Username:</label>
       <input name="username" id="name" class="skipEnter login-field"/>
   </section>

   <section class="ui-widget">
       <label for="password">Password:</label>
       <input type="password" name="password" id="password" class="skipEnter login-field"/>
   </section>

   <section>
     <button ><a id="register" class="button" href="register.php">Sign up</a></button>
     <input id="submit" type="submit" name="login" value=" " />
   </section>
 </form>

 <?php endif; ?>

</body>


<script src="resources/js/jquery-1.7.1.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="resources/js/pikaday.js"></script>
<script type="text/javascript" src="resources/js/auth.js"></script>

</html>
