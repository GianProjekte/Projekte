<h1>Primzahlentester</h1>

<p>Trage bitte eine ganzzahlige Zahl ein, welche dann überprüft wird.</p>

<form>

    <input type="text" name="nummer">

    <input type="submit" value="Testen!">

</form>

<?php

   

if(isInteger($_GET['nummer']) && $_GET['nummer'] > 0){

    if(isprime($_GET['nummer'])){

        echo "<p>".$_GET['nummer']." ist eine Primzahl</p>";

    }else {

        echo "<p>".$_GET['nummer']." ist keine Primzahl</p>";

    }

}else {

    echo "<b><p>Bitte trage eine Zahl ein!</p></b>";

}


    function isInteger($input) {

        return(ctype_digit(strval($input)));

    }

    function isprime($primetest) {

        $maxtest = sqrt($primetest);
        for ($i = 2; $i <= $maxtest; ++$i) {

            if ($primetest % $i == 0) {

                return false;

            }

        }

        return true;

    }


  


?>

