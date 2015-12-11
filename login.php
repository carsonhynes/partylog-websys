<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
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
    $select_salt = $dbconn->prepare('SELECT salt FROM users WHERE username = :username');
    $select_salt->execute(array(':username' => $_POST['username']));
    $res = $select_salt->fetch();
    $salt = ($res) ? $res['salt'] : '';
    $raw_pass = $_POST['password'];

    $hashed_salt = hash('sha256', $salt . $raw_pass);

    $stmt = $dbconn->prepare('SELECT * FROM users WHERE username=:username AND password = :password');
    $stmt->execute(array(':username' => $_POST['username'], ':password' => $hashed_salt));

    if ($user = $stmt->fetch())
    {
      $_SESSION['username'] = $user['username'];
      $_SESSION['uid'] = $user['id'];
      $_SESSION['frat'] = $user['frat'];
      //add in session data for social organization
      $msg = 'Succesfully Logged in';
      header('Location: index.php');
      exit();
    }
    else
    {
      $msg = 'Wrong username or password';
    }
  }
  if(isset($_POST['logout']) && isset($_SESSION['username']))
  {
    $_SESSION['username'] = NULL;
    $_SESSION['uuid'] = NULL;
    $msg = "You have been logged out.";
  }
 ?>
 <html>
 <head>
   <title>Party Log - Login</title>
<!--    local link to the title image
 -->   <link rel="shortcut icon" href="resources/media/PL.ico">
<!--    local links to stylesheets
 -->   <link rel="stylesheet" type="text/css" href="resources/css/pikaday.css">
   <link rel="stylesheet" type="text/css" href="resources/css/login.css">
   <link rel="stylesheet" type="text/css" href="resources/css/page.css">
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
 </head>
 <body>
<!--  menu div for semantic meaning
 -->  <menu>
<!--     if a user session is active, display a "Welcome username" heading
 -->    <?php if(isset($_SESSION['username'])) echo "<p> Welcome " . htmlentities($_SESSION['username']) ."</p>";?>
    <ul>
      <li id="title"><strong><a href="index.php">Party Log</a></strong></li>
      if a session is active, 
      <li><a href="login.php"><?php echo (isset($_SESSION['username'])) ? "Logout" : "Login";?></a></li>
      <li><a href="mailto:carsonhynes@gmail.com?Subject=Party%20Log" target="_top">Contact</a></li>
<!--     if a user session is active, display a link to upload a party list
-->      <?php if(isset($_SESSION['username'])) echo "<li><a href='upload.php'>Upload</a><li><li><a href='lookup.php'>Lookup</a><li>";?>
    </ul>
  </menu>
<!--   displays a logout button if a user is logged in
 --> <?php if (isset($_SESSION['username'])):?>
    <form action="login.php" method="post" id="logout-form">
      <h1 class="title">Log Out</h1>
      <?php if (isset($msg)) echo "<p class=\"err-msg\">$msg</p>"; $msg = NULL;?>
      <input id="submit" type = "submit" name="logout" value=" "/>
    </form>
<!-- displays a login button otherwise
 --> <?php else: ?>
 <form action="login.php" method="post" id="login-form">
   <h1 class="title">Log In</h1>
   <?php if (isset($msg)) echo "<p class=\"err-msg\">$msg</p>"; $msg = NULL;?>
   <div class="ui-widget">
       <label for="name">Username:</label>
       <input name="username" id="name" class="skipEnter login-field"/>
   </div>

   <div class="ui-widget">
       <label for="password">Password:</label>
       <input type="password" name="password" id="password" class="skipEnter login-field"/>
   </div>

   <section>
     <button ><a id="register" class="button" href="register.php">Sign up</a></button>
     <input id="submit" type="submit" name="login" value=" " />
   </section>
 </form>
 <?php endif; ?>
</body>
<!-- links to the various Javascript files needed for verification, authentication, and stying
 --><script src="resources/js/jquery-1.7.1.js"></script>
<script src="resources/js/modernizr-custom.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="resources/js/pikaday.js"></script>
<script src="resources/js/auth.js"></script>
</html>
