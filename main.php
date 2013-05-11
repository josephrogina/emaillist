<?php
//Check username and password for authentication.
require_once('sessionstart.php');
if(!isset($_SESSION['id'])){
  //If user is not logged in, redirect them.
	echo "ERROR: Unauthorized access!";
	session_destroy();
	?>
	<meta http-equiv="REFRESH" content="2;url=./login.php">
	<?php
}
else{
	//Otherwise, display the content of the page.
	?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./css/style.css">
	<meta charset="utf-8">
	<title>Registration</title>
</head>

<body>
	<div id="wrapper">
		<header>
		   <hgroup>
			  <h2>Code Test Project</h2>
			  <h3><a href="http://www.arvixe.com/">arvixe</a></h3>
		   </hgroup>
		</header>

		<h1>Registered Users</h1>
		<hr />
		<nav>
		   <ul>
			  <li><a href="./main.php">Home</a></li>
			  <li><a href="./logout.php">Log out</a></li>
		   </ul>
		</nav>

		<div id="content">
			<hr />
			<form method="post" id="myForm" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<?php

				//Call database
				require('dbc.php');
				require_once('appvars.php');

				//Query database.
				$query = "SELECT * FROM email_list";

				//Error check, grab, and store required data.
				$result = mysqli_query($dbc, $query) or die('Error querying database.');

				// Loop through the array of score data, formatting it as HTML
				echo '<table id="myTable">';
				while($row = mysqli_fetch_array($result)){
					// Display the registered users.
					echo '<tr><td>';
					echo '<strong>First Name:</strong> ' . $row['first_name'] . ' ';
					echo '<strong>Last Name:</strong> ' . $row['last_name'] . '<br />';
					echo '<strong>Email:</strong> ' . $row['email'] . '</strong><br />';
					echo '<strong>Signup Date:</strong> ' . $row['date'] . '</strong><br />';
					if(is_file(UPLOADPATH . $row['pic']) && filesize(UPLOADPATH . $row['pic']) > 0){
						echo '<td><img src="' . UPLOADPATH . $row['pic'] . '" alt="User pic" width="50" height="50"></td></tr>';
					}
					else{
						echo '</tr>';
					}
				}
				echo '</table>';

				//Close the connection to the database.
				mysqli_close($dbc);
				?>
			</form>

		</div>
		<hr />
		<footer>Copyrite &copy; 2012</footer>
	</div>
	</body>
	</html>
	<?php
}
?>
