<?php

function Girl($p){
	
	$SetToken = "ImwX1ehjCEDK";
	
	if (isset($p["token"])) {
			$token = strval($p["token"]);
	}
	
	if (isset($p["username"])) {
			$user_name = strval($p["username"]);
	}
	
	if ($token == $SetToken){
		
		$Link = SQLReturnJPGLink();

		echo "{\"text\": \"" . WakeUp！. "\" , \"file_url\": \"".addslashes($Link)."\"}";
//		print_r($Link);
		
		SQLRecord($user_name, $Link);
		
	}
	
}

function SQLReturnJPGLink(){

	include 'SQLInfo.php';
		
	// Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
	
	$sql = "SELECT ImagesLink FROM ImgLink ORDER BY RAND() LIMIT 1";

	$result = mysqli_query($conn, $sql);
	
	if ($result){
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
//		printf ("%s \n", $row[0]);
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	
	mysqli_free_result($result);	
	mysqli_close($conn);
	return $row[0];
	
}

function SQLRecord($Caller, $Link){

	include 'SQLInfo.php';

	// Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }	
	
	$sql = "INSERT INTO  Request(caller, RespondLink) 
			VALUES ('$Caller', '$Link')";
	
	mysqli_query($conn, $sql);

//	if (mysqli_query($conn, $sql)){
//		echo "New record created successfully";
//	} else {
//		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
//	} 

	mysqli_close($conn);
	return 0;
		
}

Girl($_POST) 

?>