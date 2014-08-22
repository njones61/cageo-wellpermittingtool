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
$kml[] = ' <Style id="restaurantStyle">';
$kml[] = ' <IconStyle id="restuarantIcon">';
$kml[] = ' <Icon>';
$kml[] = ' <href>http://maps.google.com/mapfiles/kml/pal2/icon63.png</href>';
$kml[] = ' </Icon>';
$kml[] = ' </IconStyle>';
$kml[] = ' </Style>';
$kml[] = ' <Style id="barStyle">';
$kml[] = ' <IconStyle id="barIcon">';
$kml[] = ' <Icon>';
$kml[] = ' <href>http://maps.google.com/mapfiles/kml/pal2/icon27.png</href>';
$kml[] = ' </Icon>';
$kml[] = ' </IconStyle>';
$kml[] = ' </Style>';

// Iterates through the rows, printing a node for each row.
while ($row = @mysql_fetch_assoc($result)) 
{
  $kml[] = ' <Placemark id="placemark' . $row['Well_ID'] . '">';
  $kml[] = ' <name>' . htmlentities($row['Flow_(cfd)']) . '</name>';
  $kml[] = ' <description>' . htmlentities($row['address']) . '</description>';
  $kml[] = ' <styleUrl>#' . ($row['Well_ID']) .'Style</styleUrl>';
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
