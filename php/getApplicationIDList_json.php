<?php

//
// 
//
//
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

if( empty($appID) ) 				// empty is "", 0, null
{
  $appID=0;
}


// Selects all the rows in the "wel" table.
$query = 'SELECT DISTINCT ' . $appIdField . ' FROM ' . $wellTable . ' WHERE 1';
$result = mysql_query($query);

if (!$result) 
{
  die('Invalid query: ' . mysql_error());
}



// Iterates through the MySQL results
//$allIDs = array();
//while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
//{
//  $allIDs['id'] = $row[ $appIdField ]; // add each Application ID value to the array
//}



// Iterates through the MySQL results
$allIDs = array();
while ($row = mysql_fetch_array($result, MYSQL_BOTH)) 
{
  $idItem = array();
  $idItem['id'] = $row[ $appIdField ];

  $allIDs[] = $idItem;
}







$output = '{
  identifier:"id",
  label: "id",
  items:' . json_encode($allIDs) . '}';

echo $output;

?>
