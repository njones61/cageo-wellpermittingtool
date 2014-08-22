<?php

//
// 
//
//
//
//-------------------------------------------------------------------------------



// Try to disable browser caching
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




// Selects all the rows in the "wel" table.
$query = 'SELECT * FROM ' . $wellTable . ' WHERE 1';
$result = mysql_query($query);

if (!$result) 
{
  die('Invalid query: ' . mysql_error());
}



// Start printing the table using simple html
echo "<table>";
echo "  <tbody>";

// Print the names of each colomn as a header row
if ($result) 
{
  echo "<tr>";
  echo "<th>Well ID</th>";
  echo "<th>Application ID</th>";
  echo "<th>Latitude</th>";
  echo "<th>Longitude</th>";
  echo "<th>Flow (cfd)</th>";
  echo "<th>Screen Top Elevation (ft)</th>";
  echo "<th>Screen Bottom Elevation (ft)</th>";
  echo "<th>Edit Row</th>";
  echo "<th>Delete Row</th>";
  echo "</tr>";
}

// Print all the rows of data 
while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
{

  echo "<tr>";
  echo "<td>" . $row["Well_ID"] . "</td>";
  echo "<td>" . $row["ApplicationID"] . "</td>";
  echo "<td>" . $row["Latitude"] . "</td>";
  echo "<td>" . $row["Longitude"] . "</td>";
  echo "<td>" . $row["Flow_cfd"] . "</td>";
  echo "<td>" . $row["ScreenTopElev_ft"] . "</td>";
  echo "<td>" . $row["ScreenBotmElev_ft"] . "</td>";
  echo "<th><a href='php/'>Edit</a></th>";
  echo "<th><a href=''>Delete</a></th>";
  echo "</tr>";

}

echo "  </tbody>";
echo "</table>";



?>
