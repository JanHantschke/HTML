<?php

    echo'
           <link rel="stylesheet" href="StylesheetBlog.css">
           <form method="post"> 
           <input type="submit" name="button1"
                   value="Demodaten zuruecksetzen"/> 
           </form>';



    if (isset($_POST['button1'])) {
        $DemodatenBeitraege = file_get_contents('BeitragOriginal.csv');
        file_put_contents("Beitrag.csv", $DemodatenBeitraege);
        $DemodatenAntworten = file_get_contents('AntwortenOriginal.csv');
        file_put_contents("Antworten.csv", $DemodatenAntworten);
    }

?>
