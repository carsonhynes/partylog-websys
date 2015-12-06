<?php
  session_start();

  try
  {
    $dbname = 'partylog';
    $user = 'root';
    $pass = 'root';
    $dbconn = new PDO('mysql:host=localhost;dbname='.$dbname, $user, $pass);


    $result = $dbconn->prepare('CREATE TABLE IF NOT EXISTS `users` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `username` varchar(50) NOT NULL,
                  `salt` varchar(100) NOT NULL,
                  `password` varchar(100) NOT NULL,
                  `frat` varchar(50) NOT NULL,
                  `school` varchar(50) NOT NULL,
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
      //add in session data for social organization
      $msg = 'Succesfully Logged in';
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
   <script src="resources/js/modernizr-custom.js"></script>

   <style>
     #dateLabel {
       margin-right: 33px;
     }
     #personLabel {
       margin-right: 20px;
     }
     #fratInput, #personInput, #dateInput {
       width: 200px;
     }
     #dateInput {
       margin-right: 4px;
     }
     .center-text {
       text-align: center;
       width: 300px;
     }
   </style>
 </head>

 <body>

 <h1 class="center-text">Database Lookup</h1>
 <?php if (isset($_SESSION['username'])) echo "<p> Welcome " . htmlentities($_SESSION['username']) . "</p>";
 if (isset($msg)) echo "<p>$msg</p>"; $msg = NULL;
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
