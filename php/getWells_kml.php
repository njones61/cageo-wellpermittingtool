<?php

// 
// 
//
// used code from http://code.google.com/apis/kml/articles/phpmysqlkml.html#outputkml
//
//-------------------------------------------------------------------------------



// Try to disable caching
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1


// Defines $username, $password, $database, $server, $wellTable in a file less likely to be shared
require('dbinfo.php');



// Opens a connection to a MySQL server.
$connection = mysql_connect ($server, $username, $password);


if (!$connection) 
{
  die('Not connected : ' . mysql_error());
}


// Sets the active MySQL database.
$db_selected = mysql_select_db($database, $connection);

if (!$db_selected) 
{
  die('Can\'t use db : ' . mysql_error());
}



// Selects the rows in the "wel" table by 'ApplicationID'
$query = 'SELECT * FROM ' . $wellTable ;
$result = mysql_query($query);

if (!$result) 
{
  die('Invalid query: ' . mysql_error());
}




// Creates an array of strings to hold the lines of the KML file.
$kml = array('<?xml version="1.0" encoding="UTF-8"?>');
$kml[] = '<kml xmlns="http://earth.google.com/kml/2.1">';
$kml[] = ' <Document>';
$kml[] = ' <Style id="Style">';
$kml[] = ' <IconStyle id="canidateWellIcon"><color>ff7f0000</color>
<scale>0.8</scale>';
$kml[] = ' <Icon>';
//$kml[] = ' <href>http://maps.google.com/mapfiles/kml/paddle/blu-blank.png</href>';
$kml[] = ' <href>http://maps.google.com/mapfiles/kml/shapes/placemark_circle.png</href>';
$kml[] = ' </Icon>';
$kml[] = ' </IconStyle>';
$kml[] = ' </Style>';

// Iterates through the rows, printing a node for each row.
while ($row = @mysql_fetch_assoc($result)) 
{
  $kml[] = ' <Placemark id="placemark' . $row['Well_ID'] . '">';
  $kml[] = ' <name>' . $row['ApplicationID'] . '</name> ';
  $kml[] = ' <description><![CDATA[ ';

  $kml[] = '  Latitude: ' . $row['Latitude'] . ' <br>';
  $kml[] = '  Longitude: ' . $row['Longitude'] . ' <br>';
  $kml[] = '  Well_ID: ' . $row['Well_ID'] . ' <br>';
  $kml[] = '  Flow_cfd: ' . $row['Flow_cfd'] . ' <br> ';
  $kml[] = '  ScreenTopElev_ft: ' . $row['ScreenTopElev_ft'] . ' <br>';
  $kml[] = '  ScreenBotmElev_ft: ' . $row['ScreenBotmElev_ft'] . ' <br>';
  $kml[] = '  ApplicationID: ' . $row['ApplicationID'] . ' <br>';
  $kml[] = '  TIMESTAMP: ' . $row['TIMESTAMP'] . '  <br>';

  $kml[] = ' ]]></description>';
  $kml[] = ' <styleUrl>#Style</styleUrl>';
  $kml[] = ' <Point>';
  $kml[] = ' <coordinates>' . $row['Longitude'] . ','  . $row['Latitude'] . '</coordinates>';
  $kml[] = ' </Point>';
  $kml[] = ' </Placemark>';
 
} 

// End XML file
$kml[] = ' </Document>';
$kml[] = '</kml>';
$kmlOutput = join("\n", $kml);
header('Content-type: application/vnd.google-earth.kml+xml');
echo $kmlOutput;
?>
