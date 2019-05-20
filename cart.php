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

<form method='post'><br>
	<label for="subject" class="sr-only">Add ISBN to Cart:</label>
		<input type="text" name="bookIsbn" value="<?php echo "$isbn"; ?>" placeholder="ISBN" required="true">

<button class="btn btn-lg btn-primary" name='add' type="submit">Add</button>
</form><br>

<?php
$query = "SELECT * FROM $username";
$result = mysqli_query($con,$query);

echo "<table class='table'>
<tr>
<th scope='col'>Books In Your Cart</th>
<th scope='col'>Price</th>
</tr>";

$total = 0.00;

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td scope='row'>" . $row['book'] . "</td>";
echo "<td scope='row'>" . $row['total'] . "</td>";
echo "</tr>";
$total += $row['total'];
}
echo "</table>";

echo "<br><table class='table'>
<tr>
<th scope='col'>Total</th>
</tr>";
echo "<tr>";
echo "<td scope='row'>" . number_format((float)$total, 2, '.', '') . "</td>";
echo "</tr>";
echo "</table>";


if(isset($_POST['add'])) {

$temp = $_POST['bookIsbn'];
$look = "SELECT * FROM books WHERE isbn = '$temp'";
$result2 = mysqli_query($con,$look);
$row2 = mysqli_fetch_object($result2);
$title = $row2->title;
$price = $row2->price
;

$update2 = "INSERT INTO $username (book, total) VALUES ('$title', $price)";

if(mysqli_query($con, $update2)){
	header("Refresh:0");
} else{
    echo "ERROR: Could not able to execute $update2. " . mysqli_error($con);
}

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
<form method='post'><button class="btn btn-lg btn-primary" name='purchaseRSA' type="purchaseRSA">Purchase (RSA)</button>
<button class="btn btn-lg btn-primary" name='purchaseDigSig' type="purchaseDigSig">Purchase (Dig. Sig.)</button></form>

<?php
if(isset($_POST['purchaseRSA'])) {
  header("Location: RSA.php");
} else if(isset($_POST['purchaseDigSig'])) {
  header("Location: digitalSignature.php");
}
?>
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
</html>
