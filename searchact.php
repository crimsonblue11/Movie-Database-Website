<html>
	<head>
		<title>Database Interface</title>
		<script type="text/javascript" src="cwscript.js"></script>
		<link rel="stylesheet" type="text/css" href="cwstyle.css">
	</head>
	<body>
		<div id="forms" class="centre">
			<?php
				//taking variable from form, using _POST method
				$actor = $_POST['actName'];

				//connect to server, credentials specified in login.php
				require_once 'login.php';
				$conn = new mysqli($db_host,$db_user,$db_pass,$db_name);
				if($conn->connect_error) {
					die("Failed to connect to database");
				}

				//validate input server-side in case JS is disabled client-side
				require_once 'validate.php';
				$errMsg = actor_validate($actor);
				if($errMsg != "") {
					die("Error: " . "$errMsg");
				}

				//sql to query actor by their name
				$sql = "SELECT * FROM Actor WHERE actName = ?";
				$result = $conn->prepare($sql); //prepared to provide extra security against sql-injections
				$result->bind_param('s',$actor);
				$result->execute();
				$result->bind_result($actID,$actName);
				if($result->fetch() == null) {
					die("Error: no results :(");
				}

				echo "<table border='1' cellpadding='1' cellspacing='1'>
						<tr> <th>ID</th> <th>Name</th> </tr> 
						<tr> <td> $actID </td> 
						<td> $actName </td> </tr> </table>";
 				
				$result->close();
				$conn->close();
			?>
			<br>
			<form action="main.html">
				<input type="submit" value="Go back">
			</form>
		</div>
	</body>
</html>