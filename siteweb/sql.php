<html>
<head> 
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta charset="utf-8"> 
	<link rel="stylesheet" href="stylesheet.css">
<title>Super Injection</title>
</head>
<body background="mtn.png" height=100% width=100%> 

</body>
<h1>SEARCH</h1>
<form action="./sql.php" method="get">
 <label for="search">Rechercher :</label>
 <input type="text" id="search" name="search"><br>
 <input type="submit" valeur="Submit">
</form>
</html>

<?php
$search = $_GET['search'];

if ($search == '') {
	exit();
}

echo "Looking for " . $search . " ?";

$conn = mysqli_connect('database', 'root', 'tiger', 'docker');

if (mysqli_connect_error()) {
   print("<br>Connection to Mysql Database failed: " . mysqli_connect_error());
   exit();
}

$query = "SELECT utilisateur,note FROM searchspace WHERE utilisateur='" . $search . "' AND role='élève';";
echo "This is your query > " . $query;
$result = mysqli_query($conn, $query);
echo "<br><h4>Résultat :</h4>";
if ($result->num_rows > 0) {
	echo "<table><tr><td>prénom</td><td>note</td></tr>";
	echo "<tr><td> </td><td> </td></tr><tr><td> </td><td> </td></tr><tr><td> </td><td> </td></tr>";
	while($row = $result->fetch_assoc()) {
		echo"<tr><td>" . $row["utilisateur"] . "</td><td>" . $row["note"] . "</td></tr>";
	}
	echo "</table>";
} else {
	echo "<br>No result.";
}


$conn->close();

?>
