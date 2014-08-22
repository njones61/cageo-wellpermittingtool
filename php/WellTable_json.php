<?php

//
// Lasted updated: 9/17/2011
//
//
// used code from http://code.google.com/apis/kml/articles/phpmysqlkml.html
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

// Selects all the rows in the "wel" table.
$query = 'SELECT * FROM ' . $wellTable . ' WHERE 1';
$result = mysql_query($query);

if (!$result) 
{
  die('Invalid query: ' . mysql_error());
}


$data = array();

// Get the names of each colomn in the database
$i = 0;
$cols = array();
while ($i < mysql_num_fields($result)) {
  $field = mysql_fetch_field($result, $i);
  $cols[] = $field->name;
  $i++;
}

$data["fieldNames"] = $cols;

// Iterates through the MySQL results
$wells = array();
while ($row = mysql_fetch_array($result, MYSQL_NUM)) // could use MYSQL_BOTH instead
{
  $wells[] = $row;
}
$data["data"] = $wells;

// Returns an array like this: 
//  {"fieldNames":["ColName_1","ColName_2"],
//   "data":[{"ColName_1":"data_11","ColName_2":"data_12"},
//           {"ColName_1":"data_21","ColName_2":"data_22"},
//           ...]
//  }
//
echo json_encode($data);

?>
