<?php

require("phpsqlajax_dbinfo.php");

if(isset($_POST["id_point"])){
    $id = $_POST["id_point"];
    $query = "SELECT SampleID, PersonName, UpdatingDate, TotalValue, Category, Quality, Description, Color FROM markers
            INNER JOIN watersamples
            WHERE markers.MarkerID = watersamples.MarkerID
            AND watersamples.MarkerID = $id
            ORDER BY watersamples.UpdatingDate DESC";

    $result = $conn->query($query);
    $samples = $result->fetch_all();
    if (!$result) {
      die('Invalid query: ' . mysqli_error());
    }
    
    $output = "
                <table class='table table-bordered table-striped'>
                    <tr>
                        <th>Responsable</th>
                        <th>Fecha</th>
                        <th>BMWP/BOL</th>
                        <th>Categoría</th>
                        <th>Calidad</th>
                        <th>Significado</th>
                        <th>Color</th>
                        <th>Eliminar</th>
                    </tr>
            ";
    foreach($samples as $row){
        
        $output .=  "<tr>
                        <td>$row[1]</td>
                        <td>" . date("d-M-Y", strtotime($row[2])) . "</td>
                        <td>$row[3]</td>
                        <td>$row[4]</td>
                        <td>$row[5]</td>
                        <td>$row[6]</td>
                        <td style='background-color: $row[7]'></td>
                        <td><button data-name='$row[0]' class='remove btn btn-link btn-md'>Eliminar</button></td>
                    </tr>";
    }
    
    $output .= "</table>";
    echo $output; 
}