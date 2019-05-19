<head>

	<?php
		include("files/config.php");
		session_start();
		$username =  $_SESSION['userLoggedIn'];
	?>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" type="text/css" href="/files/css/style.css">
	<link rel="stylesheet" type="text/css" href="/files/css/home.css">
	<link rel="stylesheet" type="text/css" href="/files/css/myLists.css">

  <title>Parana Bookstore</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="files/css/home.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    	<div class="navbar-header">
     		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavBar">
		<span class= "sr-only">Toggle Nav</span>
        	</button>
    		<a class = "navbar-brand" href="home.php">
	  	<img style="max-width:300px; margin-top: -12px;" src="files/images/Parana.png" alt="Parana"></a>
  	</div>
    	<div class="collapse navbar-collapse" id="myNavbar">
        	<ul class="nav navbar-nav navbar-right">
		<li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> View Cart </a></li>
        	<li><a href="personal.php"><span class="glyphicon glyphicon-wrench"></span> Edit Profile</a></li>
		<li><a href="index.php"><span class="glyphicon glyphicon-log-out"></span> Sign Out</a></li>
      		</ul>
	</div>
  </div>
</nav>

<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<ul class="nav navbar-nav">
		<li><form class="form-inline" method="post">

		<div class="form-inline form-signin">
				<select class="form-control" name="selection">
				<option>ISBN</option>
				<option>Author</option>
				<option>Title</option>
				</select></li>
	<li><div class ="input-group">
	<input type="text" class="form-control" placeholder="Search" name="search"></li>

		<button name="searchButton" class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
	</form>
	</ul>

	<ul class="nav navbar-nav navbar-right">
		<form class="form-inline" method='post'>
			<div class="form-group">
			<li><label for="subject" class="sr-only">Add ISBN to Cart:</label>
					<input type="text" name="isbn" class="form-control" placeholder="ISBN" required="true"></li>
			</div>
			<div class="form-group">
			<li><button class="btn btn-lg btn-primary btn-block" name='add' type="submit">Add</button></li>
			</div>
			<div class="form-group">
			<li><button class="btn btn-lg btn-primary btn-block" name='one' type="submit">1-Click Checkout</button></li>
			</div>
		</form>
	</ul>
</nav>
