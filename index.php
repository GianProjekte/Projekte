<?php

    session_start();

    $error = "";

    if(array_key_exists("logout", $_GET)){
        
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";
        
    }else if(array_key_exists("id",$_SESSION) OR array_key_exists("id", $_COOKIE)){
        
        header("Location: loggedinpage.php");
        
    }

    
    if(array_key_exists("submit", $_POST)){
        
        include("connection.php");
        
        
        if(!$_POST['email']){
            
            $error .= "Die Emailadresse fehlt<br>";
            
        }
        
        if(!$_POST['password']){
            
            $error .= "Passwort wird benötigt<br>";
            
        }
        
        if($error != ""){
            
            $error = "<p>Es gab Fehler in deinem Formular</p>".$error;
            
        }else {
            
            if($_POST['signUp'] == '1'){
                    
                   $query = "SELECT id FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";

                    $result = mysqli_query($link, $query);

                    if(mysqli_num_rows($result) > 0){

                        $error = "Diese email ist bereits vorhanden.";

                    }else{

                        $query = "INSERT INTO users (email, password) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."',
                        '".mysqli_real_escape_string($link, $_POST['password'])."')";

                        if(!mysqli_query($link, $query)){

                            $error = "<p>Registrieren hat nicht funktioniert, versuche es später noch einmal.</p>";                    

                        }else{

                            $query = "UPDATE users SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";

                            mysqli_query($link, $query);

                            $_SESSION['id'] = mysqli_insert_id($link);

                            if($_POST['stayLoggedIn'] == '1'){

                                setcookie("id", mysqli_insert_id($link), time() + 60*60*24*365);

                            }

                            header("Location: loggedinpage.php");

                        }

                    }

                }else {

                    echo "Wird eingelogt";

                }

            }

        }


    }





?>


 <div id="error"><?php echo$error;?></div>

<form method = "post">
 
    <input type="email" name="email" placeholder="Email-Adresse">

    <input type="password" name="password" placeholder="Passwort">

    <input type="checkbox" name="stayLoggedIn" value=1>

    <input type="hidden" name="signUp" value="1">

    <input type="submit" name="submit" value="Sign Up!">


</form>

<form method = "post">

    <input type="email" name="email" placeholder="Email-Adresse">

    <input type="password" name="password" placeholder="Passwort">

    <input type="checkbox" name="stayLoggedIn" value=1>

    <input type="hidden" name="signUp" value="0">

    <input type="submit" name="submit" value="Log In">


</form>