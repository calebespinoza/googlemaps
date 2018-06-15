<?php

// Database connection

require("phpsqlajax_dbinfo.php");

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Select all the rows in the markers table

$query = "SELECT * FROM markers WHERE 1";

$result1 = $conn->query($query);

if (!$result1) {
  die('Invalid query: ' . mysqli_error());
}

$query = "SELECT * FROM markers
            INNER JOIN watersamples
            WHERE markers.MarkerID = watersamples.MarkerID
            ORDER BY watersamples.UpdatingDate
            DESC";

$result2 = $conn->query($query);
$samples = $result2->fetch_all();
if (!$result2) {
  die('Invalid query: ' . mysqli_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

$contMarker = 1;
while ($row = @mysqli_fetch_assoc($result1)){
    $string = "<table style='width: 100%; text-align: center;'>
            <tr>
                <th style='border-left: 10px solid white'>Fecha</th>
                <th style='border-left: 10px solid white'>BMWP</th>
                <th style='border-left: 10px solid white'>Color</th>
                <th style='border: 10px solid white'>Significado</th>
            </tr>";
  // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id",$row['MarkerID']);
  $newnode->setAttribute("name", $row['Name']);
  $newnode->setAttribute("lat", $row['Latitude']);
  $newnode->setAttribute("lng", $row['Longitude']);
  foreach ($samples as $sample){
        if($sample[12] == $contMarker){
            $date = date("d/m/y", strtotime($sample[6]));
            $string .= "<tr>
                            <td style='border-left: 10px solid white'>" . $date . "</td>
                            <td style='border-left: 10px solid white'>$sample[7]</td>
                            <td style='background-color: $sample[11]; border-top: 1px solid white'; border-left: 10px solid white' ></td>
                            <td style='width: 120px; text-align: left; border-top: 1px solid white; border: 10px solid white'>$sample[10]</td>
                        </tr>";
            //$string = $contMarker;
        }
  }
  
  $string .= "</table></br>";
  if($contMarker == 1){
    $string .= "<a target='_blank' href='http://www.gaiapacha.org/concurso-de-infografia/'>Ver Trabajo de Campo</a>";
  }
  if($contMarker == 2){
    $string .= "<a target='_blank' href='http://www.gaiapacha.org/concurso-de-infografia/'>Ver Trabajo de Campo</a>";
  }
  if($contMarker == 3){
    $string .= "<a target='_blank' href='http://www.gaiapacha.org/concurso-de-infografia/'>Ver Trabajo de Campo</a>";
  }
  $newnode->setAttribute("samples", $string . "</table></br>");
  
  $contMarker++;
}

echo $dom->saveXML();
