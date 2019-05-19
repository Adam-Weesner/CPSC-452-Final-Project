<!DOCTYPE html>
<html lang="en">

<?php include("header.php");?>

<div class="container-fluid text-center">
  <div class="row content">
    <div class="col-sm-2 sidenav">
	<form method='post'>
		<button class="btn btn-lg btn-primary btn-block" name='all' type="submit">All</button>
		<button class="btn btn-lg btn-primary btn-block" name='general' type="submit">General</button>
		<button class="btn btn-lg btn-primary btn-block" name='fiction' type="submit">Fiction</button>
		<button class="btn btn-lg btn-primary btn-block" name='children' type="submit">Children</button>
		<button class="btn btn-lg btn-primary btn-block" name='science' type="submit">Science</button>
		<button class="btn btn-lg btn-primary btn-block" name='computer' type="submit">Computer Science</button>
	</form>
    </div>

<?php
	if(isset($_POST['all'])) {
		$_SESSION['subject'] = "ALL";
		header("Location:browse.php");
	}
	else if(isset($_POST['general'])) {
		$_SESSION['subject'] = "GENERAL";
		header("Location:browse.php");
	}
	else if(isset($_POST['fiction'])) {
		$_SESSION['subject'] = "FICTION";
		header("Location:browse.php");
	}
	else if(isset($_POST['children'])) {
		$_SESSION['subject'] = "CHILDREN";
		header("Location:browse.php");
	}
	else if(isset($_POST['science'])) {
		$_SESSION['subject'] = "SCIENCE";
		header("Location:browse.php");
	}
	else if(isset($_POST['computer'])) {
		$_SESSION['subject'] = "COMPUTER SCIENCE";
		header("Location:browse.php");
	}

?>
    <div class="col-sm-8 text-left">

<?php
	$query2 = "SELECT * FROM members WHERE userid = '$username'";
	$result2 = mysqli_query($con, $query2);
	$row = mysqli_fetch_object($result2);

	if(isset($_POST['submit'])) {
		try {

		$update = "UPDATE members SET fName='".$_POST['fName']."', lName='".$_POST['lName']."', street='".$_POST['street']."', city='".$_POST['city']."', state='".$_POST['state']."', zip='".	$_POST['zip']."', phone='".$_POST['phone']."', email='".$_POST['email']."', password='".$_POST['password']."' where userid = '$username'";

		$result = $con->query($update);

		}
		catch(Exception $e) {
          echo "Message:" .$e->getMessage();
        }

        echo "<script type='text/javascript'>location.href = 'home.php';</script>";
	}

$selection = $_POST['search'];
	$subject = $_POST['selection'];
	$query = "SELECT * FROM books WHERE $subject = '$selection'";
	$result = mysqli_query($con, $query);
	$rows = $result->num_rows;

	if(isset($_POST['searchButton']) && $rows != 0) {

		session_start();
		$_SESSION['subject'] = $selection;
		$_SESSION['selection'] = $subject;

		echo "<script type='text/javascript'>location.href = 'search.php';</script>";
	} else if (isset($_POST['searchButton'])) {
		echo "<script>alert('ERROR - Cannot find $selection in $subject');</script>";
	}
	?>

<body>
		<h1 class="h3 mb-3 font-weight-normal"><font color="white">Edit Your Information</font></h1>

      	<form class='form-signin' method='post'>
		<label for="fName" class="sr-only">First Name</label>
		<input type="text" placeholder="First Name" value="<?php echo "$row->fName"; ?>" name="fName" class="form-control" required="true"><br>

		<label for="lName" class="sr-only">Last Name</label>
		<input type="text" placeholder="Last Name" value="<?php echo "$row->lName"; ?>" name="lName" class="form-control" required="true" ><br>

		<label for="street" class="sr-only">Street</label>
		<input type="text" placeholder="Street" value="<?php echo "$row->street"; ?>" name="street" class="form-control" required="" ><br>

		<label for="city" class="sr-only">City</label>
		<input type="text" placeholder="City" value="<?php echo "$row->city"; ?>" name="city" class="form-control" required="" ><br>

		<label for="state" class="sr-only">State</label>
		<input type="text" placeholder="State" value="<?php echo "$row->state"; ?>" name="state" class="form-control" required="" ><br>

		<label for="zip" class="sr-only">Zip</label>
		<input type="text" placeholder="Zip" value="<?php echo "$row->zip"; ?>" name="zip" class="form-control" required="" ><br>

		<label for="phone" class="sr-only">Phone</label>
		<input type="text" placeholder="Phone #" value="<?php echo "$row->phone"; ?>" name="phone" class="form-control" required="" ><br>

		<label for="email" class="sr-only">Email</label>
		<input type="text" placeholder="Email" value="<?php echo "$row->email"; ?>" name="email" class="form-control" required="true" ><br>

		<label for="password" class="sr-only">Password</label>
		<input type="text" placeholder="Password" value="<?php echo "$row->password"; ?>" name="password" class="form-control" required="true" ><br><br>

	<button class="btn btn-lg btn-primary btn-block" name='submit' type="submit">Confirm</button>
      	</form>

      <hr>
      <h3></h3>
      <p></p>
    </div>
    <div class="col-sm-2 sidenav">
      <div class="well">
        <p>ADS</p>
      </div>
      <div class="well">
        <p>ADS</p>
      </div>
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
</footer>
</body>
</body>
</html>
