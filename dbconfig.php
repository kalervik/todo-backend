<?php
	$servername ="localhost";
	$username ="root";
	$password ="";
	$dbname = "todo_list";

//Create Connection

	$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection

	if($conn->connect_error){
		die("connection Failed" . $conn->connect_error);
	}
	echo "Connected Successfully!";

$sqlSelect = "SELECT * FROM todos WHERE status_code = 0";
	$result = $conn->query($sqlSelect);
	$result_arr = array();
	if($result === false){
		echo "Failed";
	}
	else{
		while($row = mysql_fetch_assoc($result)){
			$result_arr[] = $row;
		}
		return $result_arr;
		}
?>