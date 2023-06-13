<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesGa.css">
    <title>NickelCloud</title>
</head>

<body>
    <h1>NickelCloud</h1>
   <div>
    

    <?php 

    $list = glob('C:\xampp\htdocs\IMS\M346\vm*.txt');
    $lastNum = 0;
    if ($list != false) {
        $lastNum = count($list);
    }

    $CPU = $_POST["CPU"];
    $RAM = $_POST["RAM"];
    $SSD = $_POST["SSD"];
    echo "Ihr Index ". $lastNum .", <br>CPU ". $CPU .", <br>RAM ". $RAM .", <br>SSD ". $SSD ."<br>";

    $smallCore = 4;
    $smallRAM = 32768;
    $smallSpeicher = 4000;

    $medCore = 8;
    $medRAM = 65536;
    $medSpeicher = 8000;

    $largeCore = 16;
    $largeRAM = 131072;
    $largeSpeicher = 16000;

    if ($lastNum != 0){
        for($i = 0; $i < $lastNum; $i++) {
            $getfile = "vm".$i.".txt";
            $filecont = file_get_contents($getfile);
            $getfilearr = explode("+++", $filecont);
            $minusCPU = $getfilearr[1];
            $minusRAM = $getfilearr[2];
            $minusSSD = $getfilearr[3];
            $indicator = $getfilearr[4];
            if ($indicator == "small") {
                $smallCore = $smallCore - $minusCPU;
                $smallRAM = $smallRAM - $minusRAM;
                $smallSpeicher = $smallSpeicher - $minusSSD;
            }
            elseif ($indicator == "medium") {
                $medCore = $medCore - $minusCPU;
                $medRAM = $medRAM - $minusRAM;
                $medSpeicher = $medSpeicher - $minusSSD;
            }
            elseif ($indicator == "big") {
                $largeCore = $largeCore - $minusCPU;
                $largeRAM = $largeRAM - $minusRAM;
                $largeSpeicher = $largeSpeicher - $minusSSD;
            }
        }
    }

    $sservausCPU = $smallCore;
    $sservausRAM = $smallRAM;
    $sservausSSD = $smallSpeicher;
    $mservausCPU = $medCore;
    $mservausRAM = $medRAM;
    $mservausSSD = $medSpeicher;
    $lservausCPU = $largeCore;
    $lservausRAM = $largeRAM;
    $lservausSSD = $largeSpeicher;

    if ($CPU <= $smallCore && $RAM <= $smallRAM && $SSD <= $smallSpeicher) {
        $output = "Bestellung bestätigt. Genug Platz auf dem kleinen Server vorhanden.";
        $server = "small";
        $pricex = 1;
        $sservausCPU = $smallCore - $CPU;
        $sservausRAM = $smallRAM - $RAM;
        $sservausSSD = $smallSpeicher - $SSD;
    }
    elseif ($CPU <= $medCore && $RAM <= $medRAM && $SSD <= $medSpeicher) {
        $output = "Bestellung bestätigt. Genug Platz auf dem mittleren Server vorhanden.";
        $server = "medium";
        $pricex = 1;
        $mservausCPU = $medCore - $CPU;
        $mservausRAM = $medRAM - $RAM;
        $mservausSSD = $medSpeicher - $SSD;
    }
    elseif ($CPU <= $largeCore && $RAM <= $largeRAM && $SSD <= $largeSpeicher) {
        $output = "Bestellung bestätigt. Genug Platz auf dem grossen Server vorhanden.";
        $server = "big";
        $pricex = 1;
        $lservausCPU = $largeCore - $CPU;
        $lservausRAM = $largeRAM - $RAM;
        $lservausSSD = $largeSpeicher - $SSD;
    }
    else {
        $output = "Bestellung abgebrochen. Nicht genügend Platz auf den Servern vorhanden.";
        $server = "not";
        $pricex = 0;
    }
    echo $output."<br>";

    if ($pricex !=0){
        $priceCPU = $CPU;
        $priceRAM = $RAM / 512;
        $priceSSD = 0;
        if ($SSD == 10) {
            $priceSSD = 1;
        }
        elseif ($SSD == 20) {
            $priceSSD = 2;
        }
        elseif ($SSD == 40) {
            $priceSSD = 3;
        }
        elseif ($SSD == 80) {
            $priceSSD = 4;
        }
        elseif ($SSD == 240) {
            $priceSSD = 5;
        }
        elseif ($SSD == 500) {
            $priceSSD = 6;
        }
        elseif ($SSD == 1000) {
            $priceSSD = 8;
        }
        else{
            $priceSSD = 0;
        }
        $priceall = $priceCPU + $priceRAM + $priceSSD;

        echo "Ihre Bestellung kostet ". $priceall.".- CHF<br><br>";
        }
        else {
            $priceall = 0;
            echo "Da Ihre Bestellung nicht durchgeführt werden konnte, konnte kein Preis berechnet werden.<br><br>";
        }

    echo "Freier Platz auf dem Server:<br>";
    echo "Small Server CPU: ".$sservausCPU."<br>";
    echo "Small Server RAM: ".$sservausRAM."<br>";
    echo "Small Server SSD: ".$sservausSSD."<br>";
    echo "Medium Server CPU: ".$mservausCPU."<br>";
    echo "Medium Server RAM: ".$mservausRAM."<br>";
    echo "Medium Server SSD: ".$mservausSSD."<br>";
    echo "Large Server CPU: ".$lservausCPU."<br>";
    echo "Large Server RAM: ".$lservausRAM."<br>";
    echo "Large Server SSD: ".$lservausSSD."<br>";

    $filename = "vm".$lastNum.".txt";
    $inhalt = $lastNum . "+++" . $CPU . "+++" . $RAM . "+++" . $SSD . "+++" . $server ."+++". $priceall;
    file_put_contents($filename, $inhalt); 

    $priceUmsatz = $priceall;
        for($i = 0; $i < $lastNum; $i++) {
        $getfile = "vm".$i.".txt";
        $filecont = file_get_contents($getfile);
        $getfilearr = explode("+++", $filecont);
        $serv = $getfilearr[4];
        $price = $getfilearr[5];
        if ($serv != "not"){
        $priceUmsatz = $priceUmsatz + $price;
        }
    }
    
    echo "<br>Unser Umsatz liegt bei ". $priceUmsatz.".- CHF.<br>";

    ?>
    </br></br></br></br></br></br>
    <h1>Löschen:</h1>
    <form id ="1" action="Gruppendelete.php" method="post">
        <h1>Wollen Sie Ihre Virtuelle Maschine löschen?</h1>
        <h1>Ja: </h1>
        <input type = "radio" name = "delete" value = "ja"/><br>
        <input type = "text" name = "delIndex" id = 1 required/>Welchen Index hat Ihre Virtuelle Maschine?<br>     
        <input type = "submit" value = "Löschen" /></br>
    </form>
    <form id ="1" action="Gruppendelete.php" method="post">
    <input type = "submit" value = "Zurück zur Bestellseite" formaction="gruppenarbeit.php"/>
    </form>

    </br>
    <div>

</body>

</html>