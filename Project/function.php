<?php

	function is_logged_in(){
			if(isset($_SESSION['user'])){
				return true;
			}
		return false;
		}
		
	function is_admin(){
		if(isset($_SESSION['user']) && isset($_SESSION['user']['roles'])){
			if(in_array("admin", $_SESSION['user']['roles'])){
				return true;
			}
		}
	return false;
	}
?>
