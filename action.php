<?php

require("phpsqlajax_dbinfo.php");

if(isset($_POST["action"])){
    if($_POST["action"] == "fetch"){
        $output = "
                <table class='table table-bordered table-striped'>
                    <tr>
                        <th>Puntos de Monitoreo</th>
                        <th>Coordenadas</th>
                        <th>Muestras</th>
                        <th>Editar</th>
                        <!--th>Eliminar</th-->
                    </tr>
            ";
        $query = "SELECT * FROM markers WHERE 1";
        $result = $conn->query($query);
        
        if($result->num_rows){
            $row = $result->fetch_all();
            foreach($row as $data){
                $output .=  "<tr>
                                <td>$data[1]</td>
                                <td>$data[2], $data[3]</td>
                                <td><button id='view_samples' data-name='$data[0]' class='update btn btn-info btn-md' value='$data[1]'>Ver Muestras</button></td>
                                <td><button data-id='$data[0]' data-place='$data[1]' data-lat='$data[2]' data-long='$data[3]' class='updateMarkers btn btn-link btn-md'>Editar</button></td>
                                <!--td><button>Eliminar</td-->
                            </tr>";
            }
        } else {
            echo "No hay puntos de monitoreo.";
            exit;
        }
        $output .= "</table>";
            
        echo $output;
    }
    
    if($_POST["action"] == "remove"){
        $id_sample = $_POST['id'];
        $query = "DELETE FROM watersamples WHERE SampleID=$id_sample";
        if($conn->query($query)){
            echo "Registro eliminado!";
        } else {
            echo "ERROR";
        }
        //echo "Registro eliminado!";
    }
    
    if($_POST["action"] == "update"){
        $id_sample = $_POST['id'];
        $query = "UPDATE TABLE watersamples WHERE MarkerID=$id_sample";
        if($conn->query($query)){
            echo "Registro eliminado!";
        } else {
            echo "ERROR";
        }
        //echo "Registro eliminado!";
    }
}

if(isset($_POST["hidden_add_sample"])){
    $markerID = filter_var($_POST["hidden_marker_id"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $name = filter_var($_POST["name_leader"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $bmwp = filter_var($_POST["bmwp_total"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $date = filter_var($_POST["date_sample"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
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
    
    $query = "INSERT INTO watersamples (PersonName, UpdatingDate, TotalValue, Category, Quality, Description, Color, MarkerID) VALUES ('$name','$date',$bmwp,'$class','$quality','$description','$color',$markerID)";
    
    try{
        $conn->query($query);
        echo "Registrado Correctamente!";
    }catch(Exception $e){
        echo "Exception: Un error con la base de datos!";
    }
}

if(isset($_POST["hidden_update_marker"])){
    $markerID = filter_var($_POST["hidden_id_marker"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $place = filter_var($_POST["marker_place"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $latitude = filter_var($_POST["marker_lat"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $longitude = filter_var($_POST["marker_long"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $query = "UPDATE markers SET Name='$place', Latitude='$latitude', Longitude='$longitude' WHERE MarkerID=" . $markerID;
    
    try{
        $conn->query($query);
        echo "Actualizado Correctamente!";
    }catch(Exception $e){
        echo "Exception: Un error con la base de datos!";
    }
}