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
					die($conn->connect_error);
				}

				//validate input server-side in case JS is disabled client-side
				require_once 'validate.php';
				$errMsg = actor_validate($actor);
				if($errMsg != "") {
					die("Error: " . "$errMsg");
				}

				//sql to search for existing actor
				$sql = "SELECT actName FROM Actor WHERE actName = ?";
				$result = $conn->prepare($sql); 
				$result->bind_param('s',$actor);
				$result->execute();
				$result->bind_result($actName);
				$result->fetch();
				if($actName == $actor) {
					die("Error: an actor with the same already exists in the table\n");
				} 
				$result->close();
				//makes sure no actor is added to the table more than once

				//sql to insert actor into actor table
				$sql = "INSERT INTO Actor (actName) VALUES (?)";
				$result = $conn->prepare($sql); //prepared for easy protection against sql-injections
				$result->bind_param('s',$actor);
				$result->execute();
				if($result === FALSE) {
					die("Error: " . $sql . "<br>" . $result->error);
				} else {
					echo "Successfully added $actor to table Actor";
				}

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