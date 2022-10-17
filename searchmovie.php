<html>
	<head>
		<title>Database Interface</title>
		<script type="text/javascript" src="cwscript.js"></script>
		<link rel="stylesheet" type="text/css" href="cwstyle.css">
	</head>
	<body>
		<div id="forms" class="centre">
			<?php 
				$title = $_POST['movieName'];

				//connect to server, credentials specified in login.php
				require_once 'login.php';
				$conn = new mysqli($db_host,$db_user,$db_pass,$db_name);
				if($conn->connect_error) {
					die("$conn->$connect_error");
				}

				//validate input server-side in case JS is disabled client-side
				//only one field since searching is done by movie title
				require_once 'validate.php';
				$errMsg = movie_title_validate($title);
				if($errMsg != "") {
					die("Error: " . "$errMsg");
				}

				//sql to search database for movie given a certain title
				$sql = "SELECT mvID, actID, mvTitle, mvYear, mvGenre, mvPrice FROM Movie WHERE mvTitle = ?";
				$result = $conn->prepare($sql); //sql is prepared and executed for easy security against injection attacks
				$result->bind_param('s',$title);
				$result->execute();
				$result->bind_result($mvID,$actID,$mvTitle,$mvYear,$mvGenre,$mvPrice); //returned attributes binded to these variables
				if($result->fetch() == null) {
					die("No results :(");
				}
				$result->close();

				$sql = "SELECT actName FROM Actor WHERE actID = ?";
				$result = $conn->prepare($sql);
				$result->bind_param('s',$actID);
				$result->execute();
				$result->bind_result($actName);
				$result->fetch();

				echo "<table border='1' cellpadding='1' cellspacing='1'> 
				<tr> <td> ID </td> <td> Title </td> <td> Lead Actor </td> 
				<td> Year </td> <td> Genre </td> <td> Price </td> </tr>
				<tr> <td> $mvID </td> <td> $mvTitle </td> <td> $actName </td> 
				<td> $mvYear </td> <td> $mvGenre </td> <td> $mvPrice </td> </tr>
				</table>";

				$result->close();
				$conn->close();
			?>
			<br>
			<form action="main.html">
				<input type="submit" value="Go back">
			</form>	
			</div>
		<br>
	</body>
</html>