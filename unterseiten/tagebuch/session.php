<?php

    session_start();

    if($_SESSION['email']){
        
        echo "Du bist eingelogt";
        
    }else{
        
        header("Location: index.php");
        
    }




?>