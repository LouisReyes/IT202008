<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if(isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])){
	$pas = $_POST['password'];
	$email = $_POST['email'];
	
	//$pas = password_hash($pas, PASSWORD_BCRYPT); //hash
	//echo "<br> '$pas' </br>";
	//hashed
	
	require("config.php");
	$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
	try{
		$db = new PDO($connection_string, $dbuser, $dbpass);
		$stmt = $db-> prepare("SELECT id, email, password from 'Users2' where email = :email LIMIT 1");
		$params = array (":email" => $email);
		$stmt -> execute($params);
		$result = $stmt -> fetch (PDO::FETCH_ASSOC);
		echo "<pre>" . var_export($stmt -> errorInfo(), true) . "</pre>";
		if($result){
			$userpassword = $result['password'];
			/*
			this is the worng way:
			$pass = password_hash($pass, PASSWORD_BCRYPT);
			if($pass == %userpassword)
			this is the correct way (lookup password_verify online) 
			*/
			if(password_verify($pas, $userpassword)){
				$id = $result['id'];
				echo "You logged in with id of " . $result['id'];
				//echo "<pre>" . var_export($result, true) . "</pre>";
				$stmt = $db-> prepare("SELECT if, role_name from 'Roles' r JOIN 'UserRoles' ur on r.id=
				ur.role_id where ur.user_id - :id");
				$stmt->execute(array(":id" ->$id));
				$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if(!$roles){
					$roles = array();
				}
				$user = array("id" => $result['id'], 
				"email" =>$result['email'],
				"roles" => array(0=>"admin", 1=>"user"));
				$_SESSION['user'] = $user;
			
				echo "Session: <pre>" . var_export($_SESSION, true) . "</pre>";
			}else{
					echo "Failed to login, invalid";
				}
			}else{
					echo "Invalid Email";
			}
	}catch(Exception $e){
		echo $e -> getMessage();
		exit();
	}
}

?>

<html>
	<head>
		Project - Login
		<title>
			Project - Login Title
		</title>
		<script>
			function findFormsOnLoad(){
			let myForm = document.forms.regform;
			let mySameForm = document.getElementById("myForm");
			console.log("Form by name", myForm);
			console.log("Form by id", mySameForm);
			}
			function verifyPasswords(form){
				if(form.password.value != form.confirm.value){
				alert("typo");
				return false;
				}
				return true;
			}
		</script>
	</head>
			<body onload="findFormsOnLoad();">
				<form name = "regform' id = "myForm" method = "POST" onsubmit = "return verifyPasswords(this)">
					<label for = "email"> Email: </label>
					<input type = "email" id = "email" placeholder = "enter Email"/>
					<label for = "pass"> Password: <label>
					<input type = "password" id = "pass" name="password" placeholder = "Enter password"/>
					<label for = "Con"> Confirm Password: </label>
					<input type = "password" id = "con" name="confirm"/>
					<input type="submit" value = "Register"/>
				</form>
			</body>
		
	
</html>