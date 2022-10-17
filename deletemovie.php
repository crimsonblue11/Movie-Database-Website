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
				$title = $_POST['movieName'];

				//connect to server, credentials specified in login.php
				require_once 'login.php';
				$conn = new mysqli($db_host,$db_user,$db_pass,$db_name);
				if($conn->connect_error) {
					die("$conn->connect_error");
				}

				//validate input server-side in case JS is disabled client-side
				//only one field since deleting is done by movie title
				require_once 'validate.php';
				$errMsg = movie_title_validate($title);
				if($errMsg != "") {
					die("Error: " . "$errMsg");
				}

				$sql = "SELECT mvTitle FROM Movie WHERE mvTitle = ?";
				$result = $conn->prepare($sql);
				$result->bind_param('s',$title);
				$result->execute();
				if($result->fetch() == null) {
					die("Error: $title does not exist in table");
				}
				$result->close();

				//sql to delete movie given a certain title 
				$sql = "DELETE FROM Movie WHERE mvTitle = ?";
				$result = $conn->prepare($sql); //prepared to provide extra security against sql-injections
				$result->bind_param('s',$title);
				$result->execute();
				if($result === FALSE) { 
					die("Error: " . $sql . "<br>" . $result->error . "\n");
				} else {
					echo "Successfully removed $title from table Movie.";
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