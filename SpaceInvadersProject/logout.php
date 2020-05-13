<?php
session_start();
session_unset();
session_destroy();
echo "You have been logged out";
echo var_export($_SESSION, true);
if (ini_get("session.use_cookies")) { 
    $params = session_get_cookie_params(); 
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], 
        $params["secure"], $params["httponly"]); 
} 
?>