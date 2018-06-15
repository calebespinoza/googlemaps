<?php

require("phpsqlajax_dbinfo.php");

if(isset($_POST["hidden_marker_id"])){
    $markerID = $_POST["hidden_marker_id"];
    $name = $_POST["name_leader"];
    $bmwp = $_POST["bmwp_total"];
    $date = $_POST["date_sample"];
    $class = "";
    $quality = "";
    $description = "";
    $color = "";
    
    if($bmwp >= 101){
        $class = "I";
        $quality = "Buena";
        $description = "Aguas muy limpias. No contaminadas";
        $color = "blue";
    } elseif($bmwp >= 61 && $bmwp <= 100){
        $class = "II";
        $quality = "Aceptable";
        $description = "Se evidencia algún efecto de contaminación";
        $color = "green";
    } elseif($bmwp >= 36 && $bmwp <= 60){
        $class = "III";
        $quality = "Dudosa";
        $description = "Aguas contaminadas";
        $color = "yellow";
    } elseif($bmwp >= 16 && $bmwp <= 35){
        $class = "IV";
        $quality = "Crítica";
        $description = "Aguas muy contaminadas";
        $color = "orange";
    } elseif($bmwp <= 15){
        $class = "V";
        $quality = "Muy Crítica";
        $description = "Aguas fuertemente contaminadas";
        $color = "red";
    }
    
    $query = "INSERT INTO watersamples(PersonName, UpdatingDate, TotalValue, Category, Quality, Description, Color, MarkerID) VALUES ('$name','$date',$bmwp,'$class','$quality','$description','$color',$markerID)";
    $result = $conn->query($query);
    
    if (!$result) {
      die('Invalid query: ' . mysqli_error($conn));
    }
    
    echo "La Muestra fue registrada satisfactoriamente!";
}