<?php

// 
// Lasted updated by 11/3/2011
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


$appID = htmlspecialchars($_GET["id"]);
$appIdField = 'ApplicationID';


if( empty($appID) )   // empty is "", 0, null
{
  $appID=0;
}


// Selects the rows in the "wel" table by 'ApplicationID'
$query = 'SELECT * FROM ' . $wellTable . ' WHERE ' . $appIdField . ' = \'' . $appID . '\'';
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
while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
{
  $well = array();
  foreach ($cols as &$fieldName) {
    $well[$fieldName] =  $row[$fieldName] ;
  }
  $wells[] = $well;
}
$data["data"] = $wells;


echo json_encode($data);


?>
