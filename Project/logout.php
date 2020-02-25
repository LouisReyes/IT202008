<?php
session_start();
session_unset();
session_destroy();

echo "Logged Out";
echo var_export($_SESSION, true);
//gets the cookies of the session and deletes them
if (ini_get("session.use_cookies")) 
{ 
  $params = session_get_cookie_params(); 
	//clones then destroys since it makes it's lifetime 
   setcookie(session_name(),'',time()-42000, $params["path"], $params["domain"], 
        $params["secure"], $params["http only"]); 
} 
?>