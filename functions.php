<?php

	$servername ="localhost";
	$username ="root";
	$password ="";
	$dbname = "todo_list";

//Create Connection

	$conn = mysql_connect($servername, $username, $password);
	mysql_select_db($dbname, $conn);

// Check connection

	if(!$conn){
		die("connection Failed" . mysql_error());
	}
//get todos

function get_todos(){
	$sqlSelect = "SELECT * FROM todos WHERE status_code = 0";
	$result = mysql_query($sqlSelect);
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
}
//Add todo

function add_todo($todo_data){
	$id = mysql_insert_id() + 1;
	$sqlSelect = "INSERT INTO todos " . "( `id`,`todo_data`, `status_code`)". "VALUES ('NULL', '$todo_data', '0');";
	$result = mysql_query($sqlSelect);
	$message = '';
	if(!$result){
		if(mysql_errno() == "1062"){
			$error_message = "";
			$result_arr = array();
			$sqlSelect = "SELECT id FROM todos WHERE todo_data = '$todo_data'";
			$result = mysql_query($sqlSelect);
			while($row = mysql_fetch_assoc($result)){
				$result_arr[] = $row['id'];
			}
			print_r($result_arr);
			$task_id = $result_arr[0];
			$message = "Task already exist with id: " . $task_id;
		}
	}
	else{
		$result_arr = array();
		$sqlSelectId = "SELECT id FROM todos WHERE todo_data"."=" . "'$todo_data'";
		$resultId = mysql_query($sqlSelect);
		while($row = mysql_fetch_assoc($resultId)){
			$result_arr[] = $row['id'];
		}
		$task_id = $result_arr[0];
		$message = "Your task has been added with id#: " . $task_id;
	}
	return $message;
		
		
}

//Update Todo
function update_todo(){

}
//Delete Todo
function delete_todo($todo_data){
	$sqlDelete = "DELETE FROM todos WHERE `id`='$todo_data';";
	mysql_query($sqlDelete);
	$message = "Todo deleted with id#: " . $todo_data;
	return $message;
}
//handling no method request
function default_request(){

}

//Serve client requests
function serve_request($method, $data){
	switch ($method){
		case 'post_todo':
			return add_todo($data);
			break;
		case 'delete_todo':
			return delete_todo($data);
			break;
		case 'update_todo':
			return update_todo($data);
			break;
		default:
			
	}
}

function get_price($find){
	$books = array(
		"java"=>299,
		"c" =>348,
		"php"=>267
	);
	foreach($books as $book=>$price){
		if($book == $find){
			return $price;
			break;
		}
	}
}