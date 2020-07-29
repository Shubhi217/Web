<?php
$name=$_POST['name'];
$email =$_POST['email'] ;
$last_name=$_POST['last_name'];
$message = $_POST['message'];

function isMsginjected($str) {
	$injections = array('(\n+)','(\r+)','(\t+)','(%0A+)','(%0D+)','(%08+)','(%09+)');
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

// If the user tries to access this script directly, redirect them to the feedback form,
if (!isset($_REQUEST['email'])) {
	header("Location: $Msg_page");
}

elseif (empty($name) || empty($email)) {
	echo json_encode('Plz Complete the details!!!');
}


else {
	$state = TRUE;

	//Database start
	$servertitle = "localhost";
	$usertitle = "root";
	$password = "";

	try {

		$conn = new mysqli($servertitle, $usertitle, $password);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		// Create database
		$sql = "CREATE DATABASE IF NOT EXISTS shubhi_resume";
		if ($conn->query($sql) === True){
			$conn = new mysqli($servertitle, $usertitle, $password, "shubhi_resume");
			if ($conn){
				$sqlTable = "CREATE TABLE IF NOT EXISTS shubhigarg_resume (
				        sno int(5) auto_increment primary key not null,
						name VARCHAR(30) NOT NULL,
						email VARCHAR(60) NOT NULL,
						last_name VARCHAR(30) NULL,
						message VARCHAR(60) NULL
						)";
			
						
						
					if ($conn->query($sqlTable) === True){
						
						$sqlInsert = "INSERT INTO form1 (name,email,last_name,message) VALUES ("."'".$name."',".
						"'".$email."',".
						"'".$last_name."',".
                        "'".$message."'
                        )";


						if ($conn->query($sqlInsert) === TRUE){
						}
						else{
							echo "".$conn->error;
							$state = FALSE;
						}
					}
					
					else{
						echo "Error creating Table".$conn->error;
						$state = FALSE;
					}
				}
			else{
				echo "error";
				$state = FALSE;
			}
		} 
		
		else {
			echo "Error creating database: " . $conn->error;
			$state = FALSE;
		}

		$conn->close();

	}
	catch(Exception $e){
		echo "Connection failed: ".str($e);
	}
/*	finally{
		//Sent mail
		if ($state == TRUE){
			mail( $acri,$Msg_Subject,$message);
            mail( $email,$Msg_Subject,$message,$headers);
			
			echo json_encode('success');
		}
		else{
			echo json_encode('Something Went wrong');
		}
	
	}*/
}
?>