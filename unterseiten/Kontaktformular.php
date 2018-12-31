<?php

    $error = "";
    $successMessage = "";
    
    if($_POST){

        
        if(!$_POST["email"]){
            
            $error .= "Eine Emailadresse wird benötigt.<br>";
            
        }
        
        if(!$_POST["titel"]){
            
           $error .= "Ein Titel wird benötigt.<br>";
            
        }
        
        if(!$_POST["content"]){
            
            $error .= "Inhalt wird benötigt.<br>";
            
        }
        
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) { 
            $error .= "Die Emailadresse ist ungültig.<br>";
        }
        
        if($error != ""){
            
            $error = '<div class="alert alert-danger" role="alert"><p><b>Es gab fehler in deinem Formular:</b></p>'.$error. '</div>';
            
        }else{
            
            $emailTo = "gian.rathgeb@bluewin.ch";
            
            $subject = $_POST['titel'];
            
            $content = $_POST['content'];
            
            $headers = "From: ".$_POST['email'];
            
            if(mail($emailTo, $subject, $content, $headers)){
                
               $successMessage=  '<div class="alert alert-success" role="alert"><p><b>Alles hat geklappt. ich antworten dir so schnell ich kann</b></p></div>';
                
                
            }else{
                
                $error = '<div class="alert alert-danger" role="alert"><p><b>Das Formular konnte nicht übertragen werden. Bitte versuche es noch einmal.</b></p></div>';
                
            }
            
        }
        
        
    }else{
        
       
    }

   

?>


<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kontaktformular</title>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
          </script>
    <!-- Bootstrap -->
   <!-- Das neueste kompilierte und minimierte CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optionales Theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </head>
  <body>
      
      <div class="container">
      
       <h1>Kontaktiere uns!</h1>
          
          <div id="error"><?php echo $error;
                echo $successMessage;  
            
              ?></div>
          
 
          
        <form method="post">
          <div class="form-group">
            <label for="beispielFeldEmail1">Email-Adresse</label>
            <input name="email" type="email" class="form-control" id="email" placeholder="Email-Adresse">
          </div>
          <div class="form-group">
            <label for="titel">Titel</label>
            <input type="text" name="titel" class="form-control" id="titel" >
          </div>

            <div class="form-group">
            <label for="anliegen">Deine Frage an uns</label>
            <textarea class="form-control" name="content" id="content" rows="3"></textarea>
          </div>


          <button type="submit" id="submit" class="btn btn-primary">Abschicken</button>
        </form>  
      
      </div>
   
      <script type="text/javascript">
      
         $("form").submit(function( event ) {
              
              event.preventDefault();
              
              var error = "";
              
              if($("#email").val() == ""){
                  
                  error += "<p>Keine Email-Adresse angegeben. Bitte trage sie ein.</p>";
                 
              }
              
              if($("#titel").val() == ""){
                  
                  error += "<p>Keinen Betreff angegeben. Bitte trage ihn ein.</p>";
                 
              }if($("#content").val() == "" ){
                  
                  error += "<p>Keinen Inhalt vorhanden .Bitte trage etwas ein. </p>";
                  
              }
              
              if(error != ""){
                  
                  $("#error").html('<div class="alert alert-danger" role="alert"><p><b>Es gab fehler in deinem Formular:</b></p>' + error + '</div>');
                  
                  
              }else{
                  
                  $("form").unbind('submit').submit();
                  
              }
              
              
            });
          
          
          
      
      </script>
    
  </body>
</html>