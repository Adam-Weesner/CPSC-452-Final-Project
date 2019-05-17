<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Chat</title>
  <div class="header">
  	<link rel="stylesheet" type="text/css" href="/files/css/style.css">
  	<link rel="stylesheet" type="text/css" href="/files/css/home.css">
    <h1 class="header-title">Chat</h1>
    <div class="header-buttons">

      <?php
        include("files/config.php");
        session_start();

				echo '<form method="post"><button id="one" name="one" class="header-button" style="vertical-align:middle"><span>Logout </span></button></form>';
				echo '<button id="two" onclick="window.location.href=\'index.php\'" class="header-button" style="vertical-align:middle"><span>Home </span></button>';

        if(array_key_exists('one',$_POST)){
          session_unset();
          session_destroy();
          header("location:login.php");
          exit();
        }

				//Check if user is logged in. Redirect if not.
				if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {} else {
					session_start();
					session_unset();
					session_destroy();
					header("location:login.php");
					exit();
				}

				$username =  $_SESSION['userLoggedIn'];
      ?>
    </div>
  </div>
</head>
