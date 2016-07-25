<?php
		//process client request (VIA URL)
header("Content-Type:application/json");
include("functions.php");
$todo_data ="Test todo-2";
$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$url_path = parse_url($url, PHP_URL_PATH);
$url_path_arr= explode('/',$url_path);

$get_todo_path ="get_todo";
$post_todo_path ="post_todo";
$update_todo_path ="update_todo";
$delete_todo_path = "delete_todo";
//Get all todo's
if($url_path_arr[2] == $get_todo_path){
	$todos[]  = get_todos();
		if(empty($todos)){
			deliver_response(200,"No task found", NULL);
		}
		else{
			deliver_response(200,"Tasks found", $todos);
		}
}

//post data condition
else if($url_path_arr[2] == $post_todo_path){
	$arg_val = parse_url($url, PHP_URL_QUERY);		
	$error_message = "";
	$arg_val_arr = explode("=", $arg_val);
	$final_todo_data = urldecode($arg_val_arr[1]);
	if(strlen($final_todo_data) > 0){
		serve_request($url_path_arr[2],$final_todo_data);
		$todos[]  = get_todos();
		$message = $message;
		deliver_response(200, $message, $todos);
	}
}

//update todo condition
else if($url_path_arr[2] == $update_todo_path){
	echo "Update Url";
}

//delete todo condition
else if($url_path_arr[2] == $delete_todo_path){
	$arg_val = parse_url($url, PHP_URL_QUERY);
	$arg_val_arr = explode("=", $arg_val);
	$final_todo_id = urldecode($arg_val_arr[1]);
	if(strlen($final_todo_id) > 0){
		serve_request($url_path_arr[2],$final_todo_id);
		$message ="Todo deleted with id#: " . $final_todo_id;
		$todos[]  = get_todos();
		deliver_response(200,$message, $todos);
	}
}
		
function deliver_response($status,$status_message,$data){
	header("HTTP/1.1 $status $status_message");
	$response['status'] = $status;
	$response['status_message'] = $status_message;
	foreach($data as $finalData){
		$response['data'] = $finalData;
	}
	$response; 
	$response['data'] = $data;
	$json_response = json_encode($response);
	echo $json_response;
}

?>