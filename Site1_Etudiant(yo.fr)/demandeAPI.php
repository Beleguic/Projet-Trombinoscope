<?php
	session_start();
	include "fonction.inc.php";

	$table = $_POST;
	
	$checkPwd = checkPwd($table);
	if(!($checkPwd)){
		header("location: admin.php?error=3&b=1");
	}
	else{
		$checkMail = checkMailJson($table);
		if($checkMail == "true"){
			$key = createAPIKey($table);
			header("location: admin.php?key=$key&b=1");
		}
		else{
			if($checkMail == "false2"){
			header("location: admin.php?error=2&b=1");
			}
			else{
				header("location: admin.php?error=1&b=1");
			}
		}
	}
?>