<?php
    error_reporting(E_ALL);


    $error = "";
    $weather = "";

    if($_GET['stadt']){
        
        $_GET['stadt'] = str_replace(' ', '', $_GET['stadt']);       
        
       
        
        function url_check($url) { 
            $hdrs = @get_headers($url); 
            return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false; 
        }; 
        
        if(url_check("http://api.apixu.com/v1/current.json?key=766a60c179f842d7972163827183112&q=".$_GET['stadt'])){
            
          
           
          
          
            //der alternative Code

            $weather = file_get_contents("http://api.apixu.com/v1/current.json?key=766a60c179f842d7972163827183112&q=".$_GET['stadt']);
           
           /* Hier währe der richtige code
           
            $forecastPage = file_get_contents("http://api.apixu.com/v1/current.json?key=766a60c179f842d7972163827183112&q=".$_GET['stadt']);
                
            $pageArray = explode('3 Day Weather Forecast Summary:</b><span class="read-more-small"><span class="read-more-content"> <span class="phrase">', $forecastPage);
        
            $secondPageArray = explode('</span></span></span></p><div class="forecast-cont"><div class="units-cont">', $pageArray[1]);
        
            $weather = $secondPageArray[0];

            */
        }else{
            
            $error = "Die Stadt konnte nicht gefunden werden.";
            
        }
        
        
        
    }
    



?>


<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <title>Wetterapp</title>

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
      
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

      <style type="text/css">
      
      
        html { 
          background: url(../img/background.jpg) no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }
      
          body{
              
              background: none;
              
          }
          
          .container{
              
              text-align: center;
              margin-top: 200px;
              width: 450px;
              
          }
          
          
          #wetter{
              
              margin-top: 20px;
              
              }
          
      
      </style>
      
      
      
  </head>
  <body>
      
      <div class="container">
        
          <h1>Wie ist das Wetter?</h1>
        
          
          <form>
              <div class="form-group">
                <label for="stadt">Trage den Namen einer Stadt ein.</label>
                <input type="text" class="form-control" name="stadt" id="stadt" placeholder="z.B. Schaffhausen, Tokyo, London">
              </div>


              <button type="submit" class="btn btn-primary">Wetter Vorhersagen</button>
            </form>
            <div id="wetter">
          
                <?php
                
                    if ($weather){
                        
                        echo '<div class="alert alert-success" role="alert">'.$weather.'</div>';
                        
                    }else if($error){
                        
                        echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
                        
                    }
                
                    
                
                
                ?>
          
          </div>
      
      </div>


  </body>
</html>
