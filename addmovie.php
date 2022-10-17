<html>
	<head>
		<title>Database Interface</title>
		<script type="text/javascript" src="cwscript.js"></script>
		<link rel="stylesheet" type="text/css" href="cwstyle.css">
	</head>
	<body>
		<div id="forms" class="centre">
			<?php
				//taking variables from form, using _POST method
				$title = $_POST['movieName'];
				$actor = $_POST['movieAct'];
				$year = $_POST['movieYear'];
				$genre = $_POST['movieGenre'];
				$price = $_POST['moviePrice'];

				//connect to server, credentials specified in login.php
				require_once 'login.php';
				$conn = new mysqli($db_host,$db_user,$db_pass,$db_name);
				if($conn->connect_error) {
					die("$conn->connect_error");
				}

				//validate input server-side in case JS is disabled client-side
				//need to validate all movie variables plus the actor's name
				require_once 'validate.php';
				$errMsg = movie_validate($title, $year, $genre, $price);
				if($errMsg != "") {
					die("Error: " . "$errMsg");
				}
				//no need to reset error message, if it gets here its already null
				$errMsg = actor_validate($actor);
				if($errMsg != "") {
					die("Error: " . "$errMsg");
				}

				//sql to search database for input actor
				$sql = "SELECT * FROM Actor WHERE actName = ?";
				$result = $conn->prepare($sql);
				$result->bind_param('s',$actor);
				$result->execute();
				$result->bind_result($actID,$actName);
				if($result->fetch() == null) {
					die("Error: actor $actor not found in database\n");
				}
				$result->close();
				//prevents non-existant (in database) actors from being lead actors

				//sql to search database for similar movie to inputted movie
				//only search by title, year, and lead actor, since we can assume if two movies have these equal then they're the same
				
				$sql = "SELECT mvTitle FROM Movie WHERE mvTitle = ? AND mvYear = ?";
				$result = $conn->prepare($sql);
				$result->bind_param("ss",$title,$year);
				$result->execute();
				if($result->fetch() != null) {
					die("Error: movie $title already exists in database\n");
				}
				$result->close();
				//prevents duplicate movies in database

				//sql to add movie into database
				$sql = "INSERT INTO Movie (actID,mvTitle,mvYear,mvPrice,mvGenre) VALUES (?,?,?,?,?) ";
				$result = $conn->prepare($sql); //preparing query to provide extra security against sql-injections
				$result->bind_param('sssss',$actID,$title,$year,$price,$genre);
				$result->execute();
				if($result === FALSE) {
					die("Error: " . $sql . "<br>" . $result->error);
				} else {
					echo "Successfully added $title to database";
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