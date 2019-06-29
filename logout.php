<?php
	session_start();
    
    if(isset($_POST['btnlogout'])) {
        if (isset($_SESSION['login'])){ 
            session_unset($_SESSION['login']);
        }
        session_destroy();
        Header("Location: principal.php");
    }

    
?>
