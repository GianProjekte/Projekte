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

                        $error = "Diese email ist bereits vergriffen.";

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
                    
                    
            }else if($_POST['signUp'] == '0'){
                
                $query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                
                $result = mysqli_query($link, $query);
                
                $row = mysqli_fetch_array($result);

                if(isset($row)){

                      $hashedPassword = md5(md5($row['id']).$_POST['password']);
                        
                        if($hashedPassword == $row['password']){
                            
                            $_SESSION['id'] = $row['id'];
                            
                            if($_POST['stayLoggedIn'] == '1'){
                                
                                setcookie("id", mysqli_insert_id($link), time() + 60*60*24*365);
                                
                            }
                            
                            header("Location: loggedinpage.php");
                            
                        }else{
                            
                            $error = "Deine Email Passwort Kombination konnte nicht gefunden werden.";
                            
                        }
                    
                }else{
                    
                     $error = "2 Deine Email Passwort Kombination konnte nicht gefunden werden.";
                    
                }
                
                
            }
            
            
            
            
        }
        
        
        
        
        
    }



?>

<?php include("header.php"); ?>

      
      <div class="container" id="homepageContainer">
      
    <h1>Geheimes Tagebuch</h1>

          <p><b>Speichere deine Erfahrungen sicher und dauerhaft.</b></p>
          
      <div id="error"><?php if($error!= ""){
    echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    
}  ?></div>

        <form method = "post" id="signUpForm">
            
            <p>Interessiert? Dann melde dich an.</p>
            
            <div class="form-group">
            <input type= "email" class="form-control"  name = "email" placeholder="Emailadresse">
            </div>
            
            <div class="form-group">
            <input type = "password" class="form-control"  name= "password" placeholder="Password">
            </div>
                
            <div class="checkbox">  
                
                <label>
                    <input type = "checkbox"  name = "stayLoggedIn" value = 1>
                    Eingelogt bleiben.
                </label>
            
            </div>     
                
            <div class="form-group">
            <input type = "hidden" class="form-control"  name = "signUp" value= "1">
            </div>
                
            <div class="form-group">    
            <input type = "submit" class="btn btn-success"  name = "submit" value= "Sign Up!">
            </div>
            
            <p><a class="toggelForms">Anmelden</a></p>
            

        </form>

        <form method = "post" id="loginForm">
            
            <p>Logge dich ein um dein Tagebuch zu erweitern.</p>
            
            <div class="form-group">
            <input type= "email" class="form-control" name = "email" placeholder="Emailadresse">
            </div>
            <div class="form-group">
            <input type = "password" class="form-control"  name= "password" placeholder="Password">
            </div>
            <div class="checkbox">  
                
                <label>
                    <input type = "checkbox"  name = "stayLoggedIn" value = 1>
                    Eingelogt bleiben.
                </label>
            
            </div>
            <div class="form-group">    
            <input type = "hidden" class="form-control"  name = "signUp" value= "0">
            </div>
            <div class="form-group">    
            <input type = "submit" class="btn btn-success"  name = "submit" value= "Log in">
            </div>    

            <p><a class="toggelForms">Registrieren</a></p>
            
        </form>

      
      </div>

<?php include("footer.php"); ?>      



