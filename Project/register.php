
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm'])){
	$pass = $_POST['password'];
	$con = $_POST['confirm'];
	if($pass != $con){
		//echo "GOOD, 'Registering'";
		$msg = "Passwords do not match!";
	}else{
		//echo "Really?";
		$msg = "Everything is good here";
	  $pass = password_hash($pass, PASSWORD_BCRYPT); //hash
	  echo "<br> '$pass' </br>";
	  //hashed
	  require("config.php");
	  $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
	  try{
    $db = new PDO($connection_string, $dbuser, $dbpass);
	  $stmt = $db->prepare("INSERT INTO 'Users2'
    (email, password) VALUES(:email,:password)");
		$email = $_POST ['email'];
		$params = array (":email" => $email, ":password" => $pass);
		$stmt -> execute($params);
		echo "<pre>" . var_export($stmt->errorInfo(),true) . "</pre>";
	}catch(Exception $e){
		echo $e -> getMessage();
		exit();
	}	
}
}
?>

<html>
	<head>
		<title>
			Project - Register 
		</title>
		<script>
   /*
			function findFormsOnLoad(){
			let myForm = document.forms.regform;
			let mySameForm = document.getElementById("myForm");
			console.log("Form by name", myForm);
			console.log("Form by id", mySameForm);
			} */
			function doValidations(form){
				let isValid = true;
				if(!verifyEmail(form)){
					isValid = false;
				}if(!verifyPasswords(form)){
					isValid = false;
				}
				return isValid;
			}
			function verifyEmail(form){
				let ee = document.getElementById("email_error");
				if(form.email.value.trim().length == 0){
          ee.innerText = "please enter email";
          return false; 
				}else{
					ee.innerText = "";
					return true;
				}
			}
			function verifyPasswords(form){
					let pe = document.getElementById("password_error");
					if(form.password.value.length == 0 || form.confirm.value.length == 0){
					//alert("You must enter both a password and confirmation password");
					pe.innerText = "You need to enter both a password and confirm password"; 
					return false;
				}
				if(form.password.value != form.confirm.value){
					//alert("typo");
					pe.innerText = "try again passwords don't match"; 
					return false;
				}
				pe.innerText= "";
				return true;
			}
		</script>
	</head>
 <style>
 body{
 background-image: url('https://wallpapershome.com/images/pages/pic_h/21456.jpg');
 background-repeat: no-repeat;
 background-position: center;
 font-size: 50px;
 font-weight: 900;
 color: white;
 background-color: black;
 }
 </style>
			<body onload="findFormsOnLoad();">
      
				<form name = "regform" id = "myForm" method = "POST" onsubmit = "return doValidations(this)">
        
					<div align = "center">
					<label for = "email"> Email: </label><br>
					<input type = "email" id = "email" name = "email" placeholder = "Enter Email"/>
					<span id = "email_error"></span>
					</div>
					<div align = "center">
					<label for = "pass"> Password: </label><br>
					<input type = "password" id = "pass" name="password" placeholder = "Enter password"/>
					</div>
					<div align = "center">
					<label for = "con"> Confirm Password: </label><br>
					<input type = "password" id = "con" name="confirm" placeholder = "ReEnter Password"/>
					<span id = "password_error"></span>
					</div>
					<div align = "center">
           <div>&nbsp;</div>
					<input type="submit" value = "Register"/>
					</div>
				</form>
				<?php if(isset($msg)):?>
				<span><?php echo $msg;?></span>
				<?php endif;?>
			</body>
</html>