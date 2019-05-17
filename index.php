<!DOCTYPE html>
<html lang="en">
	<?php include("header.php");

		// User clicks on "invite" by another user's name
		if(array_key_exists('invite',$_POST)) {
			header("location:messaging.php");
		}
	?>

<body>
<div class="strip-mylist">
	<h2 id="title" class="strip-mylist-text">Welcome to Chat!:</h2>
	<p id="desc" class="strip-mylist-text">Please enjoy your stay!</p>
</div>

<div class="strip-mylist">
	<h2 id="title" class="strip-mylist-text">Users:</h2>
	<div class="strip-mylist-table">
	<table>
	  <tr>
	    <th>Username</th>
	    <th>Online?</th>
			<th></th>
	  </tr>
		<?php
			$query = "SELECT * FROM users";
			$result = mysqli_query($con, $query);
			while($row = mysqli_fetch_array($result)) {
				if ($row['username'] != $username) {
					echo '<form method="post"><tr>';
					echo "<td>" . $row['username'] . "</td>";
					echo "<td>No</td>";
					echo '<td><button name="invite" style="vertical-align:middle"><span>Invite</span></button></td>';
  				echo "</tr></form>";
				}
			}
		?>
	</table>
	</div>
</div>
<?php include("footer.php"); ?>
</body>
</html>
