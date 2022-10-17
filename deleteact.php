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
					die("Error: failed to connect to database");
				}

				//validate input server-side in case JS is disabled client-side
				require_once 'validate.php';
				$errMsg = actor_validate($actor);
				if($errMsg != "") {
					die("Error: " . "$errMsg");
				}

				$sql = "SELECT actName FROM Actor WHERE actName = ?";
				$result = $conn->prepare($sql);
				$result->bind_param('s',$actor);
				$result->execute();
				if($result->fetch() == null) {
					die("Error: $actor does not exist in table");
				}
				$result->close();

				//sql to delete actor given their name
				$sql = "DELETE FROM Actor WHERE actName = ?";
				$result = $conn->prepare($sql); //prepared to provide extra security against sql-injections
				$result->bind_param('s',$actor);
				$result->execute();
				if($result === FALSE) { //most likely fails due to foreign key dependency in movie table
					die("Error: " . $sql . "<br>" . $result->error);
				} else {
					echo "Successfully removed $actor from table Actor.";
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