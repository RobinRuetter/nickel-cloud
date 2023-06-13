<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>NickelCloud</title>
</head>

<body>
    <h1>NickelCloud</h1>
   <div>
    

    <?php 

    $del = $_POST["delete"];
    $delIndex = $_POST["delIndex"];
    
    if ($del == "ja" && $delIndex >= 0) {
        $filename = "vm".$delIndex.".txt";
        $inhalt = "0" . "+++" . "0" . "+++" . "0" . "+++" . "0" . "+++" . "0". "+++" . "0";
        file_put_contents($filename, $inhalt); 
        echo "Ihre Maschine wurde gelöscht.";
    }
    elseif ($del == "nein") {
        echo "Ihre Maschine wird nicht gelöscht.<br><br>Danke für Ihren Kauf.";
    }
    else {
        echo "error";
    }
    


    ?>
    <form action="gruppenarbeit.php"></br></br></br>
        <input type = "submit" value = "Zurück zur Bestellseite"/>
    <form></br>

    <div>

</body>

</html>