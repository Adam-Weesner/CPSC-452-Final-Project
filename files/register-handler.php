<?php
// Takes care of inputs, text boxes and buttons, creates variables and formats inputs
function sanitizeFormPassword($inputText){
  $inputText = strip_tags($inputText);
  return $inputText;
}

function sanitizeFormUsername($inputText){
  // Doesnt allow html inputs
  $inputText = strip_tags($inputText);
  // Find this, replace with this, in username
  $inputText = str_replace(" ", "", $inputText);
  return $inputText;
}

function sanitizeFormString($inputText){
  $inputText = strip_tags($inputText);
  // Find this, replace with this, in username
  $inputText = str_replace(" ", "", $inputText);
  // Capitalize first letter
  $inputText = ucfirst(strtolower($inputText));
  return $inputText;
}

if(isset($_POST['registerButton'])){
  // Register button was pressed
  $username = sanitizeFormUsername($_POST['username']);
  $firstName = sanitizeFormString($_POST['firstName']);
  $lastName = sanitizeFormString($_POST['lastName']);
  $email = sanitizeFormString($_POST['email']);
  $email2 = sanitizeFormString($_POST['email2']);
  $password = sanitizeFormPassword($_POST['password']);
  $password2 = sanitizeFormPassword($_POST['password2']);

  // Calls register function, will return true or false to $wasSuccessful
  $wasSuccessful = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2); //call register function in Account.php file

  if($wasSuccessful == true){ //if there are no errors
    $_SESSION['userLoggedIn'] = $username;

    //$con = mysqli_connect("localhost", "", "", "filmic");
    // Create a user database
  	$query = "CREATE TABLE IF NOT EXISTS " . $username . " (
        book VARCHAR(30),
        total FLOAT(10,2) NOT NULL DEFAULT '0.00'
    )";

  	$result = mysqli_query($con, $query);


    header("Location: index.php");
  }
}
?>
