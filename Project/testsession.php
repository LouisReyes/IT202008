<?php
	
	session_start();
	include("function.php");
	echo "<pre>" . var_export($_SESSION, true) . "</pre>";
	//
	echo "User logged in: " . is_logged_in();
	echo "<br>";
	echo "User is admin: " . is_admin();
	
	$test =1 ;
	echo"<br>";
	echo "value of test is $test";
	echo"<br>";
	echo 'value of test is $test';
	
	/*if(!is_admin()){
		//exit();
		header("Location: login.php");
	}
*/

is_admin_redirect();
?>	
