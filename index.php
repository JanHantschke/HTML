<?php
    session_start();
    //echo phpinfo();
    $alleBeitraege = file("Beitrag.csv"); //Packt jede Zeile der CSV Datei in ein Array
    $alleAntworten = file("Antworten.csv");
    print_r($alleBeitraege);
    print_r($alleAntworten);

    $o = 0;
    $a = count($alleBeitraege) - 1; //Anzahl aller Beiträge minus 1 damit die Anzahl mit den Array Keys übereinstimmt (Array beginnt bei 0 und nicht bei 1)
    $b = count($alleAntworten) - 1;
    $ids = []; //erstellt ein leeres array
    echo $a;
    echo $b;

    $thema = "";
    $name = "";
    $text = "";
    //$edit = 0;
   // $x = 5;
   // $y = 5;

$beitrag = [];
function auslesen($leseort) {
    $array=[];

    $alleBeitraege = file(''.$leseort.''); //Packt jede Zeile der CSV Datei in ein Array
    for ($i=0;$i<count($alleBeitraege);$i++) {
        $array[$i] = explode(";",$alleBeitraege[$i]);
    }


    //print_r($array);
    return $array;

}

$beitrag = auslesen('Beitrag.csv');

/*function auslesenAntwort() {


    $alleAntworten = file("Antworten.csv");
    for ($i=0;$i<count($alleAntworten);$i++) {
        $arrayAntworten[$i] = explode(";",$alleAntworten[$i]);
    }


 //   print_r($arrayAntworten);
    return $arrayAntworten;

}*/

//$arrayAntworten = auslesen('Antworten.csv');

function error($ErrorWert,$ErrorMeldung,$ErrorMeldung2) {
    if($ErrorWert == "zuLang") {
        $ErrorWert = $ErrorMeldung . " lang!";
    } else if ($ErrorWert == "zuKurz") {
        $ErrorWert = $ErrorMeldung . " kurz!";
    } else if ($ErrorWert == "unerlaubteZeichen"){
        $ErrorWert = $ErrorMeldung2;
    }
    return $ErrorWert;
}


function schreiben($hauptArray,$speicherort) {
    //global $hauptArray;
    foreach ($hauptArray AS $teilArray) {
        //print_r($arrayTeile);
        $geteiltArray[] = trim(implode(";",$teilArray));
    }

    $geteiltArray = implode("\n",$geteiltArray);
    file_put_contents(''.$speicherort.'',$geteiltArray); //Abspeichern des Strings in der csv datei
    //return $beitraegeEinzeln;


}


/*function schreiben2() {
    global $beitrag;
    foreach ($beitrag AS $arrayTeile) {
        //print_r($arrayTeile);
        $arrayGeteilt[] = trim(implode(";",$arrayTeile));
    }

    $beitraegeEinzeln = implode("\n",$arrayGeteilt);
    file_put_contents("Beitrag.csv",$beitraegeEinzeln); //Abspeichern des Strings in der csv datei
    //return $beitraegeEinzeln;


}*/

/*function schreibenAntwort() {
    global $antwort;
    foreach ($antwort AS $arrayAntwortTeile) {
      //  print_r($arrayAntwortTeile);
        $arrayAntwortGeteilt[] = trim(implode(";",$arrayAntwortTeile));
    }

    $antwortenEinzeln = implode("\n",$arrayAntwortGeteilt);
    file_put_contents("Antworten.csv",$antwortenEinzeln); //Abspeichern des Strings in der csv datei
    //header("Location: http://localhost/phpuebungen/index.php#myHeader");
    //return $beitraegeEinzeln;


}*/

//$beitraegeEinzeln = schreiben();

$antwort = auslesen('Antworten.csv');

//echo $beitrag[1];

/*if (isset($_POST['beitragErstellen'])) {

    $thema = $_POST["thema"];  //Angaben aus Formular werden übergeben
    $name = $_POST["name"];
    $text = $_POST["text"];
    $id = $_POST["id"];
    $ausnahmeBeitrag = $_GET['ausnahmeBeitrag'];
    $datum = date("d.m.y");
    $uhrzeit = date("H:i");

    $id += 1;

    $content = file_get_contents('Beitrag.csv');
    if ($ausnahmeBeitrag==1) {
        $br = "";
    } else if (preg_match("/[a-z0-9]/i",$content)) {
        $br = "\n";
    } else {
        $br = "";
    }

    $beitragFertig = $br.$id.';'.$name.';'.$datum.';'.$uhrzeit.';'.$thema.';'.$text; //Zusammenfügen zu csv lesbarem String

    file_put_contents("Beitrag.csv",$beitragFertig, FILE_APPEND); //Abspeichern des Strings in der csv datei

    header("Location: http://localhost/phpuebungen/index.php#myHeader");

}*/

    function pruefen($zuUeberpruefen,$nichtErlaubt,$minZeichen,$maxZeichen) {
        if (!preg_match($nichtErlaubt,$zuUeberpruefen)) {
            $stringLaenge = strlen($zuUeberpruefen);
            if ($stringLaenge<=$maxZeichen&&$stringLaenge>=$minZeichen) {
                $pruefungErgebnis="erfolgreich";
            } else if ($stringLaenge>$maxZeichen) {
                $pruefungErgebnis="zuLang";
            } else if ($stringLaenge<$minZeichen) {
                $pruefungErgebnis="zuKurz";
            }
        } else {
            $pruefungErgebnis="unerlaubteZeichen";
        }
        return $pruefungErgebnis;
    }

if (isset($_POST['beitragErstellen'])) {

    header("Location: http://localhost/phpuebungen/index.php#myHeader");

    $thema = $_POST["thema"];  //Angaben aus Formular werden übergeben
    $name = $_POST["name"];
    $text = $_POST["text"];
    $id = $_POST["id"];
    $datum = date("d.m.y");
    $uhrzeit = date("H:i");
    $_SESSION['thema'] = $thema;
    $_SESSION['name'] = $name;
    $_SESSION['text'] = $text;

    $zuUeberpruefen = $thema;
    $nichtErlaubt = "/[^a-z0-9?äüö -+!?_%&\$\.\*\"()]/si";
    $minZeichen = 5;
    $maxZeichen = 35;

    $pruefungErgebnisThema= pruefen($zuUeberpruefen,$nichtErlaubt,$minZeichen,$maxZeichen);
    $_SESSION['themaError'] = $pruefungErgebnisThema;

    $zuUeberpruefen = $name;
    $nichtErlaubt = "/[^a-z0-9_]/si";
    $minZeichen = 4;
    $maxZeichen = 15;

    $pruefungErgebnisName= pruefen($zuUeberpruefen,$nichtErlaubt,$minZeichen,$maxZeichen);
    $_SESSION['nameError'] = $pruefungErgebnisName;

    $zuUeberpruefen = $text;
    $nichtErlaubt = "/[^a-z0-9?äüö -+!?_%&\$\.\*\"()]/si";
    $minZeichen = 50;
    $maxZeichen = 1000;

    $pruefungErgebnisText= pruefen($zuUeberpruefen,$nichtErlaubt,$minZeichen,$maxZeichen);
    $_SESSION['textError'] = $pruefungErgebnisText;

    //$id += 1;

    //pruefen($zuUeberpruefen,$nichtErlaubt,$minZeichen,$maxZeichen);

    if ($pruefungErgebnisThema == "erfolgreich" && $pruefungErgebnisName == "erfolgreich" && $pruefungErgebnisText == "erfolgreich") {

        auslesen('Beitrag.csv');

        $idFestBeitrag = file_get_contents('idFestBeitrag.txt');
        $idFestBeitrag += 1;
        file_put_contents("idFestBeitrag.txt", $idFestBeitrag);

        $aBeitraege = count($alleBeitraege);
        $beitrag[$aBeitraege][0] = $idFestBeitrag;
        $beitrag[$aBeitraege][1] = $name;
        $beitrag[$aBeitraege][2] = $datum;
        $beitrag[$aBeitraege][3] = $uhrzeit;
        $beitrag[$aBeitraege][4] = $thema;
        $beitrag[$aBeitraege][5] = $text;

        $speicherort = "Beitrag.csv";

        schreiben($beitrag, $speicherort);
    } else {
        header("Location: http://localhost/phpuebungen/index.php?eingabeFehler=1#Anker1");
    }

}

if (isset($_POST['beitragEditieren'])) {

    $themaEdit = $_POST["themaEdit"];
    $nameEdit = $_POST["nameEdit"];
    $textEdit = $_POST["textEdit"];
    $id = $_POST["idEdit"];
    $key = $_POST["keyEdit"];
    $datum = date("d.m.y");
    $uhrzeit = date("H:i");

    $_SESSION['thema'] = $themaEdit;
    $_SESSION['name'] = $nameEdit;
    $_SESSION['text'] = $textEdit;

    $zuUeberpruefen = $themaEdit;
    $nichtErlaubt = "/[^a-z0-9?äüö -+!?_%&\$\.\*\"()]/si";
    $minZeichen = 5;
    $maxZeichen = 35;

    $pruefungErgebnisThema= pruefen($zuUeberpruefen,$nichtErlaubt,$minZeichen,$maxZeichen);
    $_SESSION['themaError'] = $pruefungErgebnisThema;

    $zuUeberpruefen = $nameEdit;
    $nichtErlaubt = "/[^a-z0-9_]/si";
    $minZeichen = 4;
    $maxZeichen = 15;

    $pruefungErgebnisName= pruefen($zuUeberpruefen,$nichtErlaubt,$minZeichen,$maxZeichen);
    $_SESSION['nameError'] = $pruefungErgebnisName;

    $zuUeberpruefen = $textEdit;
    $nichtErlaubt = "/[^a-z0-9?äüö -+!?_%&\$\.\*\"()]/si";
    $minZeichen = 50;
    $maxZeichen = 1000;

    $pruefungErgebnisText= pruefen($zuUeberpruefen,$nichtErlaubt,$minZeichen,$maxZeichen);
    $_SESSION['textError'] = $pruefungErgebnisText;

    if ($pruefungErgebnisThema == "erfolgreich" && $pruefungErgebnisName == "erfolgreich" && $pruefungErgebnisText == "erfolgreich") {

        auslesen('Beitrag.csv');

        // echo"testtestttest";
        // print_r($beitrag);

        $beitrag[$key][1] = $nameEdit;
        $beitrag[$key][4] = $themaEdit;
        $beitrag[$key][5] = $textEdit;
        $beitrag[$key][5] = trim($beitrag[$key][5]);
        $beitrag[$key][6] = $datum;
        $beitrag[$key][7] = $uhrzeit;


        $speicherort = "Beitrag.csv";

        // echo"testtestttest";
        //  print_r($beitrag);

        schreiben($beitrag, $speicherort);

        //   echo"testtestttest";
        // print_r($beitrag);

        /*$beitragEdit = implode(";",$beitrag);

        if ($key==$a) {
            $alleBeitraege[$key] = $beitragEdit;
        } else {
            $alleBeitraege[$key] = $beitragEdit."\n";
        }

        file_put_contents("Beitrag.csv",$alleBeitraege);*/

        //unset($_POST['beitragEditieren']);

        header('Location: http://localhost/phpuebungen/#' . $beitrag[$o][0] . '');
    } else {
        $editKey = $_GET['key'];
        $editId = $_GET['id'];
        $editValue = $_GET['edit'];
        header('Location: http://localhost/phpuebungen/index.php?eingabeFehler=1&key='.$editKey.'&id='.$editId.'&edit='.$editValue.'#Anker1');
    }

}

if (isset($_POST['beitragAntworten'])) {
    $idAntwort = $_POST["idAntwort"];

    $nameAntwort = $_POST["nameAntwort"];
    $textAntwort = $_POST["textAntwort"];
    $idAntwort = $_POST["idAntwort"];
    $ausnahme = $_GET['ausnahme'];
    $datum = date("d.m.y");
    $uhrzeit = date("H:i");

    $_SESSION['name'] = $nameAntwort;
    $_SESSION['text'] = $textAntwort;

    $zuUeberpruefen = $nameAntwort;
    $nichtErlaubt = "/[^a-z0-9_]/si";
    $minZeichen = 4;
    $maxZeichen = 15;

    $pruefungErgebnisName= pruefen($zuUeberpruefen,$nichtErlaubt,$minZeichen,$maxZeichen);
    $_SESSION['nameError'] = $pruefungErgebnisName;

    $zuUeberpruefen = $textAntwort;
    $nichtErlaubt = "/[^a-z0-9?äüö -+!?_%&\$\.\*\"()]/si";
    $minZeichen = 5;
    $maxZeichen = 1000;

    $pruefungErgebnisText= pruefen($zuUeberpruefen,$nichtErlaubt,$minZeichen,$maxZeichen);
    $_SESSION['textError'] = $pruefungErgebnisText;


    if ($pruefungErgebnisName == "erfolgreich" && $pruefungErgebnisText == "erfolgreich") {

        header('Location: http://localhost/phpuebungen/index.php#'.$idAntwort.'');
        $details="open";
        auslesen('Antworten.csv');

        $bAntworten = count($alleAntworten);


        $idFestAntwort = file_get_contents('idFestAntwort.txt');
        $idFestAntwort += 1;
        file_put_contents("idFestAntwort.txt", $idFestAntwort);

        $antwort[$bAntworten][0] = $idFestAntwort;
        $antwort[$bAntworten][1] = $idAntwort;
        $antwort[$bAntworten][2] = $nameAntwort;
        $antwort[$bAntworten][3] = $datum;
        $antwort[$bAntworten][4] = $uhrzeit;
        $antwort[$bAntworten][5] = $textAntwort;


        $speicherort = "Antworten.csv";


        schreiben($antwort, $speicherort);

    } else {
        $editKey = $_GET['key'];
        $editId = $_GET['id'];
        $editValue = $_GET['edit'];
        header('Location: http://localhost/phpuebungen/index.php?eingabeFehlerAntwort=1&key='.$editKey.'&id='.$editId.'&edit='.$editValue.'&idAntwort='.$idAntwort.'#'.$idAntwort.'');
    }

}

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
    header("Location: http://localhost/phpuebungen/");
}

if (isset($_GET['antwortLoeschen'])) {
    $id = $_GET['id'];
    $speicherort='Antworten.csv';

    $c = count($alleAntworten);
    for ($l=0;$l<$c;$l++) {
        if ($antwort[$l][0] == $id) {
            unset($antwort[$l]);
            schreiben($antwort,$speicherort);
        }
    }

    header("Location: http://localhost/phpuebungen/");


    /*unset($alleAntworten[$keyAntwort]);
    file_put_contents("Antworten.csv",$alleAntworten);
    if ($keyAntwort==$b) {
        header("Location: http://localhost/phpuebungen/index.php?ausnahme=1");
    } else {
        header("Location: http://localhost/phpuebungen/");
    }*/
}

if (isset($_GET['beitragLoeschen'])) {
    $id = $_GET['id'];
    $speicherortBeitrag = 'Beitrag.csv';
    $speicherortAntwort = 'Antworten.csv';
    $c = count($alleAntworten);
    $d = count($alleBeitraege);
    for ($k = 0; $k < $d; $k++) {
        if ($beitrag[$k][0] == $id) {
            unset($beitrag[$k]);
            for ($j = 0; $j < $c; $j++) {
                if ($antwort[$j][1] == $id) {
                    unset($antwort[$j]);
                }
            }
            schreiben($beitrag, $speicherortBeitrag);
            schreiben($antwort, $speicherortAntwort);
        }
    }
    header("Location: http://localhost/phpuebungen/");
}

/*if (isset($_GET['beitragLoeschen'])) {
    $keyBeitrag = $_GET['keyBeitrag'];
    $id = $_GET['id'];
    unset($alleBeitraege[$keyBeitrag]);
    file_put_contents("Beitrag.csv", $alleBeitraege);
    for ($i=0;$i <= $b; $i++) {
        $antwort = explode(";", $alleAntworten[$i]);
        if ($id == $antwort[0]&&$i==$b){
            unset($alleAntworten[$i]);
            file_put_contents("Antworten.csv", $alleAntworten);
            $ausnahmeAntwort=1;
        } else if ($id == $antwort[0]) {
            unset($alleAntworten[$i]);
            file_put_contents("Antworten.csv", $alleAntworten);
        }
    }
*/


  /*  if ($keyBeitrag==$a&&$ausnahmeAntwort==1) {
        header("Location: http://localhost/phpuebungen/index.php?ausnahmeBeitrag=1&ausnahmeAntwort=1");
        $ausnahmeButton=1;
    } else if ($keyBeitrag==$a) {
        header("Location: http://localhost/phpuebungen/index.php?ausnahmeBeitrag=1");
        $ausnahmeButton=1;
    } else {
        header("Location: http://localhost/phpuebungen/");
    } */

//}

/*if (isset($_GET['ausnahmeBeitrag'])) {
    $ausnahmeButton=1;
} else {
    $ausnahmeButton=0;
}
*/
/*
if ($x==5&&$y==5) {
    echo "test erfolgreich";
}
*/
    echo '
            <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
            <link rel="stylesheet" href="StylesheetBlog.css">
            <title>Title</title>
            <style type="text/css">a {text-decoration: none}</style>
        </head>
        <body>
        <div class="Innen">
            <div class="parallax">
            <div class="links">
            </div>
            <div class="Ueberschrift">
                <h1>
                    <a id="myHeader" class="myHeaderClass"  href="Blog.html"> Vincent\'s Blog </a>
                </h1>
            </div>
            <div class="Einleitung">
                In diesem Blog hast du die Möglichkeit mit anderen Leuten über aktuelle Themen zu diskutieren. <br>
                Gibt es etwas über das du gerne mehr erfahren möchtest oder möchtest du etwas wichtiges mit der Community teilen? <br>
            </div>
            <div class="Einleitung2">
                Dann beginne jetzt mit:
            </div>
            <div class="BeitragButton">
                <a href="index.php#Anker1" class="myButton">Beitrag erstellen</a>
           </div>';

 /*<div id="myHeader" class="BeitragButton">
                <a href="index.php?/*ausnahmeBeitrag='.$ausnahmeButton.'#Anker1" class="myButton">Beitrag erstellen</a>
           </div>'; */

    for($o=$a;$o>=0;$o--) { //Fängt bei der Anzahl der Beiträge an und zählt von dort runter
        $fehlerAnzeigeAntwort1 = "";
        $fehlerAnzeigeAntwort2 = "";
        if (isset($_GET['idAntwort'])) {
            $idAntwortError = $_GET['idAntwort'];
        }
        //$beitrag = explode(";",$alleBeitraege[$a]); //durch das herrutnerzählen wird der letzte also neuste Beitrag immer zuerst angezeigt
        //print_r($beitrag);

        auslesen('Beitrag.csv');
        $BeitragAnzahl = count($beitrag[$o]);

        if ($BeitragAnzahl > 1){
        //print_r($beitrag);


          //  $ids[] = $beitrag[$o][0]; //Addiert bei jedem Schleifendurchlauf den 0. Key des Beitrag arrays in das Ids array

            if(isset($idAntwortError)) {
                if ($beitrag[$o][0] == $idAntwortError) {
                    if (isset($_GET['eingabeFehlerAntwort'])) {
                        auslesen('Beitrag.csv');
                        //  print_r($beitrag);

                        $details = "open";

                        $themaValue = $_SESSION['thema'];
                        $nameValue = $_SESSION['name'];
                        $textValue = $_SESSION['text'];

                        $themaError = $_SESSION['themaError'];
                        $nameError = $_SESSION['nameError'];
                        $textError = $_SESSION['textError'];


                        /*error($themaError,$dropdownThema,$themaClass,errorThema1);
                        function error($value,$dropdownClass,$valueClass,$valueErrorClass) {
                            if ($value == "erfolgreich") {
                                $dropdownClass = "dropdown1";
                                $valueClass = $valueErrorClass;
                            } else {
                                $dropdownClass = 'dropdown';
                                $valueClass = "errorThema";
                            }
                        }*/

                        if ($themaError == "erfolgreich") {
                            $dropdownThema = "dropdown1";
                            $themaClass = "errorThema1";
                        } else {
                            $dropdownThema = 'dropdown';
                            $themaClass = "errorThema";
                        }

                        if ($nameError == "erfolgreich") {
                            $dropdownName = "dropdown1";
                            $nameClass = "errorName1";
                        } else {
                            $dropdownName = 'dropdown';
                            $nameClass = "errorName";
                        }


                        if (preg_match("/[<>]/", "><")) {
                            print "haloo a haloo ahaloo ahaloo ahaloo ahaloo a";
                        }
                        print $textError;

                        if ($textError == "erfolgreich") {
                            $dropdownText = "dropdown1";
                            $textClass = "errorText1";
                        } else {
                            $dropdownText = 'dropdown';
                            $textClass = "errorText";
                        }


                        $themaError = error($themaError, "Das eingegebene Thema ist zu", "Das eingegebene Thema enthält unerlaubte Zeichen!");
                        $nameError = error($nameError, "Der eingegebene Name ist zu", "Der eingegebene Name enthält unerlaubte Zeichen!");
                        $textError = error($textError, "Der eingegebene Text ist zu", "Der eingegebene Text enthält unerlaubte Zeichen!");

                        $fehlerAnzeigeAntwort1 = '<div class="antwortAllFlex">
                <div class="antwortFlex">';


                        $fehlerAnzeigeAntwort2 = '
                </div>
                <div class="errorFlex">
                <div class="' . $dropdownName . '">
                <div class="' . $nameClass . '">
                </div>
                <div class="content">
                    ' . $nameError . '
                </div>
                </div>
                <div class="' . $dropdownText . '">
                <div class="' . $textClass . '">
                </div>
                <div class="content">
                    ' . $textError . '
                </div>
                </div>
                </div>
                </div>';

                        /* $fehlerAnzeigeAntwort2 = '</div>
                                    <div class="antwortErrorFlex">
                                        <div class="dropdown">
                                        <div class="content">
                                            testtesttestttest
                                        </div>
                                        </div>
                                        <div class="errorName">
                                        </div>
                                        <div class="errorText">
                                    </div>
                                    </div>
                                    </div>';*/


                    }
                }
                } else {
                    $details = "";
                    $nameValue = "";
                    $textValue = "";
                }



            print_r($antwort);

            if (empty($details)) {
                $details = "";
            }

            if (empty($nameValue)) {
                $nameValue = "";
            }

            if (empty($details)) {
                $textValue = "";
            }

            $antwortKey = $beitrag[$o][0];
            echo 'adsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsdsds'.$o;
            echo '
               <div class="Beitrag" id="'.$beitrag[$o][0].'">
                    <fieldset>
                    <legend> ' . $beitrag[$o][1] . ' - ' . $beitrag[$o][2]. ' - ' . $beitrag[$o][3]. ' </legend>
                    <div class="legend4">
                        <a href="index.php?key=' . $o . '&id=' . $beitrag[$o][0] . '&edit=1#Anker1">editieren</a>
                    </div>
                    <div class="legendBeitragEdit">
                        <a class="loeschen" href="index.php?keyBeitrag=' . $a . '&id=' . $beitrag[$o][0] . '&beitragLoeschen=1">löschen</a>
                    </div>
                    <div class="legend2">
                        <details '.$details.'>
                            <summary> Antworten </summary>
                               '.$fehlerAnzeigeAntwort1.'
                            <div class="field" id="'.$beitrag[$o][0].'">
                                <form class="contact-form" method="post">
                            </div>
                            <div class="col-md-12 mb-4">
                            <div class="field">
                                <input type="text" class="email form-control" onkeydown="myFunction(\'nameAntwort'.$beitrag[$o][0].'\',4,15,\'Der\')" id="nameAntwort'.$beitrag[$o][0].'" value="'.$nameValue.'" name="nameAntwort" class="email" placeholder="Name" >
                            <div id="nameAntwort'.$beitrag[$o][0].' invalidTooltip" class="invalid-tooltip">
                                
                            </div>
                            </div>
                            </div>
                            <div class="col-md-12 mb-2">
                            <div class="field">
                                <textarea cols="50" rows="10" class="text form-control" id="textAntwort'.$beitrag[$o][0].'" onkeydown="myFunction(\'textAntwort'.$beitrag[$o][0].'\',5,1000,\'Der\')" name="textAntwort" placeholder="Text hier eingeben">'.$textValue.'</textarea>
                            <div id="textAntwort'.$beitrag[$o][0].' invalidTooltip" class="invalid-tooltip">
                                
                            </div>
                            </div>
                            </div>
                            <input type="hidden" name="idAntwort" value="' . $beitrag[$o][0] . '">
                            <div class="col-md-12 mb-1">
                            <div class="field">
                                <button type="submit" name="beitragAntworten" class="submit" value="0">Antwort abschicken</button>
                            </div>
                            </div>
                            </form>
                            '.$fehlerAnzeigeAntwort2.'
                        </details>
                    </div>
                    <div class="legend3">
                        <details>
                            <summary> Antworten anzeigen </summary>
                            <div class="scroll">';

            for ($p=$b;$p>=0;$p--) { //Fängt bei der Anzahl aller Antworten an und zählt von dort runter, überprüft alle Antworten

                //$antwort = explode(";", $alleAntworten[$b]); //durch das rutnerzählen von hinten wird die letzte also neuste Antwort immer zuerst angezeigt
                //  print_r($antwort);

                auslesen('Antworten.csv');

                if ($antwort[$p][1] == $beitrag[$o][0]) { //Wenn der Key 0 der Antwort (ID) der Antwort mit dem Key 0 des Beitrags (ID) übereinstimmt wirde diese Antwort unter dem Beitrag angezeigt.


                    echo '
                        <fieldset class="antwort">
                            <legend>' . $antwort[$p][2] . ' - ' . $antwort[$p][3] . ' - ' . $antwort[$p][4] . ' </legend>
                            <div class="legendAntwortEdit">
                                <a class="loeschen" href="index.php?id=' . $antwort[$p][0] . '&antwortLoeschen=1">löschen</a>
                            </div>
                            <div class="AntwortText">
                                ' . $antwort[$p][5] . '
                            </div>
                        </fieldset>
                        ';
                } else {
                    //    echo "error error error error error error error ";
                }
            }
            $b = count($alleAntworten) - 1; //Counter wird zurückgesetzt damit alle Antworten mit dem nächsten Beitraf abgeglichen werden können
            echo '
                        </div>
                        </details>
                    </div>';

            if (isset($beitrag[$o][7])) {
                echo '<div class="BeitragEdit">
                        editiert am ' . $beitrag[$o][6] . " " . $beitrag[$o][7] . '
                    </div>';

            }

            echo '<div class="BeitragThema">
                        ' . $beitrag[$o][4] . '
                    </div>
                    <div class="BeitragText">
                        ' . $beitrag[$o][5] . '
                    </div>
                </fieldset>
            </div>';

        }

    }

   // print_r($ids);
    //$edit = $_GET['edit'];


if (isset($_GET['edit'])) {
    $key = $_GET['key'];
    $id = $_GET['id'];
    auslesen('Beitrag.csv');
    //  print_r($beitrag);
    $nameThema = "themaEdit";
    $themaValue = $beitrag[$key][4];

    $nameName = "nameEdit";
    $nameValue = $beitrag[$key][1];

    $nameText = "textEdit";
    $textValue = $beitrag[$key][5];

    $nameBeitrag = "beitragEditieren";
    $beitragButtonText = "Beitrag editieren";
    $fehlerAnzeige1 = "";
    $fehlerAnzeige2 = "";


} else {
    auslesen('Beitrag.csv');
    //  print_r($beitrag);
    $nameThema = "thema";
    $themaValue = "";

    $nameName = "name";
    $nameValue = "";

    $nameText = "text";
    $textValue = "";

    $nameBeitrag = "beitragErstellen";
    $beitragButtonText = "Beitrag absenden";

    $fehlerAnzeige1 = "";
    $fehlerAnzeige2 = "";

    $id = "";
    $key = "";
}

if (isset($_GET['eingabeFehler'])) {
    auslesen('Beitrag.csv');
    //  print_r($beitrag);
    $themaValue = $_SESSION['thema'];
    $nameValue = $_SESSION['name'];
    $textValue = $_SESSION['text'];

    $themaError = $_SESSION['themaError'];
    $nameError = $_SESSION['nameError'];
    $textError = $_SESSION['textError'];


    /*error($themaError,$dropdownThema,$themaClass,errorThema1);
    function error($value,$dropdownClass,$valueClass,$valueErrorClass) {
        if ($value == "erfolgreich") {
            $dropdownClass = "dropdown1";
            $valueClass = $valueErrorClass;
        } else {
            $dropdownClass = 'dropdown';
            $valueClass = "errorThema";
        }
    }*/

    if ($themaError == "erfolgreich") {
        $dropdownThema = "dropdown1";
        $themaClass = "errorThema1";
    } else {
        $dropdownThema = 'dropdown';
        $themaClass = "errorThema";
    }

    if ($nameError == "erfolgreich") {
        $dropdownName = "dropdown1";
        $nameClass = "errorName1";
    } else {
        $dropdownName = 'dropdown';
        $nameClass = "errorName";
    }


    if (preg_match("/[<>]/","><")) {
        print "haloo a haloo ahaloo ahaloo ahaloo ahaloo a";
    }
    print $textError;

    if ($textError == "erfolgreich") {
        $dropdownText = "dropdown1";
        $textClass = "errorText1";
    } else {
        $dropdownText = 'dropdown';
        $textClass = "errorText";
    }



    $themaError = error($themaError,"Das eingegebene Thema ist zu","Das eingegebene Thema enthält unerlaubte Zeichen!");
    $nameError = error($nameError,"Der eingegebene Name ist zu","Der eingegebene Name enthält unerlaubte Zeichen!");
    $textError = error($textError,"Der eingegebene Text ist zu","Der eingegebene Text enthält unerlaubte Zeichen!");

    $fehlerAnzeige1 = '<div class="allFlex">
                <div class="newFlex">';


    $fehlerAnzeige2 = '<div class="errorFlex">    
                <div class="'.$dropdownThema.'">
                <div class="'.$themaClass.'">
                </div>
                <div class="content">
                    '.$themaError.'
                </div>
                </div>
                <div class="'.$dropdownName.'">
                <div class="'.$nameClass.'">
                </div>
                <div class="content">
                    '.$nameError.'
                </div>
                </div>
                <div class="'.$dropdownText.'">
                <div class="'.$textClass.'">
                </div>
                <div class="content">
                    '.$textError.'
                </div>
                </div>
                </div>
                </div>';


}
$idValue = "thema";

    echo '<footer>
            '.$fehlerAnzeige1.'
            <div id="Anker1" class="BeitragErstellen">
                <div class="field">
                    <form class="contact-form" id="myForm" method="post">
                </div>
                <div class="col-md-12 mb-4">
                <div class="field">
                    <input type="text" id="Thema" onkeydown="myFunction(\'Thema\',5,35,\'Das\')" name="'.$nameThema.'" value="'.$themaValue.'" class="email form-control" placeholder="Thema" >
                <div id="Thema invalidTooltip" class="invalid-tooltip">
                    
                </div>
                </div>
                </div>
                <div class="col-md-12 mb-4">
                <div class="field">
                    <input type="text" id="Name" onkeydown="myFunction(\'Name\',4,15,\'Der\')" name="'.$nameName.'" value="'.$nameValue.'" class="email form-control" placeholder="Name" >
                    <div id="Name invalidTooltip" class="invalid-tooltip">
                        
                    </div>
                </div>
                </div>
                <div class="col-md-12 mb-3">
                <div class="fieldText overflow-auto">
                    <textarea cols="50" rows="3" id="Text" onkeydown="myFunction(\'Text\',50,1000,\'Der\')"  class="text form-control"  name="'.$nameText.'" placeholder="Text hier eingeben">'.$textValue.'</textarea>
                    <div id="Text invalidTooltip" class="invalid-tooltip">
                        
                    </div>
                <div class="progress">
                  <div id="idProgress" class="progress-bar" role="progressbar" style="width:0%" aria-valuemin="0" aria-valuemax="1000"></div>
                </div>
                </div>
                </div>
                <input type="hidden" name="idEdit" value="'.$id.'">
                <input type="hidden" name="keyEdit" value="'.$key.'">
                <div class="field">
                    <button type="submit" name="'.$nameBeitrag.'" class="submit" value="0">'.$beitragButtonText.'</button>
                </div>
                </form>
            </div>
            '.$fehlerAnzeige2.'
        </footer>';
/*
         } else if (isset($_GET['eingabeFehler'])) {

    $text = $_SESSION['text'];

    echo '<footer>
<div class="allFlex">
            <div class="newFlex">
                <div id="Anker1" class="BeitragErstellen">
                    <div class="field">
                        <form class="contact-form" method="post">
                    </div>
                    <div class="field">
                        <input type="text" name="thema" value="" class="email" placeholder="Thema" >
                    </div>
                    <div class="field">
                        <input type="text" name="name" class="email" placeholder="Name" >
                    </div>
                    <div class="field">
                        <textarea cols="50" rows="10"  class="text"  name="text" placeholder="Text hier eingeben">'.$text.'</textarea>
                    </div>
                    <div class="field">
                        <button type="submit" name="beitragErstellen" class="submit" value="0">Beitrag absenden</button>
                    </div>
                    </form>
                                    </div>
                <div class="errorFlex">    
                <div class="dropdown">
                <div class="errorThema">
                </div>
                <div class="content">
                testtesttestttest
                </div>
                </div>
                <div class="errorName">
                </div>
                <div class="errorText">
                </div>
                </div>
                </div>
        </footer>';
        } else {
    echo '<footer>
            <div id="Anker1" class="BeitragErstellen">
                <div class="field">
                    <form class="contact-form" method="post">
                </div>
                <div class="field">
                    <input type="text" name="thema" value="" class="email" placeholder="Thema" >
                </div>
                <div class="field">
                    <input type="text" name="name" class="email" placeholder="Name" >
                </div>
                <div class="field">
                    <textarea cols="50" rows="10"  class="text"  name="text" placeholder="Text hier eingeben"></textarea>
                </div>
                <input type="hidden" name="id" ">
                <div class="field">
                    <button type="submit" name="beitragErstellen" class="submit" value="0">Beitrag absenden</button>
                </div>
                </form>
            </div>
        </footer>';
}*/
echo '
    </div>
</div>

<script>
 /*function myFunction() {
     var x = validate.value;
     var y = x.length;
     var res = x.match(/[^a-z0-9?äüö \-+!?_%&$\.\*"()]/gi);
     console.log(validate.value);
     console.log(y);
     console.log(res);

     if ( res ) {
         document.getElementById("validate").className = \'form-control is-invalid\';
         document.getElementById("invalidTooltip").innerHTML = "Der eingegebene Text enthällt unerlaubte Zeichen!";
     }

     if (y < 10) {
         document.getElementById("validate").className = \'form-control is-invalid\';
         document.getElementById("invalidTooltip").innerHTML = "Der eingegebene Text ist zu kurz!";
     }

     if (y >= 100) {
         document.getElementById("validate").className = \'form-control is-invalid\';
         document.getElementById("invalidTooltip").innerHTML = "Der eingegebene Text ist zu lang!";
     }

     if(y <= 100 && y >= 10 && res === null) {
         document.getElementById("validate").className = \'form-control is-valid\';
         console.log(res)
     }

 }*/

 function myFunction(needsValidate,min,max,artikel) {
     
     var anzeigeValidate = needsValidate;
     
     console.log(needsValidate);
     
     var validate = document.getElementById(needsValidate);
     
     console.log(validate);
     
     var validateValue = validate.value;
     
     console.log(validateValue);
     
     var validateLength = validateValue.length;
     
     var resSearch = needsValidate.match(/^name/gi);
     console.log(resSearch);
     
     if (resSearch) {
        var res = validateValue.match(/[^a-z0-9_]/gi);
     } else {
        var res = validateValue.match(/[^a-z0-9?äüö, \-+!?_%&$\.\*"()]/gi);
     }
     
     //var res = validateValue.match(/[^a-z0-9?äüö, \-+!?_%&$\.\*"()]/gi);
     console.log(validateLength);
     console.log(res);

     var percent = validateLength / 10;
     document.getElementById("idProgress").style.width = percent + "%";
     
     
     
     var res2 = needsValidate.match(/nameAntwort[0-9]+/gi);
     if (res2) {
     console.log(res2);
     anzeigeValidate = "Name";
     }
     
     var res3 = needsValidate.match(/textAntwort[0-9]+/gi);
     if (res3) {
     console.log(res3);
     anzeigeValidate = "Text";
     }
     
     if (validateLength < 50) {
         document.getElementById("idProgress").className = \'progress-bar bg-danger\';
     } else if (validateLength >= 50 && validateLength < 1000) {
         document.getElementById("idProgress").className = \'progress-bar bg-success\';
     } else if (validateLength >= 1000) {
         document.getElementById("idProgress").className = \'progress-bar bg-danger\';
     }
     
     
     
     if ( res ) {
         document.getElementById(needsValidate).className = \'form-control is-invalid\';
         document.getElementById(needsValidate+" invalidTooltip").innerHTML = artikel + " eingegebene " + anzeigeValidate + " enthällt unerlaubte Zeichen!";
     } else if (validateLength < min) {
         document.getElementById(needsValidate).className = \'form-control is-invalid\';
         document.getElementById(needsValidate+" invalidTooltip").innerHTML = artikel + " eingegebene " + anzeigeValidate + " ist zu kurz!";
     } else if (validateLength >= max) {
         document.getElementById(needsValidate).className = \'form-control is-invalid\';
         document.getElementById(needsValidate+" invalidTooltip").innerHTML = artikel + " eingegebene " + anzeigeValidate + " ist zu lang!";
     } else if(validateLength <= max && validateLength >= min && res === null) {
         document.getElementById(needsValidate).className = \'form-control is-valid\';
         console.log(res)
     }
 }
</script>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>';
?>