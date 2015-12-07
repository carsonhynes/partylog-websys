<?php
  session_start();
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
   <link rel="stylesheet" type="text/css" href="resources/css/pikaday.css">
   <link rel="stylesheet" type="text/css" href="resources/css/login.css">
   <script src="resources/js/modernizr-custom.js"></script>


 </head>

 <body>
   <menu>
     <?php session_start(); if(isset($_SESSION['username'])) echo "<p> Welcome " . $_SESSION['username'] ."</p>";?>
     <ul>
       <li id="title"><strong>Party Log</strong></li>
       <li><a href="login.php"><?php echo (isset($_SESSION['username'])) ? "Logout" : "Login";?></a></li>
       <li><a href="mailto:carsonhynes@gmail.com?Subject=Party%20Log" target="_top">Contact</a></li>
       <li>Help</li>
     </ul>
   </menu>
   <section id="form_container">
 <h1 class="center-text">Database Lookup</h1>
 <?php if (isset($_SESSION['username'])) echo "<p> Welcome " . htmlentities($_SESSION['username']) . "</p>";
 if (isset($msg)) echo "<p id=\"info-msg\">$msg</p>"; $msg = NULL;


 if (isset($_SESSION['username'])):?>
    <form action="login.php" method="post">
      <input type = "submit" name="logout" value="Logout"/>
    </form>
 <?php else: ?>
 <form action="login.php" method="post">
   <label for="username">Username: </label>
   <input name="username" >
   <br>

   <label for="pasword" >Password: </label>
   <input name="password" >
   <br>

   <input type="submit" name="login" value="Login" />
 </form>
 <?php endif; ?>
 </section>
</body>

<script src="resources/js/pikaday.js"></script>
<script>

  function validate(formObj) {
    if (formObj.date.value == "" && formObj.type.value == "date") {
      alert("You must enter a select a date");
      formObj.date.focus();
      return false;
    }

    if (formObj.frat.value == "" && formObj.type.value == "frat") {
      alert("You must enter a enter a fraternity name");
      formObj.frat.focus();
      return false;
    }

    if (formObj.person.value == "" && formObj.type.value == "person") {
      alert("You must enter a enter a person's name");
      formObj.person.focus();
      return false;
    }

    if (formObj.person.value == "" && formObj.date.value == "" && formObj.frat.value == "") {
      alert("You must select a form of lookup");
      return false;
    }

    return true;
  }


</script>

</html>
