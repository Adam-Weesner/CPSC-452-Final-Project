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
	<h1>Check out our limited edition book sets!</h1>
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
	  <!-- Indicators -->
	  <ol class="carousel-indicators">
	    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	    <li data-target="#myCarousel" data-slide-to="1"></li>
	    <li data-target="#myCarousel" data-slide-to="2"></li>
	  </ol>

	  <!-- Wrapper for slides -->
	  <div class="carousel-inner">
	    <div class="item active">
	      <img src="https://1.bp.blogspot.com/-sODUUJ_ET_M/WPYO0-o2ekI/AAAAAAAAboc/ZIbvV4eZDb0dK6l_mQoDCNWEn3TziqrvgCLcB/s1600/Screen%2BShot%2B2017-04-18%2Bat%2B12.31.30.png" alt="Lord of The Rings" sytle="width:100%;">
	    </div>

	    <div class="item">
	      <img src="https://images.mentalfloss.com/sites/default/files/styles/mf_image_16x9/public/mosshed.png?itok=mlOXbt3E&resize=1100x1100" alt="Harry Potter" sytle="width:100%;">
	    </div>

	    <div class="item">
	      <img src="https://livesdifferently.files.wordpress.com/2016/01/hunger-games-book-covers.png?w=788" alt="The Hunger Games" style="width:100%;">
	    </div>
	  </div>

	  <!-- Left and right controls -->
	  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
	    <span class="glyphicon glyphicon-chevron-left"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="right carousel-control" href="#myCarousel" data-slide="next">
	    <span class="glyphicon glyphicon-chevron-right"></span>
	    <span class="sr-only">Next</span>
	  </a>
	</div>

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



	<?php
		$selection = $_POST['search'];
		$subject = $_POST['selection'];
		$query = "SELECT * FROM books WHERE $subject = '$selection'";
		$result = mysqli_query($db, $query);
		$rows = $result->num_rows;

		if(isset($_POST['searchButton']) && $rows != 0) {

			session_start();
			$_SESSION['subject'] = $selection;
			$_SESSION['selection'] = $subject;

			echo "<script type='text/javascript'>location.href = 'search.php';</script>";
		} else if (isset($_POST['searchButton'])) {
			echo "<script>alert('ERROR - Cannot find $selection in $subject');</script>";
		}


		session_start();
		$_SESSION['isbn'] = $_POST['isbn'];

		if(isset($_POST['add'])) {
			try {
					echo "<script type='text/javascript'>location.href = 'cart.php';</script>";

			}
			catch(Exception $e){
			}
		}

		if(isset($_POST['one'])) {
			try {
				$isbn = $_POST['isbn'];
				$look = "SELECT * FROM books WHERE isbn = '$isbn'";
				$result2 = mysqli_query($db,$look);
				$row2 = mysqli_fetch_object($result2);
				$title = $row2->title;
				$price = $row2->price;

				$update2 = "INSERT INTO $user (book, total) VALUES ('$title', $price)";

				if(mysqli_query($db, $update2)){
						echo "<script type='text/javascript'>location.href = 'cart.php';</script>";
				} else{
				    echo "ERROR: Could not able to execute $update2. " . mysqli_error($db);
				}



			}
			catch(Exception $e){
			}
		}
	?>
	</body>
	</html>
