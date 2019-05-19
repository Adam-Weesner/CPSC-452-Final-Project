<?php
  include("files/config.php");
  include("files/Account.php");
  include("files/Constants.php");

  // Create object to access Account class in Account.php file
  $account = new Account($con);

  include("files/register-handler.php");
  include("files/login-handler.php");

  // Get input value and print in text box for user to see their old input after submit
  function getInputValue($name){
    if(isset($_POST[$name])){
      echo $_POST[$name];
    }
  }
?>

<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="files/css/register.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="files/js/register.js"> </script>
  </head>
  <body>
    <?php
    // If register button is pressed, hide loginForm and show registerForm
    if(isset($_POST['registerButton'])){
      echo '
      <script>
        $(document).ready(function(){
          $("#loginForm").hide();
          $("#registerForm").show();
        });
      </script>';
    // Else if login button is pressed, hide registerForm and show loginForm
    }else{
      echo '
      <script>
        $(document).ready(function(){
          $("#loginForm").show();
          $("#registerForm").hide();
        });
      </script>';
    }
    ?>
    <div id="background">
      <div id="loginContainer">
        <div id="inputContainer">
      		</a>
          <form id="loginForm" action="index.php" method="POST">
            <h2>Log In</h2>
            <p>
              <?php echo $account->getError(Constants::$loginFailed); ?>
                <input id="loginUsername" name="loginUsername" type="text" placeholder="Username" value="<?php getInputValue('loginUsername') ?>" required>
              </label>
            </p>
            <p>
              <input id="loginPassword" name="loginPassword" type="password" placeholder="Password" required>
            </p>
            <button type="submit" name="loginButton">Login</button>
            <div class="hasAccountText">
              <br> <span id="hideLogin"> Create an account here</span>
            </div>
          </form>
          <form id="registerForm" action="index.php" method="POST">

            <h2>Create Account</h2>
            <p>
              <?php echo $account->getError(Constants::$usernameCharacters); ?>
              <?php echo $account->getError(Constants::$usernameTaken); ?>
              <?php echo $account->getError(Constants::$emailTaken); ?>
              <input id="username" name="username" type="text" placeholder="Username" value="<?php getInputValue('username') ?>" required>
            </p>
            <p>
              <?php echo $account->getError(Constants::$firstNameCharacters); ?>
              <input id="firstName" name="firstName" type="text" placeholder="First Name" value="<?php getInputValue('firstName') ?>" required>
            </p>
            <p>
              <?php echo $account->getError(Constants::$lastNameCharacters); ?>
              <input id="lastName" name="lastName" type="text" placeholder="Last Name" value="<?php getInputValue('lastName') ?>" required>
            </p>
            <p>
              <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
              <?php echo $account->getError(Constants::$emailInvalid); ?>
              <input id="email" name="email" type="email" placeholder="Email" value="<?php getInputValue('email') ?>" required>
            </p>
            <p>
              <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
              <?php echo $account->getError(Constants::$emailInvalid); ?>
              <input id="email2" name="email2" type="email" placeholder="Confirm Email" value="<?php getInputValue('email2') ?>"required>
            </p>
            <p>
              <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
              <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
              <?php echo $account->getError(Constants::$passwordCharacaters); ?>
              <input id="password" name="password" type="password" placeholder="Password" required>
            </p>
            <p>
              <input id="password2" name="password2" type="password" placeholder="Password" required>
            </p>
            <button type="submit" name="registerButton">Sign Up</button>
            <div class="hasAccountText">
              <br> <span id="hideRegister"> Have an account? Login here. </span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
